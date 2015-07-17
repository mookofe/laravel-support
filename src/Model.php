<?php namespace Mookofe\LaravelSupport;

use Carbon\Carbon;
use Mookofe\LaravelSupport\Collection;
use Illuminate\Database\Eloquent\Model as Base;
use Mookofe\LaravelSupport\Exceptions\AttributeNotFoundException;

/**
 * Base Model class
 *
 */
class Model extends Base {

    /**
     * Get human readable date
     *
     * @param string $field Field name of date
     *
     * @return Boolean
     */
    public function getHumanDate($field, $format = 'F j, Y')
    {
        if (!isset($this->$field))
            throw new AttributeNotFoundException("Field $field does not exist");

        if (is_string($this->$field))
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->$field);
        elseif(is_object($this->$field))
            $date = $this->$field;      

        return $date->format($format);
    }

    /**
     * Check if an attribute exists in the model
     *
     * @param string $property Model property to check
     *
     * @return Boolean
     */
    public function attributeExist($property)
    {
        return array_key_exists($property , $this->attributes);
    }

    /**
     * Get if there're changes in the original and the current
     *
     * @return array
     */
    public function getChanges()
    {
        $changes = [];

        if ($this->exists)
        {
            foreach ($this->getDirty() as $field => $value) 
                $changes[] = array('field'=> $field, 'old_value' => $this->original[$field], 'new_value' => $this->attributes[$field] );
        }

        return $changes;
    }

    /**
     * Create a new instance with the fields specified
     *
     * @param  array    $fields Array of fields to extract
     * @param  boolean  $deleteFields Delete this fields in original model
     *
     * @return model
     */
    public function extract($fields, $deleteFields = false)
    {
        $className = get_class($this);
        $instance = new $className();        

        foreach ($fields as $new_field => $field) 
        {
            if (is_numeric($new_field))
                $new_field = $field;

            $instance->setAttribute($new_field, $this->getAttribute($field));

            if ($deleteFields)
                unset($this->$field);
        }

        return $instance; 
    }

    /**
     * Remove atributes from model
     * 
     * @param array $items items to be removed
     *
     * @return void
     */
    public function removeFields($items)
    {
        foreach ($items as $item)
            unset($this->$item);
    }

    /**
     * Assign base collection to models
     *
     * @param array $models models to fill collection
     *
     * @return Mookofe\LaravelSupport\Collection
     */
    public function newCollection(array $models = array())
    {
        return new Collection($models);
    }
}