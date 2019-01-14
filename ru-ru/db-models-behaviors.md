* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Поведение модели

Поведения — это некторые общие конструкции или компоненты, которые могут быть применены несколькими моделями в целях переиспользования кода. ORM предоставляет API для реализации поведений для вашей модели. Also, you can use the events and callbacks as seen before as an alternative to implement Behaviors with more freedom.

Поведение должно быть добавлено при инициализации модели, модель может иметь ноль или более поведений:

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
                    "beforeCreate" => [
                        "field"  => 'created_at',
                        "format" => 'Y-m-d',
                    ]
                ]
            )
        );
    }
}
```

Фреймворком предоставлены следующие встроенные поведения:

| Название      | Описание                                                                                                        |
| ------------- | --------------------------------------------------------------------------------------------------------------- |
| Timestampable | Позволяет автоматически обновлять атрибут модели, сохраняя дату и время, когда запись создается или обновляется |
| SoftDelete    | Вместо окончательного удаления записи, изменением значения флага столбца она помечается как удалённая           |

<a name='timestampable'></a>

## Timestampable

Это поведение в качестве аргумента принимает массив, ключи которого являются названиями событий, указывающих на то, когда должно происходить присваивание:

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

Это поведение может быть использовано следующим образом:

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

Это поведение принимает две опции: `field` и `value`. Опция `field` указывает поле, которое должно быть обновлено, и `value` — значение, которым будут помечаться удаленные записи. Давайте представим, что таблица `users` имеет следующие данные:

```sql
mysql> select * from users;
+----+---------+--------+
| id | name    | status |
+----+---------+--------+
|  1 | Яна     | N      |
|  2 | Филипп  | N      |
+----+---------+--------+
2 rows in set (0.00 sec)
```

Если мы удалим любую из двух записей, изменится статус вместо удаления записи:

```php
<?php

Users::findFirst(2)->delete();
```

Операция приводит к следующим данным в таблице:

```sql
mysql> select * from users;
+----+---------+--------+
| id | name    | status |
+----+---------+--------+
|  1 | Яна     | N      |
|  2 | Филипп  | D      |
+----+---------+--------+
2 rows in set (0.00 sec)
```

Обратите внимание, что вам необходимо самостоятельно указывать в запросах условие удаления записи для того, чтобы игнорировать их как удаленные. Подобная логика не поддерживается поведением.

<a name='create-your-own-behaviors'></a>

## Создание собственных поведений

ORM предоставляет API для создания собственного поведения. A behavior must be a class implementing the [Phalcon\Mvc\Model\BehaviorInterface](api/Phalcon_Mvc_Model_BehaviorInterface). Also, [Phalcon\Mvc\Model\Behavior](api/Phalcon_Mvc_Model_Behavior) provides most of the methods needed to ease the implementation of behaviors.

В качестве примера приведем следующее поведение, оно реализует поведение Blameable, которое помогает идентифицировать пользователя, выполняющего операции с моделью:

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

                $userName = // ... получаем текущего пользователя из сессии

                // Сохраняем в логах имя пользователя, тип события и идентификатор записи
                file_put_contents(
                    'logs/blamable-log.txt',
                    $userName . ' ' . $eventType . ' ' . $model->id
                );

                break;

            default:
                /* игнорируем остальные события */
        }
    }
}
```

Пример выше довольно прост, но он показывает, как создать поведение. Теперь давайте добавим его в модель:

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

Поведение также может перехватывать отсутствующие методы ваших моделей:

```php
<?php

use Phalcon\Tag;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Sluggable extends Behavior implements BehaviorInterface
{
    public function missingMethod($model, $method, $arguments = [])
    {
        // Если метод — 'getSlug', то преобразуем заголовок
        if ($method === 'getSlug') {
            return Tag::friendlyTitle($model->title);
        }
    }
}
```

Вызов этого метода у модели, реализующей Sluggable, возвращает SEO-оптимизированный заголовок:

```php
<?php

$title = $post->getSlug();
```

<a name='traits-as-behaviors'></a>

## Использование трейтов, как поведений

You can use [Traits](https://php.net/manual/en/language.oop5.traits.php) to re-use code in your classes, this is another way to implement custom behaviors. Следующий трейт реализует простой вариант поведения Timestampable:

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

Затем вы можете использовать его в вашей модели следующим образом:

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    use MyTimestampable;
}
```