<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test show if found method
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testShowIfFound extends BaseCollection
{

    public function testExist()
    {
        $filter = array('name' => 'Jane');
        $options = array(
            'found_text' => 'Item exist'
        );

        $result = $this->collection->showIfFound($filter, $options);
        $this->assertEquals('Item exist', $result);
    }

    public function testExistNotFound()
    {
        $filter = array('name' => 'No name');
        $options = array(
            'not_found_text' => 'Item not found',
        );

        $result = $this->collection->showIfFound($filter, $options);
        $this->assertEquals('Item not found', $result);
    }

    public function testExistField()
    {
        $filter = array('name' => 'Jane');
        $options = array(            
            'field' => 'name'
        );

        $result = $this->collection->showIfFound($filter, $options);
        $this->assertEquals('Jane', $result);
    }

    public function testExistNoOptions()
    {
        $filter = array('name' => 'Jane');
        $result = $this->collection->showIfFound($filter);

        $this->assertEquals(get_class($this->collection->last()), get_class($result));
    }

}