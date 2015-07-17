<?php namespace Mookofe\LaravelSupport\Tests\Models;

use Mookofe\LaravelSupport\Model;

/**
 * Test class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testRemoveFields extends \PHPUnit_Framework_TestCase
{

    public function testGetChanges()
    {
        $model = new Model;
        $model->client_id = 1;
        $model->amount = 100;
        $model->time = time();

        $fields_to_remove = array('client_id', 'amount');
        $model->removeFields($fields_to_remove);

        //Assert properties does not exist
        $this->assertFalse($model->attributeExist('client_id'));
        $this->assertFalse($model->attributeExist('amount'));
    }    
    
}