* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Relaciones de modelos

<a name='relationships'></a>

## Relaciones entre modelos

There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access of related records to a model. Through the implementation of relations, it is easy to access data in related models from each record in a uniform way.

<a name='unidirectional'></a>

### Relaciones unidireccionales

Unidirectional relations are those that are generated in relation to one another but not vice versa.

<a name='bidirectional'></a>

### Relaciones bidireccionales

The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

<a name='defining'></a>

### Definiendo las relaciones

In Phalcon, relationships must be defined in the `initialize()` method of a model. The methods `belongsTo()`, `hasOne()`, `hasMany()` and `hasManyToMany()` define the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3 parameters: local fields, referenced model, referenced fields.

| Método        | Descripción                |
| ------------- | -------------------------- |
| hasMany       | Define una relación 1-n    |
| hasOne        | Define una relación de 1-1 |
| belongsTo     | Define una relación n-1    |
| hasManyToMany | Define una relación n-n    |

The following schema shows 3 tables whose relations will serve us as an example regarding relationships:

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

Check the EER diagram to understand better the relations:

![](/assets/images/content/models-relationships-eer-1.png)

The models with their relations could be implemented as follows:

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

The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced model and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.

Many to many relationships require 3 models and define the attributes involved in the relationship:

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

When explicitly defining the relationships between models, it is easy to find related records for a particular record.

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

foreach ($robot->robotsParts as $robotPart) {
    echo $robotPart->parts->name, "\n";
}
```

Phalcon uses the magic methods `__set`/`__get`/`__call` to store or retrieve related data using relationships.

By accessing an attribute with the same name as the relationship will retrieve all its related record(s).

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// Todos los registros relacionados en RobotsParts
$robotsParts = $robot->robotsParts;
```

Also, you can use a magic getter:

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

If the called method has a `get` prefix [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will return a `findFirst()`/`find()` result. The following example compares retrieving related results with using magic methods and without:

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

Getting related records manually:

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

The prefix `get` is used to `find()`/`findFirst()` related records. Depending on the type of relation it will use `find()` or `findFirst()`:

| Tipo             | Descripción                                                                                                                             | Método implícito    |
| ---------------- | --------------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| Belongs-To       | Devuelve una instancia del modelo relacionado directamente                                                                              | findFirst           |
| Has-One          | Devuelve una instancia del modelo relacionado directamente                                                                              | findFirst           |
| Has-Many         | Devuelve una colección de instancias del modelo, según el modelo de referencia                                                          | find                |
| Has-Many-to-Many | Devuelve una colección de instancias de modelo del modelo de referencia, implícitamente hace 'inner joins' con los modelos involucrados | (consulta compleja) |

You can also use the `count` prefix to return an integer denoting the count of the related records:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

echo 'The robot has ', $robot->countRobotsParts(), " parts\n";
```

<a name='aliases'></a>

### Relaciones con alias

To explain better how aliases work, let's check the following example:

The `robots_similar` table has the function to define what robots are similar to others:

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

Both `robots_id` and `similar_robots_id` have a relation to the model Robots:

![](/assets/images/content/models-relationships-eer-1.png)

A model that maps this table and its relationships is the following:

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

Since both relations point to the same model (Robots), obtain the records related to the relationship could not be clear:

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

The aliases allow us to rename both relationships to solve these problems:

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

With the aliasing we can get the related records easily. You can also use the `getRelated()` method to access the relationship using the alias name:

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

Most IDEs and editors with auto-completion capabilities can not infer the correct types when using magic getters (both methods and properties). To overcome that, you can use a class docblock that specifies what magic actions are available, helping the IDE to produce a better auto-completion:

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

You can also create relationships based on conditionals. When querying based on the relationship the condition will be automatically appended to the query:

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

Additionally, you can use the second parameter of `getRelated()` when accessing your relationship from your model object to further filter or order your relationship:

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

By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid value in the referenced model, Phalcon will not produce a validation message. You can modify this behavior by adding a fourth parameter when defining a relationship.

The RobotsPart model can be changed to demonstrate this feature:

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

If you alter a `belongsTo()` relationship to act as foreign key, it will validate that the values inserted/updated on those fields have a valid value on the referenced model. Similarly, if a `hasMany()`/`hasOne()` is altered it will validate that the records cannot be deleted if that record is used on a referenced model.

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

A virtual foreign key can be set up to allow null values as follows:

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

Relationships that act as virtual foreign keys by default restrict the creation/update/deletion of records to maintain the integrity of data:

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

The above code set up to delete all the referenced records (parts) if the master record (robot) is deleted.

<a name='storing-related-records'></a>

## Almacenamiento de registros relacionados

Magic properties can be used to store a record and its related properties:

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

Saving a record and its related records in a has-many relation:

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

Saving the album and the artist at the same time implicitly makes use of a transaction so if anything goes wrong with saving the related records, the parent will not be saved either. Messages are passed back to the user for information regarding any errors.

Note: Adding related entities by overloading the following methods is not possible:

* `Phalcon\Mvc\Model::beforeSave()`
* `Phalcon\Mvc\Model::beforeCreate()`
* `Phalcon\Mvc\Model::beforeUpdate()`

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

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

Instead of doing this:

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

you can do this:

```php
<?php

$robots->getParts()->update(
    [
        'stock'      => 100,
        'updated_at' => time(),
    ]
);
```

`update` also accepts an anonymous function to filter what records must be updated:

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

Instead of doing this:

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

you can do this:

```php
<?php

$robots->getParts()->delete();
```

`delete()` also accepts an anonymous function to filter what records must be deleted:

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