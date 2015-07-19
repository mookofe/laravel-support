<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test latest field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testFindByFields extends BaseCollection
{

    public function testFindByFields()
    {
        $filter = array('name' => 'John', 'lastname' => 'Doe');    
        $filtered = $this->collection->findByFields($filter);

        $this->assertEquals($filtered->first()->id, 1);
    }

}