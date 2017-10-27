<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Comportamientos en modelos (Behaviors)</a> <ul>
        <li>
          <a href="#timestampable">Timestampable</a>
        </li>
        <li>
          <a href="#softdelete">SoftDelete</a>
        </li>
        <li>
          <a href="#create-your-own-behaviors">Crea tus propios comportamientos</a>
        </li>
        <li>
          <a href="#traits-as-behaviors">Utilizando traits como comportamientos</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Comportamientos en modelos (Behaviors)

Los comportamientos son conductas compartidas que varios modelos pueden adoptar con el fin de reutilizar código, el ORM proporciona una API para implementar comportamientos en sus modelos. Además, puede utilizar los eventos y callbacks, como se ha visto antes, como una alternativa para implementar comportamientos con más libertad.

Un comportamiento debe agregarse en el inicializador del modelo, un modelo puede tener cero o más comportamientos:

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

Phalcon proporciona los siguientes comportamientos listos para utilizarse:

| Nombre        | Descripción                                                                                                                     |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Timestampable | Permite actualizar automáticamente el atributo de un modelo guardando el datetime cuando es creado o actualizado un registro    |
| SoftDelete    | En lugar de eliminar permanentemente un registro, se marca el registro como borrado, al cambiar el valor de una columna bandera |

<a name='timestampable'></a>

## Timestampable

Este comportamiento recibe un array de opciones, la primera clave debe ser un nombre de evento que indica cuando la columna debe ser asignada:

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

Cada evento puede tener sus propias opciones, `field` es el nombre de la columna que debe actualizarse, si `format` es un `string` que se utilizará como formato de PHP para la función [date](http://php.net/manual/en/function.date.php), también puede ser una función anónima que le proporciona la libertad de generar cualquier tipo timestamp:

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

Si se omite la opción `format` se utilizará la función [time](http://php.net/manual/en/function.time.php) de PHP.

<a name='softdelete'></a>

## SoftDelete

Este comportamiento se puede utilizar de la sigue manera:

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

Este comportamiento acepta dos opciones: `field` y `vale`, siendo `field` el campo debe ser actualizado y `vale` el valor de eliminado. Supongamos que la tabla `users` tiene los siguientes datos:

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

Si borramos cualquiera de los dos usuarios se actualizará el estado (status) en vez borrarse el registro:

```php
<?php

Users::findFirst(2)->delete();
```

La operación resultará en los siguientes datos en la tabla:

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

Nota: Tenga en cuenta que usted necesitara especificar la condición de eliminado en sus consultas para ignorar registros marcados como eliminados, este comportamiento no tiene soporte para hacerlo automáticamente.

<a name='create-your-own-behaviors'></a>

## Crea tus propios comportamientos

El ORM proporciona una API para crear tus propios comportamientos. Un comportamiento debe ser una clase que implementa la interfaz `Phalcon\Mvc\Model\BehaviorInterface`. Además `Phalcon\Mvc\Model\Behavior` proporciona la mayor parte de los métodos necesarios para facilitar la aplicación de los comportamientos.

El siguiente comportamiento es un ejemplo, implementa el comportamiento Blameable que ayuda a identificar al usuario que realizo operaciones sobre un modelo:

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

                $userName = // ... obtiene el usuario actual desde la sesión

                // Almacena en un log el nombre de usuario, tipo de evento y clave primaria
                file_put_contents(
                    'logs/blamable-log.txt',
                    $userName . ' ' . $eventType . ' ' . $model->id
                );

                break;

            default:
                /* ignorar el resto de los eventos */
        }
    }
}
```

El primero es un comportamiento muy simple, pero ilustra cómo crear un comportamiento, ahora vamos a agregar este comportamiento a un modelo:

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

Un comportamiento también es capaz de interceptar métodos faltantes en tus modelos:

```php
<?php

use Phalcon\Tag;
use Phalcon\Mvc\Model\Behavior;
use Phalcon\Mvc\Model\BehaviorInterface;

class Sluggable extends Behavior implements BehaviorInterface
{
    public function missingMethod($model, $method, $arguments = [])
    {
        // Si el método es 'getSlug', modificar el título
        if ($method === 'getSlug') {
            return Tag::friendlyTitle($model->title);
        }
    }
}
```

Llame a ese método en un modelo que implementa Sluggable y devolverá un título amigable para el SEO:

```php
<?php

$title = $post->getSlug();
```

<a name='traits-as-behaviors'></a>

## Utilizando traits como comportamientos

Usted puede utilizar [traits](http://php.net/manual/en/language.oop5.traits.php) para reutilizar código en tus clases, esta es otra manera se puede implementar comportamientos personalizados. El traits siguiente implementa una versión simple del comportamiento Timestampable:

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

Entonces lo puedes utilizar en tu modelo de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    use MyTimestampable;
}
```