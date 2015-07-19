<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mockery;
use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test latest field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testDelete extends BaseCollection
{   

    public function tearDown()
    {
        Mockery::close();
    }

    public function testSumValues()
    {
        $collection = new Collection();

        //Add fake items to collection
        $model1 = Mockery::mock('Mookofe\LaravelSupport\Model');
        $model2 = Mockery::mock('Mookofe\LaravelSupport\Model');

        $model1->shouldReceive('delete')->once()->andReturn(null);
        $model2->shouldReceive('delete')->once()->andReturn(null);

        $collection->add($model1);
        $collection->add($model2);

        //Delete items
        $collection->delete();
    }

}