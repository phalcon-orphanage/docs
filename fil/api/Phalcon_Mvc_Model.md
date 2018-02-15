# Klase ng Abstrak **Phalcon\\Mvc\\Model**

*implements* [Phalcon\Mvc\EntityInterface](/en/3.2/api/Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface), [Phalcon\Mvc\Model\ResultInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Serializable](http://php.net/manual/en/class.serializable.php), [JsonSerializable](http://php.net/manual/en/class.jsonserializable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model.zep" class="btn btn-default btn-sm">Pinanggalingan sa Github</a>

Phalcon\\Mvc\\Model kumokonekta sa mga layon ng negosyo at database ng mga talahanayan para gumawa ng isang matibay na modelo ng dominyo kung saan ang lohika at datos ay inilahad sa isang pag-wrap. Ito ay isang implementasyon ng layon-pagmamapa ng pamanggit (ORM).

Ang modelo ay naglalahad ng impormasyon (datos) ng aplikasyon at ng mga patakaran upang mamanipula ang datos. Ang mga modelo ay pangunahing ginamit para sa pagpapangasiwa ng mga patakaran ng interaksyon kasama ang isang tumutugon na talahanayan ng database. Sa mga kaso ng karamihan, bawat talahanayan sa iyong database ay tumutugma sa isang modelo sa iyong aplikasyon. Ang laki ng iyong aplikasyong ng lohika ng negosyo ay maaaring ang mga modelo ay maging puro.

Phalcon\\Mvc\\Model ay unang ORM na naisulat sa Zephric/C na mga lenggwahe para sa PHP, ipagkakaloob sa mga developer na mataas ang pagganap kapag nakikipagtulungan kasama ang mga database habang ito rin ay madaling magamit.

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can store robots: ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

## Mga Constant

*kabuuan* **OP_WALA**

*kabuuan* **OP_PAGLIKHA**

*kabuuan***OP_PAGBABAGO**

*kabuuan* **OP_TANGGALIN**

*kabuuan* **MARUMI_ESTADO_PAULIT-ULIT**

* kabuuan* **MARUMI_ESTADO_TRANSIYENT**

*Kabuuan* **MARUMI_ESTADO_HIWALAY**

## Mga Pamamaraan

kahuli-hulihang pampubliko **__gumawa** ([*magkahalo* $data], [[Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Model\ManagerInterface](/en/3.2/api/Phalcon_Mvc_Model_ManagerInterface) $modelsManager])

Phalcon\\Mvc\\Model tagapagbuo

pampublikong **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector)

Itatakda ang dependensya na lalagyan ng ineksyon

pampublikong **getDI** ()

Ibabalik ang dependensya na lalagyan ng ineksyon

protektadong **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Itatakda ang isang tagapamahala ng mga pnagyayari sa kostumbre

protektadong **getEventsManager** ()

Ibabalik ang tagapamahala ng mga pangyayari sa kostumbre

pampublikong **getModelsMetaData** ()

Ibabalik ang mga modelo ng meta-data na serbisyo na may kaugnayan sa halimbawa ng entidad

pampublikong **getModelsManager** ()

Ibabalik ang mga modelo ng tagapamahala na may kaugnayan sa halimbawa ng entidad

pampublikong **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](/en/3.2/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

Itatakda ang isang transaksyon kaugnay sa Halimbawa ng Modelo

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

protektadong **setSource** (*mixed* $source)

Itatakda ang pangalan ng talahanayan sa kung saan ang modelo ay dapat na isamapa

pampublikong **getSource** ()

Ibabalik ang pangalan ng talahanayan na isinamapa sa modelo

protektadong **setSchema** (*mixed* $schema)

Itatakda ang talahanayan ng panukala kung saan ang isinamapa na talahanayan na matatagpuan

pampublikong **getSchema** ()

Ibabalik ang pangalan ng panukala kung saan ang isinamapa na talahanayan na matatagpuan

pampublikong **setConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo

pampublikong **setReadConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagbasa ng datos

pampublikong **setWriteConnectionService** (*mixed* $connectionService)

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagsulat sa datos

pampublikong **getReadConnectionService** ()

Itatakda ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagbasa ng datos

pampublikong **getWriteConnectionService** ()

Ibabalik ang DependencyInjection na koneksyon sa pangalan ng serbisyo gamit ang pagsulat sa datos na may kaugnayan sa datos

pampublikong **setDirtyState** (*magkahalo* $dirtyState)

Itatakda ang maruming estado ng layon gamit ang isa sa DIRTY_STATE_* na mga constant

pampublikong **getDirtyState** ()

Ibabalik ang isa sa DIRTY_STATE_* na mga constant sasabihin na ang umiiral na rekord sa database o hindi

pampublikong **getReadConnection** ()

Makakakuha ng koneksyon upang gamitin ang pagbasa ng datos para sa modelo

pampublikong **getWriteConnection** ()

Makakakuha ng koneksyon upang gamitin ang pagsulat ng datos sa modelo

pampublikong [Phalcon\Mvc\Model](/en/3.2/api/Phalcon_Mvc_Model) **assign** (*array* $data, [*mixed* $dataColumnMap], [*array* $whiteList])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array

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

pampublikong istatik **cloneResultMap** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\Model\Row](/en/3.2/api/Phalcon_Mvc_Model_Row) $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array, pagbabalik sa isang bagong modelo.

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

pampublikong istatik *mixed* **cloneResultMapHydrate** (*array* $data, *array* $columnMap,*int* $hydrationMode)

Ibabalik ang isang hydrated na resulta base sa datos at sa kulumna na mapa

pampublikong istatik [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) **cloneResult** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $base, *array* $data, [*int* $dirtyState])

Nagtatalaga ng mga mahahalaga sa isang modelo mula sa isang array pagbabalik sa isang bagong modelo

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

pampublikong istatik **find** ([*mixed* $parameters])

Mag-usisa para sa isang takda ng mga rekord na tumutugma ang tinukoy na mga kondisyon

```php
<?php

// How many robots are there?
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

pampublikong istatik *static* **findFirst** ([*string* | *array* $parameters])

Mag-usisa sa unang pagrekord na magtutugma sa tinukoy na mga kondisyon

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

pampublikong istatik **query** ([[Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector])

Gumawa ng isang pamantayan para sa isang partikular na modelo

protektadong *boolean* **_exists** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [*string* | *array* $table])

Sinisiyasat kung ang kasalukuyang rekord ay umiiral na

protektadong istatik [Phalcon\Mvc\Model\ResultsetInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultsetInterface) **_groupResult** (*mixed* $functionName, *string* $alias, *array* $parameters)

Bumuo ng isang PHQL SELECT na pahayag para sa isang kabuuan

pampublikong istatik *mixed* **count** ([*array* $parameters])

Binibilang kung gaano karami ang mga rekord na tumutugma ang tinukoy na mga kondisyon

```php
<?php

// How many robots are there?
$number = Robots::count();

echo "There are ", $number, "\n";

// How many mechanical robots are there?
$number = Robots::count("type = 'mechanical'");

echo "There are ", $number, " mechanical robots\n";

```

pampublikong istatik *mixed* **sum** ([*array* $parameters])

Kalkulahin ang kabuuan sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

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

pampublikong istatik *mixed* **maximum** ([*array* $parameters])

Ibabalik ang pinakamataas na halaga sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

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

pampublikong istatik *mixed* **minimum** ([*array* $parameters])

Ibabalik ang pinakamababa na halaga sa isang kulumna para sa isang resulta na itinakda ng mga hanay na tumugma ang tinukoy na mga kondisyon

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

pampumblikong istatik *double* **average** ([*array* $parameters])

Ibabalik ang katamtamang halaga sa isang kulumna para sa isang resulta ng itinakda ng mga hanay na tumutugma ang tinukoy na mga kondisyon

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

pampublikong **fireEvent** (*mixed* $eventName)

Isisante ang isang pangyayari, implicitly ay tinatawag na pag-uugali at mga tagapakinig sa tagapamahala ng mga pangyayari ay maabisuhan

public **fireEventCancel** (*mixed* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified This method stops if one of the callbacks/listeners returns boolean false

protected **_cancelOperation** ()

Cancel the current operation

public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](/en/3.2/api/Phalcon_Mvc_Model_MessageInterface) $message)

Appends a customized message on the validation process

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

protected **validate** ([Phalcon\ValidationInterface](/en/3.2/api/Phalcon_ValidationInterface) $validator)

Executes validators on every validation call

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

Check whether validation process has generated any messages

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

Returns array of validation messages

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

Reads "belongs to" relations and check the virtual foreign keys when inserting or updating records to verify that inserted/updated values are present in the related entity

final protected **_checkForeignKeysReverseCascade** ()

Reads both "hasMany" and "hasOne" relations and checks the virtual foreign keys (cascade) when deleting records

final protected **_checkForeignKeysReverseRestrict** ()

Reads both "hasMany" and "hasOne" relations and checks the virtual foreign keys (restrict) when deleting records

protected **_preSave** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, *mixed* $exists, *mixed* $identityField)

Executes internal hooks before save a record

protected **_postSave** (*mixed* $success, *mixed* $exists)

Executes internal events after save a record

protected *boolean* **_doLowInsert** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table, *boolean* | *string* $identityField)

Sends a pre-build INSERT SQL statement to the relational database system

protected *boolean* **_doLowUpdate** ([Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table)

Sends a pre-build UPDATE SQL statement to the relational database system

protected *boolean* **_preSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $related)

Saves related records that must be stored prior to save the master record

protected *boolean* **_postSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $related)

Save the related records assigned in the has-one/has-many relations

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

Returns the type of the latest operation performed by the ORM Returns one of the OP_* class constants

public **refresh** ()

Refreshes the model attributes re-querying the record from the database

public **skipOperation** (*mixed* $skip)

Skips the current operation forcing a success state

public **readAttribute** (*mixed* $attribute)

Reads an attribute value by its name

```php
<?php

echo $robot->readAttribute("name");

```

public **writeAttribute** (*mixed* $attribute, *mixed* $value)

Writes an attribute value by its name

```php
<?php

$robot->writeAttribute("name", "Rosey");

```

protected **skipAttributes** (*array* $attributes)

Sets a list of attributes that must be skipped from the generated INSERT/UPDATE statement

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

Sets a list of attributes that must be skipped from the generated INSERT statement

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

Setup a 1-1 relation between two models

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

protected **belongsTo** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Setup a reverse 1-1 or n-1 relation between two models

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

protected [Phalcon\Mvc\Model\Relation](/en/3.2/api/Phalcon_Mvc_Model_Relation) **hasManyToMany** (*string* | *array* $fields, *string* $intermediateModel, *string* | *array* $intermediateFields, *string* | *array* $intermediateReferencedFields, *mixed* $referenceModel, *string* | *array* $referencedFields, [*array* $options])

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
            "id",
        );
    }
}

```

public **addBehavior** ([Phalcon\Mvc\Model\BehaviorInterface](/en/3.2/api/Phalcon_Mvc_Model_BehaviorInterface) $behavior)

Setups a behavior in a model

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

Sets if the model must keep the original record snapshot in memory

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

Checks if the object has internal snapshot data

public **getSnapshotData** ()

Returns the internal snapshot data

public **getOldSnapshotData** ()

Returns the internal old snapshot data

public **hasChanged** ([*string* | *array* $fieldName], [*boolean* $allFields])

Check if a specific attribute has changed This only works if the model is keeping data snapshots

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

Check if a specific attribute was updated This only works if the model is keeping data snapshots

public **getChangedFields** ()

Returns a list of changed values.

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

public [Phalcon\Mvc\Model\ResultsetInterface](/en/3.2/api/Phalcon_Mvc_Model_ResultsetInterface) **getRelated** (*string* $alias, [*array* $arguments])

Returns related records based on defined relations

protected *mixed* **_getRelatedRecords** (*string* $modelName, *string* $method, *array* $arguments)

Returns related records defined relations depending on the method name

final protected static [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) | *boolean* **_invokeFinder** (*string* $method, *array* $arguments)

Try to check if the query must invoke a finder

public *mixed* **__call** (*string* $method, *array* $arguments)

Handles method calls when a method is not implemented

public static *mixed* **__callStatic** (*string* $method, *array* $arguments)

Handles method calls when a static method is not implemented

public **__set** (*string* $property, *mixed* $value)

Magic method to assign values to the the model

final protected *string* **_possibleSetter** (*string* $property, *mixed* $value)

Check for, and attempt to use, possible setter.

public [Phalcon\Mvc\Model\Resultset](/en/3.2/api/Phalcon_Mvc_Model_Resultset) | [Phalcon\Mvc\Model](/en/3.2/api/Phalcon_Mvc_Model) **__get** (*string* $property)

Magic method to get related records using the relation alias as a property

public **__isset** (*mixed* $property)

Magic method to check if a property is a valid relation

public **serialize** ()

Serializes the object ignoring connections, services, related objects or static properties

public **unserialize** (*mixed* $data)

Unserializes the object from a serialized string

public **dump** ()

Returns a simple representation of the object that can be used with var_dump

```php
<?php

var_dump(
    $robot->dump()
);

```

public *array* **toArray** ([*array* $columns])

Returns the instance as an array representation

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

Enables/disables options in the ORM

public **reset** ()

Reset a model instance data