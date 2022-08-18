---
layout: default
language: 'es-es'
version: '5.0'
title: 'Lenguaje de consulta de Phalcon (PHQL)'
keywords: 'phql, lenguaje consulta phalcon, lenguaje consulta'
---

# Lenguaje de consulta de Phalcon (PHQL)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Phalcon Query Language, PhalconQL o simplemente PHQL es un dialecto SQL de alto nivel, orientado a objetos, que le permite escribir consultas usando un lenguaje estándar como SQL. PHQL está implementado como un analizador (escrito en C) que traduce la sintaxis en la del RDBMS destino.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as [SQLite][sqlite]. Esta tecnología proporciona un analizador pequeño en memoria con una huella en memoria muy baja que también es segura en hilos.

The parser first checks the syntax of the PHQL statement to be parsed, then builds an intermediate representation of the statement, and finally it converts it to the respective SQL dialect of the target RDBMS.

En PHQL, hemos implementado un conjunto de características para hacer más seguro su acceso a las base de datos:

* Los parámetros enlazados son parte del lenguaje PHQL que lo ayudará a proteger su código
* PHQL sólo permite una sentencia SQL para ser ejecutada por llamada, previniendo de inyecciones
* PHQL ignora todos los comentarios SQL que generalmente se utilizan en las inyecciones SQL
* PHQL sólo permite declaraciones de manipulación de datos, evitando alterar o borrar tablas y bases de datos por error o desde el exterior sin autorización
* PHQL implementa una abstracción de alto nivel que permite manejar tablas como modelos y campos como atributos de clase

Para explicar mejor como funciona PHQL, vamos a usar dos modelos en este artículo `Invoices` y `Customers`:

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

Y cada Cliente tiene una o más facturas:

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

## Consulta
PHQL queries can be created just by instantiating the class [Phalcon\Mvc\Model\Query][mvc-model-query]:

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

The [Phalcon\Mvc\Model\Query][mvc-model-query] requires the second parameter of the constructor to be the DI container. When calling the above code from a controller or any class that extends the [Phalcon\Di\Injectable][di-injectable], you can use:

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

## Gestor de Modelos
We can also utilize the [Phalcon\Mvc\Model\Manager][mvc-model-manager] which is injected in the DI container:

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

Usando parámetros enlazados:

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

También puede omitir la creación de la consulta y luego ejecutarla y en su lugar ejecutar la consulta directamente desde el objeto Gestor de Modelos:

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

Usando parámetros enlazados:

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
Como el familiar SQL, PHQL permite seleccionar registros usando la sentencia `SELECT`, excepto que en lugar de especificar tablas, usamos las clases del modelo:

**Modelos**

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

**Modelos con espacio de nombres**

```sql
SELECT 
    * 
FROM   
    MyApp\Models\Invoices
ORDER BY 
    MyApp\Models\Invoices.inv_title'
```

**Alias**

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

**Alias en Espacios de Nombres**

Puede definir alias en espacio de nombres para hacer su código un poco más legible. Esto se configura cuando registra el `modelsManager` en su contenedor DI:

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

y ahora nuestra consulta se puede escribir como:

```sql
SELECT 
    i.inv_id 
FROM   
    inv:Invoices i
WHERE  
    i.inv_status_flag = 1  
```

The above _shortens_ the whole namespace for the model, replacing it with an alias.

**Subconsultas**

PHQL también soporta subconsultas. La sintaxis es similar a la ofrecida por PDO.


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

### Resultados
Dependiendo de las columnas que consultemos así como las tablas, los tipos de resultados variarán.

If you retrieve all the columns from a single table, you will get back a fully functional [Phalcon\Mvc\Model\Resultset\Simple][mvc-model-resultset-simple] object back. The object returned is a _complete_ and can be modified and re-saved in the database because they represent a complete record of the associated table.

Los siguientes ejemplos devuelven resultados idénticos:

**Modelo**

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

Any queries that use specific columns do not return _complete_ objects, and therefore database operations cannot be performed on them. Sin embargo, son mucho más pequeños que sus contrapartes completas y ofrecen micro optimizaciones en su código.

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

The returned result is a [Phalcon\Mvc\Model\Resultset\Simple][mvc-model-resultset-simple] object. Sin embargo, cada elemento es un objeto estándar que sólo contiene las dos columnas que fueron solicitadas.

Estos valores que no representan objetos completos son lo que llamamos escalares. PHQL permite consultar todos los tipos de escalares: campos, funciones, literales, expresiones, etc..:

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

Podemos consultar objetos completos o escalares, por lo tanto también podemos consultar ambos a la vez:

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

The result in this case is a [Phalcon\Mvc\Model\Resultset\Complex][mvc-model-resultset-complex] object. Esto permite el acceso a objetos completos y escalares a la vez:

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

Los escalares se mapean como propiedades de cada 'fila', mientras que los objetos completos se mapean como propiedades con el nombre de su modelo relacionado. En el ejemplo anterior, el escalar `status` se accede directamente desde el modelo, mientras que la fila de la base de datos se accede por la propiedad `invoices`, que es el mismo nombre que el nombre del modelo.

If you mix `*` selections from one model with columns from another, you will end up with both scalars and objects.

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

Lo anterior producirá:

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

Otro ejemplo:

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

Lo anterior producirá:

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

Note that we are selecting one column from the `Customers` model, and we need to alias it (`name_last`) so that it becomes a scalar in our resultset.

### Uniones (Joins)
Es fácil solicitar registros desde múltiples modelos usando PHQL. Se soportan la mayoría de tipos de uniones. Como definimos las relaciones en los modelos, PHQL añade estas condiciones automáticamente:

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
> 
> {: .alert .alert-info }

Puede especificar los siguientes tipos de uniones en su consulta:

- `CROSS JOIN`
- `LEFT JOIN`
- `LEFT OUTER JOIN`
- `INNER JOIN`
- `JOIN`
- `RIGHT JOIN`
- `RIGHT OUTER JOIN`

El analizador PHQL automáticamente resolverá las condiciones de la operación `JOIN`, en función de las relaciones configuradas en el `initialize()` de cada modelo. Estas son llamadas a `hasMany`, `hasOne`, `belongsTo` etc.

Sin embargo, es posible configurar manualmente las condiciones del `JOIN`:

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

Also, the joins can be created using multiple tables in the `FROM` clause, using the alternative _join_ syntax:

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

Si se usan alias en los modelos, entonces el conjunto de resultados usarán esos alias para nombrar los atributos de cada fila del resultado:

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

Cuando el modelo unido tiene una relación muchos-a-muchos con el modelo `from`, el modelo intermedio se añade implícitamente a la consulta generada. Para este ejemplo tenemos los modelos `Invoices`, `InvoicesXProducts` y `Products`:

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

Este código ejecuta el siguiente SQL en MySQL:

```sql
SELECT 
    co_invoices.inv_id, 
    co_invoices.inv_title, 
    co_products.prd_id,
    co_products.prd_title 
FROM 
    co_invoices
JOIN
    co_invoices_x_products 
ON 
    co_invoices.inv_id = co_invoices_x_products.ixp_inv_id
JOIN
    co_products 
ON 
    co_invoices_x_products.ixp_prd_id = co_products.prd_id
WHERE
    co_invoices.inv_id = 1
ORDER BY
    co_products.prd_name
```

### Agregaciones
Los siguientes ejemplos muestran como usar agregaciones en PHQL:

**Average**

¿Cuál es la cantidad promedio de facturas para un cliente con `inv_cst_id = 1`?

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

**Contar**

¿Cuántas facturas tiene cada cliente?

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

¿Cuántas facturas tiene cada cliente?

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

¿Cuál es la cantidad máxima de facturas para un cliente con `inv_cst_id = 1`?

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

¿Cuál es la cantidad mínima de facturas para un cliente con `inv_cst_id = 1`?

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

¿Cuál es la cantidad total de facturas para un cliente con `inv_cst_id = 1`?

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

### Condiciones
Las condiciones nos permiten filtrar el conjunto de registros que queremos consultar usando la palabra clave `WHERE`.

Selecciona un registro con una única comparación numérica:

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

Selecciona registros con un comparación numérica mayor que:

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

Selecciona registros con una única comparación de texto usando `TRIM`:

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

Selecciona registros usando la palabra clave `LIKE`:

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

Selecciona registros usando las palabras claves `NOT LIKE`:

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

Selecciona registros donde un campo es `NULL`:

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

Selecciona registros usando la palabra clave `IN`:

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

Selecciona registros usando las palabras claves `NOT IN`:

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

Selecciona registros usando la palabra clave `BETWEEN`:

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

### Parámetros

PHQL escapa automáticamente parámetros, introduciendo más seguridad:

Usando parámetros nombrados:

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

Usando índices numéricos:

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

## Insertar
Con PHQL es posible insertar datos usando la sentencia familiar `INSERT`:

Insertar datos sin columnas:

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

Inserting data with specific columns:

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

Insertar datos con marcadores de posición nombrados:

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

Insertar datos con marcadores de posición numéricos:

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

Phalcon no sólo transforma sentencias PHQL en SQL. Todos los eventos y reglas de negocio definidas en el modelo se ejecutan como si creáramos objetos individuales manualmente.

Si añadimos una regla de negocio en el evento `beforeCreate` para el modelo `Invoices`, se llamará el evento y se ejecutará nuestro código. Supongamos que añadimos una regla en la que una factura no puede tener un total negativo:

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

Si emitimos la siguiente sentencia `INSERT`:

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

Como intentamos insertar un número negativo para `inv_total` el `beforeCreate` se invoca antes de guardar el registro. Como resultado, la operación falla y se envían de vuelta los mensajes de error correspondientes.

## Actualizar
Actualizar filas usa las mismas reglas que insertar filas. Para esa operación usamos el comando `UPDATE`. Al igual que cuando insertamos filas, cuando un registro se actualiza los eventos relacionados con la operación de actualización se ejecutarán para cada fila.

Actualizar una columna

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

Actualizar múltiples columnas

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

Actualizando múltiples filas:

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

Actualizar datos con marcadores de posición nombrados:

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

Actualizar datos con marcadores de posición numéricos:

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

Una sentencia `UPDATE` realiza la actualización en dos fases:

* Si el `UPDATE` tiene una cláusula `WHERE` recupera todos los objetos que cumplen esos criterios,
* Basado en los objetos consultados, actualiza los atributos solicitados almacenándolos en la base de datos

Esta forma de operación permite que se ejecuten durante el proceso de actualización los eventos, claves ajenas virtuales y validaciones. En resumen, el código:

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

es equivalente a:

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

## Borrar datos
Similar a la actualización de registros, borrar registros usa las mismas reglas. Para esa operación usamos el comando `DELETE`. Cuando se borra un registro los eventos relacionados a la operación de borrado se ejecutarán para cada fila.

Borrar una fila

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

Borrar múltiples filas:

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

Borrar datos con marcadores de posición nombrados:

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

Borrar datos con marcadores de posición numéricos:

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

Una sentencia `DELETE` realiza el borrado en dos fases:

* Si el `DELETE` tiene una cláusula `WHERE` recupera todos los objetos que cumplen esos criterios,
* Basado en los objetos consultados, elimina los objetos solicitados de la base de datos relacional

Igual que el resto de operaciones, comprobar el código de estado devuelto le permite recuperar cualquier mensaje de validación devuelto por operaciones conectadas a sus modelos

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

## Constructor de Consultas
[Phalcon\Mvc\Model\Query\Builder][mvc-model-query-builder] is a very handy builder that allows you to construct PHQL statements in an object-oriented way. La mayoría de métodos devuelven el objeto constructor, permitiéndole usar una interfaz fluida y lo suficiente flexible para permitirle añadir condicionales si lo necesita, sin tener que crear sentencias `if` complejas y concatenaciones de cadenas al construir la sentencia PHQL.

La consulta PHQL:

```sql
SELECT 
    * 
FROM 
    Invoices 
ORDER BY 
    inv_title
```

se puede crear y ejecutar de la siguiente manera:

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

Para obtener una sola fila:

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

### Parámetros
Whether you create a [Phalcon\Mvc\Model\Query\Builder][mvc-model-query-builder] object directly or you are using the Models Manager's `createBuilder` method, you can always use the fluent interface to build your query or pass an array with parameters in the constructor. Las claves del vector son:

- `bind` - `array` - vector de datos a enlazar
- `bindTypes` - `array` - Tipos de parámetro PDO
- `container` - DI
- `columns` - `array | string` - columnas a seleccionar
- `conditions` - `array | string` - condiciones (where)
- `distinct` - `string` - distinguir columnas
- `for_update` - `bool` - para actualizar o no
- `group` - `array` - agrupar por columnas
- `having` - `string` - teniendo columnas
- `joins` - `array` - clases de modelos usadas en joins
- `limit` - `array | int` - límite para los registros (ej. `20` o `[20, 20]`)
- `models` - `array` - clases de modelos usadas
- `offset` - `int` - el desplazamiento
- `order` - `array | string` - columnas de orden
- `shared_lock` - `bool` - emite bloque compartido o no

```php
<?php

use PDO;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Di\FactoryDefault as Di;

/* DI is mandatory to use the Query Builder */
$di = new Di();

$params = [
    "container" => $di,
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

- `autoescape(string $identifier)` - `string` - Automáticamente escapa identificadores pero solo si necesitan ser escapados.
- `getBindParams(): array` - Devuelve los parámetros de enlace predeterminados
- `getBindTypes(): array` - Returns default [bind types][pdo-constants]
- `getColumns()` - `string | array` - Devuelve las columnas a consultar
- `getDistinct()` - `bool` - Devuelve la cláusula `SELECT DISTINCT` / `SELECT ALL`
- `getFrom()` - `string | array` - Devuelve los modelos para la consulta
- `getGroupBy()` - `array` - Devuelve la cláusula `GROUP BY`
- `getHaving()` - `string` - Devuelve la cláusula `HAVING`
- `getJoins()` - `array` - Devuelve las partes `JOIN` de la consulta
- `getLimit()` - `string | array` - Devuelve la cláusula `LIMIT` actual
- `getModels()` - `string | array | null` - Devuelve los modelos involucrados en la consulta
- `getOffset()` - `int` - Devuelve la cláusula `OFFSET` actual
- `getOrderBy()` - `string / array` - Devuelve la cláusula `ORDER BY`
- `getPhql()` - `string` - Devuelve la sentencia PHQL generada
- `getQuery()` - `QueryInterface` - Devuelve la consulta construida
- `getWhere()` - `string | array` - Devuelve las condiciones de la consulta

### Métodos

```php
public function addFrom(
    string $model, 
    string $alias = null
): BuilderInterface
```
Añade un modelo. El primer parámetro es el modelo mientras que el segundo es el alias para el modelo.

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
Añade una condición a la cláusula actual de condiciones `HAVING` usando un operador `AND`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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
Añade una condición a la cláusula actual de condiciones `WHERE` usando un operador `AND`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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
Añade una condición `BETWEEN` a la cláusula actual de condiciones `HAVING`. El método acepta la expresión, mínimo y máximo, así como el operador para el `BETWEEN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Añade una condición `BETWEEN` a la cláusula actual de condiciones `WHERE`. El método acepta la expresión, mínimo y máximo, así como el operador para el `BETWEEN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Establece las columnas a consultar. Este método acepta un `string` o un `array`. Si especifica un vector con `claves` específicas, se usarán como alias para las columnas relevantes.

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
Establece el indicador `SELECT DISTINCT` / `SELECT ALL`

```php
<?php

$builder->distinct("status");
$builder->distinct(null);
```

```php
public function forUpdate(bool $forUpdate): BuilderInterface
```
Establece una cláusula `FOR UPDATE`

```php
<?php

$builder->forUpdate(true);
```

```php
public function from(mixed $models): BuilderInterface
```
Establece los modelos para la consulta. Este método acepta un `string` o un `array`. Si especifica un vector con `claves` específicas, se usarán como alias para los modelos relevantes.

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
Añade una condición `GROUP BY` al constructor.

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
Establece la cláusula de condición `HAVING`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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
Añade una condición `IN` a la cláusula actual de condición `HAVING`. El método acepta la expresión, un vector con los valores del `IN` así como el operador para el `IN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Añade un `INNER` join a la consulta. El primer parámetro es el modelo. Las condiciones de unión se calculan automáticamente, si las relaciones relevantes se han configurado apropiadamente en los respectivos modelos. However, you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

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
    "Invoices.inv_cst_id = c.cst_id",
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
Añade una condición `IN` en la cláusula actual de condiciones `WHERE`. El método acepta la expresión, un vector con los valores para la cláusula `IN` así como el operador para el `IN` (`OPERATOR_AND` o `OPERATOR_OR`)

```php
<?php

$builder->inWhere(
    "Invoices.inv_id",
    [1, 3, 5]
);

//Using OPERATOR_OR:
$builder->inWhere(
    "Invoices.inv_id",
    [1, 3, 5],
    \Phalcon\Mvc\Model\Query\BuilderInterface::OPERATOR_OR
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

Añade un join a la consulta. El primer parámetro es el modelo. Las condiciones de unión se calculan automáticamente, si las relaciones relevantes se han configurado apropiadamente en los respectivos modelos. However, you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias. El último parámetro define el `tipo` del join. By default, the join is `INNER`. Los valores aceptables son: `INNER`, `LEFT` y `RIGHT`.

```php
<?php

$builder->join(
    Customers::class
);

$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = Customers.cst_id"
);

//If model `Invoices` has an alias, use it accordingly in the following two examples:
$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = c.cst_id",
    "c"
);

$builder->join(
    Customers::class,
    "Invoices.inv_cst_id = c.cst_id",
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
Añade un `LEFT` join a la consulta. El primer parámetro es el modelo. Las condiciones de unión se calculan automáticamente, si las relaciones relevantes se han configurado apropiadamente en los respectivos modelos. However, you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

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
    "Invoices.inv_cst_id = c.cst_id",
    "c"
);
```

```php
public function limit(
    int $limit, 
    mixed $offset = null
): BuilderInterface
```
Configura una cláusula `LIMIT`, y opcionalmente una cláusula de desplazamiento como segundo parámetro

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
Añade una condición `NOT BETWEEN` a la cláusula actual de condiciones `HAVING`. El método acepta la expresión, mínimo y máximo así como el operador para el `NOT BETWEEN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Añade una condición `NOT BETWEEN` a la cláusula actual de condiciones `WHERE`. El método acepta la expresión, mínimo y máximo así como el operador para el `NOT BETWEEN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Añade una condición `NOT IN` a la cláusula actual de condiciones `HAVING`. El método acepta la expresión, un vector con los valores del `IN` así como el operador para el `NOT IN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Añade una condición `NOT IN` a la cláusula actual de condiciones `WHERE`. El método acepta la expresión, un vector con los valores para la cláusula `IN` así como el operador para el `NOT IN` (`OPERATOR_AND` o `OPERATOR_OR`)

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
Configura una cláusula `OFFSET`

```php
<?php

$builder->offset(30);
```

```php
public function orderBy(mixed $orderBy): BuilderInterface
```
Configura una cláusula de condición `ORDER BY`. El parámetro puede ser una cadena o un vector. También puede añadir un sufijo en cada columna con `ASC` o `DESC` para definir la dirección del orden.

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
Añade una condición a la cláusula actual de condición `HAVING` usando un operador `OR`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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
Añade una condición a la cláusula actual de condición `WHERE` usando un operador `OR`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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
Añade un `RIGHT` join a la consulta. El primer parámetro es el modelo. Las condiciones de unión se calculan automáticamente, si las relaciones relevantes se han configurado apropiadamente en los respectivos modelos. However, you can set the conditions manually using the second parameter is the conditions, while the third one (if specified) is the alias.

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
    "Invoices.inv_cst_id = c.cst_id",
    "c"
);
```

```php
public function setBindParams(
    array $bindParams, 
    bool $merge = false
): BuilderInterface
```
Establece los parámetros de enlace predeterminados. El primer parámetro es un vector, donde la clave es el nombre o el número del parámetro de enlace. El segundo parámetro es un booleano, que indica al componente que combine los parámetros proporcionados con la pila existente o no.

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
Establece los tipos de enlace predeterminados. El primer parámetro es un vector, donde la clave es el nombre o el número del parámetro de enlace. El segundo parámetro es un booleano, que indica al componente que combine los parámetros proporcionados con la pila existente o no. The bound types are [PDO constants][pdo-constants].

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
Configura la cláusula de condición `WHERE`. El primer parámetro es la expresión. El segundo parámetro es un vector con el nombre de los parámetros enlazados como clave. El último parámetro es un vector que define el tipo enlazado para cada parámetro. The bound types are [PDO constants][pdo-constants].

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

### Ejemplos
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

### Parámetros Enlazados
Los parámetros enlazados, en el generador de consultas, se pueden establecer cuando se construye la consulta o cuando se van a ejecutar:

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

## Deshabilitar Literales en PHQL
Los literales se pueden deshabilitar en PHQL. Esto significa que no se podrán usar cadenas, números o valores booleanos en PHQL. Tendrá que usar parámetros enlazados en su lugar.

> **NOTE**: Disabling literals increases the security of your database statements and reduces the possibility of SQL injections. 
> 
> {: .alert .alert-info }

> **NOTE**: This setting can be set globally for all models. Please refer to the [models](db-models) document for a how-to and additional settings. 
> 
> {: .alert .alert-info }

La siguiente consulta podría conducir potencialmente a una inyección SQL:

```php
<?php

$login  = 'admin';
$phql   = "SELECT * FROM Users WHERE login = '$login'";
$result = $manager->executeQuery($phql);
```

Si se cambia `$login` a `' OR '' = '`, el PHQL producido es:

```sql
SELECT * FROM Users WHERE login = '' OR '' = ''
```

Que siempre es `true`, no importa qué login hay almacenado en la base de datos. Si se deshabilitan los literales, usar cadenas, números o booleanos en cadenas PHQL causará que se lance una excepción, forzando al desarrollador a usar parámetros enlazados. La misma consulta se puede escribir de forma más segura como:

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

Puede deshabilitar los literales de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'phqlLiterals' => false
    ]
);
```

Puede (y debe) usar parámetros enlazados tanto si se han deshabilitado los literales como si no.

## Palabras Reservadas
PHQL usa internamente algunas palabras reservadas. Si quiere usar alguna de ellas como atributos o nombres de modelo, necesitará escaparlas usando los delimitadores de escape compatibles con la base de datos `[` y `]`:

```php
<?php

$phql   = 'SELECT * FROM [Update]';
$result = $manager->executeQuery($phql);

$phql   = 'SELECT id, [Like] FROM Posts';
$result = $manager->executeQuery($phql);
```

Los delimitadores se traducen dinámicamente a delimitadores válidos dependiendo del sistema de base de datos al que se conecta la aplicación.

## Dialecto Personalizado
Debido a las diferencias en los dialectos SQL basados en el RDBMS de su elección, no se soportan todos los métodos. However, you can extend the dialect, so that you can use additional functions that your RDBMS supports.

Para el siguiente ejemplo, usamos el método `MATCH_AGAINST` para MySQL.

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
            " MATCH (%s) AGAINST (%s)",
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

Now you can use this function in PHQL, and it internally translates to the correct SQL using the custom function:

```php

$phql = "SELECT *
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

Otro ejemplo mostrando `GROUP_CONCAT`:

```php
<?php

use Phalcon\Db\Dialect\MySQL as Dialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new Dialect();
$dialect->registerCustomFunction(
    'GROUPCONCAT',
    function ($dialect, $expression) {
        $arguments = $expression['arguments'];
        if (true !== empty($arguments[2])) {
            return sprintf(
                " GROUP_CONCAT(DISTINCT %s ORDER BY %s SEPARATOR %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1]),
                $dialect->getSqlExpression($arguments[2]),
            );
        } elseif (true !== empty($arguments[1])) {
            return sprintf(
                " GROUP_CONCAT(%s SEPARATOR %s)",
                $dialect->getSqlExpression($arguments[0]),
                $dialect->getSqlExpression($arguments[1])
            );
        } else {
            return sprintf(
                " GROUP_CONCAT(%s)",
                $dialect->getSqlExpression($arguments[0])
            );
        }
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

Now you can use this function in PHQL, and it internally translates to the correct SQL using the custom function:

```php

$phql = "SELECT GROUPCONCAT(inv_title, inv_title, :separator:)
         FROM Invoices";

$invoices = $modelsManager
    ->executeQuery(
        $phql, 
        [
            'separator' => ", "
        ]
    )
;
```

Lo anterior creará un `GROUP_CONCAT` basado en los parámetros pasados al método. Si se pasan tres parámetros tendremos un `GROUP_CONCAT` con un `DISTINCT`, `ORDER BY` y `SEPARATOR`, si se pasan dos parámetros tendremos un `GROUP_CONCAT` con `SEPARATOR` y si sólo se pasa un parámetro sólo un `GROUP_CONCAT`

## Caché
Las consultas PHQL se pueden cachear. También puede consultar el documento [Caché de Modelos](db-models-cache) para más información.

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

## Ciclo de Vida
Al ser un lenguaje de alto nivel, PHQL da a los desarrolladores la habilidad de personalizar diferentes aspectos para satisfacer sus necesidades. Lo siguiente es el ciclo de vida de cada sentencia PHQL ejecutada:

* El PHQL se analiza y convierte a una Representación Intermedia (IR) que es independiente del SQL implementado por el sistema de base de datos
* El IR se convierte a un SQL válido según el sistema de base de datos asociado al modelo
* Las sentencias PHQL se analizan una vez y se cachean en memoria. Las ejecuciones posteriores de la misma sentencia resultan en una ejecución ligeramente más rápida

## SQL en Bruto
Un sistema de base de datos podría ofrecer extensiones SQL específicas que no se soportan por PHQL, en este caso, un SQL en bruto puede ser apropiado:

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

Si las consultas SQL en bruto son comunes en su aplicación, se podría añadir un método genérico a su modelo:

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

El anterior `findByRawSql` se podría usar de la siguiente manera:

```php
<?php

$robots = Invoices::findByRawSql(
    'id > ?0',
    [
        10
    ]
);
```

## Resolución de problemas
Algunas cosas a tener en cuenta al usar PHQL:

* Classes are case-sensitive, if a class is not defined with the same name as it was created this could lead to an unexpected behavior in operating systems with case-sensitive file systems such as Linux.
* Se debe definir en la conexión el conjunto de caracteres correcto para enlazar parámetros correctamente.
* Las clases con alias no se reemplazan por las clases con espacios de nombres completos, ya que esto solo ocurre en el código PHP y no dentro de cadenas.
* Si el renombrado de columnas está habilitado para evitar, usar alias de columnas con el mismo nombre que las columnas a renombrar, podría confundir al resolutor de consultas.

[di-injectable]: api/phalcon_di#di-injectable
[mvc-model-manager]: api/phalcon_mvc#mvc-model-manager
[mvc-model-query]: api/phalcon_mvc#mvc-model-query
[mvc-model-query-builder]: api/phalcon_mvc#mvc-model-query-builder
[mvc-model-resultset-complex]: api/phalcon_mvc#mvc-model-resultset-complex
[mvc-model-resultset-simple]: api/phalcon_mvc#mvc-model-resultset-simple
[pdo-constants]: https://www.php.net/manual/en/pdo.constants.php
[pdo-constants]: https://www.php.net/manual/en/pdo.constants.php
[sqlite]: https://en.wikipedia.org/wiki/Lemon_Parser_Generator
