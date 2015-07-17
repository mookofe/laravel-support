<?php namespace Mookofe\LaravelSupport\Tests\Models;

use Mookofe\LaravelSupport\Model;

/**
 * Test human date method class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testAttributeExist extends \PHPUnit_Framework_TestCase
{

    public function testAttributeExist()
    {
        $model = new Model;
        $model->date = null;

        //Asserts
        $this->assertTrue($model->attributeExist('date'));
    }    
    
}