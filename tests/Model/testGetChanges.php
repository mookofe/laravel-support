<?php namespace Mookofe\LaravelSupport\Tests\Models;

use Mookofe\LaravelSupport\Model;

/**
 * Test class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testGetChanges extends \PHPUnit_Framework_TestCase
{

    public function testGetChanges()
    {
        $model = new Model();

        //Emulate model is filling from DB;
        $model->fillable(array('name'));        
        $model->setRawAttributes(array('name' => 'Victor'), true);
        $model->syncOriginal();
        $model->exists = true;

        //Change name
        $model->name = 'John';

        $changes = $model->getChanges();

        //Asserts
        $this->assertInternalType('array', $changes);
        $this->assertArrayHasKey('field', $changes[0]);
        $this->assertArrayHasKey('old_value', $changes[0]);
        $this->assertArrayHasKey('new_value', $changes[0]);
    }    
    
}