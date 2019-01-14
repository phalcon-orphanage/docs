* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Relaciones de modelos

<a name='relationships'></a>

## Relaciones entre modelos

Hay cuatro tipos de relaciones: uno-a-uno, uno-a-muchos, muchos-a-uno y muchos-a-muchos. La relaciones pueden ser unidireccionales o bidireccionales y cada una puede ser simple (un modelo uno a uno) o más complejas (una combinación de modelos). El administrador del modelos administra las restricciones de claves foráneas para estas relaciones, la definición de estas ayuda a la integridad referencial, así como un acceso fácil y rápido a registros relacionados con un modelo. Con la implementación de las relaciones, es fácil acceder a datos en modelos relacionados de cada registro de manera uniforme.

<a name='unidirectional'></a>

### Relaciones unidireccionales

Las relaciones unidireccionales son aquellas que se generan en relación a uno con el otro pero no viceversa.

<a name='bidirectional'></a>

### Relaciones bidireccionales

Las relaciones bidireccionales construyen relaciones en ambos modelos y cada modelo define la relación inversa de la otra.

<a name='defining'></a>

### Definiendo las relaciones

En Phalcon, las relaciones se deben definir en el método `initialize()` de un modelo. Los métodos `belongsTo()`, `hasOne()`, `hasMany()` y `hasManyToMany()` definen la relación entre uno o más campos del modelo actual a los campos de otro modelo. Cada uno de estos métodos requiere 3 parámetros: campos locales, modelo que se hace referencia, campos a los que hace referencia.

| Método        | Descripción                |
| ------------- | -------------------------- |
| hasMany       | Define una relación 1-n    |
| hasOne        | Define una relación de 1-1 |
| belongsTo     | Define una relación n-1    |
| hasManyToMany | Define una relación n-n    |

El siguiente esquema muestra 3 tablas cuyas relaciones nos servirán como un ejemplo en cuanto a las relaciones:

```sql
CREATE TABLE robots (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(70) NOT NULL,
    type varchar(32) NOT NULL,
    year int(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE robots_parts (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    robots_id int(10) NOT NULL,
    parts_id int(10) NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY (id),
    KEY robots_id (robots_id),
    KEY parts_id (parts_id)
);

CREATE TABLE parts (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(70) NOT NULL,
    PRIMARY KEY (id)
);
```

* El modelo de `Robots` tiene muchas `RobotsParts`.
* El modelo de `Parts` tiene muchos `RobotsParts`.
* El modelo `RobotsParts` pertenece a los modelos `Robots` y `Parts` con una relación de muchos a uno.
* El modelo `Robots` tiene una relación muchos-a-muchos con `Parts` a través de `RobotsParts`.

Compruebe el diagrama EER para entender mejor las relaciones:

![](/assets/images/content/models-relationships-eer-1.png)

Los modelos con sus relaciones podrían implementarse de la siguiente manera:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'robots_id'
        );
    }
}
```

```php
<?php

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'parts_id'
        );
    }
}
```

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id'
        );

        $this->belongsTo(
            'parts_id',
            'Parts',
            'id'
        );
    }
}
```

El primer parámetro indica el campo del modelo local utilizado en la relación; la segunda indica el nombre del modelo referenciado y la tercera el nombre del campo en el modelo referenciado. También puede usar arrays para definir varios campos en la relación.

Las relaciones muchos a muchos requieren 3 modelos y definir los atributos que intervienen en la relación:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasManyToMany(
            'id',
            'RobotsParts',
            'robots_id', 'parts_id',
            'Parts',
            'id'
        );
    }
}
```

<a name='parameters'></a>

#### Relationships with parameters

Depending on the needs of our application we might want to store data in one table, that describe different behaviors. For instance you might want to only have a table called `parts` which has a field `type` describing the type of the part.

Using relationships, we can get only those parts that relate to our Robot that are of certain type. Defining that constraint in our relationship allows us to let the model do all the work.

```php
<?php

 namespace Store\Toys;

 use Phalcon\Mvc\Model;

 class Robots extends Model
 {
     public $id;

     public $name;

     public $type;

     public function initialize()
     {
         $this->hasMany(
             'id',
             Parts::class,
             'robotId',
             [
                 'reusable' => true, // cache related data
                 'alias'    => 'mechanicalParts',
                 'params'   => [
                     'conditions' => 'robotTypeId = :type:',
                     'bind'       => [
                         'type' => 4,
                     ]
                 ]
             ]
         );
     }
 }
 ```

<a name='multiple-fields'></a>
#### Multiple field relationships
There are times where relationships need to be defined on a combination of fields and not only one. Consider the following example:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $type;
}
```

and

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $id;

    public $robotId;

    public $robotType;

    public $name;
}
```

In the above we have a `Robots` model which has three properties. A unique `id`, a `name` and a `type` which defines what this robot is (mechnical, etc.); In the `Parts` model we also have a `name` for the part but also fields that tie the robot and its type with a specific part.

Using the relationships options discussed earlier, binding one field between the two models will not return the results we need. For that we can use an array in our relationship:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $type;

    public function initialize()
    {
        $this->hasOne(
            ['id', 'type'],
            Parts::class,
            ['robotId', 'robotType'],
            [
                'reusable' => true, // cache related data
                'alias'    => 'parts',
            ]
        );
    }
}
```

**NOTE** The field mappings in the relationship are one for one i.e. the first field of the source model array matches the first field of the target array etc. The field count must be identical in both source and target models.

<a name='taking-advantage-of'></a>

### Aprovechando las relaciones

Al definir explícitamente las relaciones entre modelos, es fácil encontrar registros relacionados para un registro concreto.

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

foreach ($robot->robotsParts as $robotPart) {
    echo $robotPart->parts->name, "\n";
}
```

Phalcon utiliza los métodos mágicos `__set`/`__get`/`__call` para almacenar o recuperar datos relacionados usando las relaciones.

Al acceder a un atributo con el mismo nombre que la relación recuperará el o los registros relacionados.

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// Todos los registros relacionados en RobotsParts
$robotsParts = $robot->robotsParts;
```

Además, puede utilizar un getter mágico:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// Todos los registros relacionados en RobotsParts
$robotsParts = $robot->getRobotsParts();

// Pasando parámetros
$robotsParts = $robot->getRobotsParts(
    [
        'limit' => 5,
    ]
);
```

If the called method has a `get` prefix [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will return a `findFirst()`/`find()` result. El siguiente ejemplo compara la recuperación de resultados relacionados con el uso de métodos mágicos y sin la utilización de ellos:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// El modelo Robots tiene una relación 1-n (hasMany) con RobotsParts 
$robotsParts = $robot->robotsParts;

// Solo Parts que coinciden con las condiciones
$robotsParts = $robot->getRobotsParts(
    [
        'created_at = :date:',
        'bind' => [
            'date' => '2015-03-15'
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// El modelo RobotsParts tiene una relación n-1 (belongsTo)
$robot = $robotPart->robots;
```

Obteniendo registros relacionados manualmente:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// El modelo Robots tiene una relación 1-n (hasMany) con RobotsParts
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id:',
        'bind' => [
            'id' => $robot->id,
        ]
    ]
);

// Solo las Parts que coinciden con la condición
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id: AND created_at = :date:',
        'bind' => [
            'id'   => $robot->id,
            'date' => '2015-03-15',
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// El modelo RobotsParts tiene una relación n-1 (belongsTo) con RobotsParts then
$robot = Robots::findFirst(
    [
        'id = :id:',
        'bind' => [
            'id' => $robotPart->robots_id,
        ]
    ]
);
```

El prefijo `get` se utiliza para `find()`/`findFirst()` registros relacionados. Dependiendo del tipo de relación utilizará `find()` o `findFirst()`:

| Tipo             | Descripción                                                                                                                             | Método implícito    |
| ---------------- | --------------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| Belongs-To       | Devuelve una instancia del modelo relacionado directamente                                                                              | findFirst           |
| Has-One          | Devuelve una instancia del modelo relacionado directamente                                                                              | findFirst           |
| Has-Many         | Devuelve una colección de instancias del modelo, según el modelo de referencia                                                          | find                |
| Has-Many-to-Many | Devuelve una colección de instancias de modelo del modelo de referencia, implícitamente hace 'inner joins' con los modelos involucrados | (consulta compleja) |

También puede utilizar el prefijo `count` para devolver un entero que indica el recuento de los registros relacionados:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

echo 'The robot has ', $robot->countRobotsParts(), " parts\n";
```

<a name='aliases'></a>

### Relaciones con alias

Para explicar mejor cómo funcionan los alias, vamos a ver el siguiente ejemplo:

La tabla `robots_similar` tiene la función de definir qué robots son similares a otros:

```sql
mysql> desc robots_similar;
+-------------------+------------------+------+-----+---------+----------------+
| Field             | Type             | Null | Key | Default | Extra          |
+-------------------+------------------+------+-----+---------+----------------+
| id                | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| robots_id         | int(10) unsigned | NO   | MUL | NULL    |                |
| similar_robots_id | int(10) unsigned | NO   |     | NULL    |                |
+-------------------+------------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)
```

Los campos `robots_id` y `similar_robots_id` tienen una relación con el modelo Robots:

![](/assets/images/content/models-relationships-eer-1.png)

Un modelo que asigna esta tabla y sus relaciones es el siguiente:

```php
<?php

class RobotsSimilar extends Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id'
        );

        $this->belongsTo(
            'similar_robots_id',
            'Store\Toys\Robots',
            'id'
        );
    }
}
```

Puesto que las relaciones apuntan a un mismo modelo (Robots), la obtención los registros relacionados con la relación no puede ser clara:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Devuelve el registro relacionado basado en la columna (robots_id)
// También como es un belongsTo sólo está devolviendo un registro
// pero el nombre 'getRobots' parece implicar que devuelve más de uno
$robot = $robotsSimilar->getRobots();

// pero, cómo obtener el registro relacionado basado en la columna (similar_robots_id)
// si ambas relaciones tienen el mismo nombre?
```

Los alias nos permiten renombrar las relaciones para resolver estos problemas:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsSimilar extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'alias' => 'Robot',
            ]
        );

        $this->belongsTo(
            'similar_robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'alias' => 'SimilarRobot',
            ]
        );
    }
}
```

Con los alias podemos obtener fácilmente los registros relacionados. También puede utilizar el método `getRelated()` para acceder a la relación con el nombre del alias:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Retorna los registros relacionados basados en la columna 'robots_id'
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;
$robot = $robotsSimilar->getRelated('Robot');

// Retorna los registros relacionados basados en la columna 'similar_robots_id'
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
$similarRobot = $robotsSimilar->getRelated('SimilarRobot');
```

<a name='getters-vs-methods'></a>

#### Getters mágicos vs métodos explícitos

La mayoría de los IDEs y editores con capacidades de auto-completado no pueden deducir los tipos correctos al utilizar getters mágicos (métodos y propiedades). Para superar eso, puede utilizar un docblock en la clase que especifica qué acciones mágicas están disponibles, ayudando al IDE para producir un mejor autocompletado:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

/**
 * Clase del modelo para la tabla robots.
 * @property Simple|RobotsParts[] $robotsParts
 * @method   Simple|RobotsParts[] getRobotsParts($parameters = null)
 * @method   integer              countRobotsParts()
 */
class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'robots_id'
        );
    }
}
```

<a name='conditionals'></a>

## Condicionales

También puede crear relaciones basadas en condicionales. Al consultar la relación, la condición se agregará automáticamente a la consulta:

```php
<?php

use Phalcon\Mvc\Model;

// Empresas que tienen facturas emitidas a ellos (pagas/impagas)
// Model Facturas
class Invoices extends Model
{

}

// Model Empresas
class Companies extends Model
{
    public function initialize()
    {
        // Relación: todas las facturas
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias' => 'Invoices'
            ]
        );

        // Relación: facturas pagadas
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias'    => 'InvoicesPaid',
                'params'   => [
                    'conditions' => "inv_status = 'paid'"
                ]
            ]
        );

        // Reglación: facturas impagas con parámetros enlazados
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias'    => 'InvoicesUnpaid',
                'params'   => [
                    'conditions' => "inv_status <> :status:",
                    'bind' => ['status' => 'unpaid']
                ]
            ]
        );
    }
}
```

Además, puede utilizar el segundo parámetro de `getRelated()` al acceder a la relación desde el objeto modelo para filtrar u ordenar la relación:

```php
<?php

// Facturas impagas
$company = Companies::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => ['id' => 1],
    ]
);

$unpaidInvoices = $company->InvoicesUnpaid;
$unpaidInvoices = $company->getInvoicesUnpaid();
$unpaidInvoices = $company->getRelated('InvoicesUnpaid');
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    ['conditions' => "inv_status = 'paid'"]
);

// Ordenadas
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    [
        'conditions' => "inv_status = 'paid'",
        'order'      => 'inv_created_date ASC',
    ]
);
```

<a name='virtual-foreign-keys'></a>

## Claves externas virtuales

De forma predeterminada, las relaciones no actúan como claves foráneas de la base de datos, es decir, si se intenta insertar o actualizar un valor sin tener un valor válido en el modelo de referenciado, Phalcon no producirá un mensaje de validación. Se puede modificar este comportamiento agregando un cuarto parámetro en la definición de una relación.

El modelo RobotsPart se puede cambiar para demostrar esta característica:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'foreignKey' => true
            ]
        );

        $this->belongsTo(
            'parts_id',
            'Parts',
            'id',
            [
                'foreignKey' => [
                    'message' => 'El part_id no existe en el modelo Parts'
                ]
            ]
        );
    }
}
```

Si modifica una relación `belongsTo()` para actuar como clave externa, validará que los valores insertados o actualizados en los campos tienen un valor válido en el modelo referenciado. Del mismo modo, si un `hasMany()`/`hasOne()` se altera, se validará que los registros no se puedan eliminar si ese registro se utiliza en un modelo referenciado.

```php
<?php

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'parts_id',
            [
                'foreignKey' => [
                    'message' => 'La parte no puede ser borrada porque hay robots utilizandola',
                ]
            ]
        );
    }
}
```

Una clave externa virtual se puede configurar para permitir valores null de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'parts_id',
            'Parts',
            'id',
            [
                'foreignKey' => [
                    'allowNulls' => true,
                    'message'    => 'El part_id no existe en el modelo Parts',
                ]
            ]
        );
    }
}
```

<a name='cascade-restrict-actions'></a>

### Acciones en cascada o restringidas

Las relaciones que actúan como llaves foráneas virtuales por defecto restringen la creación/actualización/eliminación de registros para mantener la integridad de los datos:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'Parts',
            'robots_id',
            [
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE,
                ]
            ]
        );
    }
}
```

Con el código anterior, se borrarán todos los registros de referenciados (parts) si se elimina el registro maestro (robot).

<a name='storing-related-records'></a>

## Almacenamiento de registros relacionados

Las propiedades mágicas se pueden utilizar para almacenar un registro y sus propiedades relacionadas:

```php
<?php

// Crear un artista
$artist = new Artists();

$artist->name    = 'Shinichi Osawa';
$artist->country = 'Japón';

// Crear un álbum
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist; // Asignar el artista
$album->year   = 2008;

// Guardar ambos registros
$album->save();
```

Guardando un registro y sus registros relacionados en una relación has-many:

```php
<?php

// Obtener un artista existente
$artist = Artists::findFirst(
    'name = 'Shinichi Osawa''
);

// Crear un álbum
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist;

$songs = [];

// Crear una primer canción
$songs[0]           = new Songs();
$songs[0]->name     = 'Star Guitar';
$songs[0]->duration = '5:54';

// Crear una segunda canción
$songs[1]           = new Songs();
$songs[1]->name     = 'Last Days';
$songs[1]->duration = '4:29';

// Asignar el array de canciones
$album->songs = $songs;

// Guardar el algum y sus canciones
$album->save();
```

Guardando el álbum y el artista al mismo tiempo, implícitamente se hace uso de una transacción, por lo que si algo sale mal al guardar los registros relacionados, el padre tampoco se guardará. Los mensajes se devuelven al usuario para obtener información sobre los errores.

Nota: No es posible agregar entidades relacionadas sobrecargando los métodos siguientes:

* `Phalcon\Mvc\Model::beforeSave()`
* `Phalcon\Mvc\Model::beforeCreate()`
* `Phalcon\Mvc\Model::beforeUpdate()`

Es necesario sobrecargar el método `Phalcon\Mvc\Model::save()` del modelo para que esto funcione.

<a name='operations-over-resultsets'></a>

## Operaciones sobre conjuntos de resultados

If a resultset is composed of complete objects, model operations can be performed on those objects. For example:

```php
<?php

/** @var RobotType $type */
$type = $robots->getRelated('type');

$type->name = 'Some other type';
$result = $type->save();


// Obtener el tipo de robot relacionado pero solo la columna `name`
$type = $robots->getRelated('type', ['columns' => 'name']);

$type->name = 'Some other type';

// Esto fallará porque `$type` no es un objecto completo
$result = $type->save();

```

<a name='updating-related-records'></a>

### Actualización de registros relacionados

En lugar de hacer esto:

```php
<?php

$parts = $robots->getParts();

foreach ($parts as $part) {
    $part->stock      = 100;
    $part->updated_at = time();

    if ($part->update() === false) {
        $messages = $part->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

Usted puede hacer esto:

```php
<?php

$robots->getParts()->update(
    [
        'stock'      => 100,
        'updated_at' => time(),
    ]
);
```

El método `update` también acepta una función anónima para filtrar qué registros que deben ser actualizados:

```php
<?php

$data = [
    'stock'      => 100,
    'updated_at' => time(),
];

// Actualiza todas las partes excepto las "TYPE_BASIC"
$robots->getParts()->update(
    $data,
    function ($part) {
        if ($part->type === Part::TYPE_BASIC) {
            return false;
        }

        return true;
    }
);
```

<a name='deleting-related-records'></a>

### Eliminar registros relacionados

En lugar de hacer esto:

```php
<?php

$parts = $robots->getParts();

foreach ($parts as $part) {
    if ($part->delete() === false) {
        $messages = $part->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

Usted puede hacer esto:

```php
<?php

$robots->getParts()->delete();
```

El método `delete()` también acepta una función anónima para filtrar qué registros deben ser eliminados:

```php
<?php

// Eliminar solo las partes con stock mayor o igual a cero
$robots->getParts()->delete(
    function ($part) {
        if ($part->stock < 0) {
            return false;
        }

        return true;
    }
);
```