<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test to flat array convertion
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testToFlatArray extends BaseCollection
{

    public function testToFlatArray()
    {
    	$field = 'id';
        $new_array = $this->collection->toFlatArray($field);

        //Assertions
        $this->assertInternalType('array', $new_array);
        $this->assertEquals($new_array[0], $this->collection->first()->$field);
    }

}