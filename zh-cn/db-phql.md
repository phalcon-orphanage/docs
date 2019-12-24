---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon Query Language (PHQL)'
keywords: 'phql, phalcon query language, query language'
---

# Phalcon Query Language (PHQL)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Phalcon Query Language, PhalconQL or simply PHQL is a high-level, object-oriented SQL dialect that allows you to write queries using a standardized SQL-like language. PHQL is implemented as a parser (written in C) that translates syntax in that of the target RDBMS.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as [SQLite](https://en.wikipedia.org/wiki/Lemon_Parser_Generator). This technology provides a small in-memory parser with a very low memory footprint that is also thread-safe.

The parser first checks the syntax of the PHQL statement to be parsed, then builds an intermediate representation of the statement and finally it converts it to the respective SQL dialect of the target RDBMS.

In PHQL, we have implemented a set of features to make your access to databases more securely:

* 绑定参数是 PHQL语言的一部分, 可帮助您保护代码
* PHQL只允许每个调用执行一个 sql 语句, 以防止注入
* PHQL忽略 sql 注入中经常使用的所有 sql 注释
* PHQL只允许数据操作语句, 避免错误地更改或删除表数据库或未经授权在外部更改或删除
* PHQL 实现了一个高级抽象, 允许您将表作为模型处理, 将字段作为类属性处理

To better explain how PHQL works, for this article we are going to use two models `Invoices` and `Customers`:

```php
<?php

namespace MyApp\Models;

use MyApp\Models\Customers;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public $inv_cst_id;

    public $inv_id;

    public $inv_status_flag;

    public $inv_title;

    public $inv_created_at;

    public function initialize()
    {
        $this->setSource('co_invoices');

        $this->belongsTo(
            'inv_cst_id', 
            Customers::class, 
            'cst_id'
        );
    }
}
```

And every Customer has one or more invoices:

```php
<?php

namespace MyApp\Models;

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model;

class Customers extends Model
{
    public $cst_id;

    public $cst_active_flag;

    public $cst_name_last;

    public $cst_name_first;

    public $cst_created_at;

    public function initialize()
    {
        $this->setSource('co_customers');

        $this->hasMany(
            'cst_id', 
            Invoices::class, 
            'inv_cst_id'
        );
    }
}
```

## Query

PHQL queries can be created just by instantiating the class [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query):

```php
<?php

use Phalcon\Mvc\Model\Query;

$container = Di::getDefault();
$query     = new Query(
    'SELECT * FROM Invoices',
    $container
);

$invoices = $query->execute();
```

The [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query) requires the second parameter of the constructor to be the DI container. When calling the above code from a controller or any class that extends the [Phalcon\Di\Injectable](api/phalcon_di#di-injectable), you can use:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;

/**
 * @property Di   $di
 * @property View $view
 */
class Invoices extends Controller
{
    public function listAction()
    {
        $query = new Query(
            'SELECT * FROM Invoices',
            $this->di
        );

        $invoices = $query->execute();

        $this->view->setVar('invoices', $invoices);
    }
}
```

## Models Manager

We can also utilize the [Phalcon\Mvc\Model\Manager](api/phalcon_mvc#mvc-model-manager) which is injected in the DI container:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\View;

/**
 * @property Manager $modelsManager
 * @property View    $view
 */
class Invoices extends Controller
{
    public function listAction()
    {
        $query = $this
            ->modelsManager
            ->createQuery(
                'SELECT * FROM Invoices'
            )
        ;

        $invoices = $query->execute();

        $this->view->setVar('invoices', $invoices);
    }
}
```

Using bound parameters:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\View;

/**
 * @property Manager $modelsManager
 * @property Request $request
 * @property View    $view
 */
class Invoices extends Controller
{
    public function viewAction()
    {
        $invoiceId = $this->request->getQuery('id', 'int');
        $query     = $this
            ->modelsManager
            ->createQuery(
                'SELECT * FROM Invoices WHERE inv_id = :id:'
            )
        ;

        $invoices = $query->execute(
            [
                'id' => $invoiceId,
            ]
        );

        $this->view->setVar('invoices', $invoices);
    }
}
```

You can also skip creating the query and then executing it and instead execute the query directly from the Models Manager object:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\View;

/**
 * @property Manager $modelsManager
 * @property View    $view
 */
class Invoices extends Controller
{
    public function listAction()
    {
        $invoices = $this
            ->modelsManager
            ->executeQuery(
                'SELECT * FROM Invoices'
            )
        ;

        $this->view->setVar('invoices', $invoices);
    }
}
```

Using bound parameters:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\View;

/**
 * @property Manager $modelsManager
 * @property Request $request
 * @property View    $view
 */
class Invoices extends Controller
{
    public function viewAction()
    {
        $invoiceId = $this->request->getQuery('id', 'int');
        $invoices  = $this
            ->modelsManager
            ->executeQuery(
                'SELECT * FROM Invoices WHERE inv_id = :id:',
                [
                    'id' => $invoiceId,
                ]
            )
        ;

        $this->view->setVar('invoices', $invoices);
    }
}
```

## Select

As the familiar SQL, PHQL allows selecting records using the `SELECT` statement, except that instead of specifying tables, we use the model classes:

**Models**

```sql
SELECT 
    * 
FROM   
    Invoices  
ORDER BY 
    Invoices.inv_title
```

```sql
SELECT 
    Invoices.inv_id, 
    Invoices.inv_title, 
    Invoices.inv_status_flag
FROM   
    Invoices  
ORDER BY 
    Invoices.inv_title
```

**Namespaced models**

```sql
SELECT 
    * 
FROM   
    MyApp\Models\Invoices
ORDER BY 
    MyApp\Models\Invoices.inv_title'
```

**Aliases**

```sql
SELECT 
    i.inv_id, 
    i.inv_title, 
    i.inv_status_flag
FROM   
    Invoices i  
ORDER BY 
    i.inv_title
```

**`CASE`**

```sql
SELECT 
    i.inv_id, 
    i.inv_title, 
    CASE i.inv_status_flag
        WHEN 1 THEN 'Paid'
        WHEN 0 THEN 'Unpaid'
    END AS status_text
FROM   
    Invoices i
WHERE  
    i.inv_status_flag = 1  
ORDER BY 
    i.inv_title
LIMIT 100
```

**`LIMIT`**

```sql
SELECT 
    i.inv_id, 
    i.inv_title, 
    i.inv_status_flag
FROM   
    Invoices i
WHERE  
    i.inv_status_flag = 1  
ORDER BY 
    i.inv_title
LIMIT 100
```

**Aliases in Namespaces**

You can define aliases in namespaces to make your code a bit more readable. This is set up when you register the `modelsManager` in your DI container:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\Manager;

$container = new FactoryDefault();
$container->set(
    'modelsManager',
    function () {
        $modelsManager = new Manager();
        $modelsManager->registerNamespaceAlias(
            'inv',
             Invoices::class
        );

        return $modelsManager;
    }
);
```

and now our query can be written as:

```sql
SELECT 
    i.inv_id 
FROM   
    inv:Invoices i
WHERE  
    i.inv_status_flag = 1  
```

The above *shortens* the whole namespace for the model, replacing it with an alias.

**Subqueries**

PHQL also supports subqueries. The syntax is similar to the one offered by PDO.

```sql
SELECT 
    i.inv_id 
FROM   
    Invoices i
WHERE EXISTS (  
    SELECT 
        cst_id
    FROM
        Customers c
    WHERE 
        c.cst_id = i.inv_cst_id
)
```

```sql
SELECT 
    inv_id 
FROM   
    Invoices 
WHERE inv_cst_id IN (  
    SELECT 
        cst_id
    FROM
        Customers 
    WHERE 
        cst_name LIKE '%ACME%'
)
```

### Results

Depending on the columns we query as well as the tables, the result types will vary.

If you retrieve all the columns from a single table, you will get back a fully functional [Phalcon\Mvc\Model\Resultset\Simple](api/phalcon_mvc#mvc-model-resultset-simple) object back. The object returned is a *complete* and can be modified and re-saved in the database because they represent a complete record of the associated table.

The following examples return identical results:

**Model**

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find(
    [
        'order' => 'inv_title'
    ]
);

foreach ($invoices as $invoice) {
    echo $invoice->inv_id, ' - ', $invoice->inv_name, PHP_EOL;
}
```

**PHQL**

```php
<?php

$phql = "
    SELECT 
        * 
    FROM 
        Invoices 
    ORDER BY 
        inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($invoices as $invoice) {
    echo $invoice->inv_id, ' - ', $invoice->inv_name, PHP_EOL;
}
```

Any queries that use specific columns do not return *complete* objects, and therefore database operations cannot be performed on them. However, they are much smaller than their complete counterparts and offer micro optimizations in your code.

```php
<?php

$phql = "
    SELECT 
        inv_id, inv_title 
    FROM 
        Invoices 
    ORDER BY 
        inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($invoices as $invoice) {
    echo $invoice->inv_id, ' - ', $invoice->inv_name, PHP_EOL;
}
```

The returned result is a [Phalcon\Mvc\Model\Resultset\Simple](api/phalcon_mvc#mvc-model-resultset-simple) object. However, However, each element is a standard object that only contain the two columns that were requested.

These values that do not represent complete objects are what we call scalars. PHQL allows you to query all types of scalars: fields, functions, literals, expressions, etc..:

```php
<?php

$phql = "
    SELECT 
        CONCAT(inv_id, ' - ', inv_title) AS id_name 
    FROM 
        Invoices 
    ORDER BY 
        inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($invoices as $invoice) {
    echo $invoice->id_name, PHP_EOL;
}
```

We can query complete objects or scalars, therefore can also query both at once:

```php
<?php

$phql = "
    SELECT 
        i.*, 
        IF(i.inv_status_flag = 1, 'Paid', 'Unpaid') AS status 
    FROM 
        Invoices i 
    ORDER BY 
        i.inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

The result in this case is a [Phalcon\Mvc\Model\Resultset\Complex](api/phalcon_mvc#mvc-model-resultset-complex) object. This allows access to both complete objects and scalars at once:

```php
<?php

foreach ($invoices as $invoice) {
    echo $invoice->status, 
         $invoice->i->inv_id, 
         $invoice->i->inv_name, 
         PHP_EOL
    ;
}
```

Scalars are mapped as properties of each 'row', while complete objects are mapped as properties with the name of its related model. In the above example, the scalar `status` is accessed directly from the object, while the database row can be accessed by the `invoices` property, which is the same name as the name of the model.

If you mix `*` selections from one model with columns from another, you will end up with both scalars as well as objects.

```php
<?php

$phql = "
    SELECT 
        i.*, 
        IF(i.inv_status_flag = 1, 'Paid', 'Unpaid') AS status
        c.* 
    FROM 
        Invoices i
    JOIN
        Customers c
    ON
        i.inv_cst_id = c.cst_id 
    ORDER BY 
        i.inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

The above will produce:

```php
<?php

foreach ($invoices as $invoice) {
    echo $invoice->status, 
         $invoice->i->inv_id, 
         $invoice->i->inv_name, 
         $invoice->c->cst_id, 
         $invoice->c->cst_name_last, 
         PHP_EOL
    ;
}
```

Another example:

```php
<?php

$phql = "
    SELECT 
        i.*, 
        c.cst_name_last AS name_last 
    FROM 
        Invoices i
    JOIN
        Customers c
    ON
        i.inv_cst_id = c.cst_id 
    ORDER BY 
        i.inv_title";
$invoices  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

The above will produce:

```php
<?php

foreach ($invoices as $invoice) {
    echo $invoice->name_last, 
         $invoice->i->inv_id, 
         $invoice->i->inv_name, 
         PHP_EOL
    ;
}
```

Note that we are selecting one column from the `Customers` model and we need to alias it (`name_last`) so that it becomes a scalar in our resultset.

### Joins

It's easy to request records from multiple models using PHQL. Most kinds of Joins are supported. As we defined relationships in the models, PHQL adds these conditions automatically:

```php
<?php

$phql = "
    SELECT 
        Invoices.inv_id AS invoice_id, 
        Invoices.inv_title AS invoice_title, 
        Customers.cst_id AS customer_id,
        Customers.cst_name_last,
        Customers.cst_name_first 
    FROM 
        Customers
    INNER JOIN 
        Invoices 
    ORDER BY 
        Customers.cst_name_last, Customers.cst_name_first";
$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($records as $record) {
    echo $record->invoice_id, 
         $record->invoice_title, 
         $record->customer_id,
         $record->cst_name_last,
         $record->cst_name_first, 
         PHP_EOL
    ;
}
```

> **NOTE**: By default, an `INNER JOIN` is assumed. 
{: .alert .alert-info }

You can specify the following types of joins in your query:

* `CROSS JOIN`
* `LEFT JOIN`
* `LEFT OUTER JOIN`
* `INNER JOIN`
* `JOIN`
* `RIGHT JOIN`
* `RIGHT OUTER JOIN`

The PHQL parser will automatically resolve the conditions of the `JOIN` operation, depending on the relationships set up in the `initialize()` of each model. These are calls to `hasMany`, `hasOne`, `belongsTo` etc.

It is however possible to manually set the conditions of the `JOIN`:

```php
<?php

$phql = "
    SELECT 
        Invoices.inv_id AS invoice_id, 
        Invoices.inv_title AS invoice_title, 
        Customers.cst_id AS customer_id,
        Customers.cst_name_last,
        Customers.cst_name_first 
    FROM 
        Customers
    INNER JOIN 
        Invoices
    ON 
        Customers.cst_id = Invoices.inv_cst_id 
    ORDER BY 
        Customers.cst_name_last, Customers.cst_name_first";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Also, the joins can be created using multiple tables in the `FROM` clause, using the alternative *join* syntax:

```php
<?php

$phql = "
    SELECT 
        Invoices.*, 
        Customers.* 
    FROM 
        Customers, Invoices
    WHERE 
        Customers.cst_id = Invoices.inv_cst_id 
    ORDER BY 
        Customers.cst_name_last, Customers.cst_name_first";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($records as $record) {
    echo $record->invoices->inv_id, 
         $record->invoices->inv_title, 
         $record->customers->cst_id,
         $record->customers->cst_name_last,
         $record->customers->cst_name_first, 
         PHP_EOL
    ;
}
```

If aliases are used for models, then the resultset will use those aliases to name the attributes in the every row of the result:

```php
<?php

$phql = "
    SELECT 
        i.*, 
        c.* 
    FROM 
        Customers c, Invoices i
    WHERE 
        c.cst_id = i.inv_cst_id 
    ORDER BY 
        c.cst_name_last, c.cst_name_first";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($records as $record) {
    echo $record->i->inv_id, 
         $record->i->inv_title, 
         $record->c->cst_id,
         $record->c->cst_name_last,
         $record->c->cst_name_first, 
         PHP_EOL
    ;
}
```

When the joined model has a many-to-many relation to the `from` model, the intermediate model is implicitly added to the generated query. For this example we have `Invoices`, `InvoicesXProducts` and `Products` models:

```php
<?php

$phql = "
    SELECT 
        Invoices.inv_id, 
        Invoices.inv_title, 
        Products.prd_id,
        Products.prd_title 
    FROM 
        Invoices
    JOIN
        Products
    WHERE 
        Invoices.inv_id = 1 
    ORDER BY 
        Products.prd_name";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

This code executes the following SQL in MySQL:

```sql
SELECT 
    co_invoices.inv_id, 
    co_invoices.inv_title, 
    co_products.prd_id,
    co_products.prd_title 
FROM 
    co_invoices
JOIN JOIN
    co_invoices_x_products 
ON 
    co_invoices.inv_id = co_invoices_x_products.ixp_inv_id
JOIN JOIN
    co_products 
ON 
    co_invoices_x_products.ixp_prd_id = co_products.prd_id
WHERE
    co_invoices.inv_id = 1
ORDER BY
    co_products.prd_name
```

### Aggregations

The following examples show how to use aggregations in PHQL:

**Average**

What is the average amount of invoices for a customer with `inv_cst_id = 1`

```php
<?php

$phql = "
    SELECT 
        AVERAGE(inv_total) AS invoice_average
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = 1";

$results  = $this
    ->modelsManager
    ->executeQuery($phql)
;

echo $results['invoice_average'], PHP_EOL;
```

**Count**

How many invoices does each customer have

```php
<?php

$phql = "
    SELECT 
        inv_cst_id,
        COUNT(*) AS invoice_count
    FROM 
        Invoices
    GROUP BY 
        Invoices.inv_cst_id
    ORDER BY 
        Invoices.inv_cst_id";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($records as $record) {
    echo $record->inv_cst_id, 
         $record->invoice_count, 
         PHP_EOL
    ;
}
```

**Count Distinct**

How many invoices does each customer have

```php
<?php

$phql = "
    SELECT 
        COUNT(DISTINCT inv_cst_id) AS customer_id
    FROM 
        Invoices
    ORDER BY 
        Invoices.inv_cst_id";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

foreach ($records as $record) {
    echo $record->inv_cst_id, 
         PHP_EOL
    ;
}
```

**Max**

What is the maximum invoice amount for a customer with `inv_cst_id = 1`

```php
<?php

$phql = "
    SELECT 
        MAX(inv_total) AS invoice_max
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = 1";

$results  = $this
    ->modelsManager
    ->executeQuery($phql)
;

echo $results['invoice_max'], PHP_EOL;
```

**Min**

What is the minimum invoice amount for a customer with `inv_cst_id = 1`

```php
<?php

$phql = "
    SELECT 
        MIN(inv_total) AS invoice_min
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = 1";

$results  = $this
    ->modelsManager
    ->executeQuery($phql)
;

echo $results['invoice_min'], PHP_EOL;
```

**Sum**

What is the total amount of invoices for a customer with `inv_cst_id = 1`

```php
<?php

$phql = "
    SELECT 
        SUM(inv_total) AS invoice_total
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = 1";

$results  = $this
    ->modelsManager
    ->executeQuery($phql)
;

echo $results['invoice_total'], PHP_EOL;
```

### Conditions

Conditions allow us to filter the set of records we want to query using the `WHERE` keyword.

Select a record with a single numeric comparison:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = 1";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;

```

Select records with a greater than numeric comparison:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_total > 1000";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records with a single text comparison using `TRIM`:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        TRIM(Invoices.inv_title) = 'Invoice for ACME Inc.'";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records using the `LIKE` keyword:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_title LIKE '%ACME%'";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records using the `NOT LIKE` keywords:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_title NOT LIKE '%ACME%'";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records where a field is `NULL`:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_total IS NULL";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records using the `IN` keyword:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id IN (1, 3, 5)";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records using the `NOT IN` keywords:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id NOT IN (1, 3, 5)";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Select records using the `BETWEEN` keywords:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id BETWEEN 1 AND 5";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

### Parameters

PHQL automatically escapes parameters, introducing more security:

Using named parameters:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = :customer_id:";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customer_id' => 1,
        ]
    )
;
```

Using numeric indexes:

```php
<?php

$phql = "
    SELECT 
        *
    FROM 
        Invoices
    WHERE 
        Invoices.inv_cst_id = ?2";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            2 => 1,
        ]
    )
;
```

## Insert

With PHQL it's possible to insert data using the familiar `INSERT` statement:

Inserting data without columns:

```php
<?php

$phql = "
    INSERT INTO Invoices
    VALUES (
        NULL,
        1,
        0,
        'Invoice for ACME Inc.',
        0
    )";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Inserting data with specific columns columns:

```php
<?php

$phql = "
    INSERT INTO Invoices (
        inv_id,
        inv_cst_id,
        inv_status_flag,
        inv_title,
        inv_total
    )
    VALUES (
        NULL,
        1,
        0,
        'Invoice for ACME Inc.',
        0
    )";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Inserting data with named placeholders:

```php
<?php

$phql = "
    INSERT INTO Invoices (
        inv_id,
        inv_cst_id,
        inv_status_flag,
        inv_title,
        inv_total
    )
    VALUES (
        :id:,
        :cst_id:,
        :status_flag:,
        :title:,
        :total:
    )";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'id'          => NULL,
            'cst_id'      => 1,
            'status_flag' => 0,
            'title'       => 'Invoice for ACME Inc.',
            'total'       => 0
        ]
    )
;
```

Inserting data with numeric placeholders:

```php
<?php

$phql = "
    INSERT INTO Invoices (
        inv_id,
        inv_cst_id,
        inv_status_flag,
        inv_title,
        inv_total
    )
    VALUES (
        ?0,
        ?1,
        ?2,
        ?3,
        ?4
    )";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            0 => NULL,
            1 => 1,
            2 => 0,
            3 => 'Invoice for ACME Inc.',
            4 => 0
        ]
    )
;
```

Phalcon does not only transform the PHQL statements into SQL. All events and business rules defined in the model are executed as if we created individual objects manually.

If we add a business rule in the `beforeCreate` event for the `Invoices` model, the event be called and our code will be executed. Assuming we add a rule where an invoice cannot have a negative total:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;

class Invoices extends Model
{
    public function beforeCreate()
    {
        if ($this->inv_total < 0) {
            $this->appendMessage(
                new Message('An invoice cannot have a negative total')
            );

            return false;
        }
    }
}
```

If we issue the following `INSERT` statement:

```php
<?php

$phql = "
    INSERT INTO Invoices (
        inv_id,
        inv_cst_id,
        inv_status_flag,
        inv_title,
        inv_total
    )
    VALUES (
        ?0,
        ?1,
        ?2,
        ?3,
        ?4
    )";

$result  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            0 => NULL,
            1 => 1,
            2 => 0,
            3 => 'Invoice for ACME Inc.',
            4 => -100
        ]
    )
;

if (false === $result->success()) {
    foreach ($result->getMessages() as $message) {
        echo $message->getMessage();
    }
}
```

Since we tried to insert a negative number for the `inv_total` the `beforeCreate` was invoked prior to saving the record. As a result the operation fails and the relevant error messages are being sent back.

## Update

Updating rows uses the same rules as inserting rows. For that operation we use the `UPDATE` command. Just as with inserting rows, when a record is updated the events related to the update operation will be executed for each row.

Updating one column

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_total = 0
    WHERE
        inv_cst_id = 1";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Updating multiple columns

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_status_flag = 0,
        inv_total = 0
    WHERE
        inv_cst_id = 1";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Updating multiple rows:

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_status_flag = 0,
        inv_total = 0
    WHERE
        inv_cst_id > 10";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Updating data with named placeholders:

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_status_flag = :status:,
        inv_total = :total:
    WHERE
        inv_cst_id > :customerId:";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'status'     => 0,
            'total'      => 0,
            'customerId' => 10,
        ]
    )
;
```

Updating data with numeric placeholders:

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_status_flag = ?0,
        inv_total = ?1
    WHERE
        inv_cst_id > ?2";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            0 => 0,
            1 => 0,
            2 => 10,
        ]
    )
;
```

An `UPDATE` statement performs the update in two phases:

* If the `UPDATE` has a `WHERE` clause it retrieves all the objects that match these criteria,
* Based on the queried objects it updates the requested attributes storing them in the database

This way of operation allows that events, virtual foreign keys and validations to be executed during the updating process. In short, the code:

```php
<?php

$phql = "
    UPDATE Invoices
    SET
        inv_status_flag = 0,
        inv_total = 0
    WHERE
        inv_cst_id > 10";

$result = $this
    ->modelsManager
    ->executeQuery($phql)
;

if (false === $result->success()) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

is somewhat equivalent to:

```php
<?php

use MyApp\Models\Invoices;

$messages = [];
$invoices = Invoices::find(
    [
        'conditions' => 'inc_cst_id = :customerId:',
        'bind'       => [
            'customerId' => 10,
        ],
    ]  
);

foreach ($invoices as $invoice) {
    $invoice->inv_status_flag = 0;
    $invoice->inv_total       = 0;

    $result = $invoice->save();
    if (false === $result) {
        $messages[] = $invoice->getMessages();
    } 
}
```

## Deleting Data

Similar to updating records, deleting records uses the same rules. For that operation we use the `DELETE` command. When a record is deleted the events related to the update operation will be executed for each row.

Deleting one row

```php
<?php

$phql = "
    DELETE
    FROM 
        Invoices
    WHERE
        inv_cst_id = 1";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Deleting multiple rows:

```php
<?php

$phql = "
    DELETE
    FROM 
        Invoices
    WHERE
        inv_cst_id > 10";

$records  = $this
    ->modelsManager
    ->executeQuery($phql)
;
```

Deleting data with named placeholders:

```php
<?php

$phql = "
    DELETE
    FROM 
        Invoices
    WHERE
        inv_cst_id > :customerId:";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customerId' => 10,
        ]
    )
;
```

Deleting data with numeric placeholders:

```php
<?php

$phql = "
    DELETE
    FROM 
        Invoices
    WHERE
        inv_cst_id > ?2";

$records  = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            2 => 10,
        ]
    )
;
```

A `DELETE` statement performs the delete in two phases:

* If the `DELETE` has a `WHERE` clause it retrieves all the objects that match these criteria,
* Based on the queried objects it deletes the requested objects from the relational database

Just as the rest of the operations, checking the status code returned allows you to retrieve back any validation messages returned by operations hooked up to your models

```php
<?php

$phql = "
    DELETE
    FROM
        Invoices
    WHERE
        inv_cst_id > 10";

$result = $this
    ->modelsManager
    ->executeQuery($phql)
;

if (false === $result->success()) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

## Query Builder

[Phalcon\Mvc\Query\Builder](api/phalcon_mvc#mvc-model-query-builder) is a very handy builder that allows you to construct PHQL statements in an object oriented way. Most methods return the buider object, allowing you to use a fluent interface and is flexible enough allowing you to add conditionals if you need to without having to create complex `if` statements and string concatenations constructing the PHQL statement.

The PHQL query:

```sql
SELECT 
    * 
FROM 
    Invoices 
ORDER BY 
    inv_title
```

can be created and executed as follows:

```php
<?php

use MyApp\Models\Invoices;

$invoices = $this
    ->modelsManager
    ->createBuilder()
    ->from(Invoices::class)
    ->orderBy('inv_title')
    ->getQuery()
    ->execute();
```

To get a single row:

```php
<?php

use MyApp\Models\Invoices;

$invoices = $this
    ->modelsManager
    ->createBuilder()
    ->from(Invoices::class)
    ->orderBy('inv_title')
    ->getQuery()
    ->getSingleResult();
```

### Parameters

Whether you create a [Phalcon\Mvc\Query\Builder](api/phalcon_mvc#mvc-model-query-builder) object directly or you are using the Models Manager's `createBuilder` method, you can always use the fluent interface to build your query or pass an array with parameters in the constructor. The keys of the array are:

* `bind` - `array` - array of the data to be bound
* `bindTypes` - `array` - PDO parameter types
* `columns` - `array | string` - columns to select 
* `conditions` - `array | string` - conditions (where)
* `distinct` - `string` - distinct column 
* `for_update` - `bool` - for update or not
* `group` - `array` - group by columns
* `having` - `string` - having columns
* `joins` - `array` - model classes used for joins
* `limit` - `array | int` - limit for the records (i.e. `20` or `[20, 20]`)
* `models` - `array` - model classes used
* `offset` - `int` - the offset
* `order` - `array | string` - order columns
* `shared_lock` - `bool` - issue shared lock or not

```php
<?php

use PDO;
use Phalcon\Mvc\Model\Query\Builder;

$params = [
    "models"     => [
        Users::class,
    ],
    "columns"    => ["id", "name", "status"],
    "conditions" => [
        [
            "created > :min: AND created < :max:",
            [
                "min" => "2013-01-01",
                "max" => "2014-01-01",
            ],
            [
                "min" => PDO::PARAM_STR,
                "max" => PDO::PARAM_STR,
            ],
        ],
    ],
    // or "conditions" => "created > '2013-01-01' AND created < '2014-01-01'",
    "group"      => ["id", "name"],
    "having"     => "name = 'Kamil'",
    "order"      => ["name", "id"],
    "limit"      => 20,
    "offset"     => 20,
    // or "limit" => [20, 20],
];

$builder = new Builder($params);
```

### Getters

* `autoescape(string $identifier)` - `string` - Automatically escapes identifiers but only if they need to be escaped.
* `getBindParams(): array` - Returns default bind params
* `getBindTypes(): array` - Returns default [bind types](https://www.php.net/manual/en/pdo.constants.php)
* `getColumns()` - `string | array` - Return the columns to be queried
* `getDistinct()` - `bool` - Returns the `SELECT DISTINCT` / `SELECT ALL` clause 
* `getFrom()` - `string | array` - Return the models for the query
* `getGroupBy()` - `array` - Returns the `GROUP BY` clause
* `getHaving()` - `string` - Returns the `HAVING` clause
* `getJoins()` - `array` - Returns `JOIN` join parts of the query
* `getLimit()` - `string | array` - Returns the current `LIMIT` clause
* `getModels()` - `string | array | null` - Returns the models involved in the query
* `getOffset()` - `int` - Returns the current `OFFSET` clause
* `getOrderBy()` - `string / array` - Returns the `ORDER BY` clause
* `getPhql()` - `string` - Returns the generated PHQL statement
* `getQuery()` - `QueryInterface` - Returns the query built
* `getWhere()` - `string | array` - Return the conditions for the query

### Methods

```php
public function addFrom(
    string $model, 
    string $alias = null
): BuilderInterface
```

Add a model. The first parameter is the model while the second one is the alias for the model.

```php
<?php

$builder->addFrom(
    Customers::class
);

$builder->addFrom(
    Customers::class,
    "c"
);
```

```php
public function andHaving(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Appends a condition to the current `HAVING` conditions clause using an `AND` operator. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->andHaving("SUM(Invoices.inv_total) > 1000");

$builder->andHaving(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

```php
public function andWhere(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Appends a condition to the current `WHERE` conditions clause using an `AND` operator. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->andWhere("SUM(Invoices.inv_total) > 1000");

$builder->andWhere(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

```php
public function betweenHaving(
    string $expr, 
    mixed $minimum, 
    mixed $maximum, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `BETWEEN` condition to the current `HAVING` conditions clause. The method accepts the expression, minimum and maximum as well as the operator for the `BETWEEN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->betweenHaving(
    "SUM(Invoices.inv_total)",
    1000,
    5000
);
```

```php
public function betweenWhere(
    string $expr, 
    mixed $minimum, 
    mixed $maximum, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `BETWEEN` condition to the current `WHERE` conditions clause. The method accepts the expression, minimum and maximum as well as the operator for the `BETWEEN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->betweenWhere(
    "Invoices.inv_total",
    1000,
    5000
);
```

```php
public function columns(mixed $columns): BuilderInterface
```

Sets the columns to be queried. The method accepts either a `string` or an `array`. If you specify an array with specific `keys`, they will be used as aliases for the relevant columns.

```php
<?php

// SELECT inv_id, inv_title
$builder->columns("inv_id, inv_title");

// SELECT inv_id, inv_title
$builder->columns(
    [
        "inv_id",
        "inv_title",
    ]
);

// SELECT inv_cst_id, inv_total
$builder->columns(
    [
        "inv_cst_id",
        "inv_total" => "SUM(inv_total)",
    ]
);
```

```php
public function distinct(mixed $distinct): BuilderInterface
```

Sets `SELECT DISTINCT` / `SELECT ALL` flag

```php
<?php

$builder->distinct("status");
$builder->distinct(null);
```

```php
public function forUpdate(bool $forUpdate): BuilderInterface
```

Sets a `FOR UPDATE` clause

```php
<?php

$builder->forUpdate(true);
```

```php
public function from(mixed $models): BuilderInterface
```

Sets the models for the query. The method accepts either a `string` or an `array`. If you specify an array with specific `keys`, they will be used as aliases for the relevant models.

```php
<?php

$builder->from(
    Invoices::class
);

$builder->from(
    [
        Invoices::class,
        Customers::class,
    ]
);

$builder->from(
    [
        'i' => Invoices::class,
        'c' => Customers::class,
    ]
);
```

```php
public function groupBy(mixed $group): BuilderInterface
```

Adds a `GROUP BY` condition to the builder.

```php
<?php

$builder->groupBy(
    [
        "Invoices.inv_cst_id",
    ]
);
```

```php
public function having(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Sets the `HAVING` condition clause. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->having("SUM(Invoices.inv_total) > 1000");

$builder->having(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

```php
public function inHaving(
    string $expr, 
    array $values, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `IN` condition to the current `HAVING` conditions clause. The method accepts the expression, an array with the `IN` values as well as the operator for the `IN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->inHaving(
    "SUM(Invoices.inv_total)",
    [
        1000,
        5000,
    ]
);
```

```php
public function innerJoin(
    string $model, 
    string $conditions = null, 
    string $alias = null
): BuilderInterface
```

Adds an `INNER` join to the query. The first parameter is the model. The join conditions are automatically calculated, if the relevant relationships have been properly set in the respective models. However you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

```php
<?php

$builder->innerJoin(
    Customers::class
);

$builder->innerJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id"
);

$builder->innerJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id",
    "c"
);
```

```php
public function inWhere(
    string $expr, 
    array $values,  
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends an `IN` condition to the current `WHERE` conditions clause. The method accepts the expression, an array with the values for the `IN` clause as well as the operator for the `IN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->inWhere(
    "Invoices.inv_id",
    [1, 3, 5]
);
```

```php
public function join(
    string $model, 
    string $conditions = null, 
    string $alias = null, 
    string $type = null
): BuilderInterface
```

Adds a join to the query. The first parameter is the model. The join conditions are automatically calculated, if the relevant relationships have been properly set in the respective models. However you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias. The last parameter defines the `type` of the join. By default the join is `INNER`. Acceptable values are: `INNER`, `LEFT` and `RIGHT`.

```php
<?php

$builder->join(
    Customers::class
);

$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id"
);

$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id",
    "c"
);

$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id",
    "c",
    "INNER"
);
```

```php
public function leftJoin(
    string $model, 
    string $conditions = null, 
    string $alias = null
): BuilderInterface
```

Adds a `LEFT` join to the query. The first parameter is the model. The join conditions are automatically calculated, if the relevant relationships have been properly set in the respective models. However you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

```php
<?php

$builder->leftJoin(
    Customers::class
);

$builder->leftJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id"
);

$builder->leftJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id",
    "c"
);
```

```php
public function limit(
    int $limit, 
    mixed $offset = null
): BuilderInterface
```

Sets a `LIMIT` clause, optionally an offset clause as the second parameter

```php
<?php

$builder->limit(100);
$builder->limit(100, 20);
$builder->limit("100", "20");
```

```php
public function notBetweenHaving(
    string $expr, 
    mixed $minimum, 
    mixed $maximum, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `NOT BETWEEN` condition to the current `HAVING` conditions clause. The method accepts the expression, minimum and maximum as well as the operator for the `NOT BETWEEN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->notBetweenHaving(
    "SUM(Invoices.inv_total)",
    1000,
    5000
);
```

```php
public function notBetweenWhere(
    string $expr, 
    mixed $minimum, 
    mixed $maximum, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `NOT BETWEEN` condition to the current `WHERE` conditions clause. The method accepts the expression, minimum and maximum as well as the operator for the `NOT BETWEEN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->notBetweenWhere(
    "Invoices.inv_total",
    1000,
    5000
);
```

```php
public function notInHaving(
    string $expr, 
    array $values, 
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends a `NOT IN` condition to the current `HAVING` conditions clause. The method accepts the expression, an array with the `IN` values as well as the operator for the `NOT IN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->notInHaving(
    "SUM(Invoices.inv_total)",
    [
        1000,
        5000,
    ]
);
```

```php
public function notInWhere(
    string $expr, 
    array $values,  
    string $operator = BuilderInterface::OPERATOR_AND
): BuilderInterface
```

Appends an `NOT IN` condition to the current `WHERE` conditions clause. The method accepts the expression, an array with the values for the `IN` clause as well as the operator for the `NOT IN` (`OPERATOR_AND` or `OPERATOR_OR`)

```php
<?php

$builder->notInWhere(
    "Invoices.inv_id",
    [1, 3, 5]
);
```

```php
public function offset(int $offset): BuilderInterface
```

Sets an `OFFSET` clause

```php
<?php

$builder->offset(30);
```

```php
public function orderBy(mixed $orderBy): BuilderInterface
```

Sets an `ORDER BY` condition clause. The parameter can be a string or an array. You can also suffix each column with `ASC` or `DESC` to define the order direction.

```php
<?php

$builder->orderBy("Invoices.inv_total");

$builder->orderBy(
    [
        "Invoices.inv_total",
    ]
);

$builder->orderBy(
    [
        "Invoices.inv_total DESC",
    ]
);
```

```php
public function orHaving(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Appends a condition to the current `HAVING` condition clause using an `OR` operator. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->orHaving("SUM(Invoices.inv_total) > 1000");

$builder->orHaving(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

```php
public function orWhere(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Appends a condition to the current `WHERE` condition clause using an `OR` operator. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->orWhere("SUM(Invoices.inv_total) > 1000");

$builder->orWhere(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

```php
public function rightJoin(
    string $model, 
    string $conditions = null, 
    string $alias = null
): BuilderInterface
```

Adds a `RIGHT` join to the query. The first parameter is the model. The join conditions are automatically calculated, if the relevant relationships have been properly set in the respective models. However you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

```php
<?php

$builder->rightJoin(
    Customers::class
);

$builder->rightJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id"
);

$builder->rightJoin(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id",
    "c"
);
```

```php
public function setBindParams(
    array $bindParams, 
    bool $merge = false
): BuilderInterface
```

Set default bind parameters. The first parameter is an array, where the key is the bound parameter name or number. The second parameter is a boolean, instructing the component to merge the supplied parameters to the existing stack or not.

```php
<?php

$builder->setBindParams(
    [
        "sum" => 1000,
    ]
);

$builder->setBindParams(
    [
        "cst_id" => 10,
    ],
    true
);

$builder->where(
    "SUM(Invoices.inv_total) > :sum: AND inv_cst_id > :cst_id:",
    [
        "sum"    => PDO::PARAM_INT,
        "cst_id" => PDO::PARAM_INT,
    ]
);
```

```php
public function setBindTypes(
    array bindTypes, 
    bool $merge = false
): BuilderInterface
```

Set default bind types. The first parameter is an array, where the key is the bound parameter name or number. The second parameter is a boolean, instructing the component to merge the supplied parameters to the existing stack or not. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->setBindParams(
    [
        "sum" => 1000,
    ]
);

$builder->setBindParams(
    [
        "cst_id" => 10,
    ],
    true
);

$builder->setBindTypes(
    [
        "sum" => PDO::PARAM_INT,
    ]
);

$builder->setBindTypes(
    [
        "cst_id" => PDO::PARAM_INT,
    ],
    true
);

$builder->where(
    "SUM(Invoices.inv_total) > :sum: AND inv_cst_id > :cst_id:"
);
```

```php
public function where(
    mixed $conditions, 
    array $bindParams = [], 
    array $bindTypes = []
): BuilderInterface
```

Sets the `WHERE` condition clause. The first parameter is the expression. The second parameter is an array with the bound parameter name as the key. The last parameter is an array that defines the bound type for each parameter. The bound types are [PDO constants](https://www.php.net/manual/en/pdo.constants.php).

```php
<?php

$builder->where("SUM(Invoices.inv_total) > 1000");

$builder->where(
    "SUM(Invoices.inv_total) > :sum:",
    [
        "sum" => 1000,
    ],
    [
        "sum" => PDO::PARAM_INT,
    ]
);
```

### Examples

```php
<?php

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices
$builder->from(Invoices::class);

// SELECT 
//      Invoices*, 
//      Customers.* 
// FROM 
//      Invoices, 
//      Customers
$builder->from(
    [
        Invoices::class,
        Customers::class,
    ]
);

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices
$builder
    ->columns('*')
    ->from(Invoices::class)
;

// SELECT 
//      Invoices.inv_id 
// FROM 
//      Invoices
$builder
    ->columns('inv_id')
    ->from(Invoices::class)
;

// SELECT 
//      Invoices.inv_id, 
//      Invoices.inv_title 
// FROM 
//      Invoices
$builder
    ->columns(
        [
            'inv_id', 
            'inv_title',
        ]
    )
    ->from(Invoices::class)
;

// SELECT 
//      Invoices.inv_id, 
//      Invoices.title_alias 
// FROM 
//      Invoices
$builder
    ->columns(
        [
            'inv_id', 
            'title_alias' => 'inv_title',
        ]
    )
    ->from(Invoices::class)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      Invoices.inv_cst_id = 1
$builder
    ->from(Invoices::class)
    ->where("Invoices.inv_cst_id = 1")
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      Invoices.inv_id = 1
$builder
    ->from(Invoices::class)
    ->where(1)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      Invoices.inv_cst_id = 1
// AND 
//      Invoices.inv_total > 1000
$builder
    ->from(Invoices::class)
    ->where("inv_cst_id = 1")
    ->andWhere('inv_total > 1000')
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      Invoices.inv_cst_id = 1
// OR 
//      Invoices.inv_total > 1000
$builder
    ->from(Invoices::class)
    ->where("inv_cst_id = 1")
    ->orWhere('inv_total > 1000')
;


// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// GROUP BY 
//      Invoices.inv_cst_id
$builder
    ->from(Invoices::class)
    ->groupBy('Invoices.inv_cst_id')
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// GROUP BY 
//      Invoices.inv_cst_id,
//      Invoices.inv_status_flag
$builder
    ->from(Invoices::class)
    ->groupBy(
        [
            'Invoices.inv_cst_id',
            'Invoices.inv_status_flag',
        ]
    )
;

// SELECT 
//      Invoices.inv_title, 
//      SUM(Invoices.inv_total) AS total
// FROM 
//      Invoices 
// GROUP BY 
//      Invoices.inv_cst_id
$builder
    ->columns(
        [
            'Invoices.inv_title', 
            'total' => 'SUM(Invoices.inv_total)'
        ]
    )
    ->from(Invoices::class)
    ->groupBy('Invoices.inv_cst_id')
;

// SELECT 
//      Invoices.inv_title, 
//      SUM(Invoices.inv_total) AS total
// FROM 
//      Invoices 
// GROUP BY 
//      Invoices.inv_cst_id
// HAVING
//      Invoices.inv_total > 1000
$builder
    ->columns(
        [
            'Invoices.inv_title', 
            'total' => 'SUM(Invoices.inv_total)'
        ]
    )
    ->from(Invoices::class)
    ->groupBy('Invoices.inv_cst_id')
    ->having('SUM(Invoices.inv_total) > 1000')
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// JOIN 
//      Customers
$builder
    ->from(Invoices::class)
    ->join(Customers::class)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// JOIN 
//      Customers AS c
$builder
    ->from(Invoices::class)
    ->join(Customers::class, null, 'c')
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices AS i
// JOIN 
//      Customers AS c
// ON
//      i.inv_cst_id = c.cst_id
$builder
    ->from(Invoices::class, 'i')
    ->join(
        Customers::class, 
        'i.inv_cst_id = c.cst_id', 
        'c'
    )
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices AS i
// JOIN 
//      InvoicesXProducts AS x
// ON
//      i.inv_id = x.ixp_inv_id
// JOIN 
//      Products AS prd
// ON
//      x.ixp_prd_id = p.prd_id
$builder
    ->addFrom(Invoices::class, 'i')
    ->join(
        InvoicesXProducts::class, 
        'i.inv_id = x.ixp_inv_id', 
        'x'
    )
    ->join(
        Products::class, 
        'x.ixp_prd_id = p.prd_id', 
        'p'
    )
;

// SELECT 
//      Invoices.*, 
//      c.* 
// FROM 
//      Invoices, 
//      Customers AS c
$builder
    ->from(Invoices::class)
    ->addFrom(Customers::class, 'c')
;

// SELECT 
//      i.*, 
//      c.* 
// FROM 
//      Invoices AS i, 
//      Customers AS c
$builder
    ->from(
        [
            'i' => Invoices::class,
            'c' => Customers::class,
        ]
    )
;


// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// LIMIT 
//      10
$builder
    ->from(Invoices::class)
    ->limit(10)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// LIMIT 
//      10
// OFFSET
//      5
$builder
    ->from(Invoices::class)
    ->limit(10, 5)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      inv_id 
// BETWEEN 
//      1 
// AND 
//      100
$builder
    ->from(Invoices::class)
    ->betweenWhere('inv_id', 1, 100)
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      inv_id 
// IN 
//      (1, 2, 3)
$builder
    ->from(Invoices::class)
    ->inWhere(
        'inv_id', 
        [1, 2, 3]
    )
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      inv_id 
// NOT IN 
//      (1, 2, 3)
$builder
    ->from(Invoices::class)
    ->notInWhere(
        'inv_id', 
        [1, 2, 3]
    )
;

// SELECT 
//      Invoices.* 
// FROM 
//      Invoices 
// WHERE 
//      inv_title 
// LIKE 
//      '%ACME%';
$title = 'ACME';
$builder
    ->from(Invoices::class)
    ->where(
        'inv_title LIKE :title:', 
        [
            'title' => '%' . $title . '%',
        ]
    )
;
```

### Bound Parameters

Bound parameters in the query builder can be set as the query is built or when it is being executed:

```php
<?php

$invoices = $this
    ->modelsManager
    ->createBuilder()
    ->from(Invoices::class)
    ->where(
        'inv_cst_id = :cst_id:', 
        [
            'cst_id' => 1,
        ]
    )
    ->andWhere(
        'inv_total = :total:', 
        [
            'total' => 1000,
        ]
    )
    ->getQuery()
    ->execute();

$invoices = $this
    ->modelsManager
    ->createBuilder()
    ->from(Invoices::class)
    ->where('inv_cst_id = :cst_id:')
    ->andWhere('inv_total = :total:')
    ->getQuery()
    ->execute(
        [
            'cst_id' => 1,
            'total'  => 1000,
        ]
    )
;
```

## Disable Literals in PHQL

Literals can be disabled in PHQL. This means that you will not be able to use strings, numbers or boolean values in PHQL. You will have to use bound parameters instead.

> **NOTE**: Disabling literals increases the security of your database statements and reduces the possibility of SQL injections.
{: .alert .alert-info }

> 
> **NOTE**: This setting can be set globally for all models. Please refer to the [models](db-models) document for a how to and additional settings.
{: .alert .alert-info }

The following query could potentially lead to a SQL injection:

```php
<?php

$login  = 'admin';
$phql   = "SELECT * FROM Users WHERE login = '$login'";
$result = $manager->executeQuery($phql);
```

If `$login` is changed to `' OR '' = '`, the produced PHQL is:

```sql
SELECT * FROM Users WHERE login = '' OR '' = ''
```

Which is always `true` no matter what the login stored in the database is. If literals are disabled, using strings, numbers or booleans in PHQL strings will cause an exception to be thrown, forcing the developer to use bound parameters. The same query can be written more securely as:

```php
<?php

$login  = 'admin';
$phql   = "SELECT * FROM Users WHERE login = :login:";
$result = $manager->executeQuery(
    $phql,
    [
        'login' => $login,
    ]
);
```

You can disallow literals as follows:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'phqlLiterals' => false
    ]
);
```

You can (and should) use bound parameters whether literals are disabled or not.

## Reserved Words

PHQL uses some reserved words internally. If you want to use any of them as attributes or model names, you will need to escape them using the cross-database escaping delimiters `[` and `]`:

```php
<?php

$phql   = 'SELECT * FROM [Update]';
$result = $manager->executeQuery($phql);

$phql   = 'SELECT id, [Like] FROM Posts';
$result = $manager->executeQuery($phql);
```

The delimiters are dynamically translated to valid delimiters depending on the database system where the application connecting to.

## Custom Dialect

Due to differences in SQL dialects based on the RDBMS of your choice, not all methods are supported. However you can extend the dialect, so that you can use additional functions that your RDBMS supports.

For the example below, we are using the `MATCH_AGAINST` method for MySQL.

```php
<?php

use Phalcon\Db\Dialect\MySQL as Dialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new Dialect();
$dialect->registerCustomFunction(
    'MATCH_AGAINST',
    function ($dialect, $expression) {
        $arguments = $expression['arguments'];
        return sprintf(
            " MATCH (%s) AGAINST (%)",
            $dialect->getSqlExpression($arguments[0]),
            $dialect->getSqlExpression($arguments[1])
         );
    }
);

$connection = new Connection(
    [
        "host"          => "localhost",
        "username"      => "root",
        "password"      => "secret",
        "dbname"        => "phalcon",
        "dialectClass"  => $dialect
    ]
);
```

Now you can use this function in PHQL and it internally translates to the correct SQL using the custom function:

```php
<br />$phql = "SELECT *
   FROM Invoices
   WHERE MATCH_AGAINST(inv_title, :pattern:)";

$invoices = $modelsManager
    ->executeQuery(
        $phql, 
        [
            'pattern' => $pattern
        ]
    )
;
```

Another example showcasing `GROUP_CONCAT`:

```php
<?php

use Phalcon\Db\Dialect\MySQL as Dialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new Dialect();
$dialect->registerCustomFunction(
    'MATCH_AGAINST',
    function ($dialect, $expression) {
        $arguments = $expression['arguments'];
        if (true !== empty($arguments[2])) {
            return sprintf(
                " GROUP_CONCAT(DISTINCT %s SEPARATOR %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
            );
        }

        if (true !== empty($arguments[1])) {
            return sprintf(
                " GROUP_CONCAT(%s SEPARATOR %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
            );
        }

        return sprintf(
            " GROUP_CONCAT(%s)",
            $dialect->getSqlExpression($arguments[0])
        );
    }
);

$connection = new Connection(
    [
        "host"          => "localhost",
        "username"      => "root",
        "password"      => "secret",
        "dbname"        => "phalcon",
        "dialectClass"  => $dialect
    ]
);
```

Now you can use this function in PHQL and it internally translates to the correct SQL using the custom function:

```php
<br />$phql = "SELECT *
   FROM Invoices
   WHERE GROUP_CONCAT(inv_title, :first:, :separator:, :distinct:)";

$invoices = $modelsManager
    ->executeQuery(
        $phql, 
        [
            'pattern'   => $pattern,
            'separator' => $separator,
            'distinct'  => $distinct,
        ]
    )
;
```

The above will create a `GROUP_CONCAT` based on the parameters passed to the method. If three parameters passed we will have a `GROUP_CONCAT` with a `DISTINCT` and `SEPARATOR`, if two parameters passed we will have a `GROUP_CONCAT` with `SEPARATOR` and if only one parameter passed just a `GROUP_CONCAT`

## Caching

PHQL queries can be cached. You can also check the [Models Caching](db-models-cache) document for more information.

```php
<?php

$phql  = 'SELECT * FROM Customers WHERE cst_id = :cst_id:';
$query = $this
    ->modelsManager
    ->createQuery($phql)
;

$query->cache(
    [
        'key'      => 'customers-1',
        'lifetime' => 300,
    ]
);

$invoice = $query->execute(
    [
        'cst_id' => 1,
    ]
);
```

## Lifecycle

Being a high-level language, PHQL gives developers the ability to personalize and customize different aspects in order to suit their needs. The following is the life cycle of each PHQL statement executed:

* The PHQL is parsed and converted into an Intermediate Representation (IR) which is independent of the SQL implemented by database system
* The IR is converted to valid SQL according to the database system associated to the model
* PHQL statements are parsed once and cached in memory. Further executions of the same statement result in a slightly faster execution

## Raw SQL

A database system could offer specific SQL extensions that are not supported by PHQL, in this case, a raw SQL can be appropriate:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Invoices extends Model
{
    public static function findByCreateInterval()
    {
        $sql     = 'SELECT * FROM Invoices WHERE inv_id > 1';
        $invoice = new Invoices();

        // Execute the query
        return new Resultset(
            null,
            $invoice,
            $invoice->getReadConnection()->query($sql)
        );
    }
}
```

If raw SQL queries are common in your application a generic method could be added to your model:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Invoices extends Model
{
    public static function findByRawSql(
        string $conditions, 
        array $params = null
    ) {
        $sql     = 'SELECT * FROM Invoices WHERE ' . $conditions;
        $invoice = new Invoices();

        // Execute the query
        return new Resultset(
            null,
            $invoice,
            $invoice->getReadConnection()->query($sql, $params)
        );
    }
}
```

The above `findByRawSql` could be used as follows:

```php
<?php

$robots = Invoices::findByRawSql(
    'id > ?0',
    [
        10
    ]
);
```

## Troubleshooting

Some things to keep in mind when using PHQL:

* Classes are case-sensitive, if a class is not defined with the same name as it was created this could lead to an unexpected behavior in operating systems with case sensitive file systems such as Linux.
* The correct charset must be defined in the connection to bind parameters successfully.
* Aliased classes are not replaced by full namespaced classes since this only occurs in PHP code and not inside strings.
* If column renaming is enabled avoid, using column aliases with the same name as columns to be renamed, this may confuse the query resolver.