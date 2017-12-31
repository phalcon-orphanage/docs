<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Relaciones de modelos</a> <ul>
        <li>
          <a href="#relationships">Relaciones entre modelos</a> <ul>
            <li>
              <a href="#unidirectional">Relaciones unidireccionales</a>
            </li>
            <li>
              <a href="#bidirectional">Relaciones bidireccionales</a>
            </li>
            <li>
              <a href="#defining">Definiendo las relaciones</a>
            </li>
            <li>
              <a href="#taking-advantage-of">Aprovechando las relaciones</a>
            </li>
            <li>
              <a href="#aliases">Relaciones con alias</a> <ul>
                <li>
                  <a href="#getters-vs-methods">Getters mágicos vs métodos explícitos</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#virtual-foreign-keys">Claves externas virtuales</a> <ul>
            <li>
              <a href="#cascade-restrict-actions">Acciones en cascada o restringidas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#storing-related-records">Almacenamiento de registros relacionados</a>
        </li>
        <li>
          <a href="#operations-over-resultsets">Operaciones sobre conjuntos de resultados</a> <ul>
            <li>
              <a href="#updating-related-records">Actualización de registros relacionados</a>
            </li>
            <li>
              <a href="#deleting-related-records">Eliminar registros relacionados</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

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

- El modelo de `Robots` tiene muchas `RobotsParts`.
- El modelo de `Parts` tiene muchos `RobotsParts`.
- El modelo `RobotsParts` pertenece a los modelos `Robots` y `Parts` con una relación de muchos a uno.
- El modelo `Robots` tiene una relación muchos-a-muchos con `Parts` a través de `RobotsParts`.

Compruebe el diagrama EER para entender mejor las relaciones:

![](/images/content/models-relationships-eer-1.png)

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

Si el método llamado tiene un prefijo `get`, el `Phalcon\Mvc\Model` devolverá un resultado `findFirst()`/`find()`. El siguiente ejemplo compara la recuperación de resultados relacionados con el uso de métodos mágicos y sin la utilización de ellos:

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
| Belongs-To       | Devuelve directamente una instancia del modelo del registro relacionado                                                                 | findFirst           |
| Has-One          | Devuelve directamente una instancia de modelo de registro relacionado                                                                   | findFirst           |
| Has-Many         | Devuelve una colección de instancias de modelo del modelo de referencia                                                                 | find                |
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

![](/images/content/models-relationships-eer-1.png)

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

Con los alias podemos conseguir fácilmente los registros relacionados:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Devuelve los registros relacionados con la columna (robots_id)
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;

// Devuleve los registros relacionados con la columna (similar_robots_id)
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
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

- `Phalcon\Mvc\Model::beforeSave()`
- `Phalcon\Mvc\Model::beforeCreate()`
- `Phalcon\Mvc\Model::beforeUpdate()`

Es necesario sobrecargar el método `Phalcon\Mvc\Model::save()` del modelo para que esto funcione.

<a name='operations-over-resultsets'></a>

## Operaciones sobre conjuntos de resultados

Si un conjunto de resultados se compone de objetos completos, el conjunto de resultados está en la capacidad para realizar operaciones sobre los registros obtenidos de una manera simple:

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