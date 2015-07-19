<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test latest field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testSumValues extends BaseCollection
{

    public function testSumValues()
    {
        $sum = $this->collection->sumValues('lastname', 'Doe', 'id');
        //Assertions
        $this->assertEquals(3, $sum);
    }

}