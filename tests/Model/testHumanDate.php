<?php namespace Mookofe\LaravelSupport\Tests\Models;

use Carbon\Carbon;
use Mookofe\LaravelSupport\Model;

/**
 * Test human date method class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testHumanDate extends \PHPUnit_Framework_TestCase
{

    public function __construct()
    {
        date_default_timezone_set('UTC');
    }

    public function testGetHumanDate()
    {
        $model = new Model;
        $model->date = '2014-01-01 00:00:00';

        //Asserts
        $this->assertEquals('January 1, 2014', $model->getHumanDate('date'));
    }

    public function testGetHumanDateCarbon()
    {
        $model = new Model;
        $model->date = Carbon::create(2014, 1, 1, 0, 0, 0);

        //Asserts
        $this->assertEquals('January 1, 2014', $model->getHumanDate('date'));
    }

    /**
     * @expectedException     Mookofe\LaravelSupport\Exceptions\AttributeNotFoundException
     */
    public function testGetHumanDateAttrNotFound()
    {
        $model = new Model;
        
        //Asserts
        $model->getHumanDate('date');
    }
    
}