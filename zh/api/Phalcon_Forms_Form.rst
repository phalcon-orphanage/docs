Class **Phalcon\\Forms\\Form**
==============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, Countable, Iterator, Traversable

This component allows to build forms using an object-oriented interface


Methods
-------

public  **setValidation** (*unknown* $validation)

...


public  **getValidation** ()

...


public  **__construct** ([*unknown* $entity], [*unknown* $userOptions])

Phalcon\\Forms\\Form constructor



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setAction** (*unknown* $action)

Sets the form's action



public *string*  **getAction** ()

Returns the form's action



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setUserOption** (*unknown* $option, *unknown* $value)

Sets an option for the form



public *mixed*  **getUserOption** (*unknown* $option, [*unknown* $defaultValue])

Returns the value of an option if present



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setUserOptions** (*unknown* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setEntity** (*unknown* $entity)

Sets the entity related to the model



public *object*  **getEntity** ()

Returns the entity related to the model



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>` [] **getElements** ()

Returns the form elements added to the form



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **bind** (*unknown* $data, *unknown* $entity, [*unknown* $whitelist])

Binds data to the entity



public *boolean*  **isValid** ([*unknown* $data], [*unknown* $entity])

Validates the form



public *array*  **getMessages** ([*unknown* $byItemName])

Returns the messages generated in the validation



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessagesFor** (*unknown* $name)

Returns the messages generated for a specific element



public *boolean*  **hasMessagesFor** (*unknown* $name)

Check if messages were generated for a specific element



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **add** (*unknown* $element, [*string* $postion], [*unknown* $type])

Adds an element to the form



public *string*  **render** (*unknown* $name, [*unknown* $attributes])

Renders a specific item in the form



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **get** (*unknown* $name)

Returns an element added to the form by its name



public *string*  **label** (*unknown* $name, [*unknown* $attributes])

Generate the label of a element added to the form including HTML



public *string*  **getLabel** (*unknown* $name)

Returns a label for an element



public *mixed*  **getValue** (*unknown* $name)

Gets a value from the internal related entity or from the default value



public *boolean*  **has** (*unknown* $name)

Check if the form contains an element



public *boolean*  **remove** (*unknown* $name)

Removes an element from the form



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **clear** ([*unknown* $fields])

Clears every element in the form to its default value



public *int*  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **current** ()

Returns the current element in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public *boolean*  **valid** ()

Check if the current element in the iterator is valid



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



