---
layout: default
language: 'es-es'
version: '4.0'
---

# Relaciones de modelos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

La [normalización de base de datos](db-normalization) es un proceso donde los datos se dividen en diferentes tablas y se crean enlaces entre esas tablas, para incrementar la flexibilidad, reducir la redundancia de datos y mejorar la integridad de los datos. Las relaciones se definen en el método `initialize` de cada modelo.

Están disponibles los siguientes tipos de relaciones: - uno a uno

    hasOne(
        string|array $fields, 
        string $referenceModel, 
        string|array $referencedFields, 
        array $options = null
    )
    
    hasOneThrough(
        string|array $fields, 
        string $intermediateModel, 
        string|array $intermediateFields, 
        string|array $intermediateReferencedFields,
        string $referenceModel, 
        string|array $referencedFields, 
        array $options = null
    )
    

- uno a muchos

    hasMany(
        string|array $fields, 
        string $referenceModel, 
        string|array $referencedFields, 
        array options = null
    )
    

- muchos a uno

    belongsTo(
        string|array $fields, 
        string $referenceModel, 
        string|array $referencedFields, 
        array options = null
    )
    

- muchos a muchos

    hasManyToMany(
        string|array $fields, 
        string $intermediateModel, 
        string|array $intermediateFields, 
        string|array $intermediateReferencedFields,
        string $referenceModel, 
        string|array $referencedFields, 
        array $options = null
    )
    

Las relaciones pueden ser unidireccionales o bidireccionales, y cada una puede ser simple (un modelo uno a uno) o más compleja (una combinación de modelos). El gestor de modelos gestiona restricciones de clave ajena para estas relaciones, la definición de estas ayuda a la integridad referencial así como al acceso fácil y rápido de registros relacionados al modelo. A través de la implementación de relaciones, es fácil acceder a datos en modelos relacionados desde el modelo fuente de una forma fácil y uniforme.

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
            'cst_id',
            [
                'alias'    => 'customers',
                'reusable' => true,
            ]
        );
    }
}

```

## Unidireccional

Las relaciones unidireccionales son aquellas que son generadas en relación de uno con otro, pero no viceversa.

## Bidireccional

Las relaciones bidireccionales construyen relaciones en ambos modelos y cada modelo define la relación inversa del otro.

## Configuración

En Phalcon, las relaciones se deben definir en el método `initialize()` de un modelo. Los métodos `belongsTo()`, `hasMany()`, `hasManyToMany()`, `hasOne()` y `hasOneThrough()`, definen la relación entre uno o más campos del modelo actual con los campos de otro modelo. Cada uno de estos métodos requiere 3 parámetros:

- campos locales 
- modelo referenciado 
- campos referenciados

| Método          | Descripción             |
| --------------- | ----------------------- |
| `belongsTo`     | Define una relación n-1 |
| `hasMany`       | Define una relación 1-n |
| `hasManyToMany` | Define una relación n-n |
| `hasOne`        | Define una relación 1-1 |
| `hasOneThrough` | Define una relación 1-1 |

El siguiente esquema muestra 3 tablas cuyas relaciones nos servirán como ejemplo en cuanto a relaciones:

```sql
create table co_invoices
(
    inv_id          int(10) auto_increment  primary key,
    inv_cst_id      int(10)      null,
    inv_status_flag tinyint(1)   null,
    inv_title       varchar(100) null,
    inv_total       float(10, 2) null,
    inv_created_at  datetime     null
);

create table co_invoices_x_products
(
    ixp_inv_id      int(10),
    inv_prd_id      int(10)
);

create table co_products
(
    prd_id          int(10) auto_increment  primary key,
    prd_title       varchar(100) null,
    prd_price       float(10, 2) null
);
```

- El modelo `Invoices` tiene muchos `InvoicesProducts`.
- El modelo `Products` tiene muchos `InvoicesProducts`.
- El modelo `InvoicesProducts` pertenece a ambos modelos `Invoices` y `Products` como una relación muchos-a-uno.
- El modelo `Invoices` tiene una relación muchos-a-muchos con `Products` a través de `InvoicesProducts`.

![](/assets/images/content/models-relationships-erd-1.png)

El modelo con sus relaciones se puede implementar como sigue:

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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'products',
            ]
        );

        $this->hasMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            [
                'reusable' => true,
                'alias'    => 'invoicesProducts'
            ]
        );
    }
}
```

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class InvoicesProducts extends Model
{
    public $ixp_inv_id;
    public $ixp_prd_id;

    public function initialize()
    {
        $this->belongsTo(
            'ixp_inv_id',
            Invoices::class,
            'inv_id',
            [
                'reusable' => true,
                'alias'    => 'invoice'
            ]
        );

        $this->belongsTo(
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'product'
            ]
        );
    }
}
```

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $prd_id;
    public $prd_title;
    public $prd_price;
    public $prd_created_at;

    public function initialize()
    {
        // To the intermediate table
        $this->hasMany(
            'prd_id',
            InvoicesProducts::class,
            'ixp_prd_id'
        );

        // Many to many -> Invoices
        $this->hasManyToMany(
            'prd_id',
            InvoicesProducts::class,
            'ixp_prd_id',
            'ixp_inv_id',
            Invoices::class,
            'inv_id',
            [
                'reusable' => true,
                'alias'    => 'invoices',
            ]
        );
    }
}
```

El primer parámetro indica el campo del modelo local usado en la relación; el segundo indica el nombre del modelo referenciado, y el tercero el nombre del campo en el modelo referenciado. También podría usar vectores para definir múltiples campos en la relación.

Las relaciones muchos a muchos requieren 3 modelos y definir las atributos involucrados en la relación:

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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'products',
            ]
        );
    }
}
```

## Parámetros

Dependiendo de las necesidades de nuestra aplicación podríamos querer almacenar datos en una tabla, que describa distintos comportamientos. Por ejemplo, podríamos querer tener únicamente una tabla llamada `co_customers` que tiene un campo `cst_status_flag` que describe el *estado* del cliente (ej: activo, inactivo, etc.).

Usando las relaciones, puede obtener únicamente aquellos `Customers` relacionados con nuestras `Invoices` que tienen un `cst_status_flag` determinado. Definir esa restricción en la relación le permite dejar que el modelo haga todo el trabajo.

También acepta una clausura, que es evaluada cada vez antes de acceder a registros relacionados. Esto permite que las condiciones se actualicen automáticamente entre las consultas.

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
        $this->hasMany(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'reusable' => true,
                'alias'    => 'customersActive',
                'params'   => [
                    'conditions' => 'cst_status_flag = :status:',
                    'bind'       => [
                        'status' => 1,
                     ]
                ]
            ]
        );

        $container = $this->getDI();

        $this->hasMany(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'reusable' => true,
                'alias'    => 'customersNearby',
                'params'   => function() use ($container) {
                    return [
                        'conditions' => 'cst_location = :location:',
                        'bind'       => [
                            // Location can change between queries
                            'location' => $container->getShared('myLocationService')->myLocation,
                         ]
                    ];
                }
            ]
        );
    }
}
```

## Múltiples Campos

Hay veces, donde las relaciones necesitan ser definidas sobre una combinación de campos y no solo uno. Considere el siguiente ejemplo:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $prd_id;
    public $prd_type_flag;
    public $prd_name;
}
```

and

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $par_id;
    public $par_prd_id;
    public $par_par_id;
    public $par_type_flag;
    public $par_name;
}
```

Arriba tenemos un modelo `Products` que tiene los campos `prd_id`, `prd_type_flag` y `prd_name`. El modelo `Parts` contiene `par_id`, `par_prd_id`, `par_type_flag` y `par_name`. La relación existe basada sobre el id único de producto así como sobre el tipo.

Usando las opciones de relación, vistas anteriormente, vinculando un campo entre los dos modelos no devolverá los resultados que necesitamos. Podemos usar un vector con los campos necesarios para definir la relación.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $prd_id;
    public $prd_type_flag;
    public $prd_name;

    public function initialize()
    {
        $this->hasOne(
            [
                'prd_id', 
                'prd_type_flag'
            ],
            Parts::class,
            [
                'par_prd_id', 
                'par_type_flag'
            ],
            [
                'reusable' => true, // cache
                'alias'    => 'parts',
            ]
        );
    }
}
```

> **NOTA** Los mapeos de campo en la relación son uno a uno, es decir, el primer campo del vector del modelo fuente corresponde con el primer campo del vector destino, etc. El número de campos debe ser idéntico en ambos modelos fuente y destino.
{: .alert .alert-info }

## Acceso

Hay varias formas de acceder a las relaciones de un modelo.

- Métodos mágicos `__get`, `__set`
- Métodos mágicos `get*`
- `getRelated`

### `__get()`

Podemos usar el método mágico para acceder a la relación. Asignar un `alias` a la relación simplifica el acceso a los datos relacionados. El nombre de la propiedad es el mismo que el definido en el `alias`.

```php
<?php

$customer = Customers::findFirst(
    [
        'conditions' => 'cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($customer->invoices as $invoice) {
    echo $invoice->inv_title;
}
```

o para una relación muchos a muchos (ver modelos anteriores):

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($invoice->invoicesProducts as $product) {
    echo $invoice->product->prd_name;
}

foreach ($invoice->products as $product) {
    echo $invoice->prd_name;
}
```

Usar el método mágico `__get` le permite acceder a la relación directamente pero no ofrece funcionalidad adicional como filtrado u ordenación sobre la relación.

### `get*()`

Puede acceder a la misma relación usando un método *getter*, que empieza con *get* y usa el nombre de la relación.

```php
<?php

$customer = Customers::findFirst(
    [
        'conditions' => 'cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($customer->getInvoices() as $invoice) {
    echo $invoice->inv_title;
}
```

o para una relación muchos a muchos (ver modelos anteriores):

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($invoice->getInvoiceProducts() as $product) {
    echo $invoice->product->prd_name;
}

foreach ($invoice->getProducts() as $product) {
    echo $invoice->prd_name;
}
```

Este *getter* mágico también nos permite ejecutar ciertas operaciones cuando se accede a la relación como ordenar la relación:

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

$products = $invoice->getProducts(
    [
        'order' => 'prd_name',
    ]
);
foreach ($products as $product) {
    echo $invoice->prd_name;
}
```

También puede añadir condicionales adicionales en la relación:

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

$products = $invoice->getProducts(
    [
        'prd_created_at = :date:',
        'bind' => [
            'date' => '2019-12-25',
        ],
    ]
);

foreach ($products as $product) {
    echo $invoice->prd_name;
}
```

Para obtener los mismos registros manualmente:

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);


$invoicesProducts = InvoicesProducts::find(
    [
        'conditions' => 'ixp_inv_id = :invoiceId:',
        'bind'       => [
            'invoiceId' => $invoice->inv_id,
        ],
    ]
);

$productIds = [];
foreach ($invoicesProducts as $intermediate) {
    $productIds[] = $intermediate->ixp_prd_id;
}

$products = Products::find(
    [
        'conditions' => 'prd_id IN ({array:productIds})',
        'bind'       => [
            'productIds' => $productIds,,
        ],
    ]
);

foreach ($products as $product) {
    echo $invoice->prd_name;
}
```

El prefijo `get` se usa para los registros relacionados de `find()`/`findFirst()`.

| Tipo             | Método Implícito    | Devuelve                                                                 |
| ---------------- | ------------------- | ------------------------------------------------------------------------ |
| Belongs-To       | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-One          | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-One-Through  | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-Many         | `find`              | Colección de instancias de modelo del modelo referenciado                |
| Has-Many-to-Many | (consulta compleja) | Colección de instancias de modelo del modelo referenciado (`inner join`) |

También puede usar el prefijo `count` para devolver un entero que denota el recuento de registros relacionados:

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

echo $invoice->countProducts();
```

### `getRelated()`

Puede acceder a la misma relación usando `getRelated()` y definir qué relación quiere obtener.

```php
<?php

$customer = Customers::findFirst(
    [
        'conditions' => 'cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($customer->getRelated('invoices') as $invoice) {
    echo $invoice->inv_title;
}
```

o para una relación muchos a muchos (ver modelos anteriores):

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

foreach ($invoice->getRelated('products') as $product) {
    echo $invoice->prd_name;
}
```

El segundo parámetro de `getRelated()` es un vector que ofrece opciones adicionales a configurar, como filtrar u ordenar.

```php
<?php

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ],
    ]
);

$products = $invoice->getRelated(
    'products',
    [
        'prd_created_at = :date:',
        'bind' => [
            'date' => '2019-12-25',
        ],
    ]
);

foreach ($products as $product) {
    echo $invoice->prd_name;
}
```

## Alias

Acceder a una relación se puede conseguir usando el nombre de la tabla remota. Debido a la convención de nombres, esto podría no ser tan fácil y podría prestar a confusión. Como se ha visto anteriormente, puede definir un `alias` a la relación.

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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id'
        );
    }
}
```

Con un alias:

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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'products',
            ]
        );
    }
}
```

Si su estructura de tablas tiene *self joins*, no puede acceder a esas relaciones sin alias porque usa el mismo modelo.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $par_id;
    public $par_prd_id;
    public $par_par_id;
    public $par_type_flag;
    public $par_name;

    public function initialize()
    {
        $this->hasMany(
            'par_id',
            Invoices::class,
            'par_par_id',
            [
                'reusable' => true,
                'alias'    => 'children',
            ]
        );

        $this->belongsTo(
            'par_par_id',
            Invoices::class,
            'par_id',
            [
                'reusable' => true,
                'alias'    => 'parent',
            ]
        );
    }
}
```

En el ejemplo anterior, tenemos `Part` que tiene una relación con uno o más objetos `Part`. Cada `Part` puede consistir de otras partes que lo componen. Como resultado terminamos con una relación *self join*. Para un `Part` de teléfono tenemos los siguientes hijos:

    <?php
    
    $phone = Parts::findFirst(....);
    
    echo $phone->getChildren();
    
    // --- Cover
    // --- Battery
    // --- Charger
    

y cada una de esas partes tiene al teléfono como padre:

    <?php
    $charger = Parts::findFirst(....);
    
    echo $phone->getParent();
    
    // Phone
    

## Caché

Acceder a datos relacionados puede suponer un incremento del número de consultas en su base de datos. Puede reducir esta carga tanto como sea posible, usando la opción `reusable` en su relación. Estableciendo esta opción a `true` indicará a Phalcon que almacene en caché los resultados de la relación la primera vez que se accede, para que las siguientes llamadas a la misma relación puedan usar el conjunto de resultados cacheado y no solicite los datos de nuevo a la base de datos. Este caché está activo durante la misma petición.

> **NOTA**: Se recomienda usar la opción `reusable` tan a menudo como sea posible en sus relaciones
{: .alert .alert-info }

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
            'cst_id',
            [
                'alias'    => 'customers',
                'reusable' => true,
            ]
        );
    }
}

```

## Autocompletado

La mayoría de IDEs y editores con capacidades de autocompletado puede que no detecten los tipos correctos cuando se usan *getters* mágicos (tanto métodos como propiedades). Para abordar este problema, podemos usar la clase docblock que especifica qué acciones mágicas están disponibles, ayudando al IDE a producir un mejor autocompletado:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

/**
 * Invoices model
 *
 * @property Simple|Products[] $products
 * @method   Simple|Products[] getProducts($parameters = null)
 * @method   integer           countProducts()
 */
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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'products',
            ]
        );
    }
}
```

## Condicionales

También puede crear relaciones basadas en condicionales. Cuando consulta basándose en la relación, la condición se añadirá automáticamente a la consulta:

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
        $this->hasManyToMany(
            'inv_id',
            InvoicesProducts::class,
            'ixp_inv_id',
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'reusable' => true,
                'alias'    => 'products',
            ]
        );
    }
}

class Companies extends Model
{
    public function initialize()
    {
        // All invoices relationship
        $this->hasMany(
            'id',
            Invoices::class,
            'inv_id',
            [
                'alias' => 'Invoices',
            ]
        );

        // Paid invoices relationship
        $this->hasMany(
            'id',
            Invoices::class,
            'inv_id',
            [
                'alias'  => 'InvoicesPaid',
                'params' => [
                    'conditions' => "inv_status = 'paid'",
                ],
            ]
        );

        // Unpaid invoices relationship + bound parameters
        $this->hasMany(
            'id',
            Invoices::class,
            'inv_id',
            [
                'alias'  => 'InvoicesUnpaid',
                'params' => [
                    'conditions' => "inv_status <> :status:",
                    'bind'       => [
                        'status' => 'unpaid',
                    ],
                ],
            ]
        );
    }
}
```

Adicionalmente, puede usar los parámetros de `getInvoices()` o `getRelated()` en el modelo, para filtrar u ordenar aún más su relación:

```php
<?php

$company = Companies::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => [
            'id' => 1,
        ],
    ]
);
*
$unpaidInvoices = $company->InvoicesUnpaid;
$unpaidInvoices = $company->getInvoicesUnpaid();
$unpaidInvoices = $company->getRelated('InvoicesUnpaid');
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    [
        'conditions' => "inv_status = 'paid'",
    ]
);

// Also ordered
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    [
        'conditions' => "inv_status = 'paid'",
        'order'      => 'inv_created_date ASC',
    ]
);
```

## Claves Ajenas Virtuales

Por defecto, las relaciones no tienen ninguna restricción adjunta a ellas, para comprobar datos relacionados cuando se añaden, actualizan o borran registros. Sin embargo, puede adjuntar validaciones a sus relaciones, para asegurar la integridad de los datos. Esto se puede hacer con el último parámetro del método relacionado con la relación.

La tabla de cruce `InvoicesProducts` se puede cambiar ligeramente para demostrar esta funcionalidad:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class InvoicesProducts extends Model
{
    public $ixp_inv_id;
    public $ixp_prd_id;

    public function initialize()
    {
        $this->belongsTo(
            'ixp_inv_id',
            Invoices::class,
            'inv_id',
            [
                'alias'      => 'invoice',
                'foreignKey' => true,
                'reusable'   => true,
            ]
        );

        $this->belongsTo(
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'alias'      => 'product',
                'foreignKey' => [
                    'message' => 'The prd_id does not exist ' .
                                 'in the Products model',
                ],
                'reusable'   => true,
            ]
        );
    }
}
```

Si altera una relación `belongsTo()` para actuar como clave ajena, validará que los valores insertados/actualizados en esos campos tengan identificadores de referencia válidos en los respectivos modelos. De forma similar, si un `hasMany()`/`hasOne()` se cambia para definir la `foreignKey`, validará que registros pueden o no si el registro tiene datos relacionados.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Products extends Model
{
    public $prd_id;
    public $prd_title;
    public $prd_price;
    public $prd_created_at;

    public function initialize()
    {
        $this->hasMany(
            'prd_id',
            Products::class,
            'ixp_prd_id',
            [
                'foreignKey' => [
                    'message' => 'The product cannot be deleted ' . 
                                 'because there are invoices ' .
                                 'attached to it',
                ],
            ]
        );
    }
}
```

Una clave ajena virtual se puede configurar para permitir valores nulos de la siguiente manera:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class InvoicesProducts extends Model
{
    public $ixp_inv_id;
    public $ixp_prd_id;

    public function initialize()
    {
        $this->belongsTo(
            'ixp_inv_id',
            Invoices::class,
            'inv_id',
            [
                'alias'      => 'invoice',
                'foreignKey' => true,
                'reusable'   => true,
            ]
        );

        $this->belongsTo(
            'ixp_prd_id',
            Products::class,
            'prd_id',
            [
                'alias'      => 'product',
                'foreignKey' => [
                    'allowNulls' => true,
                    'message'    => 'The prd_id does not exist ' .
                                    'in the Products model',
                ],
                'reusable'   => true,
            ]
        );
    }
}
```

### Cascada/Restringir

Las relaciones que actúan como claves ajenas virtuales por defecto restringen la creación/actualización/borrado de registros para mantener la integridad de los datos. Puede definir estas restricciones que imitan la funcionalidad del RDBMS para `CASCADE` y `RESTRICT` usando la opción `action` en `foreignKey`. El objeto subyacente de [Phalcon\Mvc\Model\Relation](api/phalcon_mvc#mvc-model-relation) ofrece dos constantes:

- `Relation::ACTION_CASCADE` 
- `Relation::ACTION_RESTRICT` 

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class Products extends Model
{
    public $prd_id;
    public $prd_title;
    public $prd_price;
    public $prd_created_at;

    public function initialize()
    {
        $this->hasMany(
            'prd_id',
            Products::class,
            'ixp_prd_id',
            [
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE,
                ],
            ]
        );
    }
}
```

El código anterior le permite eliminar todos los registros relacionados si el registro primario se elimina (eliminación en cascada).

## Operaciones

Puede ejecutar operaciones usando relaciones, si un conjunto de resultados devuelve objetos completos.

### Guardar

Se pueden usar las propiedades mágicas para almacenar un registro y sus propiedades relacionadas:

```php
<?php

// Create an artist
$artist = new Artists();

$artist->name    = 'Shinichi Osawa';
$artist->country = 'Japan';

// Create an album
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist; // Assign the artist
$album->year   = 2008;

// Save both records
$album->save();
```

Guardando un registro y sus registros relacionados en una relación *has-many*:

```php
<?php

$customer = Customers::findFirst(
    [
        'conditions' => 'cst_id = :customerId:',
        'bind'       => [
            'customerId' => 1,
        ]
    ]
);

$invoice1 = new Invoices();
$invoice1-> inv_status_flag = 0;
$invoice1-> inv_title       = 'Invoice for ACME Inc. #1';
$invoice1-> inv_total       = 100;
$invoice1-> inv_created_at  = time();

$invoice2 = new Invoices();
$invoice2-> inv_status_flag = 0;
$invoice2-> inv_title       = 'Invoice for ACME Inc. #2';
$invoice2-> inv_total       = 200;
$invoice2-> inv_created_at  = time();


$customer->invoices = [
    $invoice1,
    $invoice2
];


$customer->save();
```

El código anterior obtiene un cliente de nuestra base de datos. Se crean dos facturas y se asignan a la relación `invoices` del cliente como un vector. Se guarda entonces el registro de cliente, lo que también guarda las dos facturas en la base de datos y las enlaza al cliente.

Aunque la sintaxis anterior es muy útil, no siempre es ideal para usar, especialmente cuando actualiza registros relacionados. Phalcon no sabe qué registros necesitan ser añadidos o eliminados usando un **update**, y como resultado ejecutará un *replace*. En situaciones de actualización, es mejor controlar los datos por si mismo vs. dejar que lo haga el framework.

Guardar los datos con la sintaxis anterior implícitamente creará una transacción y la confirmará si todo va bien. Los mensajes generados durante el proceso de guardado de toda la transacción se devolverán al usuario para más información.

> **NOTA**: Añadir entidades relacionadas por sobrecarga de los siguientes métodos/eventos **no** es possible:
> 
> - `Phalcon\Mvc\Model::beforeSave()`
> - `Phalcon\Mvc\Model::beforeCreate()`
> - `Phalcon\Mvc\Model::beforeUpdate()`
{: .alert .alert-warning }

Necesita sobrecargar `Phalcon\Mvc\Model::save()` para que esto funcione desde dentro de un modelo.

### Actualizar

En lugar de hacer esto:

```php
<?php

$invoices = $customer->getInvoices();

foreach ($invoices as $invoice) {
    $invoice->inv_total      = 100;
    $invoice->inv_updated_at = time();

    if (false === $invoice->update()) {
        $messages = $invoice->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

puede hacer esto:

```php
<?php

$customer->getInvoices()->update(
    [
        'inv_total'      => 100,
        'inv_updated_at' => time(),
    ]
);
```

`update` también acepta una función anónima para filtrar los registros que se deben actualizar:

```php
<?php

$data = [
    'inv_total'      => 100,
    'inv_updated_at' => time(),
];

$customer->getInvoices()->update(
    $data,
    function ($invoice) {
        return ($invoice->inv_cst_id !== 1);
    }
);
```

### Eliminar

En lugar de hacer esto:

```php
<?php

$invoices = $customer->getInvoices();

foreach ($invoices as $invoice) {
    if (false === $invoice->delete()) {
        $messages = $invoice->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

puede hacer esto:

```php
<?php

$customer->getInvoices()->delete();
```

`delete()` también acepta una función anónima para filtrar los registros que se deben eliminar:

```php
<?php

$customer->getInvoices()->delete(
    function ($invoice) {
        return ($invoice->inv_total >= 0);
    }
);
```
