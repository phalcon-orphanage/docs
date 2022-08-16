---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#models'
title: 'Modelos'
keywords: 'modelos, registro activo'
---

# Modelos
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
The [Phalcon\Mvc\Model][mvc-model] is the `M` in MVC. Es una clase que conecta objetos de negocio y tablas de la base de datos, para crear un modelo de dominio persistente, donde la lógica y los datos se envuelven en uno. Es una implementación del mapeo objeto-relacional (ORM).

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

The [Phalcon\Mvc\Model][mvc-model] is the first ORM written in Zephir/C languages for PHP, giving to developers high performance when interacting with databases while is also easy to use.

> **NOTE**: Models are intended to work with the database on a high layer of abstraction. Si necesita trabajar con bases de datos a un nivel más bajo consulte la documentación del componente [Phalcon\Db](api/Phalcon_Db). 
> 
> {: .alert .alert-warning }

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
> 
> {: .alert .alert-info }


## Constantes

| Constante                |     Valor     |
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
Construye el objeto del modelo. El método acepta un vector de datos que se usan para rellenar el objeto usando internamente `assign`. Opcionalmente puede pasar un contenedor DI y un objeto *Models Manager*. Si no se pasan, se usarán los valores predeterminados.


```php
public function __call(string $method, array $arguments): mixed
```
Gestiona las llamadas a métodos cuando un método no se ha implementado. Throws [Phalcon\Mvc\Model\Exception][mvc-model-exception] if the method doesn't exist

```php
public static function __callStatic(
    string $method, 
    array $arguments
): mixed
```
Gestiona las llamadas a métodos cuando un método estático no se ha implementado. Throws [Phalcon\Mvc\Model\Exception][mvc-model-exception] if the method doesn't exist

```php
public function __get(string $property)
```
Método mágico para obtener registros relacionados usando el alias de la relación como una propiedad

```php
public function __isset(string $property): bool
```
 Método mágico que comprueba si una propiedad es una relación válida

```php
public function __set(string $property, mixed $value)
```
Magic method to assign values to the model

```php
public function addBehavior(
    BehaviorInterface $behavior
): void
```
Configura un comportamiento en un modelo

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
Añade un mensaje personalizado a un proceso de validación

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
Asigna datos al modelo. El parámetro `data` puede ser un vector o una fila de base de datos. `whitelist` es un vector de propiedades del modelo que se actualizará durante el proceso de asignación. Las propiedades omitidas NO se aceptarán aunque estén incluidas en el vector o fila de base de datos; sin embargo si una de ellas se requiere por el modelo, los datos no se guardarán y el modelo producirá un error. `dataColumnMap` es un vector que mapea columnas desde `data` al actual modelo. Esto ayuda cuando quiere mapear la entrada desde un vector como `$_POST` a campos en la base de datos.


Asignar valores a un modelo desde un vector
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

`assign` con una fila de base de datos. - Requiere un Mapa de Columnas
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

Actualiza sólo los campos `inv_status_flag`, `inv_title`, `inv_total`.
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

Por defecto `assign` usará *setters* si existen, puede deshabilitarlo usando `ini_set` para usar directamente las propiedades

```
ini_set('phalcon.orm.disable_assign_setters', true);
```

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
Devuelve el valor medio en una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

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
Asigna valores a un modelo desde un vector devolviendo un nuevo modelo

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
Assign values to a model from an array, returning a new model, using the column map.

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
Returns a hydrated result based on the data and the column map

```php
public static function count(
    mixed $parameters = null
): int
```
Devuelve un recuento de cuantos registros coinciden con las condiciones especificadas

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
Inserta un modelo en la base de datos. Si el registro existe en la base de datos, `create()` lanzará una excepción. Devolverá `true` si todo va bien, `false` en caso contrario.

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
Borra una instancia del modelo. Devuelve `true` en caso de éxito o `false` en caso contrario.

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
Devuelve una representación simple del objeto que se puede usar con `var_dump()`

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
Consulta el conjunto de resultados que coincida con las condiciones especificadas. `find()` es lo suficientemente flexible para aceptar una variedad de parámetros y encontrar los datos requeridos. Puede consultar la sección [Encontrar Registros](#finding-records) para más información.

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
Consulta el primer registro que coincida con las condiciones especificadas. Devolverá un conjunto de resultados o `null` si el registro no se encuentra.

> **NOTE**: `findFirst()` no longer returns `false` if records were not found. 
> 
> {: .alert .alert-warning }

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();
```

```php
public function fireEvent(string $eventName): bool
```
Dispara un evento, llama implícitamente a comportamientos y se notifica a los oyentes del gestor de eventos

```php
public function fireEventCancel(string $eventName): bool
```
Dispara un evento, llama implícitamente a comportamientos y se notifica a los oyentes del gestor de eventos. Este método se detiene si alguna de las funciones de retorno/oyentes devuelve `false`

```php
public function getChangedFields(): array
```
Devuelve una lista de valores cambiados.

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
Devuelve una de las constantes `DIRTY_STATE_*` que indican si el registro existe en la base de datos o no

```php
public function getMessages(
    mixed $filter = null
): MessageInterface[]
```
Devuelve un vector de mensajes de validación

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
> **NOTE**: `save()` no longer accepts parameters to set data. Puede usar `assign` en su lugar. 
> 
> {: .alert .alert-warning }

```php
public function getModelsManager(): ManagerInterface
```
Devuelve el gestor de modelos relacionado con la instancia de la entidad

```php
public function getModelsMetaData(): MetaDataInterface
```
Devuelve el servicio de metadatos del modelo relacionado con la instancia de la entidad

```php
public function getOperationMade(): int
```
Devuelve el tipo de la última operación ejecutada por el ORM. Devuelve una de las constantes de clase `OP_*`

```php
public function getOldSnapshotData(): array
```
Devuelve los datos de instantánea internos antiguos

```php
final public function getReadConnection(): AdapterInterface
```
Obtiene la conexión usada para leer datos del modelo

```php
final public function getReadConnectionService(): string
```
Devuelve el nombre del servicio de conexión de *DependencyInjection* usado para leer datos relacionados con el modelo

```php
public function getRelated(
    string $alias, 
    mixed $arguments = null
): Phalcon\Mvc\Model\Resultset\Simple | null
```
Devuelve registros relacionados basados en relaciones definidas. Si la relación es uno a uno y no se han encontrado registros, devolverá `null`

> **NOTE**: `getRelated()` no longer returns `false` if a record was not found on a one-to-one relationship. 
> 
> {: .alert .alert-warning }

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
Comprueba si los registros relacionados guardados ya se han cargado. Sólo devuelve `true` si los registros se obtuvieron previamente a través del modelo sin ningún parámetro adicional.

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
Devuelve el nombre del esquema donde se encuentra la tabla mapeada

```php
public function getSnapshotData(): array
```
Devuelve los datos de instantánea internos

```php
final public function getSource(): string
```
Devuelve el nombre de tabla mapeado en el modelo

```php
public function getUpdatedFields(): array
```
Devuelve una lista de valores actualizados.

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
Obtiene la conexión usada para escribir datos al modelo

```php
final public function getWriteConnectionService(): string
```
Devuelve el nombre del servicio de conexión de *DependencyInjection* usado para escribir datos relacionados al modelo

```php
public function hasChanged(
    string | array $fieldName = null, 
    bool $allFields = false
): bool
```
Comprueba si un atributo específico ha cambiado. Esto sólo funciona si el modelo mantiene instantáneas de datos

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
Comprueba si el objeto tiene datos de instantánea internos

```php
public function hasUpdated(
    string | array $fieldName = null, 
    bool $allFields = false
): bool
```
Comprueba si un atributo específico se ha actualizado. Esto sólo funciona si el modelo mantiene instantáneas de datos.

```php
public function jsonSerialize(): array
```
Serializa el objeto por json_encode

```php
echo json_encode($invoice);
```

```php
public static function maximum(
    mixed $parameters = null
): mixed
```
Devuelve el valor máximo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

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
Devuelve el valor mínimo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

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
 Crea un criterio para un modelo específico

```php
public function readAttribute(
    string $attribute
): mixed | null
```
Lee un valor de atributo por su nombre

```php
echo $invoice->readAttribute('inv_title');
```

```php
public function refresh(): ModelInterface
```
Refresca los atributos del modelo consultando otra vez el registro desde la base de datos

```php
public function save(): bool
```
Inserta o actualiza una instancia de modelo. Devuelve `true` si todo va bien o `false` en caso contrario.

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
> **NOTE**: `save()` no longer accepts parameters to set data. Puede usar `assign` en su lugar. 
> 
> {: .alert .alert-warning }

```php
public function serialize(): string
```
Serializa el objeto ignorando conexiones, servicios, objetos relacionados o propiedades estáticas

```php
public function unserialize(mixed $data)
```
Deserializa el objeto desde una cadena serializada

```php
final public function setConnectionService(
    string $connectionService
): void
```
Establece el nombre del servicio de conexión *DependencyInjection*

```php
public function setDirtyState(
    int $dirtyState
): ModelInterface | bool
```
Establece el estado de suciedad del objeto usando una de las constantes `DIRTY_STATE_*`

```php
public function setEventsManager(
    EventsManagerInterface $eventsManager
)
```
Establece un gestor de eventos personalizado

```php
final public function setReadConnectionService(
    string $connectionService
): void
```
Establece el nombre de servicio de conexión *DependencyInjection* usado para leer datos

```php
public function setOldSnapshotData(
    array $data, 
    array $columnMap = null
)
```
Establece los datos viejos de instantánea del registro. Este método se usa internamente para establecer datos de instantánea viejos cuando el modelo fue configurado para mantener datos de instantánea

```php
public function setSnapshotData(
    array $data, 
    array $columnMap = null
): void
```
Establece los datos de instantánea del registro. Este método se usa internamente para establecer los datos de instantánea cuando el modelo fue configurado para mantener datos de instantánea

```php
public function setTransaction(
    TransactionInterface $transaction
): ModelInterface
```
Establece una transacción relacionada con la instancia del modelo

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
Habilita / deshabilita opciones en el ORM como eventos, renombrado de columnas, etc.

```php
final public function setWriteConnectionService(
    string $connectionService
): void
```
Establece el nombre de servicio de conexión *DependencyInjection* usado para escribir datos

```php
public function skipOperation(bool $skip): void
```php
Omite la operación actual forzando un estado de éxito

```php
public static function sum(
    array $parameters = null
): float
```
Calcula la suma de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

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
Devuelve la instancia como una representación de vector. Acepta un vector con nombres de columnas para incluir en el resultado

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
Actualiza una instancia de modelo. Si la instancia no existe en la persistencia lanzará una excepción. Devuelve `true` si todo va bien o `false` en caso contrario.

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
Escribe un valor de atributo por su nombre

```php
$invoice->writeAttribute('inv_total', 120);
```

```php
protected function allowEmptyStringValues(
    array $attributes
): void
```
Establece una lista de atributos que se deben omitir de la sentencia `UPDATE` generada

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
Set up a reverse 1-1 or n-1 relation between two models

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
Configura una relación 1-n entre dos modelos

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
Set up an n-n relation between two models, through an intermediate relation

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
Configura una relación 1-1 entre dos modelos

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
Configura si el modelo debe mantener la instantánea del registro original en memoria

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
Establece el nombre del esquema donde se ubica la tabla mapeada

```php
final protected function setSource(
    string $source
): ModelInterface
```
Establece el nombre de tabla al que se debe mapear el modelo

```php
protected function skipAttributes(array $attributes)
```
Establece una lista de atributos que se deben omitir de la sentencia `INSERT`/`UPDATE` generada

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
Establece una lista de atributos que se deben omitir de la sentencia `INSERT` generada

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
Establece una lista de atributos que se deben omitir de la sentencia `UPDATE` generada

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
Establece si el modelo debe usar actualización dinámica en vez de actualizar todos los campos

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
Ejecuta los validadores en cada llamada de validación

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
Comprueba si el proceso de validación ha generado algún mensaje

## Creación de Modelos
A model is a class that extends from [Phalcon\Mvc\Model][mvc-model]. Su nombre de clase debería estar en notación *camel case*:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{

}
```

Por defecto, el modelo `MyApp\Models\Invoices` apuntará a la tabla `invoices`. Si quiere especificar manualmente otro nombre para la tabla mapeada, puede usar el método `setSource()`:

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

El modelo `Invoices` ahora apunta a la tabla `co_invoices`. El método `initialize()` ayuda a configurar este modelo con un comportamiento personalizado, es decir, una tabla diferente.

El método `initialize()` se llama sólo una vez durante la petición. Este método está destinado a realizar inicializaciones que se aplican a todas las instancias del modelo creado dentro de la aplicación. Si quiere realizar tareas de inicialización para cada instancia creada puede usar el método `onConstruct()`:

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

> NOTA: La clase modelo utiliza algunas propiedades internamente para los servicios. Los nombres de estas propiedades están reservados y no se pueden utilizar como campos en la base de datos. Por favor, tenga esto en cuenta al nombrar los campos de sus tablas. Si hay colisiones, sus modelos no se actualizarán correctamente.
> 
> `container`, `dirtyState`, `dirtyRelated`, `errorMessages`, `modelsManager`, `modelsMetaData`, `related`, `operationMade`, `oldSnapshot`, `skipped`, `snapshot`, `transaction`, `uniqueKey`, `uniqueParams`, `uniqueTypes` 
> 
> {: .alert .alert-warning }

Models can be implemented with public properties, meaning that each property can be read and updated from any part of the code that has instantiated that model class:

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

Otra implementación es usar funciones *getter* y *setter*, que controlan qué propiedades están disponibles públicamente para ese modelo.

El beneficio de usar *getters* y *setters* es que el desarrollador puede realizar transformaciones y comprobaciones de validación sobre los valores asignados u obtenidos para el modelo, lo que es imposible cuando se usan las propiedades públicas.

Además, *getters* y *setters* permiten cambios futuros sin cambiar la interfaz de la clase modelo. Así que si un nombre de campo cambia, el único cambio necesario será en la propiedad privada del modelo referenciado en el *getter/em>/*setter* y en ninguna otra parte del código.</p>

```php
<?php

namespace MyApp\Models;

use InvalidArgumentException;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    protected $inv_id;
    protected $inv_cst_id;
    protected $inv_status_flag;
    protected $inv_title;
    protected $inv_total;
    protected $inv_created_at;

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

Las propiedades públicas proporcionan menos complejidad en desarrollo. Sin embargo, *getters*/*setters* pueden incrementar en gran medida la testabilidad, extensión y mantenimiento de las aplicaciones. Necesitará elegir qué estrategia es la mejor para usted dependiendo de las necesidades de la aplicación. El ORM es compatible con ambos esquemas de definición de propiedades.

> **NOTE**: Underscores in property names can be problematic when using getters and setters. 
> 
> {: .alert .alert-warning }

> **NOTE**: When using the getters/setters approach, you will need to define your properties as `protected`. 
> 
> {: .alert .alert-warning }

Si usa guiones bajos en los nombres de sus propiedades, deberá seguir usando *camel case* en sus declaraciones *getter*/*setter* para usar con métodos mágicos. (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.).

El ORM espera nombramiento *camel case* y los guiones bajos son eliminados normalmente. Por lo tanto, se recomienda nombrar sus propiedades en la manera mostrada a lo largo de la documentación. Puede usar un mapa de columnas (como se ha descrito anteriormente) para asegurar un mapeo adecuando de sus propiedades con sus homólogos en la base de datos.

## Registros A Objetos
Cada instancia de un modelo representa una fila en la base de datos. Puede fácilmente acceder a los datos del registro leyendo las propiedades del objeto. Por ejemplo, para una tabla 'co_customers' con los registros:

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

Podría encontrar un registro determinado por su clave primaria y luego imprimir su nombre:

```php
<?php

use MyApp\Models\Customers;

// cst_id = 3
$customer = Customers::findFirst(3);

// 'Leia'
echo $customer->cst_name_first;
```

Una vez que el registro está en memoria, puede hacer modificaciones a sus datos y luego guardar los cambios:

```php
<?php

use MyApp\Models\Customers;

// cst_id = 3
$customer = Customers::findFirst(3);

$customer->cst_name_last = 'Princess';

$customer->save();
```

Como puede ver, no hay necesidad de usar sentencias SQL en bruto. [Phalcon\Mvc\Model][mvc-model] provides high database abstraction for web applications, simplifying database operations.

## Búsqueda de registros
[Phalcon\Mvc\Model][mvc-model] also offers several methods for querying records.

### `find`
The method returns a [Phalcon\Mvc\Model\Resultset][mvc-model-resultset], [Phalcon\Mvc\Model\Resultset\Comples][mvc-model-resultset-complex] or [Phalcon\Mvc\Model\Resultset\Simple][mvc-model-resultset-simple] collection of records even if the result returned is only one record.

 El método acepta una variedad de parámetros para recuperar datos:

```php
<?php

use MyApp\Models\Customers;

$invoice = Invoices::findFirst('inv_id = 3');
```
También puede pasar una cadena con una cláusula `WHERE`. En el ejemplo anterior obtenemos el mismo registro, indicando al ORM que nos dé un registro con `inv_cst_id = 3`

La sintaxis más flexible es pasar un vector con los diferentes parámetros:

```php
<?php

use MyApp\Models\Customers;

$invoice = Invoices::findFirst(
    [
        'inv_id = 3',
    ]
);
```
El primer parámetro del vector (sin clave) se trata de la misma manera que el ejemplo anterior (pasando una cadena). El vector acepta parámetros adicionales que ofrecen opciones adicionales para personalizar la operación de búsqueda.

### `findFirst`
También podría usar el método `findFirst()` para obtener sólo el primer registro que coincida con los criterios dados:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();
```
Llamar a `findFirst` sin ningún parámetro devolverá el primer registro que encuentre el ORM. Normalmente, éste es el primer registro de la tabla.

```php
<?php

use MyApp\Models\Invoices;

// cst_id = 3
$invoice = Invoices::findFirst(3);
```
Pasando un número, consultará al modelo subyacente usando la clave primaria que coincida con el parámetro numérico pasado. Si no hay clave primaria definida o hay una clave compuesta, no obtendrá ningún resultado.

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('inv_id = 3');
```
También puede pasar una cadena con una cláusula `WHERE`. En el ejemplo anterior obtenemos el mismo registro, indicando al ORM que nos dé un registro con `inv_cst_id = 3`

> **NOTE**: If primary key of table is not numeric, use condition. Vea ejemplos a continuación. 
> 
> {: .alert .alert-warning }

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

> **NOTE**: If you do not use bound parameters in your conditions, PHQL will create a new plan internally, therefore consuming more memory. ¡Se recomienda encarecidamente el uso de parámetros vinculados! 
> 
> {: .alert .alert-warning }

```php
<?php


use MyApp\Models\Invoices;

$invoice = Invoices::findFirst('uuid = "5741bfd7-6870-40b7-adf6-cbacb515b9a9"');
```


### Parámetros

> **NOTE**: It is highly recommended to use the array syntax with `conditions` and `bind` to shield yourself from SQL injections, especially when the criteria come from user input. Para más información consulte la sección [Parámetros de Vinculación](#binding-parameters)`. 
> 
> {: .alert .alert-warning }

Ambos métodos `find()` y `findFirst()` aceptan un vector asociativo especificando los criterios de búsqueda.

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

Puede (y debería) usar los elementos del vector `conditions` y `bind` para enlazar los parámetros de enlace a los parámetros de la consulta. El uso de esta implementación asegurará que sus parámetros estén enlazados y además reducirá la posibilidad de inyecciones SQL:

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

Las opciones de consulta disponibles son:

**`bind`**

*Bind* se usa junto con `conditions`, reemplazando los marcadores y escapando los valores incrementando así la seguridad

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

Al vincular parámetros, puede usar esta opción para definir una conversión de tipos adicional para los parámetros vinculados incrementando aún más la seguridad de su consulta.

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

Cachear el conjunto de resultados, reduce el acceso continuo al sistema relacional.

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

Devuelve columnas específicas en el modelo.

> **NOTE**: When using this option an incomplete object is returned, and therefore you cannot call methods such as `update()`, `getRelated()` etc. 
> 
> {: .alert .alert-info }

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

El vector de columnas puede devolver las columnas directamente si sólo se ha establecido un valor para uno de los elementos del vector. However, if you choose to specify a key, it will be used as an alias for that field. En el ejemplo anterior, `cst_name_first` tiene un alias como `first`.

**`conditions`**

Condiciones de búsqueda para la operación de búsqueda. Se usa para extraer solo aquellos registros que cumplen un criterio específico. By default, [Phalcon\Mvc\Model][mvc-model] assumes the first parameter are the conditions.

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

With this option, [Phalcon\Mvc\Model][mvc-model] reads the latest available data, setting exclusive locks on each row it reads

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

Permite recopilar datos a través de múltiples registros y agrupa los resultados por una o más columnas `'group' => 'name, status'`

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

Establece la estrategia de hidratación para representar cada registro devuelto en el resultado

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

Limita los resultados de la consulta a resultados de un rango determinado

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

Desplaza los resultados de la consulta en una cierta cantidad

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

Se usa para ordenar el conjunto de resultados. Usa uno o más campos separados por comas.

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

With this option, [Phalcon\Mvc\Model][mvc-model] reads the latest available data, setting shared locks on each row it reads

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
Si lo prefiere, también se dispone de una manera de crear consultas de una forma orientada a objetos, en vez de usar un vector de parámetros:

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

The static method `query()` returns a [Phalcon\Mvc\Model\Criteria][mvc-model-criteria] object that is friendly with IDE auto complete.

Todas las consultas se manejan internamente como consultas [PHQL](db-phql). PHQL es un lenguaje de alto nivel, orientado a objetos y similar a SQL. Este lenguaje ofrece muchas características para realizar consultas como uniones con otros modelos, agrupación de registros, agregaciones, etc.

### `findBy*`
Puede usar el método `findBy<property-name>()`. Este método expande el método `find()` mencionado antes. It allows you to quickly perform a select query from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column.

Para el siguiente modelo:

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

Tenemos las propiedades `inv_cst_id`, `inv_id`, `inv_status_flag`, `inv_title`, `inv_created_at`. Si queremos encontrar todas las facturas con `inv_total = 100` podemos usar:

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

pero también podemos usar:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::findByInvTotal(100);
```

> **NOTE**: The property names are changed to camel case if they have underscores. `inv_total` becomes `InvTotal` 
> 
> {: .alert .alert-info }

También puede pasar parámetros en un vector como segundo parámetro. Estos parámetros son los mismos que los que se pueden pasar en el método `find`.

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
Finalmente, puede usar el método `findFirstBy<property-name>()`. Este método expande el método `findFirst()` mencionado antes. Le permite realizar rápidamente una selección de registros de una tabla usando el nombre de la propiedad en el propio método y pasándole un parámetro que contiene los datos que quiere buscar para esa columna.

Para el siguiente modelo:

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

Tenemos propiedades `id`, `email`, `name` y `text`. Si queremos encontrar la entrada del libro de invitados para `Darth Vader` podemos:

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

pero también podemos usar:

```php
<?php

use MyApp\Models\Guestbook;

$name  = 'Darth Vader';
$guest = Guestbook::findFirstByName($name);
```

> **NOTE**: Notice that we used `Name` in the method call and passed the variable `$name` to it, which contains the name we are looking for in our table. Tenga en cuenta también que cuando encontramos una coincidencia con nuestra consulta, también tendremos disponibles todas las demás propiedades. 
> 
> {: .alert .alert-info }

### Resultados del modelo
While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a [Phalcon\Mvc\Model\Resultset\Simple][mvc-model-resultset-simple]. Este es un objeto que encapsula toda la funcionalidad que tiene un conjunto de resultados, como buscar, recorrer, contar, etc.

Estos objetos son más poderosos que los vectores estándar. One of the greatest features of the [Phalcon\Mvc\Model\Resultset][mvc-model-resultset] is that at any time there is only one record in memory. Estoy ayuda mucho en la gestión de memoria, especialmente cuando trabajamos con grandes cantidades de datos.

Algunos ejemplos de recorrido de conjuntos de resultados son:

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

Los conjuntos de resultados de Phalcon emulan cursores desplazables. Puede obtener cualquier fila justo al acceder a su posición, o buscando el puntero interno a una posición específica.

> **NOTE**: Some database systems do not support scrollable cursors. Esto obliga a Phalcon a volver a ejecutar la consulta, para poder rebobinar el cursor hasta el principio y obtener el registro de la posición solicitada. Del mismo modo, si un conjunto de resultados se recorre múltiples veces, la consulta se debe ejecutar el mismo número de veces. 
> 
> {: .alert .alert-info }

Almacenar grandes resultados de consulta en memoria consumirá muchos recursos. Sin embargo, puede ordenar a Phalcon que obtenga los datos en trozos de filas, reduciendo así la necesidad de volver a ejecutar la solicitud en muchos casos. Puede conseguir esto estableciendo el valor de configuración de `orm.resultset_prefetch_records`. Esto se puede hacer en `php.ini` o en el `setup()` del modelo. Puede encontrar más información sobre esto en la sección [características](#disablingenabling-features).

Tenga en cuenta que los conjuntos de resultados se pueden serializar y almacenar en un *backend* de caché. [Phalcon\Cache](cache) puede ayudar con esta tarea. However, serializing data causes [Phalcon\Mvc\Model][mvc-model] to retrieve all the data from the database in an array, thus consuming more memory while this process takes place.

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
### Conjuntos de Resultados Personalizados
Hay veces que la lógica de aplicación requiere una manipulación adicional de los datos que se obtienen de la base de datos. Previously, we would just extend the model and encapsulate the functionality in a class in the model or a trait, returning to the caller usually an array of transformed data.

Con conjuntos de resultados personalizados, ya no necesita hacer eso. The custom resultset will encapsulate the functionality, that otherwise would be in the model, and can be reused by other models, thus keeping the code [DRY][dry]. This way, the `find()` method will no longer return the default [Phalcon\Mvc\Model\Resultset][mvc-model-resultset], but instead the custom one. Phalcon le permite hacer esto usando `getResultsetClass()` en su modelo.

Primero necesitamos definir la clase del conjunto de resultados:
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

En el modelo, establecemos la clase en el `getResultsetClass()` como sigue:

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

y finalmente en su código tendrá algo similar a esto:

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

### Filtrado de Resultados
La forma más eficiente de filtrar datos es estableciendo algunos criterios de búsqueda, las bases de datos usarán los índices configurados en las tablas para devolver los datos más rápido. Phalcon además le permite filtrar datos usando PHP:

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

El ejemplo anterior devolverá sólo las facturas pagadas de nuestra tabla (`inv_status_flag = 1`);

### Parámetros de Enlace
Bound parameters are also supported in [Phalcon\Mvc\Model][mvc-model]. You are encouraged to use this methodology to eliminate the possibility of your code being subject to SQL injection attacks. Se soportan tanto marcadores `string` como `integer`.

> **NOTE**: When using `integer` placeholders you must prefix them with `?` (`?0`, `?1`). Cuando usa marcadores `string` debe encerrar la cadena entre `:` (`:name:`, `:total:`). 
> 
> {: .alert .alert-info }

Algunos ejemplos:

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

Strings are automatically escaped using [PDO][pdo-statements]. This function takes into account the connection charset, therefore it is recommended to define the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Additionally, you can set the parameter `bindTypes`, this allows defining how the parameters should be bound according to their data type:

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

> **NOTE**: Since the default bind type is `Phalcon\Db\Column::BIND_PARAM_STR`, there is no need to specify the 'bindTypes' parameter if all the columns are strings 
> 
> {: .alert .alert-info }

También puede enlazar vectores en los parámetros, especialmente cuando usa la palabra clave SQL `IN`.

> **NOTE**: You need to use a zero based array for arrays without missing elements 
> 
> {: .alert .alert-info }

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
> 
> {: .alert .alert-info }

If you're using _finders_ e.g. `find()`, `findFirst()`, etc., you can inject the bound parameters when using the string syntax for the first parameter instead of using the `conditions` array element. Also, when using `findFirstBy*` the parameters are automatically bound.

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

## Antes/Después de Obtener
Hay casos donde necesitamos manipular los datos después de que se hayan devuelto desde la base de datos para que nuestro modelo contenga lo que necesitamos en la capa de aplicación. As seen in the [events](events) document, models act as listeners, so we can implement some events as methods in the model.

Tales métodos incluyen `beforeSave`, `afterSave` y `afterFetch` como se muestra en nuestro ejemplo a continuación. El método `afterFetch` se ejecutará justo después de que los datos rellenen el modelo desde la base de datos. Podemos usar este método para modificar o transformar los datos en el modelo.

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
En el ejemplo anterior, recibimos una cadena separada por coma desde la base de datos y la `separamos` en un vector para poder usarlo desde nuestra aplicación. Después de esto, puede añadir o eliminar elementos en el vector; antes de que el modelo lo guarde, se llamará a `implode` para almacenar el vector como una cadena en la base de datos.

Si usa *getters*/*setters* en vez de/o además de propiedades públicas, puede inicializar el campo una vez que se accede:

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

## Cálculos
Los cálculos (o agregaciones) son ayudantes para funciones usadas normalmente en sistemas de bases de datos como `COUNT`, `SUM`, `MAX`, `MIN` o `AVG`. [Phalcon\Mvc\Model][mvc-model] allows to use these functions directly from the exposed methods.

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

También podemos usar el parámetro `group` para agrupar nuestros resultados. Los resultados del recuento aparecen en la propiedad `rowcount` de cada objeto en la colección devuelta.

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
También puede agrupar resultados. Los resultados del recuento aparecen en la propiedad `sumatory` de cada objeto en la colección devuelta.

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

## Crear - Actualizar
El método `Phalcon\Mvc\Model::save()` le permite crear/actualizar registros según si ya existen en la tabla asociada al modelo. The save method is called internally by the create and update methods of [Phalcon\Mvc\Model][mvc-model]. Para que esto funcione según lo esperado es necesario tener definida correctamente una clave primaria en la entidad que determine si un registro debería ser creado o actualizado.

El método también ejecuta las validaciones asociadas, las claves ajenas virtuales y los eventos que estén definidos en el modelo:

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

También puede usar el método `assign()` y pasar un vector de elementos `field => value`, para evitar asignar cada columna manualmente. [Phalcon\Mvc\Model][mvc-model] will check if there are setters implemented for the columns passed in the array, giving priority to them, instead of assign directly the values of the attributes:

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

Values assigned directly, or via the array of attributes, are escaped/sanitized according to the related attribute data type. Así que puede pasar un vector inseguro sin preocuparse de posibles inyecciones SQL:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();

$invoice->assign($_POST);

$result = $invoice->save();
```

> **NOTE**: Without precautions mass assignment could allow attackers to set any database column's value. Utilice esta característica sólo si quiere permitir al usuario insertar/actualizar cada columna en el modelo, incluso si esos campos no se han enviado en el formulario. 
> 
> {: .alert .alert-danger }

You can set an additional parameter in `assign` to set a whitelist of fields that are only taken into account when doing the mass assignment:

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

> **NOTE**: On really busy applications, you can use `create` or `update` for the respective operations. Usando estos dos métodos en vez de `save`, nos aseguramos de que los datos serán guardados o no en la base de datos, ya que estos lanzarán excepciones en `create` si el registro ya existe, y en `update` si el registro no existe. 
> 
> {: .alert .alert-info }

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

Los métodos `create` y `update` también aceptan un vector de valores como parámetro.

## Eliminar
El método `delete()` le permite eliminar un registro. Devuelve un booleano que significa éxito o fallo

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

También puede eliminar muchos registros recorriendo un conjunto de resultados con un `foreach`:

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
> 
> {: .alert .alert-info }

## Modos de Hidratación
Como se ha mencionado anteriormente, los conjuntos de resultados son colecciones de objetos completos. Esto significa que cada resultado devuelto es un objeto, que representa una fila en la base de datos. Estos documentos se pueden modificar y más tarde guardados para persistir los cambios en la base de datos.

Sin embargo, hay veces que necesitará obtener los datos en modo solo lectura, como en casos en los que solo visualiza datos. En estos casos, es útil cambiar la forma en que se devuelven los registros para ahorrar recursos y aumentar el rendimiento. The strategy used to represent these objects returned in a resultset is called `hydration`.

Phalcon offers three ways of hydrating data:
- Arrays : `Phalcon\Mvc\Model\Resultset::HYDRATE_ARRAYS`
- Objects : `Phalcon\Mvc\Model\Resultset::HYDRATE_OBJECTS`
- Records : `Phalcon\Mvc\Model\Resultset::HYDRATE_RECORDS`

El modo de hidratación por defecto es devolver registros (`HYDRATE_RECORDS`). Podemos cambiar fácilmente el modo de hidratación para obtener vectores u objetos. Changing the hydration mode to anything other than `HYDRATE_RECORDS` will return objects (or arrays) that have no connection to the database i.e. we will not be able to perform any operations on those objects such as `save()`, `create()`, `delete()` etc.

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

El modo de hidratación también se puede pasar como parámetro de `find`, `findFirst`, `findFirstBy*` etc.:

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

## Prefijos de Tablas
If you want all your tables to have certain prefix and without setting the source in all models, you can use the [Phalcon\Mvc\Model\Manager][mvc-model-manager] and the method `setModelPrefix()`:

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

## Columnas de Identidad
Algunos modelos pueden tener columnas de identidad. Estas columnas normalmente son clave primaria de la tabla mapeada. [Phalcon\Mvc\Model][mvc-model] can recognize the identity column omitting it in the generated `INSERT` SQL statements, to allow the database system to correctly generate a new value for that field. Después de crear un nuevo registro, el campo identidad siempre se registrará con el valor que le ha generado el sistema de base de datos:

```php
<?php

$invoice->save();

echo $invoice->inv_id; // 4
```

[Phalcon\Mvc\Model][mvc-model] attempts to recognize the identity column from each table. Sin embargo, dependiendo del sistema de base de datos, estas columnas podrían ser columnas de serie, como en el caso de PostgreSQL o columnas `auto_increment` en el caso de MySQL.

PostgreSQL usa secuencias para generar automáticamente valores numéricos para la clave primaria. Phalcon intenta obtener el valor generado de la secuencia `table_field_seq`, por ejemplo: `co_invoices_id_seq`. If the sequence name is different, you can always use the `getSequenceName()` method in the model, instructing Phalcon the sequence it needs to use for the primary key:

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

## Omitir Columnas
Dependiendo de como implemente las reglas de negocio o reglas de modelo en su base de datos, ciertos campos podrían ignorarse perfectamente en las operaciones de la base de datos. Por ejemplo, si tenemos `inv_created_date` en nuestro modelo, podemos indicar al sistema de base de datos que inyecte la marca de tiempo actual en él:

```php
CREATE TABLE co_invoices (
    // ...
    inv_created_at datetime DEFAULT CURRENT_TIMESTAMP
)
```

El código anterior (para MySQL) indica al RDBMS que asigne la marca de tiempo actual al campo `inv_created_at` cuando se crea el registro. Por lo tanto, podemos omitir este campo cuando creamos un registro. Similarly, we might want to ignore some fields when we are updating records.

Para lograr esta tarea podemos usar `skipAttributes` (para cualquier operación), `skipAttributesOnCreate` (crear) o `skipAttributesOnUpdate` (actualizar)

To tell [Phalcon\Mvc\Model][mvc-model] that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

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

If you want to set default values in your model properties (such as the `inv_created_at`) you can use the [Phalcon\Db\RawValue][db-rawvalue]:

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

También podemos aprovechar el evento `beforeCreate` en el modelo para asignar el valor por defecto ahí:

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

> **NOTE**: Never use a [Phalcon\Db\RawValue][db-rawvalue] to assign external data (such as user input) or variable data. El valor de estos campos se ignora cuando se enlazan los parámetros a la consulta. Así que se podrían usar para inyecciones SQL. 
> 
> {: .alert .alert-warning }

## Actualización Dinámica
Las sentencias SQL `UPDATE` se crean por defecto con cada columna definida en el modelo (actualización SQL completa de todos los campos). Puede cambiar modelos específicos para hacer actualizaciones dinámicas, en este caso, sólo se usarán los campos que han cambiado para crear la sentencia SQL final.

En algunos casos esto podría mejorar el rendimiento al reducir el tráfico entre la aplicación y el servidor de base de datos, especialmente cuando la tabla destino tiene campos blob/text:

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

## Mapeado de Columnas
El ORM soporta un mapa de columnas independiente, que permite al desarrollador usar en el modelo nombres de columna diferentes a los de la tabla. Phalcon reconocerá los nuevos nombres de columna y los renombrará apropiadamente para que coincidan con las columnas respectivas en la base de datos. Esta es una gran característica cuando se necesita renombrar campos en la base de datos sin tener que preocuparse por todas las consultas del código.

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

> **NOTE**: In the array defined in the column map, the keys are the actual names of the fields in the database, and the values are the _virtual_ fields we can use in your code 
> 
> {: .alert .alert-info }

Now we can use those _virtual_ fields (or column map) in your code:

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

**Consideraciones**

Considere lo siguiente cuando renombre sus columnas:

* References to attributes in relationships/validators **must use the virtual names**
* Hacer referencia a nombres de columna reales resultará en una excepción por el ORM

El mapa de columnas independientes le permite:

* Escribir aplicaciones que utilizan sus propias convenciones
* Eliminar prefijos/sufijos del proveedor en su código
* Cambiar los nombres de las columnas sin cambiar el código de su aplicación

## Instantáneas de Registros
Se podrían configurar modelos específicos para mantener una instantánea de registro cuando se consultan. Puede usar esta característica para implementar auditorías o sólo saber qué campos se han cambiado en el modelo comparando con los datos de la base de datos.

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

Cuando activamos esta característica, la aplicación consume un poco más de memoria, para mantener un seguimiento de los valores originales obtenidos desde la base de datos. En los modelos que tienen esta característica activada, puede comprobar qué campos han cambiado de la siguiente manera:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst();

$invoice->inv_total = 120;

var_dump($invoice->getChangedFields()); // ['inv_total']

var_dump($invoice->hasChanged('inv_total')); // true

var_dump($invoice->hasChanged('inv_cst_id')); // false
```

Las instantáneas se actualizan en la creación/actualización del modelo. Using `hasUpdated()` and `getUpdatedFields()` can be used to check if fields were updated after a create/save/update, but it could potentially cause problems to your application if you execute `getChangedFields()` in `afterUpdate()`, `afterSave()` or `afterCreate()`.

Puede deshabilitar esta funcionalidad usando:

```php
<?php

Phalcon\Mvc\Model::setup(
    [
        'updateSnapshotOnSave' => false,
    ]
);
```
o si prefiere configurarlo en su `php.ini`

```ini
phalcon.orm.update_snapshot_on_save = 0
```

Usar esta funcionalidad tendrá los siguientes efectos:

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

`getUpdatedFields()` devolverá apropiadamente los campos actualizados o, como se ha mencionado anteriormente, puede volver al comportamiento anterior configurando el valor ini relevante.

## Eventos
As mentioned before [Phalcon\Mvc\Model][mvc-model] acts as a listener to events. Por lo tanto, todos los eventos que está escuchando el modelo se pueden implementar como métodos del propio modelo. Puede consultar el documento [eventos](events) para obtener información adicional.

Los eventos soportados son:

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
Las [transacciones](db-models-transactions) son necesarias para asegurar la integridad de los datos, cuando necesitamos insertar o actualizar datos en más de una tabla durante la misma operación. [Phalcon\Mvc\Model][mvc-model] exposes the `setTransaction` method that allows you to bind each model to an active transaction.


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

You can also include _finder_ results in your transactions or even have multiple transactions running at the same time:


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

## Cambiar Esquema
Si un modelo se mapeado a una tabla que está ubicada en un esquema diferente al predeterminado, puede usar `setSchema()` para apuntar a la ubicación correcta:

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

## Múltiples Bases de Datos
Los modelos de Phalcon por defecto conectan a la misma conexión de base de datos (servicio `db`) que se ha definido en el contenedor de inyección de dependencias. Sin embargo, podría necesitar conectar modelos específicos a distintas conexiones, que podrían ser conexiones a bases de datos distintas.

Podemos definir qué modelo conecta a qué base de datos en el método `initialize` de cada modelo:

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

y en el método `initialize()`:

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

Existe una flexibilidad adicional con respecto a las conexiones a bases de datos. Puede especificar una conexión para operaciones de `lectura` y otra diferente para operaciones de `escritura`. Esto es particularmente útil cuando tiene bases de datos de memoria que se pueden usar para operaciones de lectura y diferentes, más potentes bases de datos utilizadas para operaciones de `escritura`.

Puede configurar dos conexiones diferentes y utilizar cada base de datos en cada modelo de forma transparente

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

y en el método `initialize()`:

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

El ORM también proporciona características de Fragmentación Horizontal, que le permite implementar una selección `fragmentada` de acuerdo a las condiciones de consulta:

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

En el ejemplo anterior, estamos comprobando el vector `$intermediate`, que es un vector construido internamente en Phalcon, que ofrece la representación intermedia de la consulta. Comprobamos si tenemos alguna condición `where`. Si no, solo usamos el fragmento predeterminado `dbShard0`.

Si se han definido condiciones, comprobamos si tenemos el `id` como campo en las condiciones, y recuperamos su valor. Si el `id` está entre `0` y `100000` entonces usamos `dbShard1`, sino `dbShard2`.

El método `selectReadConnection()` se llama cada vez que necesitamos obtener datos desde la base de datos, y devuelve la conexión correcta a usar.

## Inyección de Dependencias
[Phalcon\Mvc\Model][mvc-model] is tightly bound to the DI container. Puede recuperar el contenedor usando el método `getDI`. Therefore, you have access to all services registered in the DI container.

El siguiente ejemplo muestra como puede imprimir cualquier mensaje generado por una operación `save` fallida en el modelo, y mostrar estos mensajes en el mensajero [flash](flash). Para hacer esto, usamos el evento `notSaved`:


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

        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

## Características de Modelo
El ORM tiene varias opciones que controlan comportamientos específicos globalmente. Puede habilitar o deshabilitar estas características añadiendo líneas específicas en su fichero `php.ini` o usar el método estático `setup` en el modelo. Puede habilitar o deshabilitar estas características temporalmente en su código o permanentemente.

```
phalcon.orm.column_renaming = false
phalcon.orm.events          = false
```

o usando el `Modelo`:

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

Las opciones disponibles son:

| Opción                          | Predeterminado | Descripción                                                                      |
| ------------------------------- |:--------------:| -------------------------------------------------------------------------------- |
| `caseInsensitiveColumnMap`      |    `false`     | Mapa de columnas insensitivo a mayúsculas/minúsculas                             |
| `castLastInsertIdToInt`         |    `false`     | Convierte `lastInsertId` a entero                                                |
| `castOnHydrate`                 |    `false`     | Convierte automáticamente a tipos originales en la hidratación                   |
| `columnRenaming`                |     `true`     | Renombrado de columnas                                                           |
| `disableAssignSetters`          |    `false`     | Deshabilita *setters*                                                            |
| `enableImplicitJoins`           |     `true`     | Habilita *joins* implícitos                                                      |
| `events`                        |     `true`     | Llamadas de retorno, *hooks* y notificaciones de eventos desde todos los modelos |
| `exceptionOnFailedMetaDataSave` |    `false`     | Lanza una excepción cuando hay un error al guardar metadatos                     |
| `exceptionOnFailedSave`         |    `false`     | Lanza una excepción cuando falla `save()`                                        |
| `forceCasting`                  |    `false`     | Forzar los parámetros enlazados a sus tipos nativos                              |
| `ignoreUnknownColumns`          |    `false`     | Ignora columnas desconocidas en el modelo                                        |
| `lateStateBinding`              |    `false`     | Enlace de estado tardío del método`Phalcon\Mvc\Model::cloneResultMap()`        |
| `notNullValidations`            |     `true`     | Valida automáticamente las columnas no `null` presentes                          |
| `phqlLiterals`                  |     `true`     | Literales en el analizador PHQL                                                  |
| `prefetchRecords`               |      `0`       | El número de registros a precargar cuando se obtienen datos desde el ORM         |
| `updateSnapshotOnSave`          |     `true`     | Actualizar instantáneas en `save()`                                              |
| `virtualForeignKeys`            |     `true`     | Claves ajenas virtuales                                                          |

Opciones `ini`:

```
; phalcon.orm.ast_cache = null
; phalcon.orm.cache_level = 3
; phalcon.orm.case_insensitive_column_map = false
; phalcon.orm.cast_last_insert_id_to_int = false
; phalcon.orm.cast_on_hydrate = false
; phalcon.orm.column_renaming = true
; phalcon.orm.disable_assign_setters = false
; phalcon.orm.enable_implicit_joins = true
; phalcon.orm.enable_literals = true
; phalcon.orm.events = true
; phalcon.orm.exception_on_failed_metadata_save = true
; phalcon.orm.exception_on_failed_save = false
; phalcon.orm.force_casting = false
; phalcon.orm.ignore_unknown_columns = false
; phalcon.orm.late_state_binding = false
; phalcon.orm.not_null_validations = true
; phalcon.orm.parser_cache = null,
; phalcon.orm.resultset_prefetch_records = 0
; phalcon.orm.unique_cache_id = 3
; phalcon.orm.update_snapshot_on_save = true
; phalcon.orm.virtual_foreign_keys = true
```

> **NOTE** `Phalcon\Mvc\Model::assign()` (which is used also when creating/updating/saving model) is always using setters if they exist when have data arguments passed, even when it's required or necessary. Esto añadirá una sobrecarga adicional a su aplicación. Puede cambiar este comportamiento añadiendo `phalcon.orm.disable_assign_setters = 1` a su fichero ini, con esto se usará simplemente `$this->property = value`. 
> 
> {: .alert .alert-warning }

## Stand-Alone Component
You can use [Phalcon\Mvc\Model][mvc-model] on its own, performing the necessary setup on your own if you wish. El ejemplo siguiente demuestra como puede conseguirlo.

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

[db-rawvalue]: api/phalcon_db#db-rawvalue
[dry]: https://en.wikipedia.org/wiki/Don%27t_repeat_yourself
[mvc-model]: api/phalcon_mvc#mvc-model
[mvc-model-criteria]: api/phalcon_mvc#mvc-model-criteria
[mvc-model-exception]: api/phalcon_mvc#mvc-model-exception
[mvc-model-manager]: api/phalcon_mvc#mvc-model-manager
[mvc-model-resultset]: api/phalcon_mvc#mvc-model-resultset
[mvc-model-resultset-complex]: api/phalcon_mvc#mvc-model-resultset-complex
[mvc-model-resultset-simple]: api/phalcon_mvc#mvc-model-resultset-simple
[pdo-statements]: https://php.net/manual/en/pdo.prepared-statements.php
