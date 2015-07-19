<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test latest field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testGetFirstByField extends BaseCollection
{

    public function testGetFirstByField()
    {
        //Set same id
        $last_item = $this->collection->last();
        $last_item->id = 1;
        
        $first = $this->collection->getFirstByField( array('id', 'lastname') );
        
        //Assertions
        $this->assertEquals($this->collection->first()->name, $first->first()->name);
    }    
    
}