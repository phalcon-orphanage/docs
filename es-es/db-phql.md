* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Lenguaje de consulta de Phalcon (PHQL)

El lenguaje de consulta de Phalcon, PhalconQL o simplemente PHQL es un dialecto de SQL de alto nivel, orientado a objetos que permite escribir consultas utilizando un lenguaje estándar SQL. PHQL se implementa como un analizador (escrito en C) que traduce la sintaxis en la del RDBMS de destino.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as [SQLite](https://en.wikipedia.org/wiki/Lemon_Parser_Generator). Esta tecnología proporciona un pequeño analizador en memoria con un impacto en memoria muy bajo que también es seguro para subprocesos.

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

PHQL queries can be created just by instantiating the class [Phalcon\Mvc\Model\Query](api/Phalcon_Mvc_Model_Query):

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

From a controller or a view, it's easy to create/execute them using an injected `models manager` ([Phalcon\Mvc\Model\Manager](api/Phalcon_Mvc_Model_Manager)):

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

Dependiendo del tipo de columnas que estemos consultando, varía el tipo de resultado. If you retrieve a single whole object, then the object returned is a [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). Este tipo de conjunto de resultados es un conjunto de objetos de modelo completo:

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

We are only requesting some fields in the table, therefore those cannot be considered an entire object, so the returned object is still a resultset of type [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). Sin embargo, cada elemento es un objeto estándar que sólo contiene las dos columnas que fueron solicitadas.

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

The result in this case is an object [Phalcon\Mvc\Model\Resultset\Complex](api/Phalcon_Mvc_Model_Resultset_Complex). This allows access to both complete objects and scalars at once:

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
    echo 'Automóvil: ', $row->cars->name, "\n";
    echo 'Marca: ', $row->brands->name, "\n";
}
```

Si un alias se utiliza para cambiar el nombre de los modelos en la consulta, los utilizará para nombrar los atributos en cada fila del resultado:

```php
<?php

$phql = 'SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo 'Automóvil: ', $row->c->name, "\n";
    echo 'Marca: ', $row->b->name, "\n";
}
```

Cuando el modelo unido tiene una relación muchos a muchos con el modelo `from`, el modelo intermedio se agrega implícitamente a la consulta generada:

```php
<?php

$phql = 'SELECT Artists.name, Songs.name FROM Artists ' .
        'JOIN Songs WHERE Artists.genre = "Trip-Hop"';

$result = $this->modelsManager->executeQuery($phql);
```

Este código ejecuta el siguiente código SQL en MySQL:

```sql
SELECT `artists`.`name`, `songs`.`name` FROM `artists`
INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
WHERE `artists`.`genre` = 'Trip-Hop'
```

<a name='aggregations'></a>

### Agregaciones

Los ejemplos siguientes muestran cómo utilizar agregaciones en PHQL:

```php
<?php

// ¿Cuánto cuestan todos los automóviles?
$phql = 'SELECT SUM(price) AS summatory FROM Cars';
$row  = $manager->executeQuery($phql)->getFirst();
echo $row['summatory'];

// ¿Cuántos automóviles tiene cada marca?
$phql = 'SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brand_id, ' ', $row['1'], "\n";
}

// ¿Cuántos automóviles tiene cada marca?
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

// Contar marcas usadas distintas
$phql = 'SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brandId, "\n";
}
```

<a name='conditions'></a>

### Condiciones

Las condiciones nos permiten filtrar el conjunto de registros que desea consultar. La cláusula `WHERE` permite hacerlo:

```php
<?php

// Condiciones simples
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

También, como parte de PHQL, en los parámetros preparados se escapan automáticamente los datos de entrada, introduciendo más seguridad:

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

## Insertando datos

Con PHQL es posible insertar datos mediante la instrucción familiar INSERT:

```php
<?php

// Insertando sin columnas
$phql = 'INSERT INTO Cars VALUES (NULL, "Lamborghini Espada", '
      . '7, 10000.00, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Especificando las columnas del insertado
$phql = 'INSERT INTO Cars (name, brand_id, year, style) '
      . 'VALUES ("Lamborghini Espada", 7, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Insertando utilizando marcadores
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

Phalcon no sólo transforma las declaraciones de PHQL a SQL. Todos los eventos y reglas de negocio definidas en el modelo se ejecutan como si creáramos objetos individuales manualmente. Vamos a añadir una regla de negocio en el modelo Cars. Un coche no puede costar menos de $ 10.000:

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
                new Message('Un automóvil no puede costar menos de $ 10,000')
            );

            return false;
        }
    }
}
```

Si hiciéramos el siguiente `INSERT` en los modelos de Cars, la operación no tendrá éxito porque el precio no cumple con la regla de negocio que hemos implementado. Comprobando el estado de la inserción podemos imprimir cualquier mensaje de validación generado internamente:

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

## Actualizando datos

La actualización de filas es muy similar a insertar filas. Como usted sabe, la instrucción para actualizar registros es UPDATE. Cuando se actualiza un registro, los eventos relacionados con la operación de actualización se ejecutarán para cada fila.

```php
<?php

// Actualizando una simple columna
$phql = 'UPDATE Cars SET price = 15000.00 WHERE id = 101';
$manager->executeQuery($phql);

// Actualizando múltiples columnas
$phql = 'UPDATE Cars SET price = 15000.00, type = "Sedan" WHERE id = 101';
$manager->executeQuery($phql);

// Actualizando múltiples filas
$phql = 'UPDATE Cars SET price = 7000.00, type = "Sedan" WHERE brands_id > 5';
$manager->executeQuery($phql);

// Usando marcadores
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

Una instrucción `UPDATE` realiza la actualización en dos etapas:

* En primer lugar, si el `UPDATE` tiene una cláusula `WHERE` se recuperan todos los objetos que coincidan con estos criterios,
* En segundo lugar, en función de los objetos consultados, actualiza/cambia los atributos solicitados y los almacena en la base de datos relacional

Este modo de operación permite que los eventos, claves externas virtuales y validaciones tomen parte del proceso de actualización. En resumen, el siguiente código:

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

es algo equivalente a:

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

## Borrando datos

Cuando se elimina un registro los eventos relacionados con la operación de eliminación se ejecutarán para cada fila:

```php
<?php

// Borrando una fila simple
$phql = 'DELETE FROM Cars WHERE id = 101';
$manager->executeQuery($phql);

// Borrando múltiples filas
$phql = 'DELETE FROM Cars WHERE id > 100';
$manager->executeQuery($phql);

// Usando marcadores
$phql = 'DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:';
$manager->executeQuery(
    $phql,
    [
        'initial' => 1,
        'final'   => 100,
    ]
);
```

Las operaciones `DELETE` también se ejecutan en dos etapas como los `UPDATE`. Para verificar que si la supresión produce mensajes de validación, debe verificar el código de estado devuelto:

```php
<?php

// Borrando múltiples filas
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

## Crear consultas utilizando el generador de consultas

Está disponible un constructor para crear consultas PHQL sin necesidad de escribir declaraciones de PHQL, también proporciona instalaciones IDE:

```php
<?php

// Obteniendo un conjunto completo
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->execute();

// Obteniendo la primer fila
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->getSingleResult();
```

Es lo mismo que:

```php
<?php

$phql = 'SELECT Robots.* FROM Robots JOIN RobotsParts p ORDER BY Robots.name LIMIT 20';

$result = $manager->executeQuery($phql);
```

Más ejemplos del constructor:

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

### Enlazando parámetros

Los parámetros enlazados, en el generador de consultas, se pueden establecer cuando se construye la consulta o pasarlos todos juntos al ejecutar:

```php
<?php

// Pasando parámetros en la construcción de la consulta
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:', ['name' => $name])
    ->andWhere('type = :type:', ['type' => $type])
    ->getQuery()
    ->execute();

// Pasando parámetros en la ejecución de la consulta
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:')
    ->andWhere('type = :type:')
    ->getQuery()
    ->execute(['name' => $name, 'type' => $type]);
```

<a name='disallow-literals'></a>

## No permitir literales en PHQL

Los literales pueden desactivarse en PHQL, esto significa que el uso directo de cadenas, números y valores booleanos en las cadenas de PHQL serán rechazados. Si las sentencias PHQL se crean incrustando datos externos sobre ellas, esto podría abrir la aplicación a potenciales inyecciones SQL:

```php
<?php

$login  = 'voltron';
$phql   = "SELECT * FROM Models\Users WHERE login = '$login'";
$result = $manager->executeQuery($phql);
```

Si `$login` es cambiado por `' OR ' = '`, el PHQL producido sería:

```sql
SELECT * FROM Models\Users WHERE login = '' OR '' = ''
```

Que siempre es `true` no importa cuál sea el login almacenado en la base de datos.

Si los literales no se permiten, las cadenas se pueden usar como parte de una declaración PHQL, por lo tanto, se lanzará una excepción que obligará al desarrollador a usar parámetros enlazados. La misma consulta se puede escribir de una forma segura como esta:

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

Se puede deshabilitar los literales de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'phqlLiterals' => false
    ]
);
```

Los parámetros enlazados pueden utilizarse incluso si se permiten literales o no. Deshabilitarlos es solo una decisión de seguridad que podría tomar un desarrollador de aplicaciones web.

<a name='escaping-reserved-words'></a>

## Escapando palabras reservadas

PHQL tiene algunas palabras reservadas, si desea utilizar cualquiera de ellas como atributos o nombres de modelos, necesita escapar esas palabras usando los delimitadores `[` y `]`:

```php
<?php

$phql   = 'SELECT * FROM [Update]';
$result = $manager->executeQuery($phql);

$phql   = 'SELECT id, [Like] FROM Posts';
$result = $manager->executeQuery($phql);
```

Los delimitadores se convierten dinámicamente a delimitadores válidos según el sistema de base de datos donde la aplicación se está ejecutando.

<a name='lifecycle'></a>

## Ciclo de vida de PHQL

Al ser un lenguaje de alto nivel, PHQL da a los desarrolladores la capacidad de personalizar y adaptar diferentes aspectos con el fin de satisfacer sus necesidades. El siguiente es el ciclo de vida de cada instrucción PHQL ejecutada:

* El PHQL es analizado y convertido en una Representación Intermedia (IR) que es independiente de la implementada por el sistema de base de datos de SQL
* La IR se convierte en SQL válido según el sistema de base de datos asociado al modelo
* Las declaraciones de PHQL se analizan una vez y almacenan en caché en la memoria. Las ejecuciones posteriores de la misma instrucción dan como resultado una ejecución ligeramente más rápida

<a name='raw-sql'></a>

## Usando SQL crudo

Un sistema de base de datos podría ofrecer extensiones específicas de SQL que no son compatibles con PHQL, en este caso, el uso de SQL crudo puede ser apropiado:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByCreateInterval()
    {
        // Una declaración de SQL cruda
        $sql = 'SELECT * FROM robots WHERE id > 0';

        // Modelo base
        $robot = new Robots();

        // Ejecutar la consulta
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql)
        );
    }
}
```

Si las consultas SQL crudas son comunes en la aplicación, un método genérico se podría añadir a su modelo:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByRawSql($conditions, $params = null)
    {
        // Declaración SQL cruda
        $sql = 'SELECT * FROM robots WHERE $conditions';

        // Modelo base
        $robot = new Robots();

        // Ejecutar la consulta
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql, $params)
        );
    }
}
```

El anterior `findByRawSql` podría utilizarse de sigue manera:

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

## Resolución de problemas

Algunas cosas a tener en cuenta cuando se utiliza PHQL:

* Las clases son sensibles a mayúsculas y minúsculas, si una clase no se define con el mismo nombre que fue creada, podría conducir a un comportamiento inesperado en sistemas operativos con los sistemas de archivos que distinguen mayúsculas y minúsculas como Linux.
* Un conjunto de caracteres correcto debe definirse en la conexión para enlazar parámetros con éxito.
* Las clases con alias no se reemplazan por clases con espacios de nombres completos, ya que esto solo ocurre en el código PHP y no dentro de las cadenas.
* Si el renombrado de columna está habilitado, evite el uso de alias de columna con el mismo nombre que las columnas a cambiar de nombre, esto puede confundir la resolución de la consulta.