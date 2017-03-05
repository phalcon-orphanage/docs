Class **Phalcon\\Forms\\Form**
==============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, `Countable <http://php.net/manual/en/class.countable.php>`_, `Iterator <http://php.net/manual/en/class.iterator.php>`_, `Traversable <http://php.net/manual/en/class.traversable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/forms/form.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component allows to build forms using an object-oriented interface


Methods
-------

public  **setValidation** (*mixed* $validation)

...


public  **getValidation** ()

...


public  **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\\Forms\\Form constructor



public  **setAction** (*mixed* $action)

Sets the form's action



public  **getAction** ()

Returns the form's action



public  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the form



public  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public  **setUserOptions** (*array* $options)

Sets options for the element



public  **getUserOptions** ()

Returns the options for the element



public  **setEntity** (*object* $entity)

Sets the entity related to the model



public *object* **getEntity** ()

Returns the entity related to the model



public  **getElements** ()

Returns the form elements added to the form



public  **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Binds data to the entity



public  **isValid** ([*array* $data], [*object* $entity])

Validates the form



public  **getMessages** ([*mixed* $byItemName])

Returns the messages generated in the validation



public  **getMessagesFor** (*mixed* $name)

Returns the messages generated for a specific element



public  **hasMessagesFor** (*mixed* $name)

Check if messages were generated for a specific element



public  **add** (:doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>` $element, [*mixed* $position], [*mixed* $type])

Adds an element to the form



public  **render** (*string* $name, [*array* $attributes])

Renders a specific item in the form



public  **get** (*mixed* $name)

Returns an element added to the form by its name



public  **label** (*mixed* $name, [*array* $attributes])

Generate the label of an element added to the form including HTML



public  **getLabel** (*mixed* $name)

Returns a label for an element



public  **getValue** (*mixed* $name)

Gets a value from the internal related entity or from the default value



public  **has** (*mixed* $name)

Check if the form contains an element



public  **remove** (*mixed* $name)

Removes an element from the form



public  **clear** ([*array* $fields])

Clears every element in the form to its default value



public  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public  **current** ()

Returns the current element in the iterator



public  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public  **valid** ()

Check if the current element in the iterator is valid



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the dependency injector



public  **getDI** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Sets the event manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Returns the internal event manager



public  **__get** (*mixed* $propertyName) inherited from :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

Magic method __get



