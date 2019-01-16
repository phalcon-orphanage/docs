* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Validation\Message\Group'

* * *

# Class **Phalcon\Validation\Message\Group**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validation/message/group.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Represents a group of validation messages

## 方法

public **__construct** ([*array* $messages])

Phalcon\Validation\Message\Group constructor

public [Phalcon\Validation\Message](Phalcon_Validation_Message) **offsetGet** (*int* $index)

Gets an attribute a message using the array syntax

```php
<?php

print_r(
    $messages[0]
);

```

public **offsetSet** (*int* $index, [Phalcon\Validation\Message](Phalcon_Validation_Message) $message)

Sets an attribute using the array-syntax

```php
<?php

$messages[0] = new \Phalcon\Validation\Message("This is a message");

```

public *boolean* **offsetExists** (*int* $index)

Checks if an index exists

```php
<?php

var_dump(
    isset($message["database"])
);

```

public **offsetUnset** (*mixed* $index)

Removes a message from the list

```php
<?php

unset($message["database"]);

```

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Appends a message to the group

```php
<?php

$messages->appendMessage(
    new \Phalcon\Validation\Message("This is a message")
);

```

public **appendMessages** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $messages)

Appends an array of messages to the group

```php
<?php

$messages->appendMessages($messagesArray);

```

public *array* **filter** (*string* $fieldName)

Filters the message group by field name

public **count** ()

Returns the number of messages in the list

public **rewind** ()

Rewinds the internal iterator

public **current** ()

Returns the current message in the iterator

public **key** ()

Returns the current position/key in the iterator

public **next** ()

Moves the internal iteration pointer to the next position

public **valid** ()

Check if the current message in the iterator is valid

public static [Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) **__set_state** (*array* $group)

Magic __set_state helps to re-build messages variable when exporting