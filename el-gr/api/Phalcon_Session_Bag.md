* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Session\Bag'

* * *

# Class **Phalcon\Session\Bag**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Session\BagInterface](Phalcon_Session_BagInterface), [IteratorAggregate](https://php.net/manual/en/class.iteratoraggregate.php), [Traversable](https://php.net/manual/en/class.traversable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/session/bag.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application

```php
<?php

$user = new \Phalcon\Session\Bag("user");

$user->name = "Kimbra Johnson";
$user->age  = 22;

```

## Methods

public **__construct** (*mixed* $name)

Phalcon\Session\Bag constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public **getDI** ()

Returns the DependencyInjector container

public **initialize** ()

Initializes the session bag. This method must not be called directly, the class calls it when its internal data is accessed

public **destroy** ()

Destroys the session bag

```php
<?php

$user->destroy();

```

public **set** (*mixed* $property, *mixed* $value)

Sets a value in the session bag

```php
<?php

$user->set("name", "Kimbra");

```

public **__set** (*mixed* $property, *mixed* $value)

Magic setter to assign values to the session bag

```php
<?php

$user->name = "Kimbra";

```

public **get** (*mixed* $property, [*mixed* $defaultValue])

Obtains a value from the session bag optionally setting a default value

```php
<?php

echo $user->get("name", "Kimbra");

```

public **__get** (*mixed* $property)

Magic getter to obtain values from the session bag

```php
<?php

echo $user->name;

```

public **has** (*mixed* $property)

Check whether a property is defined in the internal bag

```php
<?php

var_dump(
    $user->has("name")
);

```

public **__isset** (*mixed* $property)

Magic isset to check whether a property is defined in the bag

```php
<?php

var_dump(
    isset($user["name"])
);

```

public **remove** (*mixed* $property)

Removes a property from the internal bag

```php
<?php

$user->remove("name");

```

public **__unset** (*mixed* $property)

Magic unset to remove items using the array syntax

```php
<?php

unset($user["name"]);

```

final public **count** ()

Return length of bag

```php
<?php

echo $user->count();

```

final public **getIterator** ()

 Returns the bag iterator

final public **offsetSet** (*mixed* $property, *mixed* $value)

...

final public **offsetExists** (*mixed* $property)

...

final public **offsetUnset** (*mixed* $property)

...

final public **offsetGet** (*mixed* $property)

...