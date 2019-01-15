* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Model Behaviors

Behaviors are shared constructs that several models may adopt in order to re-use code. The ORM provides an API to implement behaviors in your models. Also, you can use the events and callbacks as seen before as an alternative to implement Behaviors with more freedom.

A behavior must be added in the model initializer, a model can have zero or more behaviors:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Users extends Model
{
    public $id;

    public $name;

    public $created_at;

    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    'beforeCreate' => [
                        'field'  => 'created_at',
                        'format' => 'Y-m-d',
                    ]
                ]
            )
        );
    }
}
```

The following built-in behaviors are provided by the framework:

| Name          | 描述                                                                                                         |
| ------------- | ---------------------------------------------------------------------------------------------------------- |
| Timestampable | Allows to automatically update a model's attribute saving the datetime when a record is created or updated |
| SoftDelete    | Instead of permanently delete a record it marks the record as deleted changing the value of a flag column  |

<a name='timestampable'></a>

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
                    'field'  => 'created_at',
                    'format' => 'Y-m-d',
                ]
            ]
        )
    );
}
```

Each event can have its own options, `field` is the name of the column that must be updated, if `format` is a string it will be used as format of the PHP's function [date](https://php.net/manual/en/function.date.php), format can also be an anonymous function providing you the free to generate any kind timestamp:

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
                    'field'  => 'created_at',
                    'format' => function () {
                        $datetime = new Datetime(
                            new DateTimeZone('Europe/Stockholm')
                        );

                        return $datetime->format('Y-m-d H:i:sP');
                    }
                ]
            ]
        )
    );
}
```

If the option `format` is omitted a timestamp using the PHP's function [time](https://php.net/manual/en/function.time.php), will be used.

<a name='softdelete'></a>

## SoftDelete

This behavior can be used as follows:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;

class Users extends Model
{
    const DELETED     = 'D';
    const NOT_DELETED = 'N';

    public $id;
    public $name;
    public $status;

    public function initialize()
    {
        $this->addBehavior(
            new SoftDelete(
                [
                    'field' => 'status',
                    'value' => Users::DELETED,
                ]
            )
        );
    }
}
```

This behavior accepts two options: `field` and `value`, `field` determines what field must be updated and `value` the value to be deleted. Let's pretend the table `users` has the following data:

```sql
mysql> select * from users;
+----+---------+--------+
| id | name    | status |
+----+---------+--------+
|  1 | Lana    | N      |
|  2 | Brandon | N      |
+----+---------+--------+
2 rows in set (0.00 sec)
```

If we delete any of the two records the status will be updated instead of delete the record:

```php
<?php

Users::findFirst(2)->delete();
```

The operation will result in the following data in the table:

```sql
mysql> select * from users;
+----+---------+--------+
| id | name    | status |
+----+---------+--------+
|  1 | Lana    | N      |
|  2 | Brandon | D      |
+----+---------+--------+
2 rows in set (0.01 sec)
```

Note that you need to specify the deleted condition in your queries to effectively ignore them as deleted records, this behavior doesn't support that.

<a name='create-your-own-behaviors'></a>

## Creating your own behaviors

The ORM provides an API to create your own behaviors. A behavior must be a class implementing the [Phalcon\Mvc\Model\BehaviorInterface](api/Phalcon_Mvc_Model_BehaviorInterface). Also, [Phalcon\Mvc\Model\Behavior](api/Phalcon_Mvc_Model_Behavior) provides most of the methods needed to ease the implementation of behaviors.

The following behavior is an example, it implements the Blameable behavior which helps identify the user that is performed operations over a model:

```php
<?php

use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Blameable extends Behavior implements BehaviorInterface
{
    public function notify($eventType, $model)
    {
        switch ($eventType) {

            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                $userName = // ... get the current user from session

                // Store in a log the username, event type and primary key
                file_put_contents(
                    'logs/blamable-log.txt',
                    $userName . ' ' . $eventType . ' ' . $model->id
                );

                break;

            default:
                /* ignore the rest of events */
        }
    }
}
```

The former is a very simple behavior, but it illustrates how to create a behavior, now let's add this behavior to a model:

```php
<?php

use Phalcon\Mvc\Model;

class Profiles extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Blameable()
        );
    }
}
```

A behavior is also capable of intercepting missing methods on your models:

```php
<?php

use Phalcon\Tag;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Sluggable extends Behavior implements BehaviorInterface
{
    public function missingMethod($model, $method, $arguments = [])
    {
        // If the method is 'getSlug' convert the title
        if ($method === 'getSlug') {
            return Tag::friendlyTitle($model->title);
        }
    }
}
```

Call that method on a model that implements Sluggable returns a SEO friendly title:

```php
<?php

$title = $post->getSlug();
```

<a name='traits-as-behaviors'></a>

## Using Traits as behaviors

You can use [Traits](https://php.net/manual/en/language.oop5.traits.php) to re-use code in your classes, this is another way to implement custom behaviors. The following trait implements a simple version of the Timestampable behavior:

```php
<?php

trait MyTimestampable
{
    public function beforeCreate()
    {
        $this->created_at = date('r');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('r');
    }
}
```

Then you can use it in your model as follows:

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    use MyTimestampable;
}
```