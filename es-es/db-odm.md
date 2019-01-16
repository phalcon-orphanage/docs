* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<h5 class='alert alert-info'>Please note that if you are using the Mongo driver provided by PHP 7, the ODM will not work for you. There is an incubator adapter but all the Mongo code must be rewritten (new Bson type instead of arrays, no MongoId, no MongoDate, etc...). Please ensure that you test your code before upgrading to PHP 7 and/or Phalcon 3+</h5>

<a name='overview'></a>

# ODM (Mapeador Objecto-Documento)

In addition to its ability to [map tables](/4.0/en/models) in relational databases, Phalcon can map documents from NoSQL databases. The ODM offers a CRUD functionality, events, validations among other services.

Due to the absence of SQL queries and planners, NoSQL databases can see real improvements in performance using the Phalcon approach. Additionally, there are no SQL building reducing the possibility of SQL injections.

The following NoSQL databases are supported:

| Nombre                              | Descripción                                                                                 |
| ----------------------------------- | ------------------------------------------------------------------------------------------- |
| [MongoDB](https://www.mongodb.org/) | MongoDB es una base de datos NoSQL de código fuente abierto, escalable y de alto desempeño. |

<a name='creating-models'></a>

## Creación de Modelos

A model is a class that extends from [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection). It must be placed in the models directory. A model file must contain a single class; its class name should be in camel case notation:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{

}
```

By default model `Robots` will refer to the collection `robots`. If you want to manually specify another name for the mapping collection, you can use the `setSource()` method:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setSource('the_robots');
    }
}
```

<a name='documents-to-objects'></a>

## Entendiendo Documentos a Objetos

Every instance of a model represents a document in the collection. You can easily access collection data by reading object properties. For example, for a collection `robots` with the documents:

```bash
$ mongo test
MongoDB shell version: 1.8.2
connecting to: test
> db.robots.find()
{ '_id' : ObjectId('508735512d42b8c3d15ec4e1'), 'name' : 'Astro Boy', 'year' : 1952,
    'type' : 'mechanical' }
{ '_id' : ObjectId('5087358f2d42b8c3d15ec4e2'), 'name' : 'Bender', 'year' : 1999,
    'type' : 'mechanical' }
{ '_id' : ObjectId('508735d32d42b8c3d15ec4e3'), 'name' : 'Wall-E', 'year' : 2008 }
>
```

<a name='namespaces'></a>

## Modelos en Espacios de Nombres

Namespaces can be used to avoid class name collision. In this case it is necessary to indicate the name of the related collection using the `setSource()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setSource('robots');
    }
}
```

You could find a certain document by its ID and then print its name:

```php
<?php

// Encontrar el registro con _id = '5087358f2d42b8c3d15ec4e2'
$robot = Robots::findById('5087358f2d42b8c3d15ec4e2');

// Imprime 'Bender'
echo $robot->name;
```

Una vez que el registro está en la memoria, puede hacer modificaciones a sus datos y guardar los cambios:

```php
<?php

$robot = Robots::findFirst(
    [
        [
            'name' => 'Astro Boy',
        ]
    ]
);

$robot->name = 'Voltron';

$robot->save();
```

<a name='connection-setup'></a>

## Establecer una Conexión

Connections are retrieved from the services container. By default, Phalcon tries to find the connection in a service called `mongo`:

```php
<?php

// Conexión simple de base de datos a localhost
$di->set(
    'mongo',
    function () {
        $mongo = new MongoClient();

        return $mongo->selectDB('store');
    },
    true
);

// Conectando a un socket de dominio, volviendo a la conexión localhost
$di->set(
    'mongo',
    function () {
        $mongo = new MongoClient(
            'mongodb:///tmp/mongodb-27017.sock,localhost:27017'
        );

        return $mongo->selectDB('store');
    },
    true
);
```

<a name='finding-documents'></a>

## Búsqueda de Documentos

As [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) relies on the Mongo PHP extension you have the same facilities to query documents and convert them transparently to model instances:

```php
<?php

// Cuantos robots hay?
$robots = Robots::find();
echo 'Hay ', count($robots), "\n";

// ¿Cuántos robots mecánicos hay?
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);
echo 'Hay ', count($robots), "\n";

// Obtener e imprimir los robots mecánicos ordenados por nombre ascendentemente
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ],
        'sort' => [
            'name' => 1,
        ],
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Obtener los primeros 100 robots mecánicos ordenados por nombre
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ],
        'sort'  => [
            'name' => 1,
        ],
        'limit' => 100,
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}
```

También puede utilizar el método `findFirst()` para obtener sólo el primer registro que coincida con el criterio dado:

```php
<?php

// Cual es el primer robot en la colección robots?
$robot = Robots::findFirst();
echo 'El nombre del robot es ', $robot->name, "\n";

// Cual es el primer robot mecánico en la colección robots?
$robot = Robots::findFirst(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);

echo 'El nombre del primer robot mecánico es ', $robot->name, "\n";
```

Ambos métodos `find()` y `findFirst()` aceptan un array asociativo, especificando los criterios de búsqueda:

```php
<?php

// Primer robot donde tipo 'mechanical' y año '1999'
$robot = Robots::findFirst(
    [
        'conditions' => [
            'type' => 'mechanical',
            'year' => '1999',
        ],
    ]
);

// Todos los robots virtuales ordenados por nombre descendentemente
$robots = Robots::find(
    [
        'conditions' => [
            'type' => 'virtual',
        ],
        'sort' => [
            'name' => -1,
        ],
    ]
);

// Encontrar todos los robots que tengan más de 4 amigos usando la condición where
$robots = Robots::find(
    [
        'conditions' => [
            '$where' => 'this.friends.length > 4',
        ]
    ]
);
```

Las opciones disponibles de consulta son:

| Parameter    | Descripción                                                                                                                                                                                                               | Ejemplo                                                 |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------- |
| `conditions` | Condiciones de búsqueda para la operación de búsqueda. Se utiliza para extraer sólo los registros que cumplan con un criterio especificado. Por defecto Phalcon_model supone que el primer parámetro son las condiciones. | `'conditions' => array('$gt' => 1990)`            |
| `fields`     | Devuelve columnas concretas en lugar de los campos completos de la colección. Cuando se utiliza esta opción que se devuelve un objeto incompleto                                                                          | `'fields' => array('name' => true)`               |
| `sort`       | Se utiliza para ordenar el conjunto de resultados. Utiliza uno o más campos para cada elemento en el arreglo, 1 significa ordenar de forma ascendente, -1 descendente                                                     | `'sort' => array('name' => -1, 'status' => 1)` |
| `limit`      | Limitar los resultados de la consulta a cierto rango                                                                                                                                                                      | `'limit' => 10`                                      |
| `skip`       | Omite un número específico de resultados                                                                                                                                                                                  | `'skip' => 50`                                       |

If you have experience with SQL databases, you may want to check the [SQL to Mongo Mapping Chart](https://www.php.net/manual/en/mongo.sqltomongo.php).

<a name='finding-documents-fields'></a>

## Consulta de Campos Específicos

To query specific fields specific fields from a MongoDB database using the Phalcon ODM, all you need to do is:

```php
$myRobots = Robots:find(
    [
        'fields' => ['name' => 1]
    ]
];
```

The `find()` above only returns a `name`. It can also be combined with a `condition`:

```php
$myRobots = Robots:find(
    [
        ['type' => 'maid'],
        'fields' => ['name' => 1]
    ]
];
```

The example above returns the `name` of the robot with the `type = 'maid'`.

<a name='aggregations'></a>

## Agregaciones

A model can return calculations using [aggregation framework](https://docs.mongodb.org/manual/applications/aggregation/) provided by Mongo. The aggregated values are calculate without having to use MapReduce. With this option is easy perform tasks such as totaling or averaging field values:

```php
<?php

$data = Article::aggregate(
    [
        [
            '\$project' => [
                'category' => 1,
            ],
        ],
        [
            '\$group' => [
                '_id' => [
                    'category' => '\$category'
                ],
                'id'  => [
                    '\$max' => '\$_id',
                ],
            ],
        ],
    ]
);
```

<a name='creating-updating'></a>

## Creación y Actualización de Registros

The `Phalcon\Mvc\Collection::save()` method allows you to create/update documents according to whether they already exist in the collection associated with a model. The `save()` method is called internally by the create and update methods of [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection).

Also the method executes associated validators and events that are defined in the model:

```php
<?php

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Ups, no podemos almacenar robots en este momento: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Grandioso, un nuevo robot ha sido agregado con éxito!';
}
```

The `_id` property is automatically updated with the [MongoId](https://www.php.net/manual/en/class.mongoid.php) object created by the driver:

```php
<?php

$robot->save();

echo 'La id generada es: ', $robot->getId();
```

<a name='validation-messages'></a>

### Mensajes de validación

[Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message consists of an instance of the class [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message). The set of messages generated can be retrieved with the method getMessages(). Cada mensaje proporciona información ampliada como el nombre del campo que genera el mensaje o el tipo de mensaje:

```php
<?php

if ($robot->save() === false) {
    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo 'Mensaje: ', $message->getMessage();
        echo 'Campo: ', $message->getField();
        echo 'Tipo: ', $message->getType();
    }
}
```

<a name='events'></a>

### Eventos de Validación y Gestor de Eventos

Models allow you to implement events that will be thrown when performing an insert or update. They help define business rules for a certain model. The following are the events supported by [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) and their order of execution:

| Operación             | Nombre                     | ¿Detiene la operación? | Explicación                                                                                                                     |
| --------------------- | -------------------------- | ---------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Insertar o actualizar | `beforeValidation`         | SI                     | Es ejecutado antes del proceso de validación y la inserción o actualización final en la base de datos                           |
| Insertar              | `beforeValidationOnCreate` | SI                     | Es ejecutado antes del proceso de validación solo cuando es una operación de inserción                                          |
| Actualizar            | `beforeValidationOnUpdate` | SI                     | Es ejecutado antes de validar los campos no nulos o claves foraneas cuando es una operación de actualización                    |
| Insertar o actualizar | `onValidationFails`        | SI (detenido)          | Es ejecutado antes del proceso de validación solo cuando es una operación de inserción                                          |
| Insertar              | `afterValidationOnCreate`  | SI                     | Es ejecutado después del proceso de validación cuando es una operación de inserción                                             |
| Actualizar            | `afterValidationOnUpdate`  | SI                     | Es ejecutado después del proceso de validación cuando es una operación de actualización                                         |
| Insertar o actualizar | `afterValidation`          | SI                     | Se ejecuta tras el proceso de validación                                                                                        |
| Insertar o actualizar | `beforeSave`               | SI                     | Se ejecuta antes de la operación sobre el sistema de base de datos, para operaciones de inserción o actualización               |
| Actualizar            | `beforeUpdate`             | SI                     | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de actualización       |
| Insertar              | `beforeCreate`             | SI                     | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de inserción           |
| Actualizar            | `afterUpdate`              | NO                     | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de actualización |
| Insertar              | `afterCreate`              | NO                     | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de inserción     |
| Insertar o actualizar | `afterSave`                | NO                     | Después que la operación se ejecuta sobre el sistema de base de datos solo para inserción o actualización                       |

To make a model to react to an event, we must to implement a method with the same name of the event:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function beforeValidationOnCreate()
    {
        echo 'Esto es ejecutado antes de crear un Robot!';
    }
}
```

Events can be useful to assign values before performing an operation, for example:

```php
<?php

use Phalcon\Mvc\Collection;

class Products extends Collection
{
    public function beforeCreate()
    {
        // Establecer la fecha de creación
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Establecer la fecha de modificación
        $this->modified_in = date('Y-m-d H:i:s');
    }
}
```

Additionally, this component is integrated with the [Phalcon Events Manager](/4.0/en/events) ([Phalcon\Events\Manager](api/Phalcon_Events_Manager)), this means we can create listeners that run when an event is triggered.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

// Ajuntar una función anónima como oyente de los eventos de 'model'
$eventsManager->attach(
    'collection:beforeSave',
    function (Event $event, $robot) {
        if ($robot->name === 'Scooby Doo') {
            echo "Scooby Doo no es un robot!";

            return false;
        }

        return true;
    }
);

$robot = new Robots();

$robot->setEventsManager($eventsManager);

$robot->name = 'Scooby Doo';
$robot->year = 1969;

$robot->save();
```

In the example given above the EventsManager only acted as a bridge between an object and a listener (the anonymous function). If we want all objects created in our application use the same EventsManager, then we need to assign this to the Models Manager:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

// Registrando el servicio collectionManager
$di->set(
    'collectionManager',
    function () {
        $eventsManager = new EventsManager();

        // Adjuntar una función anónima como oyente de los eventos del 'model'
        $eventsManager->attach(
            'collection:beforeSave',
            function (Event $event, $model) {
                if (get_class($model) === 'Robots') {
                    if ($model->name === 'Scooby Doo') {
                        echo "Scooby Doo no es un robot!";

                        return false;
                    }
                }

                return true;
            }
        );

        // Establecer un EventsManager por defecto
        $modelsManager = new CollectionManager();

        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    },
    true
);
```

<a name='business-rules'></a>

### Implementación de una Regla de Negocio

When an insert, update or delete is executed, the model verifies if there are any methods with the names of the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    protected function beforeSave()
    {
        if ($this->year < 0) {
            echo 'El año no puede ser menor a cero!';

            return false;
        }
    }
}
```

Some events return `false` as an indication to stop the current operation. If an event doesn't return anything, `Phalcon\Mvc\Collection` will assume a `true` value.

<a name='data-integrity'></a>

### Validar la integridad de los datos

[Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) provides several events to validate data and implement business rules. El evento especial `validation` nos permite llamar a validadores incorporados en el registro. Phalcon expone algunos validadores incorporados que pueden utilizarse en esta etapa de validación.

En el ejemplo siguiente se muestra cómo se utiliza:

```php
<?php

use Phalcon\Mvc\Collection;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;

class Robots extends Collection
{
    public function validation()
    {
        $validation = new Validation();

        $validation->add(
            'type',
            new InclusionIn(
                [
                    'message' => 'El tipo debe ser: mechanical o virtual',
                    'domain' => [
                        'Mechanical',
                        'Virtual',
                    ],
                ]
            )
        );

        $validation->add(
            'price',
            new Numericality(
                [
                    'message' => 'El precio debe ser numérico'
                ]
            )
        );

        return $this->validate($validation);
    }
}
```

The example above performs a validation using the built-in validator `InclusionIn`. It checks that the value of the field `type` is in a `domain` list. If the value is not included in the list, then the validator will fail and return `false`.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a> </h5>

<a name='deleting-records'></a>

## Eliminar Registros

The `Phalcon\Mvc\Collection::delete()` method allows you to delete a document. You can use it as follows:

```php
<?php

$robot = Robots::findFirst();

if ($robot !== false) {
    if ($robot->delete() === false) {
        echo "Lo sentimos, no pudimos borrar el robot: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'El robot fue borrado correctamente!';
    }
}
```

You can also delete many documents by traversing a resultset with a `foreach` loop:

```php
<?php

$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);

foreach ($robots as $robot) {
    if ($robot->delete() === false) {
        echo "Lo sentimos, no pudimos borrar el robot: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'El robot fue borrado correctamente!';
    }
}
```

Los siguientes eventos están disponibles para definir reglas de negocios personalizadas que se pueden ejecutar cuando se realiza una operación de eliminación:

| Operación | Nombre         | ¿Detiene la operación? | Explicación                                       |
| --------- | -------------- | ---------------------- | ------------------------------------------------- |
| Deleting  | `beforeDelete` | SI                     | Se ejecuta antes de la operación de eliminación   |
| Deleting  | `afterDelete`  | NO                     | Se ejecuta después de la operación de eliminación |

<a name='validation-failed-events'></a>

## Eventos de validación fallidos

Another type of events is available when the data validation process finds any inconsistency:

| Operación                     | Nombre              | Explicación                                                                        |
| ----------------------------- | ------------------- | ---------------------------------------------------------------------------------- |
| Insertar o actualizar         | `notSave`           | Se dispara cuando la operación de inserción o actualización falla por alguna razón |
| Insertar, borrar o actualizar | `onValidationFails` | Se dispara cuando cualquier operación de manipulación de datos falla               |

<a name='ids-vs-primary-keys'></a>

## IDs Implícitos vs. Llaves Primarias de Usuario

By default [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) assumes that the `_id` attribute is automatically generated using [MongoIds](https://www.php.net/manual/en/class.mongoid.php).

If a model uses custom primary keys this behavior can be overridden:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}
```

<a name='multiple-databases'></a>

## Configuración de Múltiples Bases de Datos

In Phalcon, all models can share the same database connection or specify a connection per model. Actually, when `Phalcon\Mvc\Collection` needs to connect to the database it requests the `mongo` service in the application's services container. You can overwrite this service by setting it in the `initialize()` method:

```php
<?php

// El servicio retorna una base de datos monto en 192.168.1.100
$di->set(
    'mongo1',
    function () {
        $mongo = new MongoClient(
            'mongodb://scott:nekhen@192.168.1.100'
        );

        return $mongo->selectDB('management');
    },
    true
);

// Este servicio retorna una base de datos mongo en localhost
$di->set(
    'mongo2',
    function () {
        $mongo = new MongoClient(
            'mongodb://localhost'
        );

        return $mongo->selectDB('invoicing');
    },
    true
);
```

Luego, en el método `initialize()`, definimos el servicio de conexión para el modelo:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setConnectionService('mongo1');
    }
}
```

<a name='services-in-models'></a>

## Servicios de Inyección en Modelos

Si requiere acceder a los servicios de la aplicación dentro de un modelo, en el siguiente ejemplo se explica cómo hacerlo:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function notSave()
    {
        // Obtener el servicio flash desde el contenedor DI
        $flash = $this->getDI()->getShared('flash');

        $messages = $this->getMessages();

        // Mostramos los mensajes de validación
        foreach ($messages as $message) {
            $flash->error(
                (string) $message
            );
        }
    }
}
```

The `notSave` event is triggered whenever a `creating` or `updating` action fails. We're flashing the validation messages obtaining the `flash` service from the DI container. By doing this, we don't have to print messages after each saving.