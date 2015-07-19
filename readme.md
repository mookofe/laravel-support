mookofe/laravel-support
=========

Awesome enhancements for your current Laravel Models, Collections and more.

###Work in progress, do not use in production!

[![Build Status](https://travis-ci.org/mookofe/laravel-support.svg?branch=master)](https://travis-ci.org/mookofe/laravel-support)

<!--[![Build Status](https://travis-ci.org/mookofe/tail.svg?branch=master)](https://travis-ci.org/mookofe/tail)
[![Latest Stable Version](https://poser.pugx.org/mookofe/tail/v/stable.svg)](https://packagist.org/packages/mookofe/tail)
[![License](https://poser.pugx.org/mookofe/tail/license.svg)](https://packagist.org/packages/mookofe/tail)
-->

Features
----
  - Simple setup
  - Awesome new features for your current Models
  - New features for your Collections


Requirements
----
  - illuminate/support: 5.*


Version
----
0.0.1


Installation
--------------

**Preparation**

Open your composer.json file and add the following to the require array: 

```js
"mookofe/laravel-support": "0.*"
```

**Install dependencies**

```
$ php composer install
```

Or

```batch
$ php composer update
```


Integration
--------------
Change inheritance on your models, instead of using the default Eloquent Model change as follow:

```php
<?php namespace App;

use Mookofe\LaravelSupport\Model;

class User extends Model {

}

```


Using Model features:
----

###Getting human dates from model fields

This method works both for string and carbon dates fields.

```php
	$model->current_date = '2015-01-01 00:00:00';
	echo $model->getHumanDate('current_date');                 //January 01, 2015
		
	//Using Carbon datetime format:
	$format = 'l jS \\of F Y h:i:s A';
	echo $model->getHumanDate('current_date', $format);        //Thursday 1st of January 01 2015 00:00:00 AM

```


###Check if an attribute exists in the model

This function verify if an attribute already exists in the current model.

```php
	$model = new Model;
	echo $model->attributeExist('new_property');          //false
	
	$model->new_property = null;
	echo $model->attributeExist('new_property');          //true
```

###Get changes in a model

Return an array with the affected properties.

```php
	$model = new Model;
	$changes = $model->getChanges();                    //array();
	
	$model->client_id = 1;
	$changes = $model->getChanges();                    //array( array('field' => 'client_id', 'old_value' => '', 'new_value' => 1) );
```

###Create new model from existing using only specific fields
Create a new instance only with the fields specified

```php
	$model = new Model;
	$model->client_id = 1;
	$model->amount = 100;
	$model->date = Carbon::now();
	
	$new_model_fields = array('client_id', 'amount');
	$new_model = $model->extract($new_model_fields);
	
	//You are also allowed to change property name:
	$new_model_fields = array('new_field' => 'client_id', 'amount');
	$new_model = $model->extract($new_model_fields);
```

###Remove model fields
Allows you to remove fields in model

```php
	$fields_to_remove = array('client_id', 'amount');
	$model->removeFields($fields_to_remove);
```


Using Collection features:
--------------
Our model is configured to use our collection which extends from Eloquent Collection, so all methods from the Eloquent Collection can be used.

###Rebuild collection
Allows you to rebuild a collection using the fields you want. Imagine you have a user table with the following fields: (id, name, lastname, sex)

```php
	$collection = User::all();
	
	//New collection only with the specified fields
	$format = array('name', 'lastname');
	$new_collection = $collection->rebuild($format);
	
	//You can also change field names and objects as follow:
	$format = array('id', 'personal_data' => ['name', 'lastname', 'sex']);
	$new_collection = $collection->rebuild($format);
```

###Compare collections
Allows you to compare if all values of a field is present in another collection. 

```php
	$collection = User::all();
	$user_avatar_collection = User_avatar::all();
		
	//Check if all users have a record on the user avatar collection
	$collection->compare($user_avatar_collection, 'user_id', 'id');        //boolean
```

###Create new instance
Allows you to create a new empty instance of the same type of the current collection 

```php
	$collection = User::all();
	$empty_collection = $collection->createNewInstance();
```

###Get latests rows grouped by fields
Return a new collection with the latest rows grouped by the fields specified, in the order of the collection items. Imagine you have a **post** table with the following fields (id, user_id, post\_category\_id).

This example allows you to get the latest posts categories for the user.

```php
	$collection = Post::all();
	$latests = $collection->getLatestsByField( array('user_id', 'post_category_id') );
```

###Get first rows grouped by fields
Return a new collection with the first rows grouped by the fields specified, in the order of the collection items. Using the previous table structure, in this example you get the first posts categories for the user.

```php
	$collection = Post::all();
	$first = $collection->getFirstByField( array('user_id', 'post_category_id') );
```

###Sum values by field in collection
Sum all values matching the search criteria. In this example the function will sum all products prices from category 10.

```php
	$collection = Product::all();
	$sum = $collection->sumValues('product_category_id', 10, 'price');
```

###Find items on collection
Allows you to find items on the collection filter by data in the array. In this example we will filter all products with product category 10 and price 100.

```php
	$collection = Product::all();
	$filter = array('product_category_id' => 10, 'price' => 100);
	
	$filtered = $collection->findByFields($filter);
```

###Merge collections
Merge fields from the new collection if values matches. In this example we will merge the avatar file path to the user model.

```php
	$users = User::all();
	$user_avatar = User_avatar::all()
	
	$users->mergeByFields($user_avatar, array('id' => 'user_id'), array('file_path') );
```

###Custom value for found item
Allows you to return a custom value if the item you are looking for it's been found. If no option is specified the model is returned.

```php
	$users = User::all();
	$filter = array('name' => 'John');
	$options = array(
		'found_text' => 'Item exist',
		'not_found_text' => 'Item not found',
		'field' => 'field_name'
	);
		
	echo $users->showIfFound($filter, $options);
```

###Delete all models from collection
Allows you to delete all models from the database in the current collection.

```php
	$user_comments = User_comment::all();
	$user_comments->delete();
```

###Collection average by field
Allows you to get the average by a field

```php
	$products = Product::all();
	echo $products->avg('price');
	
	//Including null values for average, assumed as zero.
	echo $products->avg('price', true);
```

###Find items not matching the filter
Allows you to find items on the collection not matching the filter criteria. In this example we will filter all products where product category is different to 10.

```php
	$collection = Product::all();
	$filter = array('product_category_id' => 10);
	
	$filtered = $collection->findIfDifferent($filter);
```

###Get maximum item by field name
Get the max value of the given key and return the item. In this example the function will return the max user from the collection.

```php
	$users = User::all();
	$max_user = $users->maxItem('id');
```

License
----
This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)