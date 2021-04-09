---
layout: default
language: 'es-es'
version: '4.0'
---

# Relaciones de modelos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

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

It also accepts a closure, which is evaluated every time before the related records are accessed. This enables the conditions to be automatically updated between queries.

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

There are times, where relationships need to be defined on a combination of fields and not only one. Consider the following example:

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

In the above we have a `Products` model which has `prd_id`, `prd_type_flag` and `prd_name` fields. The `Parts` model contains `par_id`, `par_prd_id`, `par_type_flag` and `par_name`. The relationship exists based on the product unique id as well as the type.

Using the relationship options, as seen above, binding one field between the two models will not return the results we need. We can use an array with the necessary fields to define the relationship.

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

There are several ways that we can access the relationships of a model.

- Métodos mágicos `__get`, `__set`
- Métodos mágicos `get*`
- `getRelated`

### `__get()`

You can use the magic method to access the relationship. Assigning an `alias` to the relationship simplifies accessing the related data. The name of the property is the same as the one defined in the `alias`.

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

or for a many to many relationship (see models above):

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

Using the magic `__get` allows you to access the relationship directly but does not offer additional functionality such as filtering or ordering on the relationship.

### `get*()`

You can access the same relationship by using a getter method, starting with *get* and using the name of the relationship.

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

or for a many to many relationship (see models above):

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

This magic getter also allows us to perform certain operations when accessing the relationship such as ordering the relationship:

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

You can also add additional conditionals in the relationship:

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

To get the same records manually:

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

The prefix `get` is used to `find()`/`findFirst()` related records.

| Tipo             | Método Implícito    | Devuelve                                                                 |
| ---------------- | ------------------- | ------------------------------------------------------------------------ |
| Belongs-To       | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-One          | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-One-Through  | `findFirst`         | Instancia de modelo del registro relacionado directamente                |
| Has-Many         | `find`              | Colección de instancias de modelo del modelo referenciado                |
| Has-Many-to-Many | (consulta compleja) | Colección de instancias de modelo del modelo referenciado (`inner join`) |

You can also use the `count` prefix to return an integer denoting the count of the related records:

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

You can access the same relationship by using `getRelated()` and defining which relationship you want to get.

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

or for a many to many relationship (see models above):

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

The second parameter of `getRelated()` is an array that offers additional options to be set such as filtering and ordering.

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

Accessing a relationship cam be achieved by using the name of the remote table. Due to naming conventions, this might not be that easy and could lead to confusion. As seen above, you can define an `alias` to the relationship.

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

With an alias:

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

If your table structure has self joins, you will not be able to access those relationships without aliases because you will be using the same model.

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

In the example above, we have a `Part` that has a relationship with one or more `Part` objects. Each `Part` can consist of other parts that construct it. As a result we end up with a self join relationship. For a telephone `Part` we have the following children:

    <?php
    
    $phone = Parts::findFirst(....);
    
    echo $phone->getChildren();
    
    // --- Cover
    // --- Battery
    // --- Charger
    

and each of those parts has the telephone as a parent:

    <?php
    $charger = Parts::findFirst(....);
    
    echo $phone->getParent();
    
    // Phone
    

## Caché

Accessing related data can significantly increase the number of queries in your database. You can reduce this load as much as possible, by utilizing the `reusable` option in your relationship. Setting this option to `true` will instruct Phalcon to cache the results of the relationship the first time it is accessed, so that subsequent calls to the same relationship can use the cached resultset and not request the data again from the database. This cache is active during the same request.

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

Most IDEs and editors with auto-completion capabilities can not detect the correct types when using magic getters (both methods and properties). To address this issue, you can use the class docblock that specifies what magic actions are available, helping the IDE to produce a better auto-completion:

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

You can also create relationships based on conditionals. When querying based on the relationship the condition will be automatically appended to the query:

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

Additionally, you can use the parameters of `getInvoices()` or `getRelated()` on the model, to further filter or order your relationship:

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

By default, relationships do not have any constraints attached to them, to check related data when adding, updating or deleting records. You can however attach validations to your relationships, to ensure integrity of data. This can be done with the last parameter of the relationship related method.

The cross table `InvoicesProducts` can be slightly changed to demonstrate this functionality:

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

If you alter a `belongsTo()` relationship to act as foreign key, it will validate that the values inserted/updated on those fields have reference valid ids in the respective models. Similarly, if a `hasMany()`/`hasOne()` is changed to define the `foreignKey`, it will validate that records can or cannot if the record has related data.

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

A virtual foreign key can be set up to allow null values as follows:

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

Relationships that act as virtual foreign keys by default restrict the creation/update/deletion of records to maintain the integrity of data. You can define these constraints that mimic the RDBMS functionality for `CASCADE` and `RESTRICT` by using the `action` option in `foreignKey`. The [Phalcon\Mvc\Model\Relation](api/phalcon_mvc#mvc-model-relation) underlying object offers two constants:

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

The code above allows you to delete all the related record if the primary record is deleted (cascade delete).

## Operaciones

You can perform operations using relationships, if a resultset returns complete objects.

### Guardar

Magic properties can be used to store a record and its related properties:

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

Saving a record and its related records in a has-many relation:

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

The code above gets a customer from our database. Two invoices are created and assigned to the `invoices` relationship of the customer as an array. The customer record is then saved, which also saves the two invoices in the database and links them to the customer.

Although the syntax above is very handy, it is not always ideal to use it, especially when updating related records. Phalcon does not know which records need to be added or removed using an **update**, and as a result it will perform a replace. In update situations, it is better to control the data yourself vs. leaving it to the framework to do that.

Saving data with the above syntax will implicitly create a transaction and commit it if all goes well. Messages generated during the save process of the whole transaction will be passed back to the user for more information.

> **NOTA**: Añadir entidades relacionadas por sobrecarga de los siguientes métodos/eventos **no** es possible:
> 
> - `Phalcon\Mvc\Model::beforeSave()`
> - `Phalcon\Mvc\Model::beforeCreate()`
> - `Phalcon\Mvc\Model::beforeUpdate()`
{: .alert .alert-warning }

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

### Actualizar

Instead of doing this:

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

you can do this:

```php
<?php

$customer->getInvoices()->update(
    [
        'inv_total'      => 100,
        'inv_updated_at' => time(),
    ]
);
```

`update` also accepts an anonymous function to filter what records must be updated:

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

Instead of doing this:

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

you can do this:

```php
<?php

$customer->getInvoices()->delete();
```

`delete()` also accepts an anonymous function to filter what records must be deleted:

```php
<?php

$customer->getInvoices()->delete(
    function ($invoice) {
        return ($invoice->inv_total >= 0);
    }
);
```