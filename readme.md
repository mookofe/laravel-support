mookofe/laravel-support
=========

Awesome enhancements for your current Laravel Models, Collections and more.

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
Chage inheritance on your models, instead of using the default Eloquent Model change as follow:

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
	echo $model->getHumanDate('current_date');                             //January 01, 2015
		
	//Using Carbon datetime format:
	echo $model->getHumanDate('current_date', 'l jS \\of F Y h:i:s A');    //Thursday 1st of January 01 2015 00:00:00 AM

```


###Check if property exist in the model

This function verify if a property already exist in the current model.

```php	
	$model = new Model;
	echo $model->propertyExist('new_property);          //false
	
	$model->new_property = null;
	echo $model->propertyExist('new_property);          //true    
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
	
	$new_model = $model->extract(array('client_id', 'amount'));
```



<!--Using Collection features:
------>



License
----
This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)