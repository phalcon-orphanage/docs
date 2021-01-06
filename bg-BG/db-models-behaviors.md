---
layout: default
language: 'en'
version: '4.0'
title: 'Model Behaviors'
keywords: 'models, behaviors'
---

# Model Behaviors

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Behaviors](api/phalcon_mvc#mvc-model-behavior) are shared constructs that several models may adopt in order to re-use code. Although you can use [traits](https://php.net/manual/en/language.oop5.traits.php) to reuse code, behaviors have several benefits that make them more appealing. Traits require you to use exactly the same field names for common code to work. Behaviors are more flexible.

The ORM provides an API to implement behaviors in your models. Also, you can use the events and callbacks as seen before as an alternative to implement behaviors.

A behavior must be added in the model initializer, a model can have zero or more behaviors:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Invoices extends Model
{
    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_status_flag;

    /**
     * @var string
     */
    public $inv_title;

    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    'beforeCreate' => [
                        'field'  => 'inv_created_at',
                        'format' => 'Y-m-d',
                    ],
                ]
            )
        );
    }
}
```

## Built In

The following built-in behaviors are provided by the framework:

| Name                                                              | Description                                                                                                |
| ----------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| [SoftDelete](api/phalcon_mvc#mvc-model-behavior-softdelete)       | Instead of permanently delete a record it marks the record as deleted changing the value of a flag column  |
| [Timestampable](api/phalcon_mvc#mvc-model-behavior-timestampable) | Allows to automatically update a model's attribute saving the datetime when a record is created or updated |

## Timestampable

This behavior receives an array of options, the first level key must be an event name indicating when the column must be assigned:

```php
<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;

public function initialize()
{
    $this->addBehavior(
        new Timestampable(
            [
                'beforeCreate' => [
                    'field'  => 'inv_created_at',
                    'format' => 'Y-m-d',
                ],
            ]
        )
    );
}
```

Each event can have its own options, `field` is the name of the column that must be updated, if `format` is a string it will be used as the format of the [date](https://php.net/manual/en/function.date.php) function. `format` can also be an anonymous function offering additional functionality to generate any kind of timestamp string:

```php
<?php

use DateTime;
use DateTimeZone;
use Phalcon\Mvc\Model\Behavior\Timestampable;

public function initialize()
{
    $this->addBehavior(
        new Timestampable(
            [
                'beforeCreate' => [
                    'field'  => 'inv_created_at',
                    'format' => function () {
                        $datetime = new Datetime(
                            new DateTimeZone('Europe/Stockholm')
                        );

                        return $datetime->format('Y-m-d H:i:sP');
                    },
                ],
            ]
        )
    );
}
```

If the option `format` is omitted a timestamp using the PHP's function [time](https://php.net/manual/en/function.time.php), will be used.

## SoftDelete

This behavior can be used as follows:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Invoices extends Model
{
    const ACTIVE   = 1;
    const INACTIVE = 0;

    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_deleted_flag;

    /**
     * @var string
     */
    public $inv_title;

    public function initialize()
    {
        $this->addBehavior(
            new SoftDelete(
                [
                    'field' => 'inv_deleted_flag',
                    'value' => Invoices::INACTIVE,
                ]
            )
        );
    }
}
```

This behavior accepts two options: `field` and `value`, `field` determines what field must be updated and `value` the value to be deleted. Assuming that our table has the following rows:

```sql
mysql> select * from co_invoices;
+--------+------------------+-----------------------------+
| inv_id | inv_deleted_flag | inv_title                   |
+--------+------------------+-----------------------------+
|  1     | 0                | Invoice for ACME Inc.       |
|  2     | 0                | Invoice for Spaceballs Inc. |
+--------+------------------+-----------------------------+
2 rows in set (0.00 sec)
```

If we delete any of the two records the status will be updated instead of delete the record:

```php
<?php

Invoices::findFirst(2)->delete();
```

The operation will result in the following data in the table:

```sql
mysql> select * from co_invoices;
+--------+------------------+-----------------------------+
| inv_id | inv_deleted_flag | inv_title                   |
+--------+------------------+-----------------------------+
|  1     | 0                | Invoice for ACME Inc.       |
|  2     | 1                | Invoice for Spaceballs Inc. |
+--------+------------------+-----------------------------+
2 rows in set (0.00 sec)
```

> **NOTE**: You will need to ensure to specify the *deleted* condition to filter your records so that you can get deleted or not deleted results back. This behavior does not support automatic filtering.
{: .alert .alert-warning }

## Custom

The ORM provides an API to create your own behaviors. A behavior must be a class implementing the [Phalcon\Mvc\Model\BehaviorInterface](api/phalcon_mvc#mvc-model-behaviorinterface) or extend [Phalcon\Mvc\Model\Behavior](api/phalcon_mvc#mvc-model-behavior) which exposes most of the methods required for implementing custom behaviors.

The [Phalcon\Mvc\Model\BehaviorInterface](api/phalcon_mvc#mvc-model-behaviorinterface) requires two methods to be present in your custom behavior:

```php
public function missingMethod(
    ModelInterface $model, 
    string $method, 
    array $arguments = []
)
```

This methods acts as a fallback when a missing method is called on the model

```php
public function notify(
    string $type, 
    ModelInterface $model
)
```

This method receives the notifications from the [Events Manager](events).

Additionally if you extend [Phalcon\Mvc\Model\Behavior](api/phalcon_mvc#mvc-model-behavior), you have access to:

- `getOptions(string $eventName = null)` - Returns the behavior options related to an event
- `mustTakeAction(string $eventName)` - `bool` - Checks whether the behavior must take action on certain event

The following behavior is an example, it implements the `Blameable` behavior which helps identify the user that is performed operations on a model:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;

class Blameable extends Behavior
{
    public function notify(string $eventType, ModelInterface $model)
    {
        $container = Di::getDefault();
        $userName  = $container->get('auth')->getFullName();

        switch ($eventType) {

            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                file_put_contents(
                    'logs/blamable-log.txt',
                    $userName . ' ' . $eventType . ' ' . $model->inv_id
                );

                break;

            default:
                // ...
        }
    }
}
```

The above is a very simple behavior, but it illustrates how to create a behavior. Adding the behavior to a model is illustrated below:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Blameable()
        );
    }
}
```

A behavior is also capable of intercepting missing methods on your models, and offering functionality for them:

```php
<?php

use Phalcon\Tag;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Sluggable extends Behavior
{
    public function missingMethod(
        string $model, 
        ModelInterface $method, 
        $arguments = []
    ) {
        if ($method === 'getSlug') {
            return Tag::friendlyTitle($model->title);
        }
    }
}
```

Calling that method on a model that implements `Sluggable` returns a SEO friendly title:

```php
<?php

$title = $invoice->getSlug();
```

## Traits

You can use [Traits](https://php.net/manual/en/language.oop5.traits.php) to re-use code in your classes, this is another way to implement custom behaviors. The following trait implements a simple version of the `Timestampable` behavior:

```php
<?php

trait Timestampable
{
    public function beforeCreate()
    {
        $this->inv_created_at = date('r');
    }

    public function beforeUpdate()
    {
        $this->inv_updated_at = date('r');
    }
}
```

Then you can use it in your model as follows:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    use Timestampable;
}
```

> **NOTE**: You can use traits instead of behaviors, but they do require that all your fields, that the behavior will affect, must have the same name. Also if you implement an event method in a trait (e.g. `beforeCreate`) you cannot have it also in your model since the two will produce an error.
{: .alert .alert-info }


