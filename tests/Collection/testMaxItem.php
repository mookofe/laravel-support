<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test max item in collection
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testMaxItem extends BaseCollection
{

    public function testMaxItem()
    {
        $max_user = $this->collection->maxItem('id');

        //Assertions
        $this->assertEquals($max_user->id, 2);
    }

}