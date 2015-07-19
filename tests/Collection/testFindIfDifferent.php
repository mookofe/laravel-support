<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test find item if different to conditions
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testFindIfDifferent extends BaseCollection
{

    public function testFindIfDifferent()
    {
        $filter = array('lastname' => 'Doe');
        $filtered = $this->collection->findIfDifferent($filter);

        $this->assertEquals($filtered->count(), 0);
    }

}