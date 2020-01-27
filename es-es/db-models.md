---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#models'
title: 'Modelos'
keywords: 'models, active record'
---

# Modelos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Controladores

The [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) is the `M` in MVC. It is a class that connects business objects and database tables, to create a persistent domain model, where logic and data are wrapped into one. It is an implementation of the object-relational mapping (ORM).

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

The [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) is the first ORM written in Zephir/C languages for PHP, giving to developers high performance when interacting with databases while is also easy to use.

> **NOTE**: Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the [Phalcon\Db](api/Phalcon_Db) component documentation.
{: .alert .alert-warning }

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{

}
```

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->save();

if (false === $result) {

    echo 'Error saving Invoice: ';

    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo $message . PHP_EOL;
    }
} else {

    echo 'Record Saved';

}
```

> **NOTE**: For information on how to create a model please check the [Creating Models](#creating-models) section
{: .alert .alert-info }


## Constantes

| Constante                |     Value     |
| ------------------------ |:-------------:|
| DIRTY_STATE_DETACHED   |       2       |
| DIRTY_STATE_PERSISTENT |       0       |
| DIRTY_STATE_TRANSIENT  |       1       |
| OP_CREATE                |       1       |
| OP_DELETE                |       3       |
| OP_NONE                  |       0       |
| OP_UPDATE                |       2       |
| TRANSACTION_INDEX        | 'transaction' |

## Métodos

```php
final public function __construct(
    mixed $data = null, 
    DiInterface $container = null,
    ManagerInterface $modelsManager = null
)
```

Constructs the model object. The method accepts an array of data that are used to populate the object by internally using `assign`. Optionally you can pass a DI container and a Models Manager object. If they are not passed, the defaults will be used.

```php
public function __call(string $method, array $arguments): mixed
```

Handles method calls when a method is not implemented. Throws [Phalcon\Mvc\Model\Exception](api/phalcon_mvc#mvc-model-exception) if the method doesn't exist

```php
public static function __callStatic(
    string $method, 
    array $arguments
): mixed
```

Handles method calls when a static method is not implemented. Throws [Phalcon\Mvc\Model\Exception](api/phalcon_mvc#mvc-model-exception) if the method doesn't exist

```php
public function __get(string $property)
```

Magic method to get related records using the relation alias as a property

```php
public function __isset(string $property): bool
```

Magic method to check if a property is a valid relation

```php
public function __set(string $property, mixed $value)
```

Magic method to assign values to the the model

```php
public function addBehavior(
    BehaviorInterface $behavior
): void
```

Setups a behavior in a model

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Invoices extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    'onCreate' => [
                        'field'  => 'inv_created_at',
                        'format' => 'Y-m-d H:i:s',
                    ],
                ]
            )
        );
    }
}
```

```php
public function appendMessage(
    MessageInterface $message
): ModelInterface
```

Appends a customized message on the validation process

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message as Message;

class Invoices extends Model
{
    public function beforeSave()
    {
        if (0 === $this->inv_status_flag) {
            $message = new Message(
                'Sorry, an invoice cannot be unpaid'
            );

            $this->appendMessage($message);
        }
    }
}
```

```php
public function assign(
    mixed $data, 
    array $whiteList = null, 
    array $dataColumnMap = null
): ModelInterface
```

Assigns data to the model. The `data` parameter can be an array or a database row. The `whitelist` is an array of model properties that will be updated during the assignment process. Omitted properties will NOT be accepted even if they are included in the array or database row; nevertheless if one of them is required by the model, the data will not be saved and the model will produce an error. The `dataColumnMap` is an array that maps columns from the `data` to the actual model. This helps when you want to map input from an array such as `$_POST` to fields in the database.

Assign values to a model from an array

```php
<?php

$invoice->assign(
    [
        'inv_cst_id'      => 1,
        'inv_status_flag' => 1,
        'inv_title'       => 'Invoice for ACME Inc.',
        'inv_total'       => 100,
        'inv_created_at'  => '2019-12-25 01:02:03',
    ]
);
```

`assign` with a database row. - Requires a Column Map

```php
<?php

$invoice->assign(
    $row,
    null,
    [
        'inv_cst_id'      => 'customerId',
        'inv_status_flag' => 'status',
        'inv_title'       => 'title',
        'inv_total'       => 'total',
    ]
);
```

Update only the `inv_status_flag`, `inv_title`, `inv_total` fields.

```php
<?php

$invoice->assign(
    $_POST,
    [
        'inv_status_flag',
        'inv_title',
        'inv_total',
    ]
);
```

By default `assign` will use setters if they exist, you can disable it by using `ini_set` to directly use properties

    ini_set('phalcon.orm.disable_assign_setters', true);
    

```php
<?php

$invoice->assign(
    $_POST,
    null,
    [
        'inv_status_flag',
        'inv_title',
        'inv_total',
    ]
);
```

```php
public static function average(
    mixed $parameters = null
): float
```

Returns the average value on a column for a result-set of rows matching the specified conditions

```php
<?php

use MyApp\Models\Invoices;

$average = Invoices::average(
    [
        'column' => 'inv_total',
    ]
);

echo 'AVG: ', $average, PHP_EOL;

$average = Invoices::average(
    [
        'inv_cst_id = 1',
        'column' => 'inv_total',
    ]
);

echo 'AVG [Customer: 1] ', $average, PHP_EOL;
```

```php
public static function cloneResult(
    ModelInterface $base, 
    array $data, 
    int $dirtyState = 0
): ModelInterface
```

Assigns values to a model from an array returning a new model

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::cloneResult(
     new Invoices(),
    [
        'inv_cst_id'      => 1,
        'inv_status_flag' => 0,
        'inv_title'       => 'Invoice for ACME Inc. #2',
        'inv_total'       => 400,
        'inv_created_at'  => '2019-12-25 01:02:03',
    ]
 );
```

```php
public static function cloneResultMap(
    mixed $base, 
    array $data, 
    array $columnMap, 
    int $dirtyState = 0, 
    bool $keepSnapshots = null
): ModelInterface
```

Assigns values to a model from an array, returning a new model, using the column map.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::cloneResultMap(
     new Invoices(),
     [
        'customerId' => 1,
        'status'     => 0,
        'title'      => 'Invoice for ACME Inc. #2',
        'total'      => 400,
        'created'    => '2019-12-25 01:02:03',
     ]
);
```

```php
public static function cloneResultMapHydrate(
    array $data, 
    array $columnMap, 
    int $hydrationMode
): mixed
```

Returns an hydrated result based on the data and the column map

```php
public static function count(
    mixed $parameters = null
): int
```

Returns a count of how many records match the specified conditions

```php
<?php

use MyApp\Models\Invoices;

$average = Invoices::count();

echo 'COUNT: ', $average, PHP_EOL;

$average = Invoices::count(
    'inv_cst_id = 1'
);

echo 'COUNT [Customer: 1] ', $average, PHP_EOL;
```

```php
public function create(): bool
```

Inserts a model in the database. If the record exists in the database, `create()` will throw an exception. It will return `true` on success, `false` otherwise.

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();
$invoice->assign(
    [
        'inv_cst_id'      => 1,
        'inv_status_flag' => 1,
        'inv_title'       => 'Invoice for ACME Inc.',
        'inv_total'       => 100,
        'inv_created_at'  => '2019-12-25 01:02:03',
    ]
);

$result = $invoice->create();
```

```php
public function delete(): bool
```

Deletes a model instance. Returning true on success or false otherwise.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 4');
$result  = $invoice->delete();

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 1,
        ]
    ]
);

foreach ($invoices as $invoice) {
    $invoice->delete();
}
```

```php
public function dump(): array
```

Returns a simple representation of the object that can be used with `var_dump()`

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 4');

var_dump(
    $invoice->dump()
);
```

```php
public static function find(
    mixed $parameters = null
): ResultsetInterface
```

Query for a set of records that match the specified conditions. `find()` is flexible enough to accept a variety of parameters to find the data required. You can check the [Finding Records](#finding-records) section for more information.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::find();
```

```php
public static function findFirst(
    mixed $parameters = null
): ModelInterface | null
```

Query the first record that matches the specified conditions. It will return a resultset or `null` if the record was not found.

> **NOTE**: `findFirst()` no longer returns `false` if records were not found.
{: .alert .alert-warning }

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();
```

```php
public function fireEvent(string $eventName): bool
```

Fires an event, implicitly calls behaviors and listeners in the events manager are notified

```php
public function fireEventCancel(string $eventName): bool
```

Fires an event, implicitly calls behaviors and listeners in the events manager are notified. This method stops if one of the callbacks/listeners returns `false`

```php
public function getChangedFields(): array
```

Returns a list of changed values.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();

print_r(
    $invoice->getChangedFields()
); 
// []

$invoice->inv_total = 120;;

$invoice->getChangedFields();

print_r(
    $invoice->getChangedFields()
);
// ['inv_total']
```

```php
public function getDirtyState(): int
```

Returns one of the `DIRTY_STATE_*` constants telling if the record exists in the database or not

```php
public function getMessages(
    mixed $filter = null
): MessageInterface[]
```

Returns array of validation messages

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->save();

if (false === $result) {

    echo 'Error saving Invoice: ';

    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo $message . PHP_EOL;
    }
} else {

    echo 'Record Saved';

}
```

> **NOTE**: `save()` no longer accepts parameters to set data. You can use `assign` instead.
{: .alert .alert-warning }

```php
public function getModelsManager(): ManagerInterface
```

Returns the models manager related to the entity instance

```php
public function getModelsMetaData(): MetaDataInterface
```

Returns the model's meta-data service related to the entity instance

```php
public function getOperationMade(): int
```

Returns the type of the latest operation performed by the ORM. Returns one of the `OP_*` class constants

```php
public function getOldSnapshotData(): array
```

Returns the internal old snapshot data

```php
final public function getReadConnection(): AdapterInterface
```

Gets the connection used to read data for the model

```php
final public function getReadConnectionService(): string
```

Returns the DependencyInjection connection service name used to read data related the model

```php
public function getRelated(
    string $alias, 
    mixed $arguments = null
): Phalcon\Mvc\Model\Resultset\Simple | null
```

Returns related records based on defined relations. If the relationship is one to one and no records have been found, it will return `null`

> **NOTE**: `getRelated()` no longer returns `false` if a record was not found on a one to one relationship.
{: .alert .alert-warning }

```php
<?php

use MyApp\Models\Customers;

$customer = Customers::findFirst('cst_id = 1');
$invoices = $customer->getRelated('invoices');
```

```php
public function isRelationshipLoaded(
    string $relationshipAlias
): bool
```

Checks if saved related records have already been loaded. Only returns `true` if the records were previously fetched through the model without any additional parameters.

```php
<?php

use MyApp\Models\Customers;

$customer = Customers::findFirst('cst_id = 1');
$invoices = $customer->isRelationshipLoaded('invoices'); // false

$invoices = $customer->getRelated('invoices');
$invoices = $customer->isRelationshipLoaded('invoices'); // true
```

```php
final public function getSchema(): string
```

Returns schema name where the mapped table is located

```php
public function getSnapshotData(): array
```

Returns the internal snapshot data

```php
final public function getSource(): string
```

Returns the table name mapped in the model

```php
public function getUpdatedFields(): array
```

Returns a list of updated values.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();

print_r(
    $invoice->getChangedFields()
); 
// []

$invoice->inv_total = 120;;

$invoice->getChangedFields();

print_r(
    $invoice->getChangedFields()
);
// ['inv_total']

$invoice->save();

print_r(
    $invoice->getChangedFields()
);
// []

print_r(
    $invoice->getUpdatedFields()
);
// ['inv_total']
```

```php
final public function getWriteConnection(): AdapterInterface
```

Gets the connection used to write data to the model

```php
final public function getWriteConnectionService(): string
```

Returns the DependencyInjection connection service name used to write data related to the model

```php
public function hasChanged(
    string | array $fieldName = null, 
    bool $allFields = false
): bool
```

Check if a specific attribute has changed. This only works if the model is keeping data snapshots

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->create();

$invoice->inv_total = 120;

$hasChanged = $invoice->hasChanged('inv_title');
// false
$hasChanged = $invoice->hasChanged(
    [
        'inv_total',
    ]
);
// true
$hasChanged = $invoice->hasChanged(
    [
        'inv_title', 
        'inv_total'
    ], 
    true
);
// false
```

```php
public function hasSnapshotData(): bool
```

Checks if the object has internal snapshot data

```php
public function hasUpdated(
    string | array $fieldName = null, 
    bool $allFields = false
): bool
```

Check if a specific attribute was updated. This only works if the model is keeping data snapshots.

```php
public function jsonSerialize(): array
```

Serializes the object for json_encode

```php
echo json_encode($invoice);
```

```php
public static function maximum(
    mixed $parameters = null
): mixed
```

Returns the maximum value of a column for a result-set of rows that match the specified conditions

```php
<?php

use MyApp\Models\Invoices;

$id = Invoices::maximum(
    [
        'column' => 'inv_id',
    ]
);

echo 'MAX: ', $id, PHP_EOL;

$max = Invoices::maximum(
    [
        'inv_cst_id = 1',
        'column' => 'inv_total',
    ]
);

echo 'MAX [Customer: 1] ', $max, PHP_EOL;
```

```php
public static function minimum(
    mixed parameters = null
): mixed 
```

Returns the minimum value of a column for a result-set of rows that match the specified conditions

```php
<?php

use MyApp\Models\Invoices;

$id = Invoices::minimum(
    [
        'column' => 'inv_id',
    ]
);

echo 'MIN: ', $id, PHP_EOL;

$max = Invoices::minimum(
    [
        'inv_cst_id = 1',
        'column' => 'inv_total',
    ]
);

echo 'MIN [Customer: 1] ', $max, PHP_EOL;
```

```php
public static function query(
    DiInterface $container = null
): CriteriaInterface
```

Create a criteria for a specific model

```php
public function readAttribute(
    string $attribute
): mixed | null
```

Reads an attribute value by its name

```php
echo $invoice->readAttribute('inv_title');
```

```php
public function refresh(): ModelInterface
```

Refreshes the model attributes re-querying the record from the database

```php
public function save(): bool
```

Inserts or updates a model instance. Returning `true` on success or `false` otherwise.

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->save();

$invoice = Invoices::findFirst('inv_id = 100');

$invoice->inv_total = 120;

$invoice->save();
```

> **NOTE**: `save()` no longer accepts parameters to set data. You can use `assign` instead.
{: .alert .alert-warning }

```php
public function serialize(): string
```

Serializes the object ignoring connections, services, related objects or static properties

```php
public function unserialize(mixed $data)
```

Unserializes the object from a serialized string

```php
final public function setConnectionService(
    string $connectionService
): void
```

Sets the DependencyInjection connection service name

```php
public function setDirtyState(
    int $dirtyState
): ModelInterface | bool
```

Sets the dirty state of the object using one of the `DIRTY_STATE_*` constants

```php
public function setEventsManager(
    EventsManagerInterface $eventsManager
)
```

Sets a custom events manager

```php
final public function setReadConnectionService(
    string $connectionService
): void
```

Sets the DependencyInjection connection service name used to read data

```php
public function setOldSnapshotData(
    array $data, 
    array $columnMap = null
)
```

Sets the record's old snapshot data. This method is used internally to set old snapshot data when the model was set up to keep snapshot data

```php
public function setSnapshotData(
    array $data, 
    array $columnMap = null
): void
```

Sets the record's snapshot data. This method is used internally to set snapshot data when the model was set up to keep snapshot data

```php
public function setTransaction(
    TransactionInterface $transaction
): ModelInterface
```

Sets a transaction related to the Model instance

```php
<?php

use MyApp\Models\Customers;
use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Mvc\Model\Transaction\Failed;

try {
    $txManager   = new Manager();
    $transaction = $txManager->get();

    $customer = new Customers();
    $customer->setTransaction($transaction);
    $customer->cst_name_last  = 'Vader';
    $customer->cst_name_first = 'Darth';

    if (false === $customer->save()) {
        $transaction->rollback('Cannot save Customer');
    }

    $invoice = new Invoices();
    $invoice->setTransaction($transaction);

    $invoice->inv_cst_id      = $customer->cst_id;
    $invoice->inv_status_flag = 1;
    $invoice->inv_title       = 'Invoice for ACME Inc.';
    $invoice->inv_total       = 100;
    $invoice->inv_created_at  = '2019-12-25 01:02:03';

    if (false === $invoice->save()) {
        $transaction->rollback('Cannot save record');
    }

    $transaction->commit();
} catch (Failed $ex) {
    echo 'ERROR: ', $ex->getMessage();
}
```

```php
public static function setup(
    array $options
): void
```

Enables / disables options in the ORM such as events, column renaming etc.

```php
final public function setWriteConnectionService(
    string $connectionService
): void
```

Sets the DependencyInjection connection service name used to write data

```php
public function skipOperation(bool $skip): void
```php
Skips the current operation forcing a success state

```php
public static function sum(
    array $parameters = null
): float
```

Calculates the sum on a column for a result-set of rows that match the specified conditions

```php
<?php

use MyApp\Models\Invoices;

$total = Invoices::sum(
    [
        'column' => 'inv_total',
    ]
);

echo 'SUM: ', $total, PHP_EOL;

$total = Invoices::sum(
    [
        'inv_cst_id = 1',
        'column' => 'inv_total',
    ]
);

echo 'SUM [Customer: 1] ', $total, PHP_EOL;
```

```php
public function toArray(
    array $columns = null
): array
```

Returns the instance as an array representation. Accepts an array with column names to include in the result

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 4');

print_r(
    $invoice->toArray()
);

//  [
//      'inv_id'          => 4,
//      'inv_cst_id'      = $customer->cst_id,
//      'inv_status_flag' = 1,
//      'inv_title'       = 'Invoice for ACME Inc.',
//      'inv_total'       = 100,
//      'inv_created_at'  = '2019-12-25 01:02:03',
//  ]

print_r(
    $invoice->toArray(
        [
            'inv_status_flag',
            'inv_title',
            'inv_total',
        ]
    )
);

//  [
//      'inv_status_flag' = 1,
//      'inv_title'       = 'Invoice for ACME Inc.',
//      'inv_total'       = 100,
//  ]
```

```php
public function update(): bool
```

Updates a model instance. If the instance doesn't exist in the persistence it will throw an exception. Returning true on success or `false` otherwise.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 4');

$invoice->inv_total = 120;

$invoice->update();
```

```php
public function writeAttribute(
    string $attribute, 
    mixed $value
): void
```

Writes an attribute value by its name

```php
$invoice->writeAttribute('inv_total', 120);
```

```php
protected function allowEmptyStringValues(
    array $attributes
): void
```

Sets a list of attributes that must be skipped from the generated `UPDATE` statement

```php
<?php 

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->allowEmptyStringValues(
            [
                'inv_created_at',
            ]
        );
    }
}
```

```php
protected function belongsTo(
    string | array $fields, 
    string $referenceModel, 
    string | array $referencedFields, 
    array options = null
): Relation
```

Setup a reverse 1-1 or n-1 relation between two models

```php
<?php 

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class InvoicesXProducts extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'ixp_inv_id',
            Invoices::class,
            'inv_id'
        );
    }
}
```

```php
protected function hasMany(
    string | array $fields, 
    string $referenceModel, 
    string | array $referencedFields, 
    array options = null
): Relation
```

Setup a 1-n relation between two models

```php
<?php 

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Customers extends Model
{
    public function initialize()
    {
        $this->hasMany(
            'cst_id',
            Invoices::class,
            'inv_cst_id'
        );
    }
}
```

```php
protected function hasManyToMany(
    string | array $fields,
    string $intermediateModel, 
    string | array $intermediateFields,
    string | array $intermediateReferencedFields,
    string $referenceModel, 
    string | array $referencedFields,
    array $options = null
): Relation
```

Setup an n-n relation between two models, through an intermediate relation

```php
<?php 

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->hasManyToMany(
            'inv_id',
            InvoicesXProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id'
        );
    }
}
```

```php
protected function hasOne(
    string | array $fields, 
    string $referenceModel, 
    string | array $referencedFields, 
    array options = null
): Relation
```

Setup a 1-1 relation between two models

```php
<?php 

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->hasOne(
            'inv_cst_id',
            Customers::class,
            'cst_id'
        );
    }
}
```

```php
protected function keepSnapshots(
    bool $keepSnapshot
): void
```

Sets if the model must keep the original record snapshot in memory

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

```php
final protected function setSchema(
    string $schema
): ModelInterface
```

Sets schema name where the mapped table is located

```php
final protected function setSource(
    string $source
): ModelInterface
```

Sets the table name to which model should be mapped

```php
protected function skipAttributes(array $attributes)
```

Sets a list of attributes that must be skipped from the generated `INSERT`/`UPDATE` statement

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->skipAttributes(
            [
                'inv_created_at',
            ]
        );
    }
}
```

```php
protected function skipAttributesOnCreate(
    array $attributes
): void
```

Sets a list of attributes that must be skipped from the generated `INSERT` statement

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->skipAttributesOnCreate(
            [
                'inv_created_at',
            ]
        );
    }
}
```

```php
protected function skipAttributesOnUpdate(
    array $attributes
): void
```

Sets a list of attributes that must be skipped from the generated `UPDATE` statement

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->skipAttributesOnUpdate(
            [
                'inv_modified_at',
            ]
        );
    }
}
```

```php
protected function useDynamicUpdate(
    bool dynamicUpdate
): void
```

Sets if a model must use dynamic update instead of the all-field update

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

```php
protected function validate(
    ValidationInterface $validator
): bool
```

Executes validators on every validation call

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Invoices extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'inv_status_flag',
            new ExclusionIn(
                [
                    'domain' => [
                        0,
                        1,
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

```php
public function validationHasFailed(): bool
```

Check whether validation process has generated any messages

## Creating Models

A model is a class that extends from [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model). Its class name should be in camel case notation:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{

}
```

By default, the model `MyApp\Models\Invoices` will map to the table `invoices`. If you want to manually specify another name for the mapped table, you can use the `setSource()` method:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->setSource('co_invoices');
    }
}
```

The model `Invoices` now maps to `co_invoices` table. The `initialize()` method helps with setting up this model with a custom behavior i.e. a different table.

The `initialize()` method is only called once during the request. This method is intended to perform initializations that apply for all instances of the model created within the application. If you want to perform initialization tasks for every instance created you can use the `onConstruct()` method:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function onConstruct()
    {
        // ...
    }
}
```

**Properties vs. Setters/Getters**

Models can be implemented with public properties, meaning that each property can be read and updated updated from any part of the code that has instantiated that model class:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_id;
    public $inv_cst_id;
    public $inv_status_flag;
    public $inv_title;
    public $inv_total;
    public $inv_created_at;
}
```

Another implementation is to use getter and setter functions, which control which properties are publicly available for that model.

The benefit of using getters and setters is that the developer can perform transformations and validation checks on the values set or retrieved for the model, which is impossible when using public properties.

Additionally getters and setters allow for future changes without changing the interface of the model class. So if a field name changes, the only change needed will be in the private property of the model referenced in the relevant getter/setter and nowhere else in the code.

```php
<?php

namespace MyApp\Models;

use InvalidArgumentException;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    private $inv_id;
    private $inv_cst_id;
    private $inv_status_flag;
    private $inv_title;
    private $inv_total;
    private $inv_created_at;

    public function getId(): int
    {
        return (int) $this->inv_id;
    }

    public function getCustomerId(): int
    {
        return (int) $this->inv_cst_id;
    }

    public function getStatus(): int
    {
        return (int) $this->inv_status_flag;
    }

    public function getTitle(): string
    {
        return (string) $this->inv_title;
    }

    public function getTotal(): float
    {
        return (float) $this->inv_total;
    }

    public function getCreatedAt(): string
    {
        return (string) $this->inv_created_at;
    }

    public function setCustomerId(int $customerId): Invoices
    {
        $this->inv_cst_id = $customerId;

        return $this;
    }

    public function setStatus(int $status): Invoices
    {
        $this->inv_status_flag = $status;

        return $this;
    }

    public function setTitle(string $title): Invoices
    {
        $this->inv_title = $title;

        return $this;
    }

    public function setTotal(float $total): Invoices
    {
        if ($total < 0) {
            throw new InvalidArgumentException(
                'Incorrect total'
            );
        }

        $this->inv_total = $total;

        return $this;
    }

    public function setCreatedAt(string $date): Invoices
    {
        $this->inv_created_at = $date;

        return $this;
    }
}
```

Public properties provide less complexity in development. However getters/setters can heavily increase the testability, extensibility and maintainability of applications. You will need to decide which strategy is best for you depending on the needs of the application. The ORM is compatible with both schemes of defining properties.

> **NOTE**: Underscores in property names can be problematic when using getters and setters.
{: .alert .alert-warning }

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use with magic methods. (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.).

The ORM expects camel case naming and underscores are commonly removed. It is therefore recommended to name your properties in the manner shown throughout the documentation. You can use a column map (as described above) to ensure proper mapping of your properties to their database counterparts.

## Records To Objects

Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example, for a table 'co_customers' with the records:

```sql
mysql> select * from co_customers;
+--------+---------------+----------------+
| cst_id | cst_name_last | cst_name_first |
+--------+---------------+----------------+
|      1 | Vader         | Darth          |
|      2 | Skywalker     | Like           |
|      3 | Skywalker     | Leia           |
+--------+---------------+----------------+
3 rows in set (0.00 sec)
```

You could find a certain record by its primary key and then print its name:

```php
<?php

use MyApp\Models\Customers;

// cst_id = 3
$customer = Customers::findFirst(3);

// 'Leia'
echo $customer->cst_name_first;
```

Once the record is in memory, you can make modifications to its data and then save changes:

```php
<?php

use MyApp\Models\Customers;

// cst_id = 3
$customer = Customers::findFirst(3);

$customer->inv_name_last = 'Princess';

$customer->save();
```

As you can see, there is no need to use raw SQL statements. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) provides high database abstraction for web applications, simplifying database operations.

## Finding Records

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) also offers several methods for querying records.

### `find`

The method returns a [Phalcon\Mvc\Model\Resultset](api/phalcon_mvc#mvc-model-resultset), [Phalcon\Mvc\Model\Resultset\Comples](api/phalcon_mvc#mvc-model-resultset-complex) or [Phalcon\Mvc\Model\Resultset\Simple](api/phalcon_mvc#mvc-model-resultset-simple) collection of records even if the result returned is only one record.

The method accept a variety of parameters to retrieve data:

```php
<?php

use MyApp\Models\Customers;

$invoice = Invoices::findFirst('inv_id = 3');
```

You can also pass a string with a `WHERE` clause. In the above example we are getting the same record, instructing the ORM to give us a record with `inv_cst_id = 3`

The most flexible syntax is to pass an array with different parameters:

```php
<?php

use MyApp\Models\Customers;

$invoice = Invoices::findFirst(
    [
        'inv_id = 3',
    ]
);
```

The first parameter of the array (without a key) is treated the same way as the example above (passing a string). The array accepts additional parameters that offer additional options to customize the find operation.

### `findFirst`

You could also use the `findFirst()` method to get only the first record matching the given criteria:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();
```

Calling `findFirst` without a parameter will return the first record the ORM finds. Usually this is the first record in the table.

```php
<?php

use MyApp\Models\Invoices;

// cst_id = 3
$invoice = Invoices::findFirst(3);
```

Passing a number, will query the underlying model using the primary key matching the number parameter passed. If there is no primary key defined or there is a compound key, you will not get any results.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 3');
```

You can also pass a string with a `WHERE` clause. In the above example we are getting the same record, instructing the ORM to give us a record with `inv_cst_id = 3`

> **NOTE**: If primary key of table is not numeric, use condition. See examples below.
 {: .alert .alert-warning }

```php
$uuid = '5741bfd7-6870-40b7-adf6-cbacb515b9a9';
$invoice = Invoices::findFirst([
    'uuid = ?0',
    'bind' => [$uuid],
]);

// OR

$uuid = '5741bfd7-6870-40b7-adf6-cbacb515b9a9';
$invoice = Invoices::findFirst([
    'uuid = :primary:',
    'bind' => ['primary' => $uuid],
]);
```

> **NOTE**: If you do not use bound parameters in your conditions, PHQL will create a new plan internally, therefore consuming more memory. Using bound parameters is highly recommended!
 {: .alert .alert-warning }

```php
<?php


use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('uuid = "5741bfd7-6870-40b7-adf6-cbacb515b9a9"');
```

### Parameters

> **NOTE**: It is highly recommended to use the array syntax with `conditions` and `bind` to shield yourself from SQL injections, especially when the criteria comes from user input. For more information check the [Binding Parameters](#binding-parameters)` section.
{: .alert .alert-warning }

Both `find()` and `findFirst()` methods accept an associative array specifying the search criteria.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'inv_cst_id = 3',
        'order' => 'inv_total desc'
    ]
);
```

You can (and should) use the `conditions` and `bind` array elements which bind parameters to the query parameters. Using this implementation will ensure that your parameters are bound and thus reducing the possibility of SQL injections:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'order'      => 'inv_total desc',
    ]
);
```

The available query options are:

**`bind`**

Bind is used together with `conditions`, by replacing placeholders and escaping values thus increasing security

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :inv_id:',
        'bind'       => [
            'inv_id' => 3,
        ],
    ]
);
```

**`bindTypes`**

When binding parameters, you can use this option to define additional casting to the bound parameters increasing even more the security of your query.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Column;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :inv_id:',
        'bind'       => [
            'inv_id' => 3,
        ],
        'bindTypes'  => [
            Column::BIND_PARAM_INT,
        ],
    ]
);
```

**`cache`**

Cache the resultset, reducing the continuous access to the relational system.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'cache'      => [
            'key'      => 'customer.3',
            'lifetime' => 84600,
        ],
        'order'      => 'inv_total desc',
    ]
);
```

**`columns`**

Return specific columns in the model.

> **NOTE**: When using this option an incomplete object is returned, and therefore you cannot call methods such as `update()`, `getRelated()` etc.
{: .alert .alert-info }

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'columns'    => [
            'inv_id',
            'total' => 'inv_total'
        ],
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
    ]
);
```

The columns array can return the columns directly if only a value has been set for one of the array elements. However if you choose to specify a key, it will be used as an alias for that field. In the above example, the `cst_name_first` is aliased as `first`.

**`conditions`**

Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) assumes the first parameter are the conditions.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
    ]
);
```

**`for_update`**

With this option, [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) reads the latest available data, setting exclusive locks on each row it reads

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'for_update' => true,
    ]
);
```

**`group`**

Allows to collect data across multiple records and group the results by one or more columns `'group' => 'name, status'`

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'group'      => 'inv_status_flag',
    ]
);
```

**`hydration`**

Sets the hydration strategy to represent each returned record in the result

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Resultset;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'hydration' => Resultset::HYDRATE_OBJECTS,
    ]
);
```

**`limit`**

Limit the results of the query to results to certain range

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'limit'      => 10,
    ]
);
```

**`offset`**

Offset the results of the query by a certain amount

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'limit'      => 10,
        'offset'     => 100,
    ]
);
```

**`order`**

Is used to sort the resultset. Use one or more fields separated by commas.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 3,
        ],
        'order'      => 'inv_status_flag, inv_total desc',
    ]
);
```

**`shared_lock`**

With this option, [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) reads the latest available data, setting shared locks on each row it reads

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_cst_id = :cst_id:',
        'bind'        => [
            'cst_id' => 3,
        ],
        'shared_lock' => true,
    ]
);
```

### `query`

If you prefer, there is also available a way to create queries in an object-oriented way, instead of using an array of parameters:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::query()
    ->where('inv_cst_id = :cst_id:')
    ->andWhere('inv_total > :total:')
    ->bind(
        [
            'cst_id' => 3,
            'total'  => 1000,
        ]
    )
    ->orderBy('inv_status_flag, inv_total desc')
    ->execute()
;
```

The static method `query()` returns a [Phalcon\Mvc\Model\Criteria](api/phalcon_mvc#mvc-model-criteria) object that is friendly with IDE auto complete.

All the queries are internally handled as [PHQL](db-phql) queries. PHQL is a high-level, object-oriented and SQL-like language. This language offers more features to perform queries such as joining other models, group records, aggregations etc.

### `findBy*`

You can use the `findBy<property-name>()` method. This method expands on the `find()` method mentioned above. It allows you to quickly perform a select of records from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column.

For the following model:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_cst_id;
    public $inv_id;
    public $inv_status_flag;
    public $inv_title;
    public $inv_created_at;
}
```

We have the properties `inv_cst_id`, `inv_id`, `inv_status_flag`, `inv_title`, `inv_created_at`. If we want to find all the invoices with `inv_total = 100` we can use:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_total = :total:',
        'bind'        => [
            'total' => 100,
        ],
    ]
);
```

but we can also use:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::findByInvTotal(100);
```

> **NOTE**: The property names are changed to camel case if they have underscores. `inv_total` becomes `InvTotal`
{: .alert .alert-info }

You can also pass parameters in an array as the second parameter. These parameters are the same as the ones you can pass in the `find` method.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::findByInvTotal(
    100,
    [
        'order' => `inv_cst_id, inv_created_at`
    ]
);
```

### `findFirstBy*`

Finally, you can use the `findFirstBy<property-name>()` method. This method expands on the `findFirst()` method mentioned above. It allows you to quickly perform a select from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column.

For the following model:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Guestbook extends Model
{
    public $id;
    public $email;
    public $name;
    public $text;
}
```

We have the properties `id`, `email`, `name` and `text`. If we want to find the guest book entry for `Darth Vader` we can:

```php
<?php

use MyApp\Models\Guestbook;

$guest = Guestbook::findFirst(
    [
        'conditions'  => 'name = :name:',
        'bind'        => [
            'name' => 'Darth Vader',
        ],
    ]
);
```

but we can also use:

```php
<?php

use MyApp\Models\Guestbook;

$name  = 'Darth Vader';
$guest = Guestbook::findFirstByName($name);
```

> **NOTE**: Notice that we used `Name` in the method call and passed the variable `$name` to it, which contains the name we are looking for in our table. Notice also that when we find a match with our query, all the other properties are available to us as well.
{: .alert .alert-info }

### Model Resultsets

While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a [Phalcon\Mvc\Model\Resultset\Simple](api/phalcon_mvc#mvc-model-resultset-simple). This is an object that encapsulates all the functionality a resultset has, such as seeking, traversing, counting etc.

These objects are more powerful than standard arrays. One of the greatest features of the [Phalcon\Mvc\Model\Resultset](api/phalcon_mvc#mvc-model-resultset) is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

Some examples of traversing resultsets are:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find();

// foreach
foreach ($invoices as $invoice) {
    echo $invoice->inv_title, PHP_EOL;
}

// while
$invoices->rewind();
while ($invoices->valid()) {
    $invoice = $invoices->current();

    echo $invoice->inv_title, PHP_EOL;

    $invoices->next();
}

// count
echo count($invoices);
echo $invoices->count();

// seek
$invoices->seek(2);
$invoice = $invoices->current();

// array
$invoice = $invoices[5];

// array - isset
if (true === isset($invoices[3])) {
   $invoice = $invoices[3];
}

// First
$invoice = $invoices->getFirst();

// Last
$invoice = $invoices->getLast();
```

Phalcon's resultsets emulate scrollable cursors. You can get any row just by accessing its position, or seeking the internal pointer to a specific position.

> **NOTE**: Some database systems do not support scrollable cursors. This forces Phalcon to re-execute the query, in order to rewind the cursor to the beginning and obtain the record at the requested position. Similarly, if a resultset is traversed several times, the query must be executed the same number of times.
{: .alert .alert-info }

Storing large query results in memory will consume many resources. You can however instruct Phalcon to fetch data in chunks of rows, thus reducing the need to re-execute the request in many cases. You can achieve that by setting the `orm.resultset_prefetch_records` setup value. This can be done either in `php.ini` or in the model `setup()`. More information about this can be found in the [features](#disablingenabling-features) section.

Note that resultsets can be serialized and stored in a cache backend. [Phalcon\Cache](cache) can help with that task. However, serializing data causes [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) to retrieve all the data from the database in an array, thus consuming more memory while this process takes place.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find();

file_put_contents(
    'invoices.cache',
    serialize($invoices)
);

$invoices = unserialize(
    file_get_contents('invoices.cache')
);

foreach ($invoices as $invoice) {
    echo $invoice->inv_title;
}
```

### Custom Resultsets

There are times that the application logic requires additional manipulation of the data as it is retrieved from the database. Previously, we would just extend the model and encapsulate the functionality in a class in the model or a trait, returning back to the caller usually an array of transformed data.

With custom resultsets, you no longer need to do that. The custom resultset will encapsulate the functionality, that otherwise would be in the model, and can be reused by other models, thus keeping the code [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself). This way, the `find()` method will no longer return the default [Phalcon\Mvc\Model\Resultset](api/phalcon_mvc#mvc-model-resultset), but instead the custom one. Phalcon allows you to do this by using the `getResultsetClass()` in your model.

First we need to define the resultset class:

```php
<?php

namespace MyApp\Mvc\Model\Resultset;

use \Phalcon\Mvc\Model\Resultset\Simple;

class Custom extends Simple
{
    public function calculate() {
        // ....
    }
}
```

In the model, we set the class in the `getResultsetClass()` as follows:

```php
<?php

namespace Phalcon\Test\Models\Statistics;

use MyApp\Mvc\Model\Resultset\Custom;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->setSource('co_invoices');
    }

    public function getResultsetClass()
    {
        return Custom::class;
    }
}
```

and finally in your code you will have something like this:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_cst_id = :cst_id:',
        'bind'        => [
            'cst_id' => 3,
        ],
    ]
);

$calculated = $invoices->calculate();
```

### Filtering Resultsets

The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster. Phalcon additionally allows you to filter the data using PHP:

```php
<?php

$invoices = Invoices::find();

$invoices = $invoices->filter(
    function ($invoice) {
        if (1 === $invoice->inv_status_flag) {
            return $invoice;
        }
    }
);
```

The above example will return only the paid invoices from our table (`inv_status_flag = 1`);

### Binding Parameters

Bound parameters are also supported in [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model). You are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both `string` and `integer` placeholders are supported.

> **NOTE**: When using `integer` placeholders you must prefix them with `?` (`?0`, `?1`). When using `string` placeholders you must enclose the string in `:` (`:name:`, `:total:`). 
{: .alert .alert-info }

Some examples:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_title LIKE :title: AND ' .
                         'inv_total > :total:',
        'bind'        => [
            'title' => '%ACME%',
            'total' => 1000,
        ],
    ]
);

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_title LIKE ?0 = ?0 AND ' .
                         'inv_total > ?1',
        'bind'        => [
            0 => '%ACME%',
            1 => 1000,
        ],
    ]
);

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_title = ?0 AND ' .
                         'inv_total > :total:',
        'bind'        => [
            0       => '%ACME%',
            'total' => 1000,
        ],
    ]
);
```

Strings are automatically escaped using [PDO](https://php.net/manual/en/pdo.prepared-statements.php). This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Additionally you can set the parameter `bindTypes`, this allows defining how the parameters should be bound according to their data type:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Db\Column;

$parameters = [
    'title' => '%ACME%',
    'total' => 1000,
];

$types = [
    'title' => Column::BIND_PARAM_STR,
    'total' => Column::BIND_PARAM_INT,
];

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_title LIKE :title: AND ' .
                         'inv_total > :total:',
        'bind'        => $parameters,
        'bindTypes'   => $types,
    ]
);
```

> **NOTE**: Since the default bind type is `Phalcon\Db\Column::BIND_PARAM_STR`, there is no need to specify the 'bindTypes' parameter if all of the columns are strings
{: .alert .alert-info }

You can also bind arrays in the parameters, especially when using the `IN` SQL keyword.

> **NOTE**: You need to use a zero based array for arrays without missing elements 
{: .alert .alert-info }

```php
<?php

use MyApp\Models\Invoices;

$customerIds = [1, 3, 4]; // $array: [[0] => 1, [1] => 2, [2] => 4]

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_cst_id IN ({customerId:array})',
        'bind'        => [
            'customerId' => $customerIds,
        ],
    ]
);

unset($customerIds[1]);  // $array: [[0] => 1, [2] => 4]

$customerIds = array_values($customerIds);  // $array: [[0] => 1, [1] => 4]

$invoices = Invoices::find(
    [
        'conditions'  => 'inv_cst_id IN ({customerId:array})',
        'bind'        => [
            'customerId' => $customerIds,
        ],
    ]
);
```

> **NOTE**: Bound parameters are available for all query methods such as `find()` and `findFirst()` but also the calculation methods like `count()`, `sum()`, `average()` etc.
{: .alert .alert-info }

If you're using *finders* e.g. `find()`, `findFirst()`, etc., you can inject the bound parameters when using the string syntax for the first parameter instead of using the `conditions` array element. Also when using `findFirstBy*` the parameters are automatically bound.

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    'inv_total > ?0',
    'bind'        => [
        1000,
    ]
);

$invoices = Invoices::findByInvTotal(1000);
```

## Before/After Fetching

There are cases where we need to manipulate the data after it has been fetched from the database so that our model contains what we need in the application layer. As seen in the <events> document, models act as listeners so we can implement some events as methods in the model.

Such methods include `beforeSave`, `afterSave` and `afterFetch` as shown in our example below. The `afterFetch` method will run right after the data populates the model from the database. We can utilize this method to modify or transform the data in the model.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_id;
    public $inv_cst_id;
    public $inv_status_flag;
    public $inv_total;
    public $status;

    public function beforeSave()
    {
        $this->status = join(',', $this->status);
    }

    public function afterFetch()
    {
        $this->status = explode(',', $this->status);
    }

    public function afterSave()
    {
        $this->status = explode(',', $this->status);
    }
}
```

In the above example we receive a comma delimited string from the database and `explode` it to an array so that it can be used from our application. After that, you can add or remove elements in the array; before the model saves it, `implode` will be called to store the array as a string in the database.

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is accessed:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_id;
    public $inv_cst_id;
    public $inv_status_flag;
    public $inv_total;
    public $status;

    public function getStatus()
    {
        return explode(',', $this->status);
    }
}
```

## Calculations

Calculations (or aggregations) are helpers for commonly used functions of database systems such as `COUNT`, `SUM`, `MAX`, `MIN` or `AVG`. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) allows to use these functions directly from the exposed methods.

**`COUNT`**

```php
<?php

$rowcount = Invoices::count();

// inv_cst_id = 3
$rowcount = Invoices::count(
    [
        'inv_cst_id = ?0',
        'bind'        => [
            3,
        ],
    ]
);
```

We can also use the `group` parameter to group our results. The count results appear in the `rowcount` property of each object in the collection returned.

```php
<?php

$group = Invoices::count(
    [
        'group' => 'inv_cst_id',
    ]
);
foreach ($group as $row) {
   echo 'Count: ', $row->rowcount, ' - Customer: ', $row->inv_cst_id;
}

$group = Invoices::count(
    [
        'group' => 'inv_cst_id',
        'order' => 'rowcount',
    ]
);
```

**`SUM`**

```php
<?php

$total = Invoices::sum(
    [
        'column' => 'inv_total',
    ]
);

$total = Invoices::sum(
    [
        'column'     => 'total',
        'conditions' => 'inv_cst_id = ?0',
        'bind'       => [
            3
        ]
    ]
);
```

You can also group results. The count results appear in the `sumatory` property of each object in the collection returned.

```php
<?php

$group = Invoices::sum(
    [
        'column' => 'inv_total',
        'group'  => 'inv_cst_id',
    ]
);

foreach ($group as $row) {
   echo 'Customer: ', $row->inv_cst_id, ' - Total: ', $row->sumatory;
}

$group = Invoices::sum(
    [
        'column' => 'inv_total',
        'group'  => 'inv_cst_id',
        'order'  => 'sumatory DESC',
    ]
);
```

**`AVERAGE`**

```php
<?php

$average = Invoices::average(
    [
        'column' => 'inv_total',
    ]
);

$average = Invoices::average(
    [
        'column'     => 'inv_total',
        'conditions' => 'inv_status_flag = ?0',
        'bind'       => [
            0
        ]
    ]
);
```

**`MAX` - `MIN`**

```php
<?php

$max = Invoices::maximum(
    [
        'column' => 'inv_total',
    ]
);

$max = Invoices::maximum(
    [
        'column'     => 'inv_total',
        'conditions' => 'inv_status_flag = ?0',
        'bind'       => [
            0
        ],
    ]
);

$min = Invoices::minimum(
    [
        'column' => 'inv_total',
    ]
);

$min = Invoices::minimum(
    [
        'column'     => 'inv_total',
        'conditions' => 'inv_status_flag = ?0',
        'bind'       => [
            0
        ],
    ]
);
```

## Creating - Updating

The `Phalcon\Mvc\Model::save()` method allows you to create/update records according to whether they already exist in the table associated with a model. The save method is called internally by the create and update methods of [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model). For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record should be created or updated.

The method also executes associated validators, virtual foreign keys and events that are defined in the model:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->save();

if (false === $result) {

    echo 'Error saving Invoice: ';

    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo $message . PHP_EOL;
    }
} else {

    echo 'Record Saved';
}
```

You can also use the `assign()` method and pass an array of `field => value` elements, to avoid assigning each column manually. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) will check if there are setters implemented for the columns passed in the array, giving priority to them, instead of assign directly the values of the attributes:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->assign(
    [
        'inv_cst_id'      => 1,
        'inv_status_flag' => 1,
        'inv_title'       => 'Invoice for ACME Inc.',
        'inv_total'       => 100,
        'inv_created_at'  => '2019-12-25 01:02:03',
    ]
);

$result = $invoice->save();
```

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass an insecure array without worrying about possible SQL injections:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->assign($_POST);

$result = $invoice->save();
```

> **NOTE**: Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form.
{: .alert .alert-danger }

You can set an additional parameter in `assign` to set a whitelist of fields that only must taken into account when doing the mass assignment:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->assign(
    $_POST,
    [
        'inv_cst_id',
        'inv_status_flag',
        'inv_title',
        'inv_total',
    ]
);

$result = $invoice->save();
```

> **NOTE**: On really busy applications, you can use `create` or `update` for the respective operations. By using those two methods instead of save, we ensure that data will be saved or not in the database, since those throw exceptions on `create` if the record already exists, and on `update` if the record does not exist.
{: .alert .alert-info }

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->inv_id          = 1234;
$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$result = $invoice->update();

if (false === $result) {

    echo 'Error saving Invoice: ';

    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo $message . PHP_EOL;
    }
} else {

    echo 'Record Updated';

}
```

The methods `create` and `update` also accept an array of values as parameter.

## Deleting

The `delete()` method allows you to delete a record. It returns a boolean signifying success or failure

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :id:',
        'bind'       => [
            'id' => 4,
        ]
    ]
);

if (false !== $invoice) {
    if (false === $invoice->delete()) {
        $messages = $invoice->getMessages();

        foreach ($messages as $message) {
            echo $message . PHP_EOL;
        }
    } else {

        echo 'Record Deleted';
    }
}
```

You can also delete many records by traversing a resultset with a `foreach`:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::find(
    [
        'conditions' => 'inv_cst_id = :id:',
        'bind'       => [
            'id' => 3,
        ]
    ]
);

foreach ($invoices as $invoice) {
    if (false === $invoice->delete()) {
        $messages = $invoice->getMessages();

        foreach ($messages as $message) {
            echo $message . PHP_EOL;
        }
    } else {

        echo 'Record Deleted';
    }
}
```

> **NOTE**: Check the [transactions](#transactions) section on how you can delete all the records in a loop with one operation
{: .alert .alert-info }

## Hydration Modes

As mentioned earlier, resultsets are collections of complete objects. This means that every returned result is an object, representing a row in the database. These documents can be modified and later on saved to persist the changes in the database.

However, there are times that you will need to get the data in a read only mode, such as in cases of just viewing data. In these cases, it is useful to change the way the records are returned to save resources and increase performance. The strategy used to represent these objects returned in an resultset is called `hydration`.

Phalcon offers three ways of hydrating data: - Arrays : `Phalcon\Mvc\Model\Resultset::HYDRATE_ARRAYS` - Objects : `Phalcon\Mvc\Model\Resultset::HYDRATE_OBJECTS` - Records : `Phalcon\Mvc\Model\Resultset::HYDRATE_RECORDS`

The default hydration mode is to return records (`HYDRATE_RECORDS`). We can easily change the hydration mode to get arrays or objects back. Changing the hydration mode to anything other than `HYDRATE_RECORDS` will return back objects (or arrays) that have no connection to the database i.e. we will not be able to perform any operations on those objects such as `save()`, `create()`, `delete()` etc.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Resultset;

$invoices = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :id:',
        'bind'       => [
            'id' => 4,
        ]
    ]
);

// Array
$invoices->setHydrateMode(
    Resultset::HYDRATE_ARRAYS
);

foreach ($invoices as $invoice) {
    echo $invoice['inv_total'], PHP_EOL;
}

// \stdClass
$invoices->setHydrateMode(
    Resultset::HYDRATE_OBJECTS
);

foreach ($invoices as $invoice) {
    echo $invoice->inv_total, PHP_EOL;
}

// Invoices
$invoices->setHydrateMode(
    Resultset::HYDRATE_RECORDS
);

foreach ($invoices as $invoice) {
    echo $invoice->inv_total, PHP_EOL;
}
```

Hydration mode can also be passed as a parameter of `find`, `findFirst`, `findFirstBy*` etc.:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Resultset;

$invoices = Invoices::findFirst(
    [
        'hydration'  => Resultset::HYDRATE_ARRAYS,
        'conditions' => 'inv_id = :id:',
        'bind'       => [
            'id' => 4,
        ],
    ]
);

foreach ($invoices as $invoice) {
    echo $invoice['inv_total'], PHP_EOL;
}
```

## Table Prefixes

If you want all your tables to have certain prefix and without setting the source in all models, you can use the [Phalcon\Mvc\Model\Manager](api/phalcon_mvc#mvc-model-manager) and the method `setModelPrefix()`:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model;

class Invoices extends Model
{

}

$manager = new Manager();

$manager->setModelPrefix('co_');

$invoices = new Invoices(null, null, $manager);

echo $invoices->getSource(); // will return co_invoices
```

## Identity Columns

Some models may have identity columns. These columns usually are the primary key of the mapped table. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) can recognize the identity column omitting it in the generated `INSERT` SQL statements, to allow the database system to correctly generate a new value for that field. After creating a new record, the identity field will always be registered with the value generated in the database system for it:

```php
<?php

$invoice->save();

echo $invoice->inv_id; // 4
```

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) attempts to recognize the identity column from each table. However, depending on the database system, these columns might be serial columns, such as in the case of PostgreSQL or `auto_increment` columns in the case of MySQL.

PostgreSQL uses sequences to generate automatically numeric values for the primary key. Phalcon tries to obtain the generated value from the sequence `table_field_seq`, for example: `co_invoices_id_seq`. If the sequence name is different, you can always use the `getSequenceName()` method method in the model, instructing Phalcon the sequence it needs to use for the primary key:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function getSequenceName()
    {
        return 'invoices_sequence_name';
    }
}
```

## Skipping Columns

Depending on how you implement business rules or model rules in your database, certain fields could very well be ignored in database operations. For instance, if we have a `inv_created_date` in our model, we can instruct the database system to inject the current timestamp on it:

```php
CREATE TABLE co_invoices (
    // ...
    inv_created_at datetime DEFAULT CURRENT_TIMESTAMP
)
```

The code above (for MySQL) instructs the RDBMS to assign the current timestamp on the `inv_created_at` field when the record is created. We can therefore omit this field when creating a record. Similarly we might want to ignore some fields when we are updating records.

To achieve this task we can use the `skipAttributes` (for any operation), `skipAttributesOnCreate` (create) or `skipAttributesOnUpdate` (update)

To tell [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->skipAttributes(
            [
                'inv_total',
                'inv_created_at',
            ]
        );

        $this->skipAttributesOnCreate(
            [
                'inv_created_at',
            ]
        );

        $this->skipAttributesOnUpdate(
            [
                'inv_modified_at',
            ]
        );
    }
}
```

If you want to set default values in your model properties (such as the `inv_created_at`) you can use the [Phalcon\Db\RawValue](api/phalcon_db#db-rawvalue):

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Db\RawValue;

$invoice = new Invoices();
$invoice->inv_id          = 1234;
$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = new RawValue('default');

$invoice->create();
```

We can also take advantage of the `beforeCreate` event in the model to assign the default value there:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Db\RawValue;

class Invoices extends Model
{
    public function beforeCreate()
    {
        $this->inv_created_at = new RawValue('default');
    }
}
```

> **NOTE**: Never use a [Phalcon\Db\RawValue](api/phalcon_db#db-rawvalue) to assign external data (such as user input) or variable data. The value of these fields is ignored when binding parameters to the query. So it could be used for SQL injection attacks.
{: .alert .alert-warning }

## Dynamic Updates

SQL `UPDATE` statements are by default created with every column defined in the model (full all-field SQL update). You can change specific models to make dynamic updates, in this case, just the fields that had changed are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server, especially when the target table has blob/text fields:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

## Column Mapping

The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database. This is a great feature when one needs to rename fields in the database without having to worry about all the queries in the code.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_id;
    public $inv_cst_id;
    public $inv_status_flag;
    public $inv_title;
    public $inv_total;
    public $inv_created_at;

    public function columnMap()
    {
        return [
            'inv_id'          => 'id',
            'inv_cst_id'      => 'customerId',
            'inv_status_flag' => 'status',
            'inv_title'       => 'title',
            'inv_total'       => 'total',
            'inv_created_at'  => 'createdAt',
        ];
    }
}
```

> **NOTE**: In the array defined in the column map, the keys are the actual names of the fields in the database, and the values are the *virtual* fields we can use in your code
{: .alert .alert-info }

Now we can use those *virtual* fields (or column map) in your code:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :id:',
        'bind'       => [
            'id' => 4,
        ]
    ]
);

echo $invoice->customerId, PHP_EOL,
     $invoice->total, PHP_EOL,
     $invoice->createdAt, PHP_EOL;

$invoices = Invoices::find(
    [
        'order' => 'createdAt DESC',
    ]
);

foreach ($invoices as $invoice) {
    echo $invoice->customerId, PHP_EOL,
         $invoice->total, PHP_EOL,
         $invoice->createdAt, PHP_EOL;
}

$invoice = new Invoices();

$invoice->customerId = 1;
$invoice->status     = 1;
$invoice->title      = 'Invoice for ACME Inc.';
$invoice->total      = 100;
$invoice->createdAt  = '2019-12-25 01:02:03';

$invoice->save();
```

**Considerations**

Consider the following when renaming your columns:

- References to attributes in relationships/validators **must use the virtual names**
- Hacer referencia a nombres de columna reales resultará en una excepción por el ORM

The independent column map allows you to:

- Escribir aplicaciones que utilizan sus propios convenciones
- Eliminar prefijos/sufijos del proveedor en tu código
- Change column names without changes your application code

## Record Snapshots

Specific models could be set to maintain a record snapshot when they are queried. You can use this feature to implement auditing or just to know what fields have been changed in the model compared to the data in the database.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

When activating this feature, the application consumes a bit more of memory, to keep track of the original values obtained from the database. In models that have this feature activated, you can check what fields changed as follows:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();

$invoice->inv_total = 120;

var_dump($invoice->getChangedFields()); // ['inv_total']

var_dump($invoice->hasChanged('inv_total')); // true

var_dump($invoice->hasChanged('inv_cst_id')); // false
```

Snapshots are updated on model creation/update. Using `hasUpdated()` and `getUpdatedFields()` can be used to check if fields were updated after a create/save/update but it could potentially cause problems to your application if you execute `getChangedFields()` in `afterUpdate()`, `afterSave()` or `afterCreate()`.

You can disable this functionality by using:

```php
<?php

Phalcon\Mvc\Model::setup(
    [
        'updateSnapshotOnSave' => false,
    ]
);
```

or if you prefer set this in your `php.ini`

```ini
phalcon.orm.update_snapshot_on_save = 0
```

Using this functionality will have the following effect:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_id;
    public $inv_cst_id;
    public $inv_status_flag;
    public $inv_title;
    public $inv_total;
    public $inv_created_at;

    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}

$invoice = new Invoices();

$invoice->inv_id          = 1234;
$invoice->inv_cst_id      = 1;
$invoice->inv_status_flag = 1;
$invoice->inv_title       = 'Invoice for ACME Inc.';
$invoice->inv_total       = 100;
$invoice->inv_created_at  = '2019-12-25 01:02:03';

$invoice->create();

var_dump(
    $invoice->getChangedFields() // []
);

$invoice->inv_total = 120;

var_dump(
    $invoice->getChangedFields() // ['inv_total']
);

$invoice->update();

var_dump(
    $invoice->getChangedFields() // []
);
```

`getUpdatedFields()` will properly return updated fields or as mentioned above you can go back to the previous behavior by setting the relevant ini value.

## Eventos

As mentioned before [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) acts as a listener to events. Therefore, all the events that the model is listening to can be implemented as methods in the model itself. You can check the <events> document for additional information.

The events supported are:

- `afterCreate`
- `afterDelete`
- `afterFetch`
- `afterSave`
- `afterUpdate`
- `afterValidation`
- `afterValidationOnCreate`
- `afterValidationOnUpdate`
- `beforeDelete`
- `beforeCreate`
- `beforeSave`
- `beforeUpdate`
- `beforeValidation`
- `beforeValidationOnCreate`
- `beforeValidationOnUpdate`
- `notDeleted`
- `notSaved`
- `onValidationFails`
- `prepareSave`
- `validation`

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message as Message;

class Invoices extends Model
{
    public function beforeSave()
    {
        if (0 === $this->inv_status_flag) {
            $message = new Message(
                'Sorry, an invoice cannot be unpaid'
            );

            $this->appendMessage($message);
        }
    }
}
```

## Transacciones

[Transactions](db-models-transactions) are necessary to ensure data integrity, when we need to insert or update data in more than one table during the same operation. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) exposes the `setTransaction` method that allows you to bind each model to an active transaction.

```php
<?php

use MyApp\Models\Customers;
use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Mvc\Model\Transaction\Failed;

try {
    $txManager   = new Manager();
    $transaction = $txManager->get();

    $customer = new Customers();
    $customer->setTransaction($transaction);
    $customer->cst_name_last  = 'Vader';
    $customer->cst_name_first = 'Darth';

    if (false === $customer->save()) {
        $transaction->rollback('Cannot save Customer');
    }

    $invoice = new Invoices();
    $invoice->setTransaction($transaction);

    $invoice->inv_cst_id      = $customer->cst_id;
    $invoice->inv_status_flag = 1;
    $invoice->inv_title       = 'Invoice for ACME Inc.';
    $invoice->inv_total       = 100;
    $invoice->inv_created_at  = '2019-12-25 01:02:03';

    if (false === $invoice->save()) {
        $transaction->rollback('Cannot save record');
    }

    $transaction->commit();
} catch (Failed $ex) {
    echo 'ERROR: ', $ex->getMessage();
}
```

You can also include *finder* results in your transactions or even have multiple transactions running at the same time:

```php
<?php

use MyApp\Models\Customers;
use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\Transaction\Manager;
use Phalcon\Mvc\Model\Transaction\Failed;

try {
    $txManager   = new Manager();
    $transaction = $txManager->get();

    $customer = new Customers();
    $customer->setTransaction($transaction);
    $customer->cst_name_last  = 'Vader';
    $customer->cst_name_first = 'Darth';

    if (false === $customer->save()) {
        $transaction->rollback('Cannot save Customer');
    }

    $average = Invoices::average(
        [
            Model::TRANSACTION_INDEX => $transaction,
            'column'     => 'inv_total',
            'conditions' => 'inv_cst_id = :customerId:',
            'bind'       => [
                'customerId' => 3,
            ],
        ]
    );

    $invoice = new Invoices();
    $invoice->setTransaction($transaction);

    $invoice->inv_cst_id      = $customer->cst_id;
    $invoice->inv_status_flag = 1;
    $invoice->inv_title       = 'Invoice for ACME Inc.';
    $invoice->inv_total       = 100 + $average;
    $invoice->inv_created_at  = '2019-12-25 01:02:03';

    if (false === $invoice->save()) {
        $transaction->rollback('Cannot save record');
    }

    $transaction->commit();
} catch (Failed $ex) {
    echo 'ERROR: ', $ex->getMessage();
}
```

## Changing Schema

If a model is mapped to a table that is located in a different schema than the default, you can use the `setSchema()` to point to the correct location:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->setSchema('invoices');
    }
}
```

## Multiple Databases

Phalcon models by default connect to the same database connection (`db` service) that has been defined in the dependency injection container. However, you might need to connect specific models to different connections, which could be connections to different databases.

We can define which model connects to which database in the `initialize` method of each model:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Adapter\Pdo\PostgreSQL;

$container = new FactoryDefault();

// MySQL
$container->set(
    'dbMysql',
    function () {
        return new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    },
    true
);

// PostgreSQL
$container->set(
    'dbPostgres',
    function () {
        return new PostgreSQL(
            [
                'host'     => 'localhost',
                'username' => 'postgres',
                'password' => '',
                'dbname'   => 'tutorial',
            ]
        );
    }
);
```

and in the `initialize()` method:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->setConnectionService('dbPostgres');
    }
}
```

Additional flexibility is available regarding database connections. You can specify a different connection for `read` operations and a different one for `write` operations. This is particularly useful when you have memory databases that can be used for read operations and different, more powerful databases that are used for `write` operations.

You can set two different connections and utilize each database in each model transparently

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Adapter\Pdo\PostgreSQL;

$container = new FactoryDefault();

// MySQL - read
$container->set(
    'mysqlRead',
    function () {
        return new Mysql(
            [
                'host'     => '10.0.4.100',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    },
    true
);

// MySQL - write
$container->set(
    'mysqlWrite',
    function () {
        return new Mysql(
            [
                'host'     => '10.0.4.200',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'tutorial',
            ]
        );
    },
    true
);
```

and in the `initialize()` method:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->setReadConnectionService('mysqlRead');

        $this->setWriteConnectionService('mysqlWrite');
    }
}
```

The ORM also provides Horizontal Sharding features, by allowing you to implement a `shard` selection according to the query conditions:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    /**
     * Dynamically selects a shard
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     *
     * @return Phalcon\Db\Adapter\AdapterInterface
     */
    public function selectReadConnection(
        $intermediate, 
        $bindParams, 
        $bindTypes
    ) {
        if (true === isset($intermediate['where'])) {
            $conditions = $intermediate['where'];

            if ($conditions['left']['name'] === 'id') {
                $id = $conditions['right']['value'];

                if ($id > 0 && $id < 10000) {
                    return $this->getDI()->get('dbShard1');
                }

                if ($id > 10000) {
                    return $this->getDI()->get('dbShard2');
                }
            }
        }

        return $this->getDI()->get('dbShard0');
    }
}
```

In the above example, we are checking the `$intermediate` array, which is an array constructed internally in Phalcon, offering the intermediate representation of the query. We check if we have any `where` conditions. If not, we just use the default shard `dbShard0`.

If conditions have been defined, we are checking if we have the `id` as a field in the conditions, and retrieve its value. If the `id` is between `0` and `100000` then we use `dbShard1`, alternatively `dbShard2`.

The `selectReadConnection()` method is called every time we need to get data from the database, and returns the correct connection to be used.

## Inyección de Dependencias

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) is tightly bound to the DI container. You can retrieve the container by using the `getDI` method. Therefore you have access to all services registered in the DI container.

The following example shows you how you can print any messages generated by an unsuccessful `save` operation in the model, and show these messages in the <flash> messenger. To do this, we use the `notSaved` event:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function notSaved()
    {
        $flash    = $this->getDI()->getFlash();
        $messages = $this->getMessages();

        // Show validation messages
        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

## Model Features

The ORM has several options that control specific behaviors globally. You can enable or disable these features by adding specific lines to your `php.ini` file or use the `setup` static method on the model. You can enable or disable these features temporarily in your code or permanently.

    phalcon.orm.column_renaming = false
    phalcon.orm.events          = false
    

or by using the `Model`:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'columnRenaming' => false,
        'events'         => false,
    ]
);
```

The available options are:

| Opción                          | Predeterminado | Descripción                                                              |
| ------------------------------- |:--------------:| ------------------------------------------------------------------------ |
| `astCache`                      |     `null`     | Cache level for the AST (intermediate cache)                             |
| `cacheLevel`                    |      `3`       | Cache level for the ORM                                                  |
| `caseInsensitiveColumnMap`      |    `false`     | Case insensitive column map                                              |
| `castLastInsertIdToInt`         |    `false`     | Casts the `lastInsertId` to an integer                                   |
| `castOnHydrate`                 |    `false`     | Automatic cast to original types on hydration                            |
| `columnRenaming`                |     `true`     | Column renaming                                                          |
| `disableAssignSetters`          |    `false`     | Disable setters                                                          |
| `enableImplicitJoins`           |     `true`     | Enable implicit joins                                                    |
| `events`                        |     `true`     | Callbacks, hooks and event notifications from all the models             |
| `exceptionOnFailedMetaDataSave` |    `false`     | Throw an exception when there is a failed meta-data save                 |
| `exceptionOnFailedSave`         |    `false`     | Throw an exception when there is a failed `save()`                       |
| `ignoreUnknownColumns`          |    `false`     | Ignore unknown columns on the model                                      |
| `lateStateBinding`              |    `false`     | Late state binding of the `Phalcon\Mvc\Model::cloneResultMap()` method |
| `notNullValidations`            |     `true`     | Automatically validate the not `null` columns present                    |
| `phqlLiterals`                  |     `true`     | Literals in the PHQL parser                                              |
| `prefetchRecords`               |      `0`       | The number of records to prefetch when getting data from the ORM         |
| `uniqueCacheId`                 |      `3`       | Unique cache id                                                          |
| `updateSnapshotOnSave`          |     `true`     | Update snapshots on `save()`                                             |
| `virtualForeignKeys`            |     `true`     | Virtual foreign keys                                                     |

`ini` options:

    ; phalcon..orm.ast_cache = null
    ; phalcon..orm.cache_level = 3
    ; phalcon..orm.case_insensitive_column_map = false
    ; phalcon..orm.cast_last_insert_id_to_int = false
    ; phalcon..orm.cast_on_hydrate = false
    ; phalcon..orm.column_renaming = true
    ; phalcon..orm.disable_assign_setters = false
    ; phalcon..orm.enable_implicit_joins = true
    ; phalcon..orm.enable_literals = true
    ; phalcon..orm.events = true
    ; phalcon..orm.exception_on_failed_metadata_save = true
    ; phalcon..orm.exception_on_failed_save = false
    ; phalcon..orm.ignore_unknown_columns = false
    ; phalcon..orm.late_state_binding = false
    ; phalcon..orm.not_null_validations = true
    ; phalcon..orm.resultset_prefetch_records = 0
    ; phalcon..orm.unique_cache_id = 3
    ; phalcon..orm.update_snapshot_on_save = true
    ; phalcon..orm.virtual_foreign_keys = true
    

> **NOTE** `Phalcon\Mvc\Model::assign()` (which is used also when creating/updating/saving model) is always using setters if they exist when have data arguments passed, even when it's required or necessary. This will add some additional overhead to your application. You can change this behavior by adding `phalcon.orm.disable_assign_setters = 1` to your ini file, it will just simply use `$this->property = value`.
{: .alert .alert-warning }

## Stand Alone Component

You can use [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) on its own, performing the necessary setup on your own if you wish. The example below demonstrates how you can achieve that.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Db\Adapter\Pdo\Sqlite;
use Phalcon\Mvc\Model\Metadata\Memory;

$container = new Di();

$container->set(
    'db',
    new Sqlite(
        [
            'dbname' => 'sample.db',
        ]
    )
);

$container->set(
    'modelsManager',
    new Manager()
);

$container->set(
    'modelsMetadata',
    new Memory()
);


class Invoices extends Model
{

}

echo Invoices::count();
```