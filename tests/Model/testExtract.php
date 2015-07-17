<?php namespace Mookofe\LaravelSupport\Tests\Models;

use Carbon\Carbon;
use Mookofe\LaravelSupport\Model;

/**
 * Test class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testExtract extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function __construct()
    {
        date_default_timezone_set('UTC');

        $this->model = new Model;
        $this->model->client_id = 1;
        $this->model->amount = 100;
        $this->model->date = Carbon::now();
    }

    public function testExtract()
    {
        $new_model_fields = array('client_id', 'amount');
        $new_model = $this->model->extract($new_model_fields);

        //Assert it models are the same
        $this->assertEquals(get_class($this->model), get_class($new_model));

        //Assert that have new properties and values
        $this->assertArrayHasKey('client_id', $new_model->getAttributes());
        $this->assertArrayHasKey('amount', $new_model->getAttributes());

        //Assert they have the same value
        $this->assertEquals($this->model->client_id, $new_model->client_id);
    }

    public function testExtractChangingName()
    {
        $new_model_fields = array('customer_id' => 'client_id', 'amount');
        $new_model = $this->model->extract($new_model_fields);

        //Assert new property name exist
        $this->assertArrayHasKey('customer_id', $new_model->getAttributes());
    }  
    
}