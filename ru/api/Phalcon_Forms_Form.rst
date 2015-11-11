Class **Phalcon\\Forms\\Form**
==============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, Countable, Iterator, Traversable

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/forms/form.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component allows to build forms using an object-oriented interface


Methods
-------

public  **setValidation** (*unknown* $validation)

...


public  **getValidation** ()

...


public  **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\\Forms\\Form constructor



public *\Phalcon\Forms\Form*  **setAction** (*string* $action)

Sets the form's action



public  **getAction** ()

Returns the form's action



public *\Phalcon\Forms\Form*  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the form



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public  **setUserOptions** (*unknown* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public *\Phalcon\Forms\Form*  **setEntity** (*object* $entity)

Sets the entity related to the model



public *object*  **getEntity** ()

Returns the entity related to the model



public  **getElements** ()

Returns the form elements added to the form



public *\Phalcon\Forms\Form*  **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Binds data to the entity



public *boolean*  **isValid** ([*array* $data], [*object* $entity])

Validates the form



public  **getMessages** ([*unknown* $byItemName])

Returns the messages generated in the validation



public *\Phalcon\Validation\Message\Group*  **getMessagesFor** (*string* $name)

Returns the messages generated for a specific element



public *boolean*  **hasMessagesFor** (*string* $name)

Check if messages were generated for a specific element



public *\Phalcon\Forms\Form*  **add** (:doc:`\\Phalcon\\Forms\\ElementInterface <_Phalcon_Forms_ElementInterface>` $element, [*string* $postion], [*unknown* $type])

Adds an element to the form



public *string*  **render** (*string* $name, [*array* $attributes])

Renders a specific item in the form



public  **get** (*unknown* $name)

Returns an element added to the form by its name



public  **label** (*unknown* $name, [*unknown* $attributes])

Generate the label of a element added to the form including HTML



public  **getLabel** (*unknown* $name)

Returns a label for an element



public *mixed*  **getValue** (*string* $name)

Gets a value from the internal related entity or from the default value



public  **has** (*unknown* $name)

Check if the form contains an element



public  **remove** (*unknown* $name)

Removes an element from the form



public *\Phalcon\Forms\Form*  **clear** ([*array* $fields])

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



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



