<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test rebuild method
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testRebuild extends BaseCollection
{

    public function testRebuilt()
    {
        $format = array('name', 'lastname');
        $new_collection = $this->collection->rebuild($format);

        //Assert items count
        $this->assertEquals($this->collection->count(), $new_collection->count());

        //Make sure other fields does not exist
        $item = $new_collection->first();
        $this->assertFalse($item->attributeExist('id'));
        $this->assertFalse($item->attributeExist('sex'));

        //Make sure requested fields exist
        $this->assertTrue($item->attributeExist('name'));
        $this->assertTrue($item->attributeExist('lastname'));
    }

    /**
     * @expectedException     Mookofe\LaravelSupport\Exceptions\AttributeNotFoundException
     */
    public function testRebuiltInvalidField()
    {
        $format = array('invalid_field');
        $new_collection = $this->collection->rebuild($format);        
    }
    
}