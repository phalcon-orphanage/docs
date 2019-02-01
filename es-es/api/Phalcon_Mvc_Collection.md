---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Collection'
---
# Abstract class **Phalcon\Mvc\Collection**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection.zep)

Este componente implementa un alto nivel de abstracción para las bases de datos NoSQL que funcionan con documentos

## Constantes

*integer* **OP_NONE**

*integer* **OP_CREATE**

*integer* **OP_UPDATE**

*integer* **OP_DELETE**

*integer* **DIRTY_STATE_PERSISTENT**

*integer* **DIRTY_STATE_TRANSIENT**

*integer* **DIRTY_STATE_DETACHED**

## Métodos

final public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $modelsManager])

Phalcon\Mvc\Collection constructor

public **setId** (*mixed* $id)

Configura un valor para la propiedad _id. Crea un objeto Mongold si es necesario

public *MongoId* **getId** ()

Devuelve el valor de la propiedad _id

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el contenedor de inyección de dependencia

public **getDI** ()

Devuelve el contenedor de inyección de dependencia

protected **setEventsManager** ([Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $eventsManager)

Configura un administrador de eventos personalizado

protected **getEventsManager** ()

Devuelve el administrador de eventos personalizado

public **getCollectionManager** ()

Devuelve el administrador de modelos relacionados con la instancia de entidad

public **getReservedAttributes** ()

Devuelve un arreglo con las propiedades reservadas que no pueden ser parte de insert/update

protected **useImplicitObjectIds** (*mixed* $useImplicitObjectIds)

Establece si un modelo debe utilizar ids de objetos implícitos

protected **setSource** (*mixed* $source)

Sets collection name which model should be mapped

public **getSource** ()

Returns collection name mapped in the model

public **setConnectionService** (*mixed* $connectionService)

Configura el nombre del servidor de conexión DependencyInjection

public **getConnectionService** ()

Devuelve el servicio de conexión DependencyInjection

public *MongoDb* **getConnection** ()

Recupera una conexión de base de datos

public *mixed* **readAttribute** (*string* $attribute)

Lee un valor de atributo por su nombre

```php
<?php

echo $robot->readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Escribe un valor atributo por su nombre

```php
<?php

$robot->writeAttribute("name", "Rosey");

```

public static **cloneResult** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $collection, *array* $document)

Devuelve una colección clonada

protected static *array* **_getResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection, *boolean* $unique)

Devuelve una colección resulset

protected static *int* **_getGroupResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection)

Realiza una cuenta sobre un resultset

final protected *boolean* **_preSave** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *boolean* $disableEvents, *boolean* $exists)

Ejecuta enlaces internos antes de guardar un documento

final protected **_postSave** (*mixed* $disableEvents, *mixed* $success, *mixed* $exists)

Ejecuta eventos internos después de guardar un documento

protected **validate** (*mixed* $validator)

Ejecuta validadores en cada llamada de validación

```php
<?php

use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        // Old, deprecated syntax, use new one below
        $this->validate(
            new ExclusionIn(
                [
                    "field"  => "status",
                    "domain" => ["A", "I"],
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}

```

```php
<?php

use Phalcon\Validation\Validator\ExclusionIn as ExclusionIn;
use Phalcon\Validation;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $validator = new Validation();
        $validator->add("status",
            new ExclusionIn(
                [
                    "domain" => ["A", "I"]
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

public **validationHasFailed** ()

Comprueba si el proceso de validación ha generado algún mensaje

```php
<?php

use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $this->validate(
            new ExclusionIn(
                [
                    "field"  => "status",
                    "domain" => ["A", "I"],
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}

```

public **fireEvent** (*mixed* $eventName)

Activa un evento interno

public **fireEventCancel** (*mixed* $eventName)

Activa un evento interno que cancela la operación

protected **_cancelOperation** (*mixed* $disableEvents)

Cancela la operación actual

protected *boolean* **_exists** (*MongoCollection* $collection)

Comprueba si el documento existe en la colección

public **getMessages** ()

Devuelve todos los mensajes de validación

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface) $message)

Añade un mensaje personalizado al proceso de validación

```php
<?php

use \Phalcon\Mvc\Model\Message as Message;

class Robots extends \Phalcon\Mvc\Model
{
    public function beforeSave()
    {
        if ($this->name === "Peter") {
            $message = new Message(
                "Sorry, but a robot cannot be named Peter"
            );

            $this->appendMessage(message);
        }
    }
}

```

protected **prepareCU** ()

Shared Code for CU Operations Prepares Collection

public **save** ()

Crea o actualiza una colección basada en los valores de los atributos

public **create** ()

Crea una colección basada en los valores de los atributos

public **createIfNotExist** (*array* $criteria)

Crea un documento basado en los valores de los atributos si no lo encuentra por criterios. La manera preferida de evitar duplicación es crear un índice en los atributos

```php
<?php

$robot = new Robot();

$robot->name = "MyRobot";
$robot->type = "Droid";

// Create only if robot with same name and type does not exist
$robot->createIfNotExist(
    [
        "name",
        "type",
    ]
);

```

public **update** ()

Crea o actualiza una colección basada en los valores de los atributos

public static **findById** (*mixed* $id)

Encuentra un documento por su id (_id)

```php
<?php

// Find user by using \MongoId object
$user = Users::findById(
    new \MongoId("545eb081631d16153a293a66")
);

// Find user by using id as sting
$user = Users::findById("45cbc4a0e4123f6920000002");

// Validate input
if ($user = Users::findById($_POST["id"])) {
    // ...
}

```

public static **findFirst** ([*array* $parameters])

Permite consultar el primer registro que coincide con las condiciones especificadas

```php
<?php

// What's the first robot in the robots table?
$robot = Robots::findFirst();

echo "The robot name is ", $robot->name, "\n";

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst(
    [
        [
            "type" => "mechanical",
        ]
    ]
);

echo "The first mechanical robot name is ", $robot->name, "\n";

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        [
            "type" => "mechanical",
        ],
        "order" => [
            "name" => 1,
        ],
    ]
);

echo "The first virtual robot name is ", $robot->name, "\n";

// Get first robot by id (_id)
$robot = Robots::findFirst(
    [
        [
            "_id" => new \MongoId("45cbc4a0e4123f6920000002"),
        ]
    ]
);

echo "The robot id is ", $robot->_id, "\n";

```

public static **find** ([*array* $parameters])

Permite consultar un conjunto de registros que coinciden con las condiciones especificadas

```php
<?php

// Cuantos robots hay?
$robots = Robots::find();

echo "There are ", count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    [
        [
            "type" => "mechanical",
        ]
    ]
);

echo "There are ", count(robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::findFirst(
    [
        [
            "type" => "virtual"
        ],
        "order" => [
            "name" => 1,
        ]
    ]
);

foreach ($robots as $robot) {
   echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
$robots = Robots::find(
    [
        [
            "type" => "virtual",
        ],
        "order" => [
            "name" => 1,
        ],
        "limit" => 100,
    ]
);

foreach ($robots as $robot) {
   echo $robot->name, "\n";
}

```

public static **count** ([*array* $parameters])

Realiza una cuenta sobre un colección

```php
<?php

echo "There are ", Robots::count(), " robots";

```

public static **aggregate** ([*array* $parameters])

Realiza una agregación utilizando el marco de trabajo de agregación Mongo

public static **summatory** (*mixed* $field, [*mixed* $conditions], [*mixed* $finalize])

Permite realizar un grupo summatory para una columna en la collección

public **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

```php
<?php

$robot = Robots::findFirst();

$robot->delete();

$robots = Robots::find();

foreach ($robots as $robot) {
    $robot->delete();
}

```

public **setDirtyState** (*mixed* $dirtyState)

Configura el estado modificado del objeto utilizando una de las constantes DIRTY_STATE_*

public **getDirtyState** ()

Devuelve una de las constantes DIRTY_STATE_* que indica si el documento existe en la colección o no

protected **addBehavior** ([Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

Configura un comportamiento en una colección

public **skipOperation** (*mixed* $skip)

Omite la operación actual forzando un estado de éxito

public **toArray** ()

Devuelve la instancia como una representación de arreglo

```php
<?php

print_r(
    $robot->toArray()
);

```

public **serialize** ()

Serializa el objeto ignorando conexiones o propiedades protegidas

public **unserialize** (*mixed* $data)

Revierte la serialización del objeto desde una cadena serializada