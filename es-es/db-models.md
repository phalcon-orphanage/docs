* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='working-with'></a>

# Trabajando con Modelos

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is the base for all models in a Phalcon application. It provides database independence, basic CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) avoids the need of having to use SQL statements because it translates methods dynamically to the respective database engine operations.

<h5 class='alert alert-warning'>Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the <a href="api/Phalcon_Db">Phalcon\Db</a> component documentation.</h5>

<a name='creating'></a>

## Creación de Modelos

A model is a class that extends from [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). Its class name should be in camel case notation:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

<h5 class='alert alert-warning'>If you're using PHP 5.4/5.5 it is recommended you declare each column that makes part of the model in order to save memory and reduce the memory allocation. </h5>

By default, the model `Store\Toys\RobotParts` will map to the table `robot_parts`. If you want to manually specify another name for the mapped table, you can use the `setSource()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function initialize()
    {
        $this->setSource('toys_robot_parts');
    }
}
```

The model `RobotParts` now maps to `toys_robot_parts` table. The `initialize()` method helps with setting up this model with a custom behavior i.e. a different table.

The `initialize()` method is only called once during the request. This method is intended to perform initializations that apply for all instances of the model created within the application. If you want to perform initialization tasks for every instance created you can use the `onConstruct()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function onConstruct()
    {
        // ...
    }
}
```

<a name='properties-setters-getters'></a>

### Propiedades públicas vs Setters / Getters

Models can be implemented public properties, meaning that each property can be read/updated from any part of the code that has instantiated that model class:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

Another implementation is to use getters and setter functions, which control which properties are publicly available for that model. The benefit of using getters and setters is that the developer can perform transformations and validation checks on the values set for the model, which is impossible when using public properties. Additionally getters and setters allow for future changes without changing the interface of the model class. So if a field name changes, the only change needed will be in the private property of the model referenced in the relevant getter/setter and nowhere else in the code.

```php
<?php

namespace Store\Toys;

use InvalidArgumentException;
use Phalcon\Mvc\Model;

class Robots extends Model
{
    protected $id;

    protected $name;

    protected $price;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        // ¿El nombre es muy corto?
        if (strlen($name) < 10) {
            throw new InvalidArgumentException(
                'El nombre es muy corto'
            );
        }

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        // Precios negativos no están permitidos
        if ($price < 0) {
            throw new InvalidArgumentException(
                "El precio no puede ser negativo"
            );
        }

        $this->price = $price;
    }

    public function getPrice()
    {
        // Convertir el valor a double antes de usarse
        return (double) $this->price;
    }
}
```

Public properties provide less complexity in development. However getters/setters can heavily increase the testability, extensibility and maintainability of applications. Developers can decide which strategy is more appropriate for the application they are creating, depending on the needs of the application. The ORM is compatible with both schemes of defining properties.

<h5 class='alert alert-warning'>Underscores in property names can be problematic when using getters and setters. </h5>

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use with magic methods. (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.). As much of the system expects camel case, and underscores are commonly removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a column map (as described above) to ensure proper mapping of your properties to their database counterparts.

<a name='records-to-objects'></a>

## Comprensión de Registros a Objetos

Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example, for a table 'robots' with the records:

```sql
mysql> select * from robots;
+----+------------+------------+------+
| id | name       | type       | year |
+----+------------+------------+------+
|  1 | Robotina   | mechanical | 1972 |
|  2 | Astro Boy  | mechanical | 1952 |
|  3 | Terminator | cyborg     | 2029 |
+----+------------+------------+------+
3 rows in set (0.00 sec)
```

You could find a certain record by its primary key and then print its name:

```php
<?php

use Store\Toys\Robots;

// Buscar registro con id = 3
$robot = Robots::findFirst(3);

// Imprimir 'Terminator'
echo $robot->name;
```

Una vez que el registro está en la memoria, puede hacer modificaciones a sus datos y guardar los cambios:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(3);

$robot->name = 'RoboCop';

$robot->save();
```

As you can see, there is no need to use raw SQL statements. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides high database abstraction for web applications.

<a name='finding-records'></a>

## Búsqueda de registros

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) also offers several methods for querying records. The following examples will show you how to query one or more records from a model:

```php
<?php

use Store\Toys\Robots;

// ¿Cuantos robots hay?
$robots = Robots::find();
echo 'Hay ', count($robots), "\n";

// ¿Cuántos robots mecánicos hay?
$robots = Robots::find("type = 'mechanical'");
echo 'Hay ', count($robots), "\n";

// Obtener e imprimir robots virtuales ordenados por nombre
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Obtener los primeros 100 robots virtuales ordenados por nombre
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
        'limit' => 100,
    ]
);
foreach ($robots as $robot) {
   echo $robot->name, "\n";
}
```

<h5 class='alert alert-warning'>If you want find record by external data (such as user input) or variable data you must use <a href="#binding-parameters">Binding Parameters</a>`.</h5>

También puede utilizar el método `findFirst()` para obtener sólo el primer registro que coincida con el criterio dado:

```php
<?php

use Store\Toys\Robots;

// ¿Cuál es el primer robot de la tabla?
$robot = Robots::findFirst();
echo 'El nombre del robot es ', $robot->name, "\n";

// ¿Cuál es el primer robot mecánico de la tabla?
$robot = Robots::findFirst("type = 'mechanical'");
echo 'El nombre del primer robot mecánico es ', $robot->name, "\n";

// Obtener el primer robot virtual ordenado por nombre
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);

echo 'Ell nombre del primer robot virtual es ', $robot->name, "\n";
```

Ambos métodos `find()` y `findFirst()` aceptan un array asociativo, especificando los criterios de búsqueda:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name DESC',
        'limit' => 30,
    ]
);

$robots = Robots::find(
    [
        'conditions' => 'type = ?1',
        'bind'       => [
            1 => 'virtual',
        ]
    ]
);
```

Las opciones disponibles de consulta son:

| Parameter     | Descripción                                                                                                                                                                                                                                         | Ejemplo                                                              |
| ------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | Condiciones de búsqueda para la operación de búsqueda. Se utiliza para extraer sólo los registros que cumplan con un criterio especificado. By default [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) assumes the first parameter are the conditions. | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | Devolverá las columnas especificadas aquí en lugar de las todas columnas del modelo. Cuando se utiliza esta opción se devuelve un objeto incompleto                                                                                                 | `'columns' => 'id, name'`                                         |
| `bind`        | Se utiliza junto a las opciones, mediante la sustitución de marcadores y escapando los valores para aumentar la seguridad                                                                                                                           | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | Al enlazar parámetros, puede utilizar este parámetro para definir el tipo de datos de los parámetros y aumentar aún más la seguridad                                                                                                                | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | Se utiliza para ordenar el conjunto de resultados. Utilice uno o más campos separados por comas.                                                                                                                                                    | `'order' => 'name DESC, status'`                                  |
| `limit`       | Limitar los resultados de la consulta a cierto rango                                                                                                                                                                                                | `'limit' => 10`                                                   |
| `offset`      | Desplazar los resultados de la consulta por una cierta cantidad                                                                                                                                                                                     | `'offset' => 5`                                                   |
| `group`       | Permite recopilar datos a través de múltiples registros y agrupar los resultados de una o más columnas                                                                                                                                              | `'group' => 'name, status'`                                       |
| `for_update`  | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting exclusive locks on each row it reads                                                                                                        | `'for_update' => true`                                            |
| `shared_lock` | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting shared locks on each row it reads                                                                                                           | `'shared_lock' => true`                                           |
| `cache`       | Almacenar en caché el conjunto de resultados, reduciendo el acceso continuo al sistema relacional                                                                                                                                                   | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | Establece la estrategia de hidratación para representar cada registro devuelto en el resultado                                                                                                                                                      | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

If you prefer, there is also available a way to create queries in an object-oriented way, instead of using an array of parameters:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::query()
    ->where('type = :type:')
    ->andWhere('year < 2000')
    ->bind(['type' => 'mechanical'])
    ->order('name')
    ->execute();
```

The static method `query()` returns a [Phalcon\Mvc\Model\Criteria](api/Phalcon_Mvc_Model_Criteria) object that is friendly with IDE autocompleters.

All the queries are internally handled as [PHQL](/4.0/en/db-phql) queries. PHQL is a high-level, object-oriented and SQL-like language. This language provide you more features to perform queries like joining other models, define groupings, add aggregations etc.

Lastly, there is the `findFirstBy<property-name>()` method. This method expands on the `findFirst()` method mentioned earlier. It allows you to quickly perform a retrieval from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column. An example is in order, so taking our Robots model mentioned earlier:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

We have three properties to work with here: `$id`, `$name` and `$price`. So, let's say you want to retrieve the first record in the table with the name 'Terminator'. This could be written like:

```php
<?php

use Store\Toys\Robots;

$name = 'Terminator';

$robot = Robots::findFirstByName($name);

if ($robot) {
    echo 'El primer robot con el nombre ' . $name . ' costo ' . $robot->price . '.';
} else {
    echo 'No se encontraron Robots con el nombre' . $name . '.';
}
```

Notice that we used 'Name' in the method call and passed the variable `$name` to it, which contains the name we are looking for in our table. Notice also that when we find a match with our query, all the other properties are available to us as well.

<a name='resultsets'></a>

### Conjuntos de resultados

While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). This is an object that encapsulates all the functionality a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

```php
<?php

use Store\Toys\Robots;

// Obtener todos los robots
$robots = Robots::find();

// Recorrerlos con un foreach
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Recorrerlos con un while
$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}

// Contar cuantos elementos hay en el resultset
echo count($robots);

// Otra forma alternativa de contar los elementos del resultset
echo $robots->count();

// Mover el cursor interno al tercer robot
$robots->seek(2);

$robot = $robots->current();

// Acceder a un robot por su posición en el resultset
$robot = $robots[5];

// Chequear si hay un registro en determinada posición
if (isset($robots[3])) {
   $robot = $robots[3];
}

// Obtener el primer registro del resultset
$robot = $robots->getFirst();

// Obtener el último registro
$robot = $robots->getLast();
```

Phalcon's resultsets emulate scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer to a specific position. Note that some database systems don't support scrollable cursors, this forces to re-execute the query in order to rewind the cursor to the beginning and obtain the record at the requested position. Similarly, if a resultset is traversed several times, the query must be executed the same number of times.

As storing large query results in memory could consume many resources, resultsets are obtained from the database in chunks of 32 rows - reducing the need to re-execute the request in several cases.

Note that resultsets can be serialized and stored in a cache backend. [Phalcon\Cache](api/Phalcon_Cache) can help with that task. However, serializing data causes [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) to retrieve all the data from the database in an array, thus consuming more memory while this process takes place.

```php
<?php

// Consultar todos los registros desde el modelo Parts
$parts = Parts::find();

// Almacenar el resultset en un archivo
file_put_contents(
    'cache.txt',
    serialize($parts)
);

// Obtener las partes desde el archivo
$parts = unserialize(
    file_get_contents('cache.txt')
);

// Recorrer las partes
foreach ($parts as $part) {
    echo $part->id;
}
```

<a name='custom-resultsets'></a>

### Conjuntos de resultados personalizados

There are times that the application logic requires additional manipulation of the data as it is retrieved from the database. Previously, we would just extend the model and encapsulate the functionality in a class in the model or a trait, returning back to the caller usually an array of transformed data.

With custom resultsets, you no longer need to do that. The custom resultset will encapsulate the functionality that otherwise would be in the model and can be reused by other models, thus keeping the code [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself). This way, the `find()` method will no longer return the default [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset), but instead the custom one. Phalcon allows you to do this by using the `getResultsetClass()` in your model.

First we need to define the resultset class:

```php
<?php

namespace Application\Mvc\Model\Resultset;

use \Phalcon\Mvc\Model\Resultset\Simple;

class Custom extends Simple
{
    public function getSomeData() {
        /** CÓDIGO */
    }
}
```

In the model, we set the class in the `getResultsetClass()` as follows:

```php
<?php

namespace Phalcon\Test\Models\Statistics;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getSource()
    {
        return 'robots';
    }

    public function getResultsetClass()
    {
    return 'Application\Mvc\Model\Resultset\Custom';
    }
}
```

and finally in your code you will have something like this:

```php
<?php

/**
 * Buscar robots
 */
$robots = Robots::find(
    [
        'conditions' => 'date between "2017-01-01" AND "2017-12-31"',
        'order'      => 'date'
    ]
);

/**
 * Enviar datos a la vista
 */
$this->view->mydata = $robots->getSomeData();
```

<a name='filters'></a>

### Filtrar Conjuntos de Resultados

The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster. Phalcon additionally allows you to filter the data using PHP using any resource that is not available in the database:

```php
<?php

$customers = Customers::find();

$customers = $customers->filter(
    function ($customer) {
        // Retornar solo clientes con un email valido
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }
    }
);
```

<a name='binding-parameters'></a>

### Enlazando parámetros

Bound parameters are also supported in [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). You are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and integer placeholders are supported. El enlazado de parámetros se hace simplemente de la siguiente manera:

```php
<?php

use Store\Toys\Robots;

// Consultamos por Robots enlazando parámetros con marcadores de nombre
// Parámetros cuyas claves son iguales a los marcadores
$robots = Robots::find(
    [
        'name = :name: AND type = :type:',
        'bind' => [
            'name' => 'Robotina',
            'type' => 'maid',
        ],
    ]
);

// Consultando robots enlazando parámetros con marcadores numéricos
$robots = Robots::find(
    [
        'name = ?1 AND type = ?2',
        'bind' => [
            1 => 'Robotina',
            2 => 'maid',
        ],
    ]
);

// Consultamos los robots enlazando ambos tipos de parámetros
// Los parámetros cuyas claves son iguales a los marcadores
$robots = Robots::find(
    [
        'name = :name: AND type = ?1',
        'bind' => [
            'name' => 'Robotina',
            1      => 'maid',
        ],
    ]
);
```

When using numeric placeholders, you will need to define them as integers i.e. `1` or `2`. In this case `'1'` or `'2'` are considered strings and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using [PDO](https://php.net/manual/en/pdo.prepared-statements.php). This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Additionally you can set the parameter `bindTypes`, this allows defining how the parameters should be bound according to its data type:

```php
<?php

use Phalcon\Db\Column;
use Store\Toys\Robots;

// Enlazando parámetros
$parameters = [
    'name' => 'Robotina',
    'year' => 2008,
];

// Clasificación de tipos
$types = [
    'name' => Column::BIND_PARAM_STR,
    'year' => Column::BIND_PARAM_INT,
];

// Consulta de robots enlazando parámetros con marcadores de nombre
$robots = Robots::find(
    [
        'name = :name: AND year = :year:',
        'bind'      => $parameters,
        'bindTypes' => $types,
    ]
);
```

<h5 class='alert alert-warning'>Since the default bind-type is <code>Phalcon\Db\Column::BIND_PARAM_STR</code>, there is no need to specify the 'bindTypes' parameter if all of the columns are of that type.</h5>

If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:

```php
<?php

use Store\Toys\Robots;

$array = ['a','b','c']; // $array: [[0] => 'a', [1] => 'b', [2] => 'c']

unset($array[1]); // $array: [[0] => 'a', [2] => 'c']

// Ahora tenemos que numerar las claves
$array = array_values($array); // $array: [[0] => 'a', [1] => 'c']

$robots = Robots::find(
    [
        'letter IN ({letter:array})',
        'bind' => [
            'letter' => $array
        ]
    ]
);
```

<h5 class='alert alert-warning'>Bound parameters are available for all query methods such as <code>find()</code> and <code>findFirst()</code> but also the calculation methods like <code>count()</code>, <code>sum()</code>, <code>average()</code> etc. </h5>

If you're using "finders" e.g. `find()`, `findFirst()`, etc., bound parameters are automatically used:

```php
<?php

use Store\Toys\Robots;

// Consulta explicita utilizando parámetros enlazados
$robots = Robots::find(
    [
        'name = ?0',
        'bind' => [
            'Ultron',
        ],
    ]
);

// Consulta implícita utilizando parámetros enlazados
$robots = Robots::findByName('Ultron');
```

<a name='preparing-records'></a>

## Inicializando y preparando registros obtenidos

May be the case that after obtaining a record from the database is necessary to initialise the data before being used by the rest of the application. You can implement the `afterFetch()` method in a model, this event will be executed just after create the instance and assign the data to it:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function beforeSave()
    {
        // Convertir de array a string
        $this->status = join(',', $this->status);
    }

    public function afterFetch()
    {
        // Convertir de string a array
        $this->status = explode(',', $this->status);
    }

    public function afterSave()
    {
        // Convertir de string a array
        $this->status = explode(',', $this->status);
    }
}
```

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is accessed:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function getStatus()
    {
        return explode(',', $this->status);
    }
}
```

<a name='calculations'></a>

## Generando Cálculos

Calculations (or aggregations) are helpers for commonly used functions of database systems such as `COUNT`, `SUM`, `MAX`, `MIN` or `AVG`. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) allows to use these functions directly from the exposed methods.

Count examples:

```php
<?php

// ¿Cuántos empleados hay?
$rowcount = Employees::count();

// ¿Cuántas áreas diferentes están asignadas a los empleados?
$rowcount = Employees::count(
    [
        'distinct' => 'area',
    ]
);

// ¿Cuántos empleados hay en el área de testing?
$rowcount = Employees::count(
    "area = 'Testing'"
);

// Contar empleados agrupando los resultados por sus áreas
$group = Employees::count(
    [
        'group' => 'area',
    ]
);
foreach ($group as $row) {
   echo 'Hay ', $row->rowcount, ' empleados en ', $row->area;
}

// Contar empleados agrupándolos por sus áreas y ordenándolos por la cuenta
$group = Employees::count(
    [
        'group' => 'area',
        'order' => 'rowcount',
    ]
);

// Evitar inyecciones SQL utilizando parámetros enlazados
$group = Employees::count(
    [
        'type > ?0',
        'bind' => [
            $type
        ],
    ]
);
```

Sum examples:

```php
<?php

// ¿A cuánto asciende el salario de todos los empleados?
$total = Employees::sum(
    [
        'column' => 'salary',
    ]
);

// ¿Cuánto suma el salario de todos los empleados del área de ventas?
$total = Employees::sum(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Generar una agrupación de salarios por cada área
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
    ]
);
foreach ($group as $row) {
   echo 'La sumatoria de los salarios del área ', $row->area, ' es ', $row->sumatory;
}

// Generar grupo de salario por cada área ordenando salario de mayor a menor
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
        'order'  => 'sumatory DESC',
    ]
);

// Evitar inyecciones SQL utilizando parámetros enlazados
$group = Employees::sum(
    [
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

Average examples:

```php
<?php

// ¿Cuál es el salario promedio de todos los empleados?
$average = Employees::average(
    [
        'column' => 'salary',
    ]
);

// ¿Cuál es el salario promedio de los empleados en el área de ventas?
$average = Employees::average(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Evitar inyecciones SQL utilizando parámetros enlazados
$average = Employees::average(
    [
        'column'     => 'age',
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

Max/Min examples:

```php
<?php

// ¿Cuál es la edad máxima de todos los empleados?
$age = Employees::maximum(
    [
        'column' => 'age',
    ]
);

// ¿Cuál es la edad máxima en el área de ventas?
$age = Employees::maximum(
    [
        'column'     => 'age',
        'conditions' => "area = 'Sales'",
    ]
);

// ¿Cuál es el salario mínimo de todos los empleados?
$salary = Employees::minimum(
    [
        'column' => 'salary',
    ]
);
```

<a name='create-update-records'></a>

## Crear/Actualizar Registros

The `Phalcon\Mvc\Model::save()` method allows you to create/update records according to whether they already exist in the table associated with a model. The save method is called internally by the create and update methods of [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

if ($robot->save() === false) {
    echo "No podemos almacenar el robot: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Genial, un nuevo robot fue guardado correctamente!';
}
```

An array could be passed to `save` to avoid assign every column manually. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will check if there are setters implemented for the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    [
        'type' => 'mechanical',
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass an insecure array without worrying about possible SQL injections:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<h5 class='alert alert-warning'>Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form. </h5>

You can set an additional parameter in `save` to set a whitelist of fields that only must taken into account when doing the mass assignment:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    $_POST,
    [
        'name',
        'type',
    ]
);
```

<a name='create-update-with-confidence'></a>

### Crear/actualizar con confianza

When an application has a lot of competition, we could be expecting create a record but it is actually updated. This could happen if we use `Phalcon\Mvc\Model::save()` to persist the records in the database. If we want to be absolutely sure that a record is created or updated, we can change the `save()` call with `create()` or `update()`:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

// Este registro solo debe ser creado
if ($robot->create() === false) {
    echo "Oh no! no pudimos guardar el robot: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Genial, se creo un nuevo robot!';
}
```

The methods `create` and `update` also accept an array of values as parameter.

<a name='delete-records'></a>

## Eliminar Registros

The `Phalcon\Mvc\Model::delete()` method allows to delete a record. You can use it as follows:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(11);

if ($robot !== false) {
    if ($robot->delete() === false) {
        echo "Lo sentimos, no se puedo borrar el robot: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'El robot fue borrado correctamente!';
    }
}
```

You can also delete many records by traversing a resultset with a `foreach`:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find(
    "type = 'mechanical'"
);

foreach ($robots as $robot) {
    if ($robot->delete() === false) {
        echo "Lo sentimos, no pudimos borrar el robot: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'El robot fue borrado correctamente!';
    }
}
```

Los siguientes eventos están disponibles para definir reglas de negocios personalizadas que se pueden ejecutar cuando se realiza una operación de eliminación:

| Operación | Nombre       | ¿Detiene la operación? | Explicación                                       |
| --------- | ------------ |:----------------------:| ------------------------------------------------- |
| Deleting  | afterDelete  |           No           | Se ejecuta después de la operación de eliminación |
| Deleting  | beforeDelete |           Si           | Se ejecuta antes de la operación de eliminación   |

With the above events can also define business rules in the models:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeDelete()
    {
        if ($this->status === 'A') {
            echo "El robot esta activo, no puede ser borrado";

            return false;
        }

        return true;
    }
}
```

<a name='hydration-modes'></a>

## Modos de hidratación

As mentioned previously, resultsets are collections of complete objects, this means that every returned result is an object representing a row in the database. These objects can be modified and saved again to persistence:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find();

// Modificando un conjunto de resultados de objectos completos
foreach ($robots as $robot) {
    $robot->year = 2000;

    $robot->save();
}
```

Sometimes records are obtained only to be presented to a user in read-only mode, in these cases it may be useful to change the way in which records are represented to facilitate their handling. The strategy used to represent objects returned in a resultset is called 'hydration mode':

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find();

// Retornar cada robot como un array
$robots->setHydrateMode(
    Resultset::HYDRATE_ARRAYS
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}

// Retornar cada robot como un stdClass
$robots->setHydrateMode(
    Resultset::HYDRATE_OBJECTS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}

// Retornar cada robot como una instancia de Robots 
$robots->setHydrateMode(
    Resultset::HYDRATE_RECORDS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}
```

Hydration mode can also be passed as a parameter of `find`:

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find(
    [
        'hydration' => Resultset::HYDRATE_ARRAYS,
    ]
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}
```

<a name='table-prefixes'></a>

## Prefijos de Tablas

If you want all your tables to have certain prefix and without setting source in all models you can use the `Phalcon\Mvc\Model\Manager` and the method `setModelPrefix()`:

```php
<?php

use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model;

class Robots extends Model
{

}

$manager = new Manager();
$manager->setModelPrefix('wp_');
$robots = new Robots(null, null, $manager);
echo $robots->getSource(); // regresará wp_robots
```

<a name='identity-columns'></a>

## Columnas de identidad auto generadas

Some models may have identity columns. These columns usually are the primary key of the mapped table. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can recognize the identity column omitting it in the generated SQL `INSERT`, so the database system can generate an auto-generated value for it. Always after creating a record, the identity field will be registered with the value generated in the database system for it:

```php
<?php

$robot->save();

echo 'El ID generado es: ', $robot->id;
```

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is able to recognize the identity column. Depending on the database system, those columns may be serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence `table_field_seq`, for example: `robots_id_seq`, if that sequence has a different name, the `getSequenceName()` method needs to be implemented:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getSequenceName()
    {
        return 'robots_sequence_name';
    }
}
```

<a name='skipping-columns'></a>

## Saltando columnas

To tell [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        // Saltando campos o columnas en ambas operaciones de INSERT/UPDATE
        $this->skipAttributes(
            [
                'year',
                'price',
            ]
        );

        // Saltar solo cuando se crea
        $this->skipAttributesOnCreate(
            [
                'created_at',
            ]
        );

        // Saltar solo cuando se actualiza
        $this->skipAttributesOnUpdate(
            [
                'modified_in',
            ]
        );
    }
}
```

This will ignore globally these fields on each `INSERT`/`UPDATE` operation on the whole application. If you want to ignore different attributes on different `INSERT`/`UPDATE` operations, you can specify the second parameter (boolean) - `true` for replacement. Forcing a default value can be done as follows:

```php
<?php

use Store\Toys\Robots;

use Phalcon\Db\RawValue;

$robot = new Robots();

$robot->name       = 'Bender';
$robot->year       = 1999;
$robot->created_at = new RawValue('default');

$robot->create();
```

A callback also can be used to create a conditional assignment of automatic default values:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Db\RawValue;

class Robots extends Model
{
    public function beforeCreate()
    {
        if ($this->price > 10000) {
            $this->type = new RawValue('default');
        }
    }
}
```

<h5 class='alert alert-warning'>Never use a <a href="api/Phalcon_Db_RawValue">Phalcon\Db\RawValue</a> to assign external data (such as user input) or variable data. The value of these fields is ignored when binding parameters to the query. So it could be used to attack the application injecting SQL. </h5>

<a name='dynamic-updates'></a>

## Actualización Dinámica

SQL `UPDATE` statements are by default created with every column defined in the model (full all-field SQL update). You can change specific models to make dynamic updates, in this case, just the fields that had changed are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server, this specially helps when the table has blob/text fields:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

<a name='column-mapping'></a>

## Mapeo de columnas independiente

The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database. This is a great feature when one needs to rename fields in the database without having to worry about all the queries in the code. A change in the column map in the model will take care of the rest. Por ejemplo:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $code;

    public $theName;

    public $theType;

    public $theYear;

    public function columnMap()
    {
        // Las claves son los nombres reales en la tabla y 
        // sus valores en la aplicación
        return [
            'id'       => 'code',
            'the_name' => 'theName',
            'the_type' => 'theType',
            'the_year' => 'theYear',
        ];
    }
}
```

Then you can use the new names naturally in your code:

```php
<?php

use Store\Toys\Robots;

// Buscar un robot por su nombre
$robot = Robots::findFirst(
    "theName = 'Voltron'"
);

echo $robot->theName, "\n";

// Obtener robots ordenados por tipo
$robot = Robots::find(
    [
        'order' => 'theType DESC',
    ]
);

foreach ($robots as $robot) {
    echo 'Código: ', $robot->code, "\n";
}

// Crear un robot
$robot = new Robots();

$robot->code    = '10101';
$robot->theName = 'Bender';
$robot->theType = 'Industrial';
$robot->theYear = 2999;

$robot->save();
```

Consider the following when renaming your columns:

* Referencias a atributos en relaciones/validadores deben utilizar los nuevos nombres
* Hacer referencia a nombres de columna reales resultará en una excepción por el ORM

The independent column map allows you to:

* Escribir aplicaciones que utilizan sus propios convenciones
* Eliminar prefijos/sufijos del proveedor en tu código
* Cambiar nombres de columnas sin cambiar su código de aplicación

<a name='record-snapshots'></a>

## Instantáneas de registros

Specific models could be set to maintain a record snapshot when they're queried. You can use this feature to implement auditing or just to know what fields are changed according to the data queried from the persistence:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

When activating this feature the application consumes a bit more of memory to keep track of the original values obtained from the persistence. In models that have this feature activated you can check what fields changed as follows:

```php
<?php

use Store\Toys\Robots;

// Obtener un registro de la base de datos
$robot = Robots::findFirst();

// Modificar una columna
$robot->name = 'Other name';

var_dump($robot->getChangedFields()); // ['name']

var_dump($robot->hasChanged('name')); // true

var_dump($robot->hasChanged('type')); // false
```

Snapshots are updated on model creation/update. Using `hasUpdated()` and `getUpdatedFields()` can be used to check if fields were updated after a create/save/update but it could potentially cause problems to your application if you execute `getChangedFields()` in `afterUpdate()`, `afterSave()` or `afterCreate()`.

You can disable this functionality by using:

```php
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

use Phalcon\Mvc\Model;

class User extends Model
{
  public function initialize()
  {
      $this->keepSnapshots(true);
  }
}

$user       = new User();
$user->name = 'Test User';
$user->create();
var_dump($user->getChangedFields());
$user->login = 'testuser';
var_dump($user->getChangedFields());
$user->update();
var_dump($user->getChangedFields());
```

On Phalcon 4.0.0 and later it is:

```php
array(0) {
}
array(1) {
[0]=> 
    string(5) "login"
}
array(0) {
}
```

`getUpdatedFields()` will properly return updated fields or as mentioned above you can go back to the previous behavior by setting the relevant ini value.

<a name='different-schemas'></a>

## Apuntando a un esquema diferente

If a model is mapped to a table that is in a different schemas/databases than the default. You can use the `setSchema()` method to define that:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setSchema('toys');
    }
}
```

<a name='multiple-databases'></a>

## Configuración de Múltiples Bases de Datos

In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) needs to connect to the database it requests the `db` service in the application's services container. You can overwrite this service setting it in the `initialize()` method:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

// Este servicio retorna una base de datos MySQL
$di->set(
    'dbMysql',
    function () {
        return new MysqlPdo(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// Este servicio retorna una base de datos PostgreSQL
$di->set(
    'dbPostgres',
    function () {
        return new PostgreSQLPdo(
            [
                'host'     => 'localhost',
                'username' => 'postgres',
                'password' => '',
                'dbname'   => 'invo',
            ]
        );
    }
);
```

Luego, en el método `initialize()`, definimos el servicio de conexión para el modelo:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setConnectionService('dbPostgres');
    }
}
```

But Phalcon offers you more flexibility, you can define the connection that must be used to `read` and for `write`. This is specially useful to balance the load to your databases implementing a master-slave architecture:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setReadConnectionService('dbSlave');

        $this->setWriteConnectionService('dbMaster');
    }
}
```

The ORM also provides Horizontal Sharding facilities, by allowing you to implement a 'shard' selection according to the current query conditions:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Selecciona dinámicamente un fragmento
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     */
    public function selectReadConnection($intermediate, $bindParams, $bindTypes)
    {
        // Comprueba si hay un 'where' en la consulta select
        if (isset($intermediate['where'])) {
            $conditions = $intermediate['where'];

            // Escoger el posible fragmento acorde al acondición
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

        // Utilizar el fragmento por defecto
        return $this->getDI()->get('dbShard0');
    }
}
```

The `selectReadConnection()` method is called to choose the right connection, this method intercepts any new query executed:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst('id = 101');
```

<a name='injecting-services-into-models'></a>

## Servicios de Inyección en Modelos

Si requiere acceder a los servicios de la aplicación dentro de un modelo, en el siguiente ejemplo se explica cómo hacerlo:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function notSaved()
    {
        // Obtener el servicio flash desde el contenedor DI 
        $flash = $this->getDI()->getFlash();

        $messages = $this->getMessages();

        // Mostrar mensajes de validación
        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

The `notSaved` event is triggered every time that a `create` or `update` action fails. So we're flashing the validation messages obtaining the `flash` service from the DI container. By doing this, we don't have to print messages after each save.

<a name='disabling-enabling-features'></a>

## Deshabilitar/habilitar características

In the ORM we have implemented a mechanism that allow you to enable/disable specific features or options globally on the fly. According to how you use the ORM you can disable that you aren't using. These options can also be temporarily disabled if required:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'events'         => false,
        'columnRenaming' => false,
    ]
);
```

The available options are:

| Opción                | Descripción                                                                                    | Predeterminado |
| --------------------- | ---------------------------------------------------------------------------------------------- |:--------------:|
| astCache              | Habilita o inhabilita los eventos de callbacks, hooks y notificaciones de todos los modelos    |     `null`     |
| cacheLevel            | Establece el nivel de caché para el ORM                                                        |      `3`       |
| castOnHydrate         |                                                                                                |    `false`     |
| columnRenaming        | Activa/desactiva el renombrado de columnas                                                     |     `true`     |
| disableAssignSetters  | Permite deshabilitar setters en el modelo                                                      |    `false`     |
| enableImplicitJoins   |                                                                                                |     `true`     |
| enableLiterals        |                                                                                                |     `true`     |
| escapeIdentifiers     |                                                                                                |     `true`     |
| events                | Habilita o inhabilita los eventos de callbacks, hooks y notificaciones de todos los modelos    |     `true`     |
| exceptionOnFailedSave | Activa/desactiva lanzar una excepción cuando se produce un fallo en `save()`                   |    `false`     |
| forceCasting          |                                                                                                |    `false`     |
| ignoreUnknownColumns  | Activa/desactiva ignorar columnas desconocidas en el modelo                                    |    `false`     |
| lateStateBinding      | Activa/desactiva el enlace de estado tardío del método `Phalcon\Mvc\Model::cloneResultMap()` |    `false`     |
| notNullValidations    | El ORM valida automáticamente las columnas no nulas en la tabla asignada                       |     `true`     |
| parserCache           |                                                                                                |     `null`     |
| phqlLiterals          | Habilita o inhabilita literales en el analizador PHQL                                          |     `true`     |
| uniqueCacheId         |                                                                                                |      `3`       |
| updateSnapshotOnSave  | Habilita o inhabilita la actualización instantáneas en `save()`                                |     `true`     |
| virtualForeignKeys    | Activa/desactiva las claves externas virtuales                                                 |     `true`     |

<div class="alert alert-warning">
    <p>
        <strong>Nota</strong> <code>Phalcon\Mvc\Model::assign()</code> (que se utiliza cuando se crea/actualiza/guarda el modelo) siempre utiliza setters si existen cuando se pasan los argumentos de datos, incluso cuando es requerido o necesario. Esto agregará sobrecarga adicional a su solicitud. Se puede cambiar este comportamiento mediante la adición de <code>phalcon.orm.disable_assign_setters = 1</code> al archivo ini, simplemente utilice <code>$this->property = value</code>.
    </p>
</div>

<a name='stand-alone-component'></a>

## Componente independiente

Using [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

$di = new Di();

// Configurar una conexión
$di->set(
    'db',
    new Connection(
        [
            'dbname' => 'sample.db',
        ]
    )
);

// Configurar un gestor de modelos
$di->set(
    'modelsManager',
    new ModelsManager()
);

// Utilizar el adaptador de metadata en memoria u otro
$di->set(
    'modelsMetadata',
    new MetaData()
);

// Crear un modelo
class Robots extends Model
{

}

// Usar el modelo
echo Robots::count();
```