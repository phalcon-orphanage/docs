---
layout: default
language: 'fa-ir'
version: '4.0'
---

# Model Relationships

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Database normalization](db-normalization) is a process where data is split into different tables and links are created between those tables, in order to increase flexibility, reduce data redundancy and improve data integrity. Relationships are defined in the `initialize` method of each model.

The following types of relationships are available: - one to one

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
    

- one to many

    hasMany(
        string|array $fields, 
        string $referenceModel, 
        string|array $referencedFields, 
        array options = null
    )
    

- many to one

    belongsTo(
        string|array $fields, 
        string $referenceModel, 
        string|array $referencedFields, 
        array options = null
    )
    

- many to many

    hasManyToMany(
        string|array $fields, 
        string $intermediateModel, 
        string|array $intermediateFields, 
        string|array $intermediateReferencedFields,
        string $referenceModel, 
        string|array $referencedFields, 
        array $options = null
    )
    

Relationships can be unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access of related records to a model. Through the implementation of relations, it is easy to access data in related models from the source model easily and in a uniform way.

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

## Unidirectional

Unidirectional relations are those that are generated in relation to one another but not vice versa.

## Bidirectional

The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

## Setup

In Phalcon, relationships must be defined in the `initialize()` method of a model. The methods `belongsTo()`, `hasMany()`, `hasManyToMany()`, `hasOne()` and `hasOneThrough()`, define the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3 parameters:

- local fields 
- referenced model 
- referenced fields

| Method          | Description                |
| --------------- | -------------------------- |
| `belongsTo`     | Defines a n-1 relationship |
| `hasMany`       | Defines a 1-n relationship |
| `hasManyToMany` | Defines a n-n relationship |
| `hasOne`        | Defines a 1-1 relationship |
| `hasOneThrough` | Defines a 1-1 relationship |

The following schema shows 3 tables whose relations will serve us as an example regarding relationships:

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

- The model `Invoices` has many `InvoicesProducts`.
- The model `Products` has many `InvoicesProducts`.
- The model `InvoicesProducts` belongs to both `Invoices` and `Products` models as a many-to-one relation.
- The model `Invoices` has a relation many-to-many to `Products` through `InvoicesProducts`.

![](/assets/images/content/models-relationships-erd-1.png)

The models with their relations could be implemented as follows:

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

The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced model, and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.

Many to many relationships require 3 models and define the attributes involved in the relationship:

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

## Parameters

Depending on the needs of our application we might want to store data in one table, that describe different behaviors. For instance, you might want to only have a table called `co_customers` which has a field `cst_status_flag` describing the *status* of the customer (e.g. active, inactive, etc.).

Using relationships, you can get only those `Customers` that relate to our `Invoices` that have a certain `cst_status_flag`. Defining that constraint in the relationship allows you to let the model do all the work.

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
    }
}
```

## Multiple Fields

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

> **NOTE** The field mappings in the relationship are one for one i.e. the first field of the source model array matches the first field of the target array etc. The field count must be identical in both source and target models.
{: .alert .alert-info }

## Accessing

There are several ways that we can access the relationships of a model.

- Magic `__get`, `__set`
- Magic `get*`
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

| Type             | Implicit Method | Returns                                                              |
| ---------------- | --------------- | -------------------------------------------------------------------- |
| Belongs-To       | `findFirst`     | Model instance of the related record directly                        |
| Has-One          | `findFirst`     | Model instance of the related record directly                        |
| Has-One-Through  | `findFirst`     | Model instance of the related record directly                        |
| Has-Many         | `find`          | Collection of model instances of the referenced model                |
| Has-Many-to-Many | (complex query) | Collection of model instances of the referenced model (`inner join`) |

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

## Aliases

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
    

## Caching

Accessing related data can significantly increase the number of queries in your database. You can reduce this load as much as possible, by utilizing the `reusable` option in your relationship. Setting this option to `true` will instruct Phalcon to cache the results of the relationship the first time it is accessed, so that subsequent calls to the same relationship can use the cached resultset and not request the data again from the database. This cache is active during the same request.

> **NOTE**: You are encouraged to use the `reusable` option as often as possible in your relationships
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

## Autocompletion

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

## Conditionals

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

## Virtual Foreign Keys

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

### Cascade/Restrict

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

## Operations

You can perform operations using relationships, if a resultset returns complete objects.

### Save

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

> **NOTE**: Adding related entities by overloading the following methods/events is **not** possible:
> 
> - `Phalcon\Mvc\Model::beforeSave()`
> - `Phalcon\Mvc\Model::beforeCreate()`
> - `Phalcon\Mvc\Model::beforeUpdate()`
{: .alert .alert-warning }

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

### Update

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

### Delete

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