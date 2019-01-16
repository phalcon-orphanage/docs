* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Validation'

* * *

# Class **Phalcon\Validation**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\ValidationInterface](Phalcon_ValidationInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validation.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to validate data using custom or built-in validators

## Methods

public **getData** ()

...

public **setValidators** (*mixed* $validators)

...

public **__construct** ([*array* $validators])

Phalcon\Validation constructor

public [Phalcon\Validation\Message\Group](Phalcon_Validation_Message_Group) **validate** ([*array* | *object* $data], [*object* $entity])

Validate a set of data according to a set of rules

public **add** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Adds a validator to a field

public **rule** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Alias of `add` method

public **rules** (*mixed* $field, *array* $validators)

Adds the validators to a field

public [Phalcon\Validation](Phalcon_Validation) **setFilters** (*string* $field, *array* | *string* $filters)

Adds filters to the field

public *mixed* **getFilters** ([*string* $field])

Returns all the filters or a specific one

public **getValidators** ()

Returns the validators added to the validation

public **setEntity** (*object* $entity)

Sets the bound entity

public *object* **getEntity** ()

Returns the bound entity

public **setDefaultMessages** ([*array* $messages])

Adds default messages to validators

public **getDefaultMessage** (*mixed* $type)

Get default message for validator type

public **getMessages** ()

Returns the registered validators

public **setLabels** (*array* $labels)

Adds labels for fields

public *string* **getLabel** (*string* $field)

Get label for field

public **appendMessage** ([Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface) $message)

Appends a message to the messages list

public [Phalcon\Validation](Phalcon_Validation) **bind** (*object* $entity, *array* | *object* $data)

Assigns the data to an entity The entity is used to obtain the validation values

public *mixed* **getValue** (*string* $field)

Gets the a value to validate in the array/object data source

protected **preChecking** (*mixed* $field, [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface) $validator)

Internal validations, if it returns true, then skip the current validator

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get