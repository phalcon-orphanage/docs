---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Model'
---
# Abstract class **Phalcon\Mvc\Model**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface), [Phalcon\Mvc\Model\ResultInterface](Phalcon_Mvc_Model_ResultInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Serializable](https://php.net/manual/en/class.serializable.php), [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model.zep)

Phalcon\Mvc\Model connects business objects and database tables to create a persistable domain model where logic and data are presented in one wrapping. It's an implementation of the object-relational mapping (ORM).

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

Phalcon\Mvc\Model is the first ORM written in Zephir/C languages for PHP, giving to developers high performance when interacting with databases while is also easy to use.

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We cannot store robots: ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

## Constantes

*integer* **OP_NONE**

*integer* **OP_CREATE**

*integer* **OP_UPDATE**

*integer* **OP_DELETE**

*integer* **DIRTY_STATE_PERSISTENT**

*integer* **DIRTY_STATE_TRANSIENT**

*integer* **DIRTY_STATE_DETACHED**

## Métodos

final public **__construct** ([*mixed* $data], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $modelsManager])

Phalcon\Mvc\Model constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el contenedor de inyección de dependencia

public **getDI** ()

Devuelve el contenedor de inyección de dependencia

protected **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Configura un administrador de eventos personalizado

protected **getEventsManager** ()

Devuelve el administrador de eventos personalizado

public **getModelsMetaData** ()

Devuelve el servicio de metadatos de los modelos relacionados a la instancia de entidad

public **getModelsManager** ()

Devuelve el administrador de modelos relacionados con la instancia de entidad

public **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

Configura una transacción relacionada a la instancia del Modelo

```php
<?php

use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

try {
    $txManager = new TxManager();

    $transaction = $txManager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Robot part cannot be saved");
    }

    $transaction->commit();
} catch (TxFailed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

protected **setSource** (*mixed* $source)

Configura el nombre de la table a la cual el modelo debe asignarse

public **getSource** ()

Devuelve el nombre de la tabla asignada al modelo

protected **setSchema** (*mixed* $schema)

Configura el nombre del esquema donde está ubicada la tabla asignada

public **getSchema** ()

Devuelve el nombre del esquema donde está ubicada la tabla asignada

public **setConnectionService** (*mixed* $connectionService)

Configura el nombre del servidor de conexión DependencyInjection

public **setReadConnectionService** (*mixed* $connectionService)

Configura el nombre del servicio de conexión DependencyInjection utilizado para leer datos

public **setWriteConnectionService** (*mixed* $connectionService)

Configura el nombre del servicio de conexión DependencyInjection utilizado para escribir datos

public **getReadConnectionService** ()

Devuelve el nombre del servicio de conexión DependencyInjection utilizado para leer datos relacionados al modelo

public **getWriteConnectionService** ()

Devuelve el nombre del servicio de conexión DependencyInjection utilizado para escribir datos relacionados al modelo

public **setDirtyState** (*mixed* $dirtyState)

Sets the dirty state of the object using one of the `DIRTY_STATE_*` constants

public **getDirtyState** ()

Returns one of the `DIRTY_STATE_*` constants telling if the record exists in the database or not

public **getReadConnection** ()

Obtiene la conexión utilizada para leer datos para el modelo

public **getWriteConnection** ()

Obtiene la conexión utilizada para escribir datos al modelo

public [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **assign** (*array* $data, [*mixed* $dataColumnMap], [*array* $whiteList])

Asigna valores a un modelo desde un arreglo

```php
<?php

$robot->assign(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Assign by db row, column map needed
$robot->assign(
    $dbRow,
    [
        "db_type" => "type",
        "db_name" => "name",
        "db_year" => "year",
    ]
);

// Allow assign only name and year
$robot->assign(
    $_POST,
    null,
    [
        "name",
        "year",
    ]
);

// By default assign method will use setters if exist, you can disable it by using ini_set to directly use properties

ini_set("phalcon.orm.disable_assign_setters", true);

$robot->assign(
    $_POST,
    null,
    [
        "name",
        "year",
    ]
);

```

public static **cloneResultMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\Model\Row](Phalcon_Mvc_Model_Row) $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Asigna valores a un modelo desde un arreglo, devolviendo un nuevo modelo.

```php
<?php

$robot = \Phalcon\Mvc\Model::cloneResultMap(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

public static *mixed* **cloneResultMapHydrate** (*array* $data, *array* $columnMap, *int* $hydrationMode)

Devuelve un resultado hidratado basado en los datos y el mapa de la columna

public static [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **cloneResult** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $base, *array* $data, [*int* $dirtyState])

Asigna valores a un modelo desde un arreglo y devuelve un nuevo modelo

```php
<?php

$robot = Phalcon\Mvc\Model::cloneResult(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

public static **find** ([*mixed* $parameters])

Consulta un conjunto de registros que coinciden con las condiciones especificadas

```php
<?php

// Cuantos robots hay?
$robots = Robots::find();

echo "There are ", count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    "type = 'mechanical'"
);

echo "There are ", count($robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

foreach ($robots as $robot) {
 echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100,
    ]
);

foreach ($robots as $robot) {
 echo $robot->name, "\n";
}

```

public static *static* **findFirst** ([*string* | *array* $parameters])

Consulta el primer registro que coincide con las condiciones especificadas

```php
<?php

// What's the first robot in robots table?
$robot = Robots::findFirst();

echo "The robot name is ", $robot->name;

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst(
    "type = 'mechanical'"
);

echo "The first mechanical robot name is ", $robot->name;

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

echo "The first virtual robot name is ", $robot->name;

```

public static **query** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Crea un criterio para un modelo específico

protected *boolean* **_exists** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [*string* | *array* $table])

Comprueba si el registro actual ya existe

protected static [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **_groupResult** (*mixed* $functionName, *string* $alias, *array* $parameters)

Genera una instrucción PHQL SELECT para un agregado

public static *mixed* **count** ([*array* $parameters])

Cuenta cuantos registros coinciden con las condiciones especificadas

```php
<?php

// Cuantos robots hay?
$number = Robots::count();

echo "There are ", $number, "\n";

// How many mechanical robots are there?
$number = Robots::count("type = 'mechanical'");

echo "There are ", $number, " mechanical robots\n";

```

public static *mixed* **sum** ([*array* $parameters])

Calcula la suma en una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
<?php

// How much are all robots?
$sum = Robots::sum(
    [
        "column" => "price",
    ]
);

echo "The total price of robots is ", $sum, "\n";

// How much are mechanical robots?
$sum = Robots::sum(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The total price of mechanical robots is  ", $sum, "\n";

```

public static *mixed* **maximum** ([*array* $parameters])

Devuelve el valor máximo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
<?php

// What is the maximum robot id?
$id = Robots::maximum(
    [
        "column" => "id",
    ]
);

echo "The maximum robot id is: ", $id, "\n";

// What is the maximum id of mechanical robots?
$sum = Robots::maximum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The maximum robot id of mechanical robots is ", $id, "\n";

```

public static *mixed* **minimum** ([*array* $parameters])

Devuelve el valor mínimo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
<?php

// What is the minimum robot id?
$id = Robots::minimum(
    [
        "column" => "id",
    ]
);

echo "The minimum robot id is: ", $id;

// What is the minimum id of mechanical robots?
$sum = Robots::minimum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The minimum robot id of mechanical robots is ", $id;

```

public static *double* **average** ([*array* $parameters])

Devuelve el valor promedio de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
<?php

// What's the average price of robots?
$average = Robots::average(
    [
        "column" => "price",
    ]
);

echo "The average price is ", $average, "\n";

// What's the average price of mechanical robots?
$average = Robots::average(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The average price of mechanical robots is ", $average, "\n";

```

public **fireEvent** (*mixed* $eventName)

Activa un evento. Implícitamente los comportamientos y escuchas de las llamadas son notificadas en el administrador de eventos

public **fireEventCancel** (*mixed* $eventName)

Activa un evento. Implícitamente los comportamientos y escuchas de las llamadas son notificadas en el administrador de eventos. Este método se detiene si uno de los callbacks o escuchas devuelven el valor booleano false

protected **_cancelOperation** ()

Cancela la operación actual

public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface) $message)

Añade un mensaje personalizado al proceso de validación

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message as Message;

class Robots extends Model
{
    public function beforeSave()
    {
        if ($this->name === "Peter") {
            $message = new Message(
                "Sorry, but a robot cannot be named Peter"
            );

            $this->appendMessage($message);
        }
    }
}

```

protected **validate** ([Phalcon\ValidationInterface](Phalcon_ValidationInterface) $validator)

Ejecuta validadores en cada llamada de validación

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscriptors extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
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

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscribers extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->validate(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

public **getMessages** ([*mixed* $filter])

Devuelve un arreglo de mensajes de validación

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

final protected **_checkForeignKeysRestrict** ()

Lee relaciones "belongs to" y comprueba las claves virtuales externas cuando se insertan o actualizan registros para verificar que los valores insertados o actualizados estén presentes en la entidad relacionada

final protected **_checkForeignKeysReverseCascade** ()

Lee las relaciones "hasMany" y "hasOne" y comprueba las claves virtuales externas (cascada) cuando se eliminan registros

final protected **_checkForeignKeysReverseRestrict** ()

Lee las relaciones "hasMany" y "hasOne" y comprueba las claves virtuales externas (restringida) cuando se eliminan registros

protected **_preSave** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, *mixed* $exists, *mixed* $identityField)

Ejecuta enlaces internos antes de guardar un registro

protected **_postSave** (*mixed* $success, *mixed* $exists)

Ejecutas eventos internos después de guardar un registro

protected *boolean* **_doLowInsert** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table, *boolean* | *string* $identityField)

Envía una instrucción incorporada INSERT SQL al sistema de base de datos relacional

protected *boolean* **_doLowUpdate** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table)

Envía una instrucción incorporada UPDATESQL al sistema de base de datos relacional

protected *boolean* **_preSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $related)

Guarda los registros relacionados que deben almacenarse antes de guardar el registro maestro

protected *boolean* **_postSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $related)

Guarda los archivos relacionados asignados en las relaciones tiene uno/tiene muchos

public *boolean* **save** ([*array* $data], [*array* $whiteList])

Inserts or updates a model instance. Returning true on success or false otherwise.

```php
<?php

// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->save();

// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->save();

```

public **create** ([*mixed* $data], [*mixed* $whiteList])

Inserts a model instance. If the instance already exists in the persistence it will throw an exception Returning true on success or false otherwise.

```php
<?php

// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();

// Passing an array to create
$robot = new Robots();

$robot->create(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

```

public **update** ([*mixed* $data], [*mixed* $whiteList])

Updates a model instance. If the instance doesn't exist in the persistence it will throw an exception Returning true on success or false otherwise.

```php
<?php

// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->update();

```

public **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

```php
<?php

$robot = Robots::findFirst("id=100");

$robot->delete();

$robots = Robots::find("type = 'mechanical'");

foreach ($robots as $robot) {
    $robot->delete();
}

```

public **getOperationMade** ()

Devuelve el tipo de la operación realizada más reciente por el ORM. Devuelve una de las constantes de clase OP_*

public **refresh** ()

Actualiza los atributos del modelo volviendo a consultar el registro de la base de datos

public **skipOperation** (*mixed* $skip)

Omite la operación actual forzando un estado de éxito

public **readAttribute** (*mixed* $attribute)

Lee un valor de atributo por su nombre

```php
<?php

echo $robot->readAttribute("name");

```

public **writeAttribute** (*mixed* $attribute, *mixed* $value)

Escribe un valor atributo por su nombre

```php
<?php

$robot->writeAttribute("name", "Rosey");

```

protected **skipAttributes** (*array* $attributes)

Configura una lista de atributos de deben omitirse de la declaración INSERT/UPDATE generada

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributes(
            [
                "price",
            ]
        );
    }
}

```

protected **skipAttributesOnCreate** (*array* $attributes)

Configura una lista de atributos que deben omitirse de la declaración INSERT generada

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnCreate(
            [
                "created_at",
            ]
        );
    }
}

```

protected **skipAttributesOnUpdate** (*array* $attributes)

Sets a list of attributes that must be skipped from the generated UPDATE statement

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnUpdate(
            [
                "modified_in",
            ]
        );
    }
}

```

protected **allowEmptyStringValues** (*array* $attributes)

Sets a list of attributes that must be skipped from the generated UPDATE statement

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->allowEmptyStringValues(
            [
                "name",
            ]
        );
    }
}

```

protected **hasOne** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Configura una relacion 1-1 entre dos modelos

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne("id", "RobotsDescription", "robots_id");
    }
}

```

Using more than one field:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(["id", "type"], "RobotParts", ["robots_id", "robots_type"]);
    }
}

```

Using options:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(
            "id", 
            "RobotParts", 
            "robots_id",
            [
                "reusable" => true,    // cache the results of this relationship
                "alias"    => "parts", // Alias of the relationship
            ]
        );
    }
}

```

Using conditionals:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(
            "id", 
            "RobotParts", 
            "robots_id",
            [
                "reusable" => true,           // cache the results of this relationship
                "alias"    => "partsTypeOne", // Alias of the relationship
                "params"   => [               // Acts like a filter
                    "conditions" => "type = :type:",
                    "bind"       => [
                        "type" => 1,
                    ],
                ],
            ]
        );
    }
}

```

protected **belongsTo** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Configura una relación 1-1 o n-1 entre dos modelos

```php
<?php

class RobotsParts extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo("robots_id", "Robots", "id");
    }
}

```

protected **hasMany** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Setup a 1-n relation between two models

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "robots_id");
    }
}

```

protected [Phalcon\Mvc\Model\Relation](Phalcon_Mvc_Model_Relation) **hasManyToMany** (*string* | *array* $fields, *string* $intermediateModel, *string* | *array* $intermediateFields, *string* | *array* $intermediateReferencedFields, *mixed* $referenceModel, *string* | *array* $referencedFields, [*array* $options])

Setup an n-n relation between two models, through an intermediate relation

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        // Setup a many-to-many relation to Parts through RobotsParts
        $this->hasManyToMany(
            "id",
            "RobotsParts",
            "robots_id",
            "parts_id",
            "Parts",
            "id"
        );
    }
}

```

public **addBehavior** ([Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface) $behavior)

Configura un comportamiento en un modelo

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Robots extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
               [
                   "onCreate" => [
                        "field"  => "created_at",
                        "format" => "Y-m-d",
                       ],
                ]
            )
        );
    }
}

```

protected **keepSnapshots** (*mixed* $keepSnapshot)

Establece si el modelo debe mantener el registro instantáneo original en la memoria

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}

```

public **setSnapshotData** (*array* $data, [*array* $columnMap])

Sets the record's snapshot data. This method is used internally to set snapshot data when the model was set up to keep snapshot data

public **hasSnapshotData** ()

Comprueba si el objeto tiene datos internos de la instantánea

public **getSnapshotData** ()

Devuelve los datos internos de la instantánea

public **getOldSnapshotData** ()

Devuelve los datos internos antiguos de la instantánea

public **hasChanged** ([*string* | *array* $fieldName], [*boolean* $allFields])

Comprueba si un atributo específico ha cambiado. Esto solo funciona si el modelo mantiene instantáneas de los datos

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();
$robot->type = "hydraulic";
$hasChanged = $robot->hasChanged("type"); // returns true
$hasChanged = $robot->hasChanged(["type", "name"]); // returns true
$hasChanged = $robot->hasChanged(["type", "name", true]); // returns false

```

public **hasUpdated** ([*string* | *array* $fieldName], [*mixed* $allFields])

Comprueba si un atributo específico fue actualizado. Esto solo funciona si el modelo mantiene instantáneas de los datos

public **getChangedFields** ()

Devuelve una lista de los valores cambiados.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]

```

public **getUpdatedFields** ()

Returns a list of updated values.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]
$robots->save();
print_r($robots->getChangedFields()); // []
print_r($robots->getUpdatedFields()); // ["deleted"]

```

protected **useDynamicUpdate** (*mixed* $dynamicUpdate)

Sets if a model must use dynamic update instead of the all-field update

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}

```

public [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **getRelated** (*string* $alias, [*array* $arguments])

Devuelve los registros relacionados basados en relaciones definidas

```php
<?php

// Gets the relationship data named "parts"
$parts = $robot->getRelated('parts');

// Gets the relationship data named "parts" sorted descending by name
$parts = $robot->getRelated('parts', ['order' => 'name DESC']);

// Gets the relationship data named "parts" filtered
$parts = $robot->getRelated('parts', ['conditions' => 'type = 1']);

$parts = $robot->getRelated(
    'parts', 
    [
        'conditions' => 'type = :type:',
        'bind'       => [
            'type' => 1,
        ]
    ]
);

```

protected *mixed* **_getRelatedRecords** (*string* $modelName, *string* $method, *array* $arguments)

Devuelve las relaciones definidas de los registros relacionados dependiendo del nombre del método

final protected static [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | *boolean* **_invokeFinder** (*string* $method, *array* $arguments)

Intenta comprobar si la solicitud debe invocar un buscador

public *mixed* **__call** (*string* $method, *array* $arguments)

Controla las llamadas de método cuando no se implementa un método

public static *mixed* **__callStatic** (*string* $method, *array* $arguments)

Controla las llamadas de método cuando no se implementa un método estático

public **__set** (*string* $property, *mixed* $value)

Método mágico para asignar valores al modelo

final protected *string* **_possibleSetter** (*string* $property, *mixed* $value)

Comprueba e intenta utilizar un posible establecedor.

public [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset) | [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **__get** (*string* $property)

Un método mágico para obtener registros relacionados utilizando el alias de relación como una propiedad

public **__isset** (*mixed* $property)

Método mágico para comprobar si una propiedad es una relación válida

public **serialize** ()

Serializa el objeto ignorando las conexiones, servicios, objetos relacionados o propiedades estáticas

public **unserialize** (*mixed* $data)

Revierte la serialización del objeto desde una cadena serializada

public **dump** ()

Devuelve una representación simple de un objeto que puede ser utilizado con var_dump

```php
<?php

var_dump(
    $robot->dump()
);

```

public *array* **toArray** ([*array* $columns])

Devuelve la instancia como una representación de arreglo

```php
<?php

print_r(
    $robot->toArray()
);

```

public *array* **jsonSerialize** ()

Serializes the object for json_encode

```php
<?php

echo json_encode($robot);

```

public static **setup** (*array* $options)

Habilita o inhabilita las opciones en el ORM

public **reset** ()

Restablece los datos de instancia del modelo