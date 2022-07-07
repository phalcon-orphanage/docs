---
layout: default
language: 'es-es'
version: '5.0'
title: 'Comportamientos en Modelos (Behaviors)'
keywords: 'modelos, comportamientos'
---

# Comportamientos en Modelos (Behaviors)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Behaviors][mvc-model-behavior] are shared constructs that several models may adopt in order to re-use code. Although you can use [traits][traits] to reuse code, behaviors have several benefits that make them more appealing. Los `Traits` requieren que use exactamente los mismos nombres de campos para que el código común funcione. Los Comportamientos son más flexibles.

El ORM proporciona un API para implementar los comportamientos en sus modelos. Además, puede usar los eventos y las llamadas de retorno vistas anteriormente como alternativa para implementar los comportamientos.

Un comportamiento se debe añadir en el inicializador del modelo, un modelo puede tener ninguno o más comportamientos:

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

## Integrado
El framework proporciona los siguientes comportamientos integrados:

| Nombre                                            | Descripción                                                                                                              |
| ------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| [SoftDelete][mvc-model-behavior-softdelete]       | En lugar de borrar permanentemente un registro, marca el registro como borrado cambiando el valor de una columna bandera |
| [Timestampable][mvc-model-behavior-timestampable] | Le permite actualizar automáticamente un atributo del modelo guardando la fecha cuando un registro se crea o actualiza   |

## Timestampable
Este comportamiento recibe un vector de opciones, la clave del primer nivel debe ser un nombre de evento que indica cuando se debe asignar la columna:

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

Each event can have its own options, `field` is the name of the column that must be updated, if `format` is a string it will be used as the format of the [date][date] function. `format` puede ser una función anónima que ofrece funcionalidad adicional para generar cualquier tipo de cadena de marca de tiempo:

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

If the option `format` is omitted a timestamp using the PHP's function [time][time], will be used.

## SoftDelete
Este comportamiento se puede usar como sigue:

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

Este comportamiento acepta dos opciones: `field` y `value`, `field` determina el campo a ser actualizado y `value` el valor para estar borrado. Suponiendo que nuestra tabla tiene las siguientes filas:

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

Si borramos cualquiera de los dos registros se actualizará el estado en lugar de borrar el registro:

```php
<?php

Invoices::findFirst(2)->delete();
```

La operación provocará los siguientes datos en la tabla:

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

> **NOTE**: You will need to ensure to specify the _deleted_ condition to filter your records so that you can get deleted or not deleted results back. Este comportamiento no soporta filtrado automático. 
> 
> {: .alert .alert-warning }

## Personalizado
El ORM proporciona un API para crear sus propios comportamientos. A behavior must be a class implementing the [Phalcon\Mvc\Model\BehaviorInterface][mvc-model-behaviorinterface] or extend [Phalcon\Mvc\Model\Behavior][mvc-model-behavior] which exposes most of the methods required for implementing custom behaviors.

The [Phalcon\Mvc\Model\BehaviorInterface][mvc-model-behaviorinterface] requires two methods to be present in your custom behavior:

```php 
public function missingMethod(
    ModelInterface $model, 
    string $method, 
    array $arguments = []
)
```

Este método actúa como respaldo cuando se llama un método inexistente en el modelo

```php
public function notify(
    string $type, 
    ModelInterface $model
)
```

Este método recibe las notificaciones del [Events Manager](events).

Additionally if you extend [Phalcon\Mvc\Model\Behavior][mvc-model-behavior], you have access to:

- `getOptions(string $eventName = null)` - Devuelve las opciones del comportamiento relativas a un evento
- `mustTakeAction(string $eventName)` - `bool` - Comprueba si el comportamiento debe realizar acciones sobre un cierto evento

El siguiente comportamiento es un ejemplo, implementa el comportamiento `Blameable` que ayuda a identificar el usuario que ha ejecutado operaciones sobre el modelo:

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

Lo anterior es un comportamiento muy simple, pero ilustra como crear un comportamiento. Añadir el comportamiento a un modelo se ilustra a continuación:

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

Un comportamiento también es capaz de interceptar métodos inexistentes en sus modelos, y ofrecer funcionalidad para ellos:

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

Llamar a ese método en un modelo que implementa `Sluggable` devuelve un título amigable SEO:

```php
<?php

$title = $invoice->getSlug();
```

## Rasgos (Traits)
You can use [Traits][traits] to re-use code in your classes, this is another way to implement custom behaviors. El siguiente rasgo implementa una versión simple del comportamiento `Timestampable`:

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

Entonces puede usarlo en su modelo de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    use Timestampable;
}
```

> **NOTE**: You can use traits instead of behaviors, but they do require that all your fields, that the behavior will affect, must have the same name. También, si implementa un método de evento en un rasgo (ej. `beforeCreate`) no podrá tenerlo también en su modelo ya que los dos producirán un error. 
> 
> {: .alert .alert-info }


[date]: https://php.net/manual/en/function.date.php
[mvc-model-behavior]: api/phalcon_mvc#mvc-model-behavior
[mvc-model-behavior]: api/phalcon_mvc#mvc-model-behavior
[mvc-model-behavior-softdelete]: api/phalcon_mvc#mvc-model-behavior-softdelete
[mvc-model-behavior-timestampable]: api/phalcon_mvc#mvc-model-behavior-timestampable
[mvc-model-behaviorinterface]: api/phalcon_mvc#mvc-model-behaviorinterface
[time]: https://php.net/manual/en/function.time.php
[traits]: https://php.net/manual/en/language.oop5.traits.php
[traits]: https://php.net/manual/en/language.oop5.traits.php
