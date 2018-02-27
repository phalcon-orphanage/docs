<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Поведение модели</a> <ul>
        <li>
          <a href="#timestampable">Timestampable</a>
        </li>
        <li>
          <a href="#softdelete">SoftDelete</a>
        </li>
        <li>
          <a href="#create-your-own-behaviors">Создание собственных поведений</a>
        </li>
        <li>
          <a href="#traits-as-behaviors">Использование трейтов, как поведений</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Поведение модели

Поведения — это некторые общие конструкции или компоненты, которые могут быть применены несколькими моделями в целях переиспользования кода. ORM предоставляет API для реализации поведений для вашей модели. Кроме того, вы можете использовать события и функции обратного вызова, как видели раньше, в качестве альтернативы для более свободной реализации поведения.

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

Каждое событие может иметь свои собственные настройки, `field` — имя столбца, который необходимо обновить. Если `format` является строкой, то будет использоваться в качестве формата PHP функции [date](http://php.net/manual/en/function.date.php), format также может быть анонимной функцией, позволяющей вам свободно создавать любые виды временных меток:

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

Если опция `format` опущена, то будет использована временная метка PHP функции [time](http://php.net/manual/en/function.time.php).

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

ORM предоставляет API для создания собственного поведения. Поведение должно быть классом, реализующим `Phalcon\Mvc\Model\BehaviorInterface`. Кроме того, `Phalcon\Mvc\Model\Behavior` предоставляет большую часть методов, необходимых для простой реализации поведения.

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

Начиная с PHP 5.4 вы можете использовать [трейты](http://php.net/manual/en/language.oop5.traits.php), чтобы повторно использовать код в ваших классах. Это еще один способ для реализации пользовательского поведения. Следующий трейт реализует простой вариант поведения Timestampable:

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