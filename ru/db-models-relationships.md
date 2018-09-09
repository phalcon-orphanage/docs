<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Отношения модели</a> <ul>
        <li>
          <a href="#relationships">Отношения между моделями</a> <ul>
            <li>
              <a href="#unidirectional">Однонаправленные отношения</a>
            </li>
            <li>
              <a href="#bidirectional">Двунаправленные отношения</a>
            </li>
            <li>
              <a href="#defining">Определение отношений</a>
            </li>
            <li>
              <a href="#taking-advantage-of">Преимущества отношений</a>
            </li>
            <li>
              <a href="#aliases">Синонимы отношений</a> <ul>
                <li>
                  <a href="#getters-vs-methods">Магические методы против явных</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#virtual-foreign-keys">Виртуальные внешние ключи</a> <ul>
            <li>
              <a href="#cascade-restrict-actions">Cascade/Restrict действия </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#storing-related-records">Связаное сохранение записей</a>
        </li>
        <li>
          <a href="#operations-over-resultsets">Операции над набором результатов</a> <ul>
            <li>
              <a href="#updating-related-records">Обновление связанных записей</a>
            </li>
            <li>
              <a href="#deleting-related-records">Удаление связанных записей</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Model Relationships

<a name='relationships'></a>

## Relationships between Models

There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access of related records to a model. Through the implementation of relations, it is easy to access data in related models from each record in a uniform way.

<a name='unidirectional'></a>

### Unidirectional relationships

Unidirectional relations are those that are generated in relation to one another but not vice versa.

<a name='bidirectional'></a>

### Bidirectional relations

The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

<a name='defining'></a>

### Defining relationships

In Phalcon, relationships must be defined in the `initialize()` method of a model. The methods `belongsTo()`, `hasOne()`, `hasMany()` and `hasManyToMany()` define the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3 parameters: local fields, referenced model, referenced fields.

| Метод         | Description                |
| ------------- | -------------------------- |
| hasMany       | Defines a 1-n relationship |
| hasOne        | Defines a 1-1 relationship |
| belongsTo     | Defines a n-1 relationship |
| hasManyToMany | Defines a n-n relationship |

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

- The model `Robots` has many `RobotsParts`.
- The model `Parts` has many `RobotsParts`.
- The model `RobotsParts` belongs to both `Robots` and `Parts` models as a many-to-one relation.
- The model `Robots` has a relation many-to-many to `Parts` through `RobotsParts`.

Check the EER diagram to understand better the relations:

![](/images/content/models-relationships-eer-1.png)

Модели с их отношениями могут быть реализованы следующим образом:

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

Отношение “многие-ко-многим” требуют 3 модели и определение атрибутов, участвующих в отношениях:

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

### Taking advantage of relationships

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

// All the related records in RobotsParts
$robotsParts = $robot->robotsParts;
```

Also, you can use a magic getter:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// All the related records in RobotsParts
$robotsParts = $robot->getRobotsParts();

// Passing parameters
$robotsParts = $robot->getRobotsParts(
    [
        'limit' => 5,
    ]
);
```

If the called method has a `get` prefix `Phalcon\Mvc\Model` will return a `findFirst()`/`find()` result. The following example compares retrieving related results with using magic methods and without:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots model has a 1-n (hasMany)
// relationship to RobotsParts then
$robotsParts = $robot->robotsParts;

// Only parts that match conditions
$robotsParts = $robot->getRobotsParts(
    [
        'created_at = :date:',
        'bind' => [
            'date' => '2015-03-15'
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// RobotsParts model has a n-1 (belongsTo)
// relationship to RobotsParts then
$robot = $robotPart->robots;
```

Getting related records manually:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots model has a 1-n (hasMany)
// relationship to RobotsParts, then
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id:',
        'bind' => [
            'id' => $robot->id,
        ]
    ]
);

// Only parts that match conditions
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

// RobotsParts model has a n-1 (belongsTo)
// relationship to RobotsParts then
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

| Type             | Description                                                                                                                | Implicit Method |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------- | --------------- |
| Belongs-To       | Returns a model instance of the related record directly                                                                    | findFirst       |
| Has-One          | Returns a model instance of the related record directly                                                                    | findFirst       |
| Has-Many         | Returns a collection of model instances of the referenced model                                                            | find            |
| Has-Many-to-Many | Returns a collection of model instances of the referenced model, it implicitly does 'inner joins' with the involved models | (complex query) |

You can also use the `count` prefix to return an integer denoting the count of the related records:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

echo 'The robot has ', $robot->countRobotsParts(), " parts\n";
```

<a name='aliases'></a>

### Aliasing Relationships

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

![](/images/content/models-relationships-eer-1.png)

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

// Returns the related record based on the column (robots_id)
// Also as is a belongsTo it's only returning one record
// but the name 'getRobots' seems to imply that return more than one
$robot = $robotsSimilar->getRobots();

// but, how to get the related record based on the column (similar_robots_id)
// if both relationships have the same name?
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

With the aliasing we can get the related records easily:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Returns the related record based on the column (robots_id)
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;

// Returns the related record based on the column (similar_robots_id)
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
```

<a name='getters-vs-methods'></a>

#### Магические методы против явных

Most IDEs and editors with auto-completion capabilities can not infer the correct types when using magic getters (both methods and properties). To overcome that, you can use a class docblock that specifies what magic actions are available, helping the IDE to produce a better auto-completion:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

/**
 * Model class for the robots table.
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

## Виртуальные внешние ключи

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
                    'message' => 'The part_id does not exist on the Parts model'
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
                    'message' => 'The part cannot be deleted because other robots are using it',
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
                    'message'    => 'The part_id does not exist on the Parts model',
                ]
            ]
        );
    }
}
```

<a name='cascade-restrict-actions'></a>

### Cascade/Restrict actions

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

## Связаное сохранение записей

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

// Get an existing artist
$artist = Artists::findFirst(
    'name = 'Shinichi Osawa''
);

// Create an album
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist;

$songs = [];

// Create a first song
$songs[0]           = new Songs();
$songs[0]->name     = 'Star Guitar';
$songs[0]->duration = '5:54';

// Create a second song
$songs[1]           = new Songs();
$songs[1]->name     = 'Last Days';
$songs[1]->duration = '4:29';

// Assign the songs array
$album->songs = $songs;

// Save the album + its songs
$album->save();
```

Saving the album and the artist at the same time implicitly makes use of a transaction so if anything goes wrong with saving the related records, the parent will not be saved either. Messages are passed back to the user for information regarding any errors.

Note: Adding related entities by overloading the following methods is not possible:

- `Phalcon\Mvc\Model::beforeSave()`
- `Phalcon\Mvc\Model::beforeCreate()`
- `Phalcon\Mvc\Model::beforeUpdate()`

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

<a name='operations-over-resultsets'></a>

## Операции над набором результатов

If a resultset is composed of complete objects, the resultset is in the ability to perform operations on the records obtained in a simple manner:

<a name='updating-related-records'></a>

### Updating related records

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

// Update all the parts except those whose type is basic
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

### Deleting related records

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

// Delete only whose stock is greater or equal than zero
$robots->getParts()->delete(
    function ($part) {
        if ($part->stock < 0) {
            return false;
        }

        return true;
    }
);
```