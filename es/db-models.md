<div class='article-menu'>
  <ul>
    <li>
      <a href="#working-with">Trabajando con Modelos</a> <ul>
        <li>
          <a href="#creating">Creación de Modelos</a> <ul>
            <li>
              <a href="#properties-setters-getters">Propiedades públicas vs Setters / Getters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#records-to-objects">Comprensión de Registros a Objetos</a>
        </li>
        <li>
          <a href="#finding-records">Búsqueda de registros</a> <ul>
            <li>
              <a href="#resultsets">Conjuntos de resultados</a>
            </li>
            <li>
              <a href="#filters">Filtrar Conjuntos de Resultados</a>
            </li>
            <li>
              <a href="#binding-parameters">Enlazando parámetros</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#preparing-records">Inicializando y preparando registros obtenidos</a>
        </li>
        <li>
          <a href="#calculations">Generando Cálculos</a>
        </li>
        <li>
          <a href="#create-update-records">Crear/Actualizar Registros</a> <ul>
            <li>
              <a href="#create-update-with-confidence">Crear/actualizar con confianza</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#delete-records">Eliminar Registros</a>
        </li>
        <li>
          <a href="#hydration-modes">Modos de hidratación</a>
        </li>
        <li>
          <a href="#identity-columns">Columnas de identidad auto generadas</a>
        </li>
        <li>
          <a href="#skipping-columns">Saltando columnas</a>
        </li>
        <li>
          <a href="#dynamic-updates">Actualización Dinámica</a>
        </li>
        <li>
          <a href="#column-mapping">Mapeo de columnas independiente</a>
        </li>
        <li>
          <a href="#record-snapshots">Instantáneas de registros</a>
        </li>
        <li>
          <a href="#different-schemas">Apuntando a un esquema diferente</a>
        </li>
        <li>
          <a href="#multiple-databases">Configuración de múltiples bases de datos</a>
        </li>
        <li>
          <a href="#injecting-services-into-models">Inyectando servicios en modelos</a>
        </li>
        <li>
          <a href="#disabling-enabling-features">Deshabilitar/habilitar características</a>
        </li>
        <li>
          <a href="#stand-alone-component">Componente independiente</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='working-with'></a>

# Trabajando con Modelos

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una tabla de base de datos correspondiente. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

`Phalcon\Mvc\Model` es la base para todos los modelos en una aplicación Phalcon. Proporciona independencia de base de datos, funcionalidades básicas de CRUD (Crear Leer Actualizar Eliminar, por sus siglas en inglés), capacidades de búsqueda avanzadas y la capacidad para crear relaciones con otros modelos, entre otros servicios. `Phalcon\Mvc\Model` evita la necesidad de tener que usar sentencias SQL porque traduce los métodos dinámicamente a las operaciones del motor de base de datos correspondiente.

<h5 class='alert alert-warning'>Los Modelos están diseñados para trabajar con la base de datos en un nivel alto de abstracción. Si usted necesita trabajar con bases de datos en un nivel inferior y tener mayor control sobre la base de datos consulte la documentación del componente <code>Phalcon\Db</code>.</h5>

<a name='creating'></a>

## Creación de Modelos

Un modelo es una clase que se extiende desde `Phalcon\Mvc\Model`. El nombre de la clase debe estar en notación camel case:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

<h5 class='alert alert-warning'>Si usa PHP 5.4/5.5 se recomienda declarar cada columna que sea parte del modelo con el fin de ahorrar memoria y reducir la asignación de memoria. </h5>

Por defecto, el modelo `Store\Toys\RobotParts` se asigna a la tabla `robot_parts`. Si desea especificar manualmente otro nombre para la tabla asignada, puede utilizar el método `setSource()`:

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

El modelo `RobotParts` ahora se mapea de la tabla `toys_robot_parts`. El método `initialize()` ayuda a configurar este modelo con un comportamiento personalizado, por ejemplo una tabla diferente.

El método `initialize()` se llama sólo una vez durante la solicitud. Este método pretende realizar inicializaciones que se aplican para todas las instancias del modelo creado dentro de la aplicación. Si desea realizar tareas de inicialización para cada instancia creada del modelo puede usar el método `onConstruct()`:

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

Los modelos pueden ser implementados con propiedades públicas, lo que significa que cada propiedad puede ser leída y actualizada desde cualquier parte del código que ha instanciado esa clase de modelo:

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

Otra implementación es usar las funciones getters y setter, que controlan las propiedades que están públicamente disponibles para ese modelo. El beneficio de la utilización de setters y getters es que el desarrollador puede realizar transformaciones y validaciones en los valores para el modelo, lo cual es imposible tratándose de propiedades públicas. Además getters y setters permiten futuros cambios sin cambiar la interfaz de la clase modelo. Así que si cambia un nombre de campo, el único cambio necesario será en la propiedad privada del modelo referido en el getter / setter relevante y en ninguna otra parte del código.

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

Las propiedades públicas proporcionan menor complejidad en el desarrollo. Sin embargo los getters/setters puede aumentar fuertemente la testabilidad, extensibilidad y mantenimiento de aplicaciones. Los desarrolladores pueden decidir qué estrategia es más apropiada para la aplicación que va a crear, dependiendo de las necesidades de la aplicación. El ORM es compatible con ambos esquemas de definición de propiedades.

<h5 class='alert alert-warning'>Los guiones bajos "_" en los nombres de propiedades pueden ser problemáticos al usar getters y setters. </h5>

Si utilizas guiones bajos en los nombres de sus propiedades, deberá utilizar camel case en las declaraciones de getter/setter para poder usar los métodos mágicos. (p. ej. `$model->getPropertyName` en lugar de `$model->getProperty_name`, `$model->findByPropertyName` en lugar de `$model->findByProperty_name`, etcétera.). Como gran parte del sistema espera el uso de camel case, y los guiones bajos se quitan, es aconsejable nombrar sus propiedades en la forma que se muestra a través de la documentación. Puede utilizar un mapa de columna (como se describe anteriormente) para asegurar la correcta asignación de sus propiedades a sus contrapartes de la base de datos.

<a name='records-to-objects'></a>

## Comprensión de Registros a Objetos

Cada instancia de un modelo representa una fila en la tabla. Usted puede fácilmente acceder a datos del registro leyendo las propiedades del objeto. Por ejemplo, para una tabla de 'robots' con los siguientes registros:

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

Podría encontrar cierto registro por su clave primaria y luego imprimir su nombre:

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

Como se puede ver, no es necesario utilizar sentencias SQL crudas. `Phalcon\Mvc\Model` ofrece una abstracción de base de datos de alto nivel para aplicaciones web.

<a name='finding-records'></a>

## Búsqueda de registros

`Phalcon\Mvc\Model` también ofrece varios métodos para consultar registros. Los siguientes ejemplos le muestran cómo consultar uno o varios registros de un modelo:

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

<h5 class='alert alert-warning'>Si desea buscar registros mediante datos externos (como la entrada del usuario) o datos variables, debe utilizar <a href="#binding-parameters">Parámetros enlazados</a>`.</h5>

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

| Parámetro     | Descripción                                                                                                                                                                                                                   | Ejemplo                                                              |
| ------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | Condiciones de búsqueda para la operación de búsqueda. Se utiliza para extraer sólo los registros que cumplan con un criterio especificado. Por defecto `Phalcon\Mvc\Model` asume el primer parámetro como las condiciones. | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | Devolverá las columnas especificadas aquí en lugar de las todas columnas del modelo. Cuando se utiliza esta opción se devuelve un objeto incompleto                                                                           | `'columns' => 'id, name'`                                         |
| `bind`        | Se utiliza junto a las opciones, mediante la sustitución de marcadores y escapando los valores para aumentar la seguridad                                                                                                     | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | Al enlazar parámetros, puede utilizar este parámetro para definir el tipo de datos de los parámetros y aumentar aún más la seguridad                                                                                          | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | Se utiliza para ordenar el conjunto de resultados. Utilice uno o más campos separados por comas.                                                                                                                              | `'order' => 'name DESC, status'`                                  |
| `limit`       | Limitar los resultados de la consulta a cierto rango                                                                                                                                                                          | `'limit' => 10`                                                   |
| `offset`      | Desplazar los resultados de la consulta por una cierta cantidad                                                                                                                                                               | `'offset' => 5`                                                   |
| `group`       | Permite recopilar datos a través de múltiples registros y agrupar los resultados de una o más columnas                                                                                                                        | `'group' => 'name, status'`                                       |
| `for_update`  | Con esta opción, `Phalcon\Mvc\Model` lee los últimos datos disponibles, estableciendo bloqueos exclusivos en cada fila que lea                                                                                              | `'for_update' => true`                                            |
| `shared_lock` | Con esta opción, `Phalcon\Mvc\Model` lee los últimos datos disponibles, estableciendo bloqueos compartidos en cada fila que lea                                                                                             | `'shared_lock' => true`                                           |
| `cache`       | Almacenar en caché el conjunto de resultados, reduciendo el acceso continuo al sistema relacional                                                                                                                             | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | Establece la estrategia de hidratación para representar cada registro devuelto en el resultado                                                                                                                                | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

Si lo prefiere, también hay disponible una manera de crear consultas de una manera orientada a objetos, en lugar de utilizar un array de parámetros:

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

El método estático `query()` devuelve un objeto `Phalcon\Mvc\Model\Criteria` que es amigable con los autocompletadores de los IDE.

Todas las consultas son manejadas internamente como consultas [PHQL](/[[language]]/[[version]]/db-phql). PHQL es un lenguaje de alto nivel, orientado a objetos y similar a SQL. Este lenguaje le proporciona más características para realizar consultas como unir otros modelos, definir grupos, agregar agregaciones, etcétera.

Por último, el método `findFirstBy<nombre de la propiedad>()`. Este método amplía al método `findFirst()` mencionado anteriormente. Le permite realizar rápidamente una recuperación de una tabla utilizando el nombre de la propiedad en el método en sí mismo y se pasa un parámetro que contiene los datos que desea buscar en la columna. Veamos un ejemplo, tomando el modelo de Robots visto anteriormente:

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

Tenemos tres propiedades a trabajar aquí: `$id`, `$name` y `$price`. Entonces supongamos que deseamos recuperar el primer registro en la tabla con el nombre de 'Terminator'. Esto podría escribirse como:

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

Tenga en cuenta que se utilizó 'Name' en el método y se paso la variable `$name`, que contiene el nombre que buscamos en nuestra tabla. Observe también que cuando encontramos una coincidencia con nuestra consulta, todas las otras propiedades también están disponibles para nosotros.

<a name='resultsets'></a>

### Conjuntos de resultados

Mientras `findFirst()` directamente devuelve una instancia de la clase llamada (cuando hay datos para devolver), el método `find()` devuelve un `Phalcon\Mvc\Model\Resultset\Simple`. Se trata de un objeto que encapsula toda la funcionalidad que un conjunto de resultados, como recorrer los registros, buscar registros específicos, contar, etcétera.

Estos objetos son más poderosos que los array regulares. Una de las mejores características del `Phalcon\Mvc\Model\Resultset` es que en cualquier momento hay sólo un registro en memoria. Esto ayuda enormemente en la gestión de memoria especialmente cuando se trabaja con grandes cantidades de datos.

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

Los conjuntos de resultados o Resultset de Phalcon emulan cursores desplazables, usted puede conseguir cualquier fila sólo por acceder a su posición, o moviendo el puntero interno a una posición específica. Tenga en cuenta que algunos sistemas de base de datos no soportan cursores desplazables, Esto obliga a volver a ejecutar la consulta para retroceder el cursor hasta el principio y obtener el registro en la posición solicitada. Del mismo modo, si un resultado es recorrido varias veces, la consulta debe ser ejecutada el mismo número de veces.

Como almacenar resultados de grandes consultas en la memoria podrían consumir muchos recursos, los conjuntos de resultados se obtienen de la base de datos en fragmentos de 32 filas para reducir la necesidad de volver a ejecutar la solicitud en demasiadas ocasiones.

Tenga en cuenta que los conjuntos de resultados pueden ser serializados y almacenados en caché. `Phalcon\Cache` puede ayudar con esa tarea. Sin embargo, serializar datos causa que `Phalcon\Mvc\Model` deba recuperar todos los datos de la base de datos en un array, consumiendo más memoria mientras este proceso ocurre.

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

Hay veces que la lógica de la aplicación requiere manipulación adicional de los datos que se recupera de la base de datos. Anteriormente, extenderiamos el modelo y encapsulariamos la funcionalidad en una clase del modelo o de un trait, regresando a la llama, generalmente, un array con los datos transformados.

Con los conjuntos de resultados personalizados, no es necesario seguir haciendo este trabajo. El conjunto de resultados personalizado encapsulará la funcionalidad que de otro modo estaría en el modelo y puede ser reutilizado por otros modelos, manteniendo así el código [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself). De este modo, el método `find()` no devolverá el `Phalcon\Mvc\Model\Resultset` por defecto, sino uno personalizado. Phalcon permite hacer esto mediante el uso de la función `getResultsetClass()` en el modelo.

Primero tenemos que definir la clase resultset:

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

En el modelo, configuramos la clase en el `getResultsetClass()` de la siguiente manera:

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

y finalmente en el código tenemos algo como esto:

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

La manera más eficiente para filtrar datos es establecer algunos criterios de búsqueda, las bases de datos utilizan índices en las tablas para devolver los datos más rápidamente. Phalcon además permite filtrar los datos mediante PHP usando cualquier recurso que no está disponible en la base de datos:

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

En `Phalcon\Mvc\Model` también se admiten parámetros enlazados. Recomendamos utilizar esta metodología con el fin de eliminar la posibilidad de que su código sea vulnerable a ataques de inyección SQL. Se admiten dos tipos de marcadores: por nombre o numérico. El enlazado de parámetros se hace simplemente de la siguiente manera:

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

Cuando se utilizan a marcadores numéricos, Ud. necesita definirlos como enteros es decir, `1` o `2`. En este caso `'1'` o `'2'` son considerados como cadenas de texto y no como números, por lo que el marcador de posición no podría sustituirse con éxito.

Las cadenas de texto se escapan automáticamente usando [PDO](http://php.net/manual/en/pdo.prepared-statements.php). Esta función tiene en cuenta el conjunto de caracteres de conexión, por lo que se recomienda definir el conjunto de caracteres correcto en los parámetros de conexión o en la configuración de la base de datos, un conjunto de caracteres incorrecto producirá efectos no deseados al almacenar o recuperar datos.

Además puede establecer el parámetro `bindTypes`, este permite definir cómo los parámetros deben regirse según su tipo de datos:

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

<h5 class='alert alert-warning'>Puesto que el tipo de enlace por defecto es <code>Phalcon\Db\Column::BIND_PARAM_STR</code>, no hay necesidad para especificar el parámetro <code>bindTypes</code> si todas las columnas son de ese tipo.</h5>

Si vincula arrays en parámetros enlazados, tenga en cuenta que las claves deben numerarse desde cero:

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

<h5 class='alert alert-warning'>Los parámetros enlazados están disponibles para todos los métodos de consulta como <code>find()</code> y <code>findFirst()</code> como así también en los métodos de cálculo como <code>count()</code>, <code>sum()</code>, <code>average()</code> etcétera. </h5>

Si utiliza 'finders', automáticamente se utilizan parámetros enlazados:

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

## Inicializando y preparando registros buscados

Puede ser el caso que después de obtener un registro de la base de datos sea necesario inicializar los datos, antes de ser utilizados por la aplicación. Puede implementar el método `afterFetch()` en un modelo, este evento se ejecutará justo después de crear la instancia y asignarle los datos:

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

Si utilizas getters/setters en vez de propiedades públicas, puede inicializar el campo una vez que se accede:

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

## Generar Cálculos

Los cálculos (o agregados) son funciones de ayuda comúnmente utilizadas por sistemas de bases de datos tales como `COUNT`, `SUM`, `MAX`, `MIN` o `AVG`. `Phalcon\Mvc\Model` permite utilizar estas funciones directamente con los métodos expuestos.

Ejemplos de COUNT:

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

Ejemplos de SUM:

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

Ejemplos de AVERANGE:

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

Ejemplos MIN/MAX:

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

El método `Phalcon\Mvc\Model::save()` le permite crear o actualizar registros, según sea si ya existen en la tabla asociada al modelo o no. El método `save` llama internamente a los métodos `create` y `update` de `Phalcon\Mvc\Model`. Para que funcione como se espera, es necesario haber definido correctamente una clave primaria en la entidad para determinar si un registro debe ser actualizado o creado.

El método también ejecutará los validadores asociados, claves externas virtuales y eventos que se definen en el modelo:

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

Se puede pasar un array al método `save` para evitar asignar cada columna manualmente. `Phalcon\Mvc\Model` verificará si hay setters implementados para las columnas pasadas en el array, dando prioridad a ellas en lugar de asignar directamente los valores de los atributos:

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

Los valores se asignan directamente o a través del array de atributos, se escapan/sanitizan según el tipo de datos relacionados con atributo. Por lo que puede pasar un array inseguro sin preocuparse de posibles inyecciones de SQL:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<h5 class='alert alert-warning'>Sin precauciones, la asignación masiva podría permitir a los atacantes establecer el valor de cualquier columna de la base de datos. Sólo utilice esta característica si desea permitir a un usuario insertar o actualizar todas las columnas en el modelo, incluso si los campos no están en la forma presentada. </h5>

Además usted puede establecer un parámetro adicional en `save` para definir una lista blanca de campos que pueden ser tenidos en cuenta al hacer la asignación en masa:

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

Cuando una aplicación tiene mucha competencia, nosotros podríamos estar esperando crear un registro pero realmente estamos actualizadolo. Esto podría ocurrir si usamos `Phalcon\Mvc\Model::save()` para conservar los registros de la base de datos. Si queremos estar absolutamente seguros que se ha creado o actualizado un registro, podemos cambiar el uso de la función `save()` por `create()` o `update()`:

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

Los métodos de `create` y `update` también aceptan un array de valores como parámetro.

<a name='delete-records'></a>

## Eliminar Registros

El método `Phalcon\Mvc\Model::delete()` permite eliminar un registro. Se puede utilizar de la siguiente manera:

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

También puede eliminar muchos registros al recorrer un resultset con un foreach:

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

| Operación | Nombre       | ¿Puede detener la operación? | Explicación                                       |
| --------- | ------------ |:----------------------------:| ------------------------------------------------- |
| Deleting  | beforeDelete |              Sí              | Se ejecuta antes de la operación de eliminación   |
| Deleting  | afterDelete  |              No              | Se ejecuta después de la operación de eliminación |

Con los eventos antes mencionados también se pueden definir reglas de negocio en los modelos:

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

Como se mencionó anteriormente, los conjuntos de resultados son colecciones de objetos completos, esto significa que cada resultado devuelto es un objeto que representa una fila en la base de datos. Estos objetos pueden ser modificados y guardados otra vez para persistir:

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

A veces se obtienen registros sólo para ser presentados a un usuario en modo de sólo lectura, en estos casos puede ser útil cambiar la forma en que están representados los registros para facilitar su manejo. La estrategia utilizada para representar objetos en un conjunto de resultados se llama 'modo de hidratación' o 'hydration mode':

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

Modo de hidratación también puede ser pasado como un parámetro de 'find':

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

<a name='identity-columns'></a>

## Columnas de identidad auto generadas

Algunos modelos pueden tener columnas de identidad. Estas columnas suelen ser la clave primaria de la tabla asignada. `Phalcon\Mvc\Model` puede reconocer la columna de identidad omitiendo la misma al generar consultas SQL `INSERT`, por lo que el sistema de base de datos puede generar un valor generado automáticamente para ella. Siempre después de la creación de un registro, se registrará el valor generado por el sistema de base de datos para el campo de identidad:

```php
<?php

$robot->save();

echo 'El ID generado es: ', $robot->id;
```

`Phalcon\Mvc\Model` es capaz de reconocer la columna de identidad. Dependiendo del sistema de base de datos, las columnas pueden ser columnas seriales como en PostgreSQL o columnas auto_increment en MySQL.

PostgreSQL utiliza secuencias para generar valores auto-numeric, por defecto, Phalcon intenta obtener el valor generado de la secuencia `table_field_seq`, por ejemplo: `robots_id_seq`, si esa secuencia tiene un nombre diferente, el método ` getSequenceName()` debe aplicarse:

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

Para decirle a `Phalcon\Mvc\Model` que omita algunos campos en la creación y/o actualización de los registros con el fin de delegar en el sistema de base de datos la asignación de los valores por un disparador o un valor por defecto:

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

Esto omitirá globalmente estos campos en cada operación de `INSERT`/`UPDATE` en la aplicación. Si quiere ignorar diferentes atributos en diferentes operaciones de `INSERT`/`UPDATE` puede especificar un segundo parámetro (boolean) - `true` para el reemplazo. Forzando un valor por defecto se puede hacer de la siguiente manera:

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

Un callback también puede ser utilizado para crear una asignación condicional de valores por defecto:

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

<h5 class='alert alert-warning'>Nunca utilice un <code>Phalcon\Db\RawValue</code> para asignar datos externos (como la entrada del usuario) o datos variables. El valor de estos campos se omite al enlazar parámetros a la consulta. Por lo tanto podría utilizarse para atacar la aplicación con inyección SQL. </h5>

<a name='dynamic-updates'></a>

## Actualización Dinámica

Las instrucciones de `UPDATE` en SQL son creadas, por defecto, con todas las columnas definidas en el modelo (actualización completa de filas utilizando todos los campos). Usted puede especificar que modelos pueden realizar actualizaciones dinámicas, en este caso, sólo los campos que habían cambiado se utilizan para crear la instrucción SQL final.

En algunos casos esto podría mejorar el rendimiento al reducir el tráfico entre la aplicación y el servidor de base de datos, esto ayuda especialmente cuando la tabla tiene campos blob o text:

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

ORM soporta mapas de columnas independientes, lo que permite al desarrollador utilizar nombres de columnas diferentes en el modelo a los de la tabla. Phalcon reconocerá los nuevos nombres de columna y renombrará en consecuencia para que coincida con las respectivas columnas de la base de datos. Esta es una gran característica cuando uno necesita cambiar el nombre de campos en la base de datos sin tener que preocuparse por todas las consultas en el código. Un cambio en el mapa de columnas y el modelo se encargará del resto. Por ejemplo:

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

Naturalmente puede utilizar los nuevos nombres en el código:

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

Considere lo siguiente al renombrar sus columnas:

- Referencias a atributos en relaciones/validadores deben utilizar los nuevos nombres
- Hacer referencia a nombres de columna reales resultará en una excepción por el ORM

El mapa de columnas independiente le permite:

- Escribir aplicaciones que utilizan sus propios convenciones
- Eliminar prefijos/sufijos del proveedor en tu código
- Cambiar nombres de columnas sin cambiar su código de aplicación

<a name='record-snapshots'></a>

## Instantáneas de registros

Modelos específicos pueden establecer para mantener una instantánea del registro cuando se consultan. Puede utilizar esta función para implementar la auditorias o simplemente para saber qué campos se cambian según los datos consultados de la persistencia:

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

Al activar esta función la aplicación consume un poco más de memoria para mantener los valores originales de la persistencia. En los modelos que tienen esta característica activada puede comprobar qué campos se modifican de la siguiente manera:

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

<a name='different-schemas'></a>

## Apuntando a un esquema diferente

Si un modelo se asigna a una tabla en un esquema/bases de datos distintas a la predeterminada. Puede utilizar el método `setSchema()` para redefinirlo:

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

## Configuración de múltiples bases de datos

En Phalcon, todos los modelos pueden pertenecer a la misma conexión de base de datos o tener una individual. Actualmente, cuando `Phalcon\Mvc\Model` necesita conectarse a la base de datos pide el servicio `db` en contenedor de servicios de la aplicación. Usted puede sobrescribir este servicio configurándolo en el método `initialize()`:

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

Pero Phalcon le ofrece más flexibilidad, puede definir la conexión que debe utilizar para `read` y para `write`. Esto es especialmente útil para balancear la carga a sus bases de datos implementando de una arquitectura master-slave:

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

El ORM también proporciona instalaciones de Sharding Horizontal, por lo que le permite implementar una selección de 'fragmentos' según las condiciones actuales de la consulta:

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

El método `selectReadConnection()` es utilizado para elegir la conexión correcta, este método intercepta cualquier consulta nueva ejecutada:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst('id = 101');
```

<a name='injecting-services-into-models'></a>

## Inyectando servicios en modelos

Si requiere acceder a los servicios de la aplicación dentro de un modelo, en el ejemplo se explica cómo hacerlo:

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

El evento `notSaved` se desencadena cada vez que falla una acción de `create` o `update`. Así que estamos mostrando los mensajes de validación obteniendo el servicio `flash` del contenedor DI. Haciendo esto, no tenemos que imprimir los mensajes después de cada save.

<a name='disabling-enabling-features'></a>

## Deshabilitar/habilitar características

En el ORM se ha implementado un mecanismo que permite activar o desactivar opciones globalmente sobre la marcha o características específicas. Según cómo utilice el ORM puede deshabilitar lo que usted no está usando. Estas opciones también pueden ser temporalmente desactivadas si es necesario:

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

Las opciones disponibles son:

| Opción             | Descripción                                                                                    | Predeterminado |
| ------------------ | ---------------------------------------------------------------------------------------------- |:--------------:|
| events             | Habilita o inhabilita los eventos de callbacks, hooks y notificaciones de todos los modelos    |     `true`     |
| columnRenaming     | Activa/desactiva el renombrado de columnas                                                     |     `true`     |
| notNullValidations | El ORM valida automáticamente las columnas no nulas en la tabla asignada                       |     `true`     |
| virtualForeignKeys | Activa/desactiva las claves externas virtuales                                                 |     `true`     |
| phqlLiterals       | Habilita o inhabilita literales en el analizador PHQL                                          |     `true`     |
| lateStateBinding   | Activa/desactiva el enlace de estado tardío del método `Phalcon\Mvc\Model::cloneResultMap()` |    `false`     |

<a name='stand-alone-component'></a>

## Componente independiente

A continuación mostraremos como utilizar `Phalcon\Mvc\Model` en modo independiente:

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