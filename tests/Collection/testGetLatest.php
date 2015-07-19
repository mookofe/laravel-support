<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test latest field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testGetLatest extends BaseCollection
{

    public function testGetLatest()
    {
        //Set same id
        $last_item = $this->collection->last();
        $last_item->id = 1;
        
        $latests = $this->collection->getLatestsByField( array('id', 'lastname') );

        //Assertions
        $this->assertEquals($last_item->name, $latests->first()->name);
    }    
    
}