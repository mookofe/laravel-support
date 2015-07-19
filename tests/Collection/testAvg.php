<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test average
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testAvg extends BaseCollection
{

    public function testAvg()
    {
        $avg = $this->collection->avg('id');

        //Assertions
        $this->assertEquals(1.5, $avg);
    }

    public function testAvgWithNull()
    {
        $first = $this->collection->first();
        $first->id = null;

        $avg = $this->collection->avg('id', true);

        //Assertions
        $this->assertEquals(1, $avg);
    }

    public function testAvgEmpty()
    {
        $collection = new Collection;        
        $avg = $collection->avg('id');

        //Assertions
        $this->assertEquals(null, $avg);
    }

}