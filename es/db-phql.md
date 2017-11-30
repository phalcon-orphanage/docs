<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Lenguaje de consulta de Phalcon (PHQL)</a> 
      <ul>
        <li>
          <a href="#usage">Ejemplo de Uso</a>
        </li>
        <li>
          <a href="#creating">Crear consultas PHQL</a>
        </li>
        <li>
          <a href="#selecting-records">Seleccionando registros</a> 
          <ul>
            <li>
              <a href="#result-types">Tipo de resultado</a>
            </li>
            <li>
              <a href="#joins">Uniones (Joins)</a>
            </li>
            <li>
              <a href="#aggregations">Agregaciones</a>
            </li>
            <li>
              <a href="#conditions">Condiciones</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#inserting-data">Insertando datos</a>
        </li>
        <li>
          <a href="#updating-data">Actualizando datos</a>
        </li>
        <li>
          <a href="#deleting-data">Borrando datos</a>
        </li>
        <li>
          <a href="#query-builder">Crear consultas utilizando el generador de consultas</a> 
          <ul>
            <li>
              <a href="#query-builder-parameters">Enlazando parámetros</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#disallow-literals">No permitir literales en PHQL</a>
        </li>
        <li>
          <a href="#escaping-reserved-words">Escapando palabras reservadas</a>
        </li>
        <li>
          <a href="#lifecycle">Ciclo de vida de PHQL</a>
        </li>
        <li>
          <a href="#raw-sql">Usando SQL crudo</a>
        </li>
        <li>
          <a href="#troubleshooting">Resolución de problemas</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Lenguaje de consulta de Phalcon (PHQL)

El lenguaje de consulta de Phalcon, PhalconQL o simplemente PHQL es un dialecto de SQL de alto nivel, orientado a objetos que permite escribir consultas utilizando un lenguaje estándar SQL. PHQL se implementa como un analizador (escrito en C) que traduce la sintaxis en la del RDBMS de destino.

Para lograr el mayor rendimiento posible, Phalcon proporciona un analizador que utiliza la misma tecnología como [SQLite](http://en.wikipedia.org/wiki/Lemon_Parser_Generator). Esta tecnología proporciona un pequeño analizador en memoria con un impacto en memoria muy bajo que también es seguro para subprocesos.

El analizador comprueba la sintaxis de la declaración de PHQL, luego construye una representación intermedia de la declaración y finalmente convierte en el dialecto SQL correspondiente del RDBMS de destino.

En PHQL, hemos implementado un conjunto de características para hacer más seguro el acceso a bases de datos:

* Los parámetros enlazados son parte del lenguaje PHQL que lo ayudara a proteger su código
* PHQL solo permite una sentencia SQL para ser ejecutada por llamada, previniendo de inyecciones
* PHQL ignora todos los comentarios SQL que generalmente se utilizan en las inyecciones SQL
* PHQL sólo permite declaraciones de manipulación de datos, evitando alterar o borrar tablas y bases de datos por error o desde el exterior sin autorización
* PHQL implementa una abstracción de alto nivel que permite manejar tablas como modelos y campos como atributos de clase

<a name='usage'></a>

## Ejemplo de Uso

Para explicar mejor cómo funciona PHQL consideren el ejemplo siguiente. Tenemos dos modelos `Cars` y `Brands`, osea automóviles y marcas respectivamente:

```php
<?php

use Phalcon\Mvc\Model;

class Cars extends Model
{
    public $id;

    public $name;

    public $brand_id;

    public $price;

    public $year;

    public $style;

    /**
     * Este modelo se completa desde la tabla sample_cars
     */
    public function getSource()
    {
        return 'sample_cars';
    }

    /**
     * Un automóvil tiene una sola marca, pero una marca tiene muchos automóviles
     */
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id');
    }
}
```

Y cada automóvil tiene una marca, por lo que una marca tiene muchos automóviles:

```php
<?php

use Phalcon\Mvc\Model;

class Brands extends Model
{
    public $id;

    public $name;

    /**
     * El modelo Brands se completa desde la tabla 'sample_brands'
     */
    public function getSource()
    {
        return 'sample_brands';
    }

    /**
     * Una marca tiene muchos automóviles
     */
    public function initialize()
    {
        $this->hasMany('id', 'Cars', 'brand_id');
    }
}
```

<a name='creating'></a>

## Crear consultas PHQL

Las consultas PHQL pueden crearse simplemente instanciando la clase `Phalcon\Mvc\Model\Query`:

```php
<?php

use Phalcon\Mvc\Model\Query;

// Instanciar a Query
$query = new Query(
    'SELECT * FROM Cars',
    $this->getDI()
);

// Ejecutar una consulta retornando un resultado si lo hay
$cars = $query->execute();
```

Desde una vista o un controlador, es muy fácil crear/ejecutar usando el servicio gestor de modelos o `modelManager` que esta inyectado (`Phalcon\Mvc\Model\Manager`):

```php
<?php

// Ejecutando una consulta simple
$query = $this->modelsManager->createQuery('SELECT * FROM Cars');
$cars  = $query->execute();

// Con parámetros enlazados
$query = $this->modelsManager->createQuery('SELECT * FROM Cars WHERE name = :name:');
$cars  = $query->execute(
    [
        'name' => 'Audi',
    ]
);
```

O simplemente ejecutar:

```php
<?php

// Ejecutando una simple consulta
$cars = $this->modelsManager->executeQuery(
    'SELECT * FROM Cars'
);

// Ejecutando con parámetros enlazados
$cars = $this->modelsManager->executeQuery(
    'SELECT * FROM Cars WHERE name = :name:',
    [
        'name' => 'Audi',
    ]
);
```

<a name='selecting-records'></a>

## Seleccionando registros

Tan familiar como en SQL, PHQL permite consultas de registros con la instrucción SELECT que ya conocemos, excepto que en vez de tablas, usamos las clases de los modelos:

```php
<?php

$query = $manager->createQuery(
    'SELECT * FROM Cars ORDER BY Cars.name'
);

$query = $manager->createQuery(
    'SELECT Cars.name FROM Cars ORDER BY Cars.name'
);
```

También se permiten clases en espacios de nombres:

```php
<?php

$phql  = 'SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name';
$query = $manager->createQuery($phql);

$phql  = 'SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name';
$query = $manager->createQuery($phql);

$phql  = 'SELECT c.name FROM Formula\Cars c ORDER BY c.name';
$query = $manager->createQuery($phql);
```

La mayor parte del estándar SQL es soportado por PHQL, incluso directivas no estandarizadas como `LIMIT`:

```php
<?php

$phql = 'SELECT c.name FROM Cars AS c WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100';

$query = $manager->createQuery($phql);
```

<a name='result-types'></a>

### Tipo de resultado

Dependiendo del tipo de columnas que estemos consultando, varía el tipo de resultado. Si se recupera un objeto entero, el objeto devuelto es un `Phalcon\Mvc\Model\Resultset\Simple`. Este tipo de conjunto de resultados es un conjunto de objetos de modelo completo:

```php
<?php

$phql = 'SELECT c.* FROM Cars AS c ORDER BY c.name';

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo 'Nombre: ', $car->name, "\n";
}
```

Esto es exactamente lo mismo que:

```php
<?php

$cars = Cars::find(
    [
        'order' => 'name'
    ]
);

foreach ($cars as $car) {
    echo 'Nombre: ', $car->name, "\n";
}
```

Los objetos completos pueden ser modificados y volverse a guardar en la base de datos debido a que representan un registro completo de la tabla asociada. Hay otros tipos de consultas que no devuelven objetos completos, por ejemplo:

```php
<?php

$phql = 'SELECT c.id, c.name FROM Cars AS c ORDER BY c.name';

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo 'Nombre: ', $car->name, "\n";
}
```

Sólo estamos solicitando algunos campos de la tabla, por lo tanto, aquellos no pueden considerarse un objeto completo, por lo que el objeto devuelto es todavía un resultset de tipo `Phalcon\Mvc\Model\Resultset\Simple`. Sin embargo, cada elemento es un objeto estándar que sólo contiene las dos columnas que fueron solicitadas.

Estos valores que no representan objetos completos son lo que llamamos escalares. PHQL le permite consultar todos los tipos de escalares: campos, funciones, literales, expresiones, etcétera..:

```php
<?php

$phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo $car->id_name, "\n";
}
```

Como podemos consultar objetos completos o escalares, también podemos consultar ambos a la vez:

```php
<?php

$phql = 'SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name';

$result = $manager->executeQuery($phql);
```

En este caso, el resultado es un objeto `Phalcon\Mvc\Model\Resultset\Complex`. Esto permite el acceso a objetos completos y escalares a la vez:

```php
<?php

foreach ($result as $row) {
    echo 'Nombre: ', $row->cars->name, "\n";
    echo 'Precio: ', $row->cars->price, "\n";
    echo 'Impuestos: ', $row->taxes, "\n";
}
```

Los escalares se asignan como propiedades de cada 'fila', mientras que objetos completos se asignan como propiedades con el nombre de su modelo relacionado.

<a name='joins'></a>

### Uniones (Joins)

Es fácil consultar registros de múltiples modelos con PHQL. La mayoría de los tipos de uniones son compatibles. Como definimos las relaciones en los modelos, PHQL agrega automáticamente estas condiciones:

```php
<?php

$phql = 'SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo $row->car_name, "\n";
    echo $row->brand_name, "\n";
}
```

Por defecto, se asume un INNER JOIN. Usted puede especificar el tipo de JOIN en la consulta:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars LEFT JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands';
$rows = $manager->executeQuery($phql);
```

También es posible ajustar manualmente las condiciones del JOIN:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id';

$rows = $manager->executeQuery($phql);
```

También, las uniones pueden crearse utilizando varias tablas en la cláusula FROM:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo 'Car: ', $row->cars->name, "\n";
    echo 'Brand: ', $row->brands->name, "\n";
}
```

If an alias is used to rename the models in the query, those will be used to name the attributes in the every row of the result:

```php
<?php

$phql = 'SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo 'Car: ', $row->c->name, "\n";
    echo 'Brand: ', $row->b->name, "\n";
}
```

When the joined model has a many-to-many relation to the `from` model, the intermediate model is implicitly added to the generated query:

```php
<?php

$phql = 'SELECT Artists.name, Songs.name FROM Artists ' .
        'JOIN Songs WHERE Artists.genre = "Trip-Hop"';

$result = $this->modelsManager->executeQuery($phql);
```

This code executes the following SQL in MySQL:

```sql
SELECT `artists`.`name`, `songs`.`name` FROM `artists`
INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
WHERE `artists`.`genre` = 'Trip-Hop'
```

<a name='aggregations'></a>

### Aggregations

The following examples show how to use aggregations in PHQL:

```php
<?php

// How much are the prices of all the cars?
$phql = 'SELECT SUM(price) AS summatory FROM Cars';
$row  = $manager->executeQuery($phql)->getFirst();
echo $row['summatory'];

// How many cars are by each brand?
$phql = 'SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brand_id, ' ', $row['1'], "\n";
}

// How many cars are by each brand?
$phql = 'SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->name, ' ', $row['1'], "\n";
}

$phql = 'SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row['maximum'], ' ', $row['minimum'], "\n";
}

// Count distinct used brands
$phql = 'SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brandId, "\n";
}
```

<a name='conditions'></a>

### Conditions

Conditions allow us to filter the set of records we want to query. The `WHERE` clause allows to do that:

```php
<?php

// Simple conditions
$phql = 'SELECT * FROM Cars WHERE Cars.name = "Lamborghini Espada"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.price > 10000';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE TRIM(Cars.name) = "Audi R8"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.name LIKE "Ferrari%"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.name NOT LIKE "Ferrari%"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.price IS NULL';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id IN (120, 121, 122)';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id NOT IN (430, 431)';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id BETWEEN 1 AND 100';
$cars = $manager->executeQuery($phql);
```

Also, as part of PHQL, prepared parameters automatically escape the input data, introducing more security:

```php
<?php

$phql = 'SELECT * FROM Cars WHERE Cars.name = :name:';
$cars = $manager->executeQuery(
    $phql,
    [
        'name' => 'Lamborghini Espada'
    ]
);

$phql = 'SELECT * FROM Cars WHERE Cars.name = ?0';
$cars = $manager->executeQuery(
    $phql,
    [
        0 => 'Lamborghini Espada'
    ]
);
```

<a name='inserting-data'></a>

## Inserting Data

With PHQL it's possible to insert data using the familiar INSERT statement:

```php
<?php

// Inserting without columns
$phql = 'INSERT INTO Cars VALUES (NULL, "Lamborghini Espada", '
      . '7, 10000.00, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Specifying columns to insert
$phql = 'INSERT INTO Cars (name, brand_id, year, style) '
      . 'VALUES ("Lamborghini Espada", 7, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Inserting using placeholders
$phql = 'INSERT INTO Cars (name, brand_id, year, style) '
      . 'VALUES (:name:, :brand_id:, :year:, :style)';
$manager->executeQuery(
    $phql,
    [
        'name'     => 'Lamborghini Espada',
        'brand_id' => 7,
        'year'     => 1969,
        'style'    => 'Grand Tourer',
    ]
);
```

Phalcon doesn't only transform the PHQL statements into SQL. All events and business rules defined in the model are executed as if we created individual objects manually. Let's add a business rule on the model cars. A car cannot cost less than $ 10,000:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Cars extends Model
{
    public function beforeCreate()
    {
        if ($this->price < 10000) {
            $this->appendMessage(
                new Message('A car cannot cost less than $ 10,000')
            );

            return false;
        }
    }
}
```

If we made the following `INSERT` in the models Cars, the operation will not be successful because the price does not meet the business rule that we implemented. By checking the status of the insertion we can print any validation messages generated internally:

```php
<?php

$phql = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2015, 'Sedan')";

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    foreach ($result->getMessages() as $message) {
        echo $message->getMessage();
    }
}
```

<a name='updating-data'></a>

## Updating Data

Updating rows is very similar than inserting rows. As you may know, the instruction to update records is UPDATE. When a record is updated the events related to the update operation will be executed for each row.

```php
<?php

// Updating a single column
$phql = 'UPDATE Cars SET price = 15000.00 WHERE id = 101';
$manager->executeQuery($phql);

// Updating multiples columns
$phql = 'UPDATE Cars SET price = 15000.00, type = "Sedan" WHERE id = 101';
$manager->executeQuery($phql);

// Updating multiples rows
$phql = 'UPDATE Cars SET price = 7000.00, type = "Sedan" WHERE brands_id > 5';
$manager->executeQuery($phql);

// Using placeholders
$phql = 'UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2';
$manager->executeQuery(
    $phql,
    [
        0 => 7000.00,
        1 => 'Sedan',
        2 => 5,
    ]
);
```

An `UPDATE` statement performs the update in two phases:

* First, if the `UPDATE` has a `WHERE` clause it retrieves all the objects that match these criteria,
* Second, based on the queried objects it updates/changes the requested attributes storing them to the relational database

This way of operation allows that events, virtual foreign keys and validations take part of the updating process. In summary, the following code:

```php
<?php

$phql = 'UPDATE Cars SET price = 15000.00 WHERE id > 101';

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

is somewhat equivalent to:

```php
<?php

$messages = null;

$process = function () use (&$messages) {
    $cars = Cars::find('id > 101');

    foreach ($cars as $car) {
        $car->price = 15000;

        if ($car->save() === false) {
            $messages = $car->getMessages();

            return false;
        }
    }

    return true;
};

$success = $process();
```

<a name='deleting-data'></a>

## Deleting Data

When a record is deleted the events related to the delete operation will be executed for each row:

```php
<?php

// Deleting a single row
$phql = 'DELETE FROM Cars WHERE id = 101';
$manager->executeQuery($phql);

// Deleting multiple rows
$phql = 'DELETE FROM Cars WHERE id > 100';
$manager->executeQuery($phql);

// Using placeholders
$phql = 'DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:';
$manager->executeQuery(
    $phql,
    [
        'initial' => 1,
        'final'   => 100,
    ]
);
```

`DELETE` operations are also executed in two phases like `UPDATEs`. To check if the deletion produces any validation messages you should check the status code returned:

```php
<?php

// Deleting multiple rows
$phql = 'DELETE FROM Cars WHERE id > 100';

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

<a name='query-builder'></a>

## Creating queries using the Query Builder

A builder is available to create PHQL queries without the need to write PHQL statements, also providing IDE facilities:

```php
<?php

// Getting a whole set
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->execute();

// Getting the first row
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->getSingleResult();
```

That is the same as:

```php
<?php

$phql = 'SELECT Robots.* FROM Robots JOIN RobotsParts p ORDER BY Robots.name LIMIT 20';

$result = $manager->executeQuery($phql);
```

More examples of the builder:

```php
<?php

// 'SELECT Robots.* FROM Robots';
$builder->from('Robots');

// 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts';
$builder->from(
    [
        'Robots',
        'RobotsParts',
    ]
);

// 'SELECT * FROM Robots';
$phql = $builder->columns('*')
                ->from('Robots');

// 'SELECT id FROM Robots';
$builder->columns('id')
        ->from('Robots');

// 'SELECT id, name FROM Robots';
$builder->columns(['id', 'name'])
        ->from('Robots');

// 'SELECT Robots.* FROM Robots WHERE Robots.name = 'Voltron'';
$builder->from('Robots')
        ->where("Robots.name = 'Voltron'");

// 'SELECT Robots.* FROM Robots WHERE Robots.id = 100';
$builder->from('Robots')
        ->where(100);

// 'SELECT Robots.* FROM Robots WHERE Robots.type = 'virtual' AND Robots.id > 50';
$builder->from('Robots')
        ->where("type = 'virtual'")
        ->andWhere('id > 50');

// 'SELECT Robots.* FROM Robots WHERE Robots.type = 'virtual' OR Robots.id > 50';
$builder->from('Robots')
        ->where("type = 'virtual'")
        ->orWhere('id > 50');

// 'SELECT Robots.* FROM Robots GROUP BY Robots.name';
$builder->from('Robots')
        ->groupBy('Robots.name');

// 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id';
$builder->from('Robots')
        ->groupBy(['Robots.name', 'Robots.id']);

// 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name';
$builder->columns(['Robots.name', 'SUM(Robots.price)'])
    ->from('Robots')
    ->groupBy('Robots.name');

// 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name HAVING SUM(Robots.price) > 1000';
$builder->columns(['Robots.name', 'SUM(Robots.price)'])
    ->from('Robots')
    ->groupBy('Robots.name')
    ->having('SUM(Robots.price) > 1000');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts';
$builder->from('Robots')
    ->join('RobotsParts');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p';
$builder->from('Robots')
    ->join('RobotsParts', null, 'p');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p';
$builder->from('Robots')
    ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p');

// 'SELECT Robots.* FROM Robots
// JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
// JOIN Parts ON Parts.id = RobotsParts.parts_id AS t';
$builder->from('Robots')
    ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')
    ->join('Parts', 'Parts.id = RobotsParts.parts_id', 't');

// 'SELECT r.* FROM Robots AS r';
$builder->addFrom('Robots', 'r');

// 'SELECT Robots.*, p.* FROM Robots, Parts AS p';
$builder->from('Robots')
    ->addFrom('Parts', 'p');

// 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
$builder->from(['r' => 'Robots'])
        ->addFrom('Parts', 'p');

// 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
$builder->from(['r' => 'Robots', 'p' => 'Parts']);

// 'SELECT Robots.* FROM Robots LIMIT 10';
$builder->from('Robots')
    ->limit(10);

// 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5';
$builder->from('Robots')
        ->limit(10, 5);

// 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100';
$builder->from('Robots')
        ->betweenWhere('id', 1, 100);

// 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)';
$builder->from('Robots')
        ->inWhere('id', [1, 2, 3]);

// 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)';
$builder->from('Robots')
        ->notInWhere('id', [1, 2, 3]);

// 'SELECT Robots.* FROM Robots WHERE name LIKE '%Art%';
$builder->from('Robots')
        ->where('name LIKE :name:', ['name' => '%' . $name . '%']);

// 'SELECT r.* FROM Store\Robots WHERE r.name LIKE '%Art%';
$builder->from(['r' => 'Store\Robots'])
        ->where('r.name LIKE :name:', ['name' => '%' . $name . '%']);
```

<a name='query-builder-parameters'></a>

### Bound Parameters

Bound parameters in the query builder can be set as the query is constructed or past all at once when executing:

```php
<?php

// Passing parameters in the query construction
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:', ['name' => $name])
    ->andWhere('type = :type:', ['type' => $type])
    ->getQuery()
    ->execute();

// Passing parameters in query execution
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:')
    ->andWhere('type = :type:')
    ->getQuery()
    ->execute(['name' => $name, 'type' => $type]);
```

<a name='disallow-literals'></a>

## Disallow literals in PHQL

Literals can be disabled in PHQL, this means that directly using strings, numbers and boolean values in PHQL strings will be disallowed. If PHQL statements are created embedding external data on them, this could open the application to potential SQL injections:

```php
<?php

$login  = 'voltron';
$phql   = "SELECT * FROM Models\Users WHERE login = '$login'";
$result = $manager->executeQuery($phql);
```

If `$login` is changed to `' OR '' = '`, the produced PHQL is:

```sql
SELECT * FROM Models\Users WHERE login = '' OR '' = ''
```

Which is always `true` no matter what the login stored in the database is.

If literals are disallowed strings can be used as part of a PHQL statement, thus an exception will be thrown forcing the developer to use bound parameters. The same query can be written in a secure way like this:

```php
<?php

$type   = 'virtual';
$phql   = 'SELECT Robots.* FROM Robots WHERE Robots.type = :type:';
$result = $manager->executeQuery(
    $phql,
    [
        'type' => $type,
    ]
);
```

You can disallow literals in the following way:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'phqlLiterals' => false
    ]
);
```

Bound parameters can be used even if literals are allowed or not. Disallowing them is just another security decision a developer could take in web applications.

<a name='escaping-reserved-words'></a>

## Escaping Reserved Words

PHQL has a few reserved words, if you want to use any of them as attributes or models names, you need to escape those words using the cross-database escaping delimiters `[` and `]`:

```php
<?php

$phql   = 'SELECT * FROM [Update]';
$result = $manager->executeQuery($phql);

$phql   = 'SELECT id, [Like] FROM Posts';
$result = $manager->executeQuery($phql);
```

The delimiters are dynamically translated to valid delimiters depending on the database system where the application is currently running on.

<a name='lifecycle'></a>

## PHQL Lifecycle

Being a high-level language, PHQL gives developers the ability to personalize and customize different aspects in order to suit their needs. The following is the life cycle of each PHQL statement executed:

* The PHQL is parsed and converted into an Intermediate Representation (IR) which is independent of the SQL implemented by database system
* The IR is converted to valid SQL according to the database system associated to the model
* PHQL statements are parsed once and cached in memory. Further executions of the same statement result in a slightly faster execution

<a name='raw-sql'></a>

## Using Raw SQL

A database system could offer specific SQL extensions that aren't supported by PHQL, in this case, a raw SQL can be appropriate:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByCreateInterval()
    {
        // A raw SQL statement
        $sql = 'SELECT * FROM robots WHERE id > 0';

        // Base model
        $robot = new Robots();

        // Execute the query
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql)
        );
    }
}
```

If raw SQL queries are common in your application a generic method could be added to your model:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByRawSql($conditions, $params = null)
    {
        // A raw SQL statement
        $sql = 'SELECT * FROM robots WHERE $conditions';

        // Base model
        $robot = new Robots();

        // Execute the query
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql, $params)
        );
    }
}
```

The above `findByRawSql` could be used as follows:

```php
<?php

$robots = Robots::findByRawSql(
    'id > ?',
    [
        10
    ]
);
```

<a name='troubleshooting'></a>

## Troubleshooting

Some things to keep in mind when using PHQL:

* Classes are case-sensitive, if a class is not defined with the same name as it was created this could lead to an unexpected behavior in operating systems with case-sensitive file systems such as Linux.
* Correct charset must be defined in the connection to bind parameters with success.
* Aliased classes aren't replaced by full namespaced classes since this only occurs in PHP code and not inside strings.
* If column renaming is enabled avoid using column aliases with the same name as columns to be renamed, this may confuse the query resolver.