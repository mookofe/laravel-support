<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test new instance method class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testNewInstance extends BaseCollection
{

    public function testNewInstance()
    {
        $new_instance = $this->collection->createNewInstance();
        $this->assertEquals(get_class($this->collection), get_class($new_instance));
    }
   
}