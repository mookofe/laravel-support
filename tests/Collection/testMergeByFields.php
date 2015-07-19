<?php namespace Mookofe\LaravelSupport\Tests\Collections;

use Mookofe\LaravelSupport\Model;
use Mookofe\LaravelSupport\Collection;

/**
 * Test merge by field
 *
 * @author Victor Cruz <cruzrosario@gmail.com> 
 */
class testMergeByFields extends BaseCollection
{

    public function testMergeByFields()
    {
        $model = new Model;
        $model->user_id = 1;
        $model->file_path = '/avatars/af3311.jpg';

        $user_avatar = new Collection;
        $user_avatar->add($model);

        $fields_to_compare = array('id' => 'user_id');
        $fields_to_merge = array('file_path');
    
        $this->collection->mergeByFields($user_avatar, $fields_to_compare, $fields_to_merge);

        //Assert first model has the item file_path
        $first = $this->collection->first();
        $this->assertTrue($first->attributeExist('file_path'));

        //Assert the value is the same
        $this->assertEquals($first->file_path, $model->file_path);
    }

}