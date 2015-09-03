<?php namespace Mookofe\LaravelSupport;

use Illuminate\Database\Eloquent\Collection as Base;
use Mookofe\LaravelSupport\Exceptions\AttributeNotFoundException;

/**
 * Base collection class
 *
 */
class Collection extends Base {

    /**
     * Create a new collection of object with format specified
     *
     * @param array $format New collection format
     *          array('field', 'field2'=> ['field3'])
     *
     * @return Mookofe\LaravelSupport\Collection
     */
    public function rebuild($format)
    {
        $collectionInstance = $this->createNewInstance();

        foreach ($this->items as $item)
        {
            $modelClass = get_class($item);
            $model = new $modelClass();

            $model = $this->buildModel($model, $item, $format);

            $collectionInstance->add($model);
        }

        return $collectionInstance;
    }


    /**
     * Recursive function to build a model from array definition
     *
     * @param EloquentModel $format New model instance
     * @param EloquentModel $row Current row model
     * @param array $format New model format
     *
     * @return Model
     */
    private function buildModel($newModel, $row, $format)
    {
        $modelName = get_class($newModel);

        foreach ($format as $key => $field)
        {
            if (is_array($field))
            {
                $nextInstance = new $modelName();
                $newModel->$key = $this->buildModel($nextInstance, $row, $field)->toArray();
            }
            else
            {
                if ($row->$field)
                    $newModel->$field = $row->$field;
                else
                    throw new AttributeNotFoundException("Field '$field' does not exist in the model");
            }
        }
        return $newModel;
    }


    /**
     * Compare if the current collection is the same based on one field
     *
     * @param Collection $collection of item to be compared
     * @param string $collectionField Field name in the remote collection
     * @param string $localField Field name in the local collection
     *
     * @return boolean
     */
    public function compare($collection, $collectionField, $localField)
    {
        //Convert collections to simple array
        $currentCollection = array_flatten($this->rebuild([$localField])->toArray());

        $arrayCollection = [];
        foreach ($collection as $item)
        {
            if (!$item->attributeExist($collectionField))
                throw new AttributeNotFoundException("Attribute $collectionField does not exist in the remote collection");
            array_push($arrayCollection, $item[$collectionField]);
        }

        return $this->hasIdenticalValues($currentCollection, $arrayCollection);
    }


    /**
     * Check if to arrays are equals
     *
     * @param array $arrayA First array to compare
     * @param array $arrayB Second array to compare
     *
     * @return boolean
     */
    private function hasIdenticalValues(array $arrayA , array $arrayB )
    {
        sort( $arrayA );
        sort( $arrayB );

        return $arrayA == $arrayB;
    }

    /**
     * Create a new empty collection based on the current class
     *
     * @return Mookofe\LaravelSupport\Collection
     */
    public function createNewInstance()
    {
        $class_name = get_class($this);
        return new $class_name();
    }

    /**
     * Create a new collection using the last row grouped by the fields specified
     *
     * @param array $fields Array of fields to group by
     *
     * @return Mookofe\LaravelSupport\Collection
     */
    public function getLatestsByField(array $fields)
    {
        $collection = $this->createNewInstance();
        $tmpArray = array();

        foreach ($this->items as $item)
        {
            $index = $this->buildFieldsIndex($fields, $item);
            $tmpArray[$index] = clone($item);
        }

        //Add to collection
        foreach ($tmpArray as $item){
            $collection->add($item);
        }

        return $collection;
    }

    /**
     * Create a new collection using the first instance found
     *
     * @param array $fields Array of fields to group by
     *
     * @return Jasper\Support\Collections\BaseCollection
     */
    public function getFirstByField(array $fields)
    {
        $collection = $this->createNewInstance();
        $tmpArray = array();

        foreach ($this->items as $item)
        {
            $index = $this->buildFieldsIndex($fields, $item);
            if (!isset($tmpArray[$index]))
                $tmpArray[$index] = clone($item);
        }

        //Add to collection
        foreach ($tmpArray as $item){
            $collection->add($item);
        }

        return $collection;
    }

    /**
     * Sum all items matching the field supplied
     *
     * @param string $fieldName Field name to compare
     * @param mixed $fieldValue Field value to compare 
     * @param string $collectionValueName Field name to sum in collection
     *
     * @return Decimal
     */
    public function sumValues($fieldName, $fieldValue, $collectionValueName)
    {
        $sum = 0;
        foreach ($this->items as $item) {
            if ($item->$fieldName == $fieldValue) {
                $sum += $item->$collectionValueName;
            }
        }
        return $sum;
    }

    /**
     * Find items on collection filtered by fields
     *
     * @param array $fields Fields to find
     *          $fields = array('field_name' => 'field_value');
     *
     * @return Mookofe\LaravelSupport\Collection
     */
    public function findByFields(array $fields)
    {
        $collection = $this->createNewInstance();

        $found = true;
        foreach ($this->items as $item)
        {
            $found = true;
            foreach ($fields as $property => $value) 
            {
                if (!$item->attributeExist($property))
                    throw new AttributeNotFoundException("Field '$property' not found in the item");
                $found = $found && ($item->$property == $value);
            }
            if ($found)
                $collection->add($item);
        }

        return $collection;
    }

    /**
     * Merge collection with other collection based with fields
     *
     * @param  BaseCollection $collection      Remote collection to merge
     * @param  array $fieldsToCompare Array of fields to find the values
     *               array('field1', field2)
     *               array('local_field_name' => 'remote_field_name')
     * @param  array $fieldsToMerge   Array of fields on remote collection to merge with the local collection
     * @return void
     */
    public function mergeByFields($collection, $fieldsToCompare, $fieldsToMerge)
    {
        foreach ($this->items as $item)
        {
            foreach ($fieldsToCompare as $localField => $remoteField)
            {
                //Check if field names are diferent
                if (is_numeric($localField))
                    $localField = $remoteField;

                //Check if field exist
                if (is_null($item->$localField))
                    throw new AttributeNotFoundException("Field [$localField] not found in the local collection");

                //Set conditions to find items
                $conditions = array($remoteField => $item->$localField);
                $itemToFind = $collection->findByFields($conditions)->first();

                if ($itemToFind)
                {
                    foreach ($fieldsToMerge as $newField)
                    {
                        //Check if field exist on remote collection
                        if (is_null($itemToFind->$newField))
                            throw new AttributeNotFoundException("Field [$newField] not found in the remote collection");

                        $item->$newField = $itemToFind->$newField;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Find a in a collection and show result as specified
     *
     * @param   array $fields Fields to find
     *              $fields = array('field_name' => 'field_value');
     * @param   array options Option to return
     * @return  string
     */
    public function showIfFound(array $fields, array $options = array())
    {
        $item = $this->findByFields($fields)->first();

        if ($item)
        {
            if (isset($options['found_text']))
                return $options['found_text'];
            if (isset($options['field']))
                return $item->$options['field'];

            return $item;
        }
        else
        {
            if (isset($options['not_found_text']))
                return $options['not_found_text'];
        }            
    }

    /**
     * Trigger delete method to every item in the collection
     *
     * @return  void
     */
    public function delete()
    {
        foreach ($this->items as $item)
            $item->delete();
    }

    /**
     * Calculate average in a by a field
     *
     * @param string $fields Field to calculate average
     * @param boolean $count_nulls Option to indicate if want to calculate null values
     *
     * @return decimal
     */
    public function avg($field, $count_nulls = false)
    {
        $collection = $this->createNewInstance();

        if ($count_nulls)
            $collection = $this;
        else 
            $collection = $this->findIfDifferent(array($field => null));

        if ($collection->count() == 0)
            return null;

        return $collection->sum($field)/$collection->count();
    }

    /**
     * Find items on collection having different value than specified
     *
     * @param array $fields Fields to find
     *          $fields = array('field_name' => 'field_value');
     *
     * @return Collection
     */
    public function findIfDifferent(array $fields)
    {
        $collection = $this->createNewInstance();

        $found = true;
        foreach ($this->items as $item)
        {
            $found = true;
            foreach ($fields as $property => $value) 
            {
                if (!$item->attributeExist($property))
                    throw new AttributeNotFoundException("Field '$property' not found in the item");

                $found = $found && ($item->$property != $value);
            }
            if ($found)
                $collection->add($item);
        }

        return $collection;
    }

    /**
     * Get the max value of the given key and return the item
     *
     * @param string $key Attribute to compare
     *
     * @return Model
     */
    public function maxItem($key)
    {
        $max_value = $this->max($key);
        return $this->findByFields(array($key => $max_value))->first();
    }

    /**
     * Build fields index, help find items in collection
     *
     * @return string
     */
    protected function buildFieldsIndex($fields, $item)
    {
        $index = "";
        foreach ($fields as $field)
            $index .= $item->$field . '_';
        return $index;
    }

    /**
     * Convert collection to flat array using a field
     *
     * @param string $field Field to convert to array
     *
     * @return array
     */
    public function toFlatArray($field)
    {
        $coll = $this->rebuild([$field]);

        return array_flatten($coll->toArray());
    }

}
