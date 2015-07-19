<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Base Collection class
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
abstract class BaseCollection extends \PHPUnit_Framework_TestCase
{

    protected $collection;

    public function __construct()
    {
        //Initialize collection
        $this->collection = new Collection;
        $this->fillCollection();
    }

    protected function fillCollection()
    {
        //Fill collection with models
        $model = new Model;
        $model->id = 1;
        $model->name = 'John';
        $model->lastname = 'Doe';
        $model->sex = 'M';
        $this->collection->add($model);

        $model = new Model;
        $model->id = 2;
        $model->name = 'Jane';
        $model->lastname = 'Doe';
        $model->sex = 'F';
        $this->collection->add($model);
    }     
    
}