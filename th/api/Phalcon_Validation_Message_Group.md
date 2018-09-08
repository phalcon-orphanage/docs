# Class **Phalcon\\Validation\\Message\\Group**

*implements* [Countable](http://php.net/manual/en/class.countable.php), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/message/group.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Represents a group of validation messages

## Methods

public **__construct** ([*array* $messages])

Phalcon\\Validation\\Message\\Group constructor

public [Phalcon\Validation\Message](/en/3.2/api/Phalcon_Validation_Message) **offsetGet** (*int* $index)

Gets an attribute a message using the array syntax

```php
<?php

print_r(
    $messages[0]
);

```

public **offsetSet** (*int* $index, [Phalcon\Validation\Message](/en/3.2/api/Phalcon_Validation_Message) $message)

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

public **appendMessage** ([Phalcon\Validation\MessageInterface](/en/3.2/api/Phalcon_Validation_MessageInterface) $message)

Appends a message to the group

```php
<?php

$messages->appendMessage(
    new \Phalcon\Validation\Message("This is a message")
);

```

public **appendMessages** ([Phalcon\Validation\MessageInterface](/en/3.2/api/Phalcon_Validation_MessageInterface) $messages)

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

public static [Phalcon\Validation\Message\Group](/en/3.2/api/Phalcon_Validation_Message_Group) **__set_state** (*array* $group)

Magic __set_state helps to re-build messages variable when exporting