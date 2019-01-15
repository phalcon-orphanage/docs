* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<h5 class='alert alert-info'>Please note that if you are using the Mongo driver provided by PHP 7, the ODM will not work for you. There is an incubator adapter but all the Mongo code must be rewritten (new Bson type instead of arrays, no MongoId, no MongoDate, etc...). Please ensure that you test your code before upgrading to PHP 7 and/or Phalcon 3+</h5>

<a name='overview'></a>

# ODM (Mapeador Objecto-Documento)

In addition to its ability to [map tables](/4.0/en/models) in relational databases, Phalcon can map documents from NoSQL databases. El ODM ofrece una funcionalidad CRUD, eventos, validaciones entre otros servicios.

Debido a la ausencia de consultas y planificadores SQL, con las bases de datos NoSQL se pueden ver mejoras reales en el rendimiento utilizando el enfoque de Phalcon. Además, no hay construcción de sentencias de SQL, lo que reduce la posibilidad de inyecciones SQL.

Son soportadas las siguientes bases de datos NoSQL:

| Nombre                              | Descripción                                                                                 |
| ----------------------------------- | ------------------------------------------------------------------------------------------- |
| [MongoDB](https://www.mongodb.org/) | MongoDB es una base de datos NoSQL de código fuente abierto, escalable y de alto desempeño. |

<a name='creating-models'></a>

## Creación de Modelos

A model is a class that extends from [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection). Debe colocarse en el directorio de los modelos. Un archivo de modelo debe contener una sola clase; su nombre de clase debe estar en notación "camel case":

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{

}
```

Por defecto, el modelo `Robots` se refiere a la colección `robots`. Si deseas especificar manualmente otro nombre para la colección de asignación, puedes utilizar el método `setSource()`:

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

Cada instancia de un modelo representa un documento en la colección. Podrás acceder fácilmente a la colección de datos al leer las propiedades de los objetos. Por ejemplo, para una colección de `robots` con los documentos:

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

Los Espacios de Nombres se pueden utilizar para evitar la colisión de nombres de clases. En este caso es necesario indicar el nombre de la colección involucrada con el método `setSource()`:

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

Podrías encontrar cierto documento por su ID primaria y luego imprimir su nombre:

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

Las conexiones se realizan desde el contenedor de servicios. Por defecto, Phalcon trata de encontrar la conexión en un servicio llamado `mongo`:

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

Para consultar campos específicos de los campos de una base de datos MongoDB con el ODM Phalcon, todo lo que necesitas hacer es:

```php
$myRobots = Robots:find(
    [
        'fields' => ['name' => 1]
    ]
];
```

El `find()` anterior devuelve sólo un `nombre`. También puede combinarse con una `condición`:

```php
$myRobots = Robots:find(
    [
        ['type' => 'maid'],
        'fields' => ['name' => 1]
    ]
];
```

El ejemplo anterior devuelve el campo `name` que es el nombre del robot con con el campo `type = 'maid'`.

<a name='aggregations'></a>

## Agregaciones

A model can return calculations using [aggregation framework](https://docs.mongodb.org/manual/applications/aggregation/) provided by Mongo. Los valores agregados se calculan sin tener que utilizar MapReduce. Con esta opción es fácil realizar tareas como calcular un total o un promedio de valores de los campos:

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

El método `Phalcon\Mvc\Collection::save()` te permite crear o actualizar documentos según si ya existen en la colección asociada a un modelo. The `save()` method is called internally by the create and update methods of [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection).

El método también ejecuta validadores y eventos asociados que están definidos en modelo:

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

Los modelos permiten implementar eventos que serán ejecutados cuando se realice una inserción o actualización. Ellos ayudan a definir reglas de negocio para cierto modelo. The following are the events supported by [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) and their order of execution:

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

Para hacer a un modelo reaccionar a un evento, debemos implementar un método con el mismo nombre del evento:

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

Los eventos pueden utilizarse para asignar valores antes de realizar una operación, por ejemplo:

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

En el ejemplo anterior el EventsManager o Gestor de Eventos sólo actuó como un puente entre un objeto y un oyente que era una función anónima. Si queremos que todos los objetos creados en nuestra aplicación utilicen el mismo EventsManager, tenemos que asignarlo al administrador de modelos:

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

Cuando se ejecuta una inserción, actualización o borrado, el modelo verifica si hay algunos métodos con nombres de eventos listados en la tabla anterior.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.

El siguiente ejemplo implementa un evento que valida que el año no sea menor a cero en la actualización o inserción:

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

Algunos eventos retornar el valor `false` indicando que se debe detener la operación actual. Si un evento no retorna nada, `Phalcon\Mvc\Collection` asume un valor `true`.

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

El ejemplo anterior realiza una validación con el validador integrado `InclusionIn`. Comprueba que el valor del campo `type` este en la lista `domain`. Si el valor no está incluido en el dominio, entonces el validador fallará y devolverá `false`.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a> </h5>

<a name='deleting-records'></a>

## Eliminar Registros

El método `Phalcon\Mvc\Collection::delete()` le permite borrar un documento. Se puede utilizar de la sigue manera:

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

También puede eliminar muchos documentos recorriendo un conjunto de resultados con un bucle `foreach`:

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

Otro tipo de eventos está disponible cuando el proceso de validación de datos encuentra cualquier inconsistencia:

| Operación                     | Nombre              | Explicación                                                                        |
| ----------------------------- | ------------------- | ---------------------------------------------------------------------------------- |
| Insertar o actualizar         | `notSave`           | Se dispara cuando la operación de inserción o actualización falla por alguna razón |
| Insertar, borrar o actualizar | `onValidationFails` | Se dispara cuando cualquier operación de manipulación de datos falla               |

<a name='ids-vs-primary-keys'></a>

## IDs Implícitos vs. Llaves Primarias de Usuario

By default [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) assumes that the `_id` attribute is automatically generated using [MongoIds](https://www.php.net/manual/en/class.mongoid.php).

Si un modelo utiliza un claves primarias personalizadas este comportamiento puede ser redefinido:

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

En Phalcon, todos los modelos pueden compartir la misma conexión a la base de datos o especificar una conexión por modelo. Actualmente, cuando `Phalcon\Mvc\Collection` necesita conectarse a la base de datos pide el servicio `mongo` al contenedor de servicios de la aplicación. Usted puede sobrescribir este servicio configurándolo en el método `initialize()`:

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

El evento `notSaved` se desencadena cada vez que falla una acción de `creacion` o `actualización`. Estamos mostrando los mensajes de validación obteniendo el servicio `flash` del contenedor DI. Haciendo esto, no tenemos que imprimir los mensajes después de cada guardado.