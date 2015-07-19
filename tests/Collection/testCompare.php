<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test compare method class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testCompare extends BaseCollection
{

    public function testCompareEquals()
    {
        $compare_collection = new Collection;

        //Set items
        foreach ($this->collection->all() as $item)
            $compare_collection->add($item);

        $this->assertTrue($this->collection->compare($compare_collection, 'id', 'id'));
    }

    public function testCompareDifferent()
    {
        $compare_collection = new Collection;

        //Check if all users have a record on the user avatar collection
        $this->assertFalse($this->collection->compare($compare_collection, 'id', 'id'));
    }

    /**
     * @expectedException     Mookofe\LaravelSupport\Exceptions\AttributeNotFoundException
     */
    public function testCompareInvalidAttribute()
    {
        $compare_collection = new Collection;

        //Add an empty model
        $model = new Model;
        $compare_collection->add($model);

        //Check if all users have a record on the user avatar collection
        $this->assertTrue($this->collection->compare($compare_collection, 'invalid_field', 'id'));
    }
    
}