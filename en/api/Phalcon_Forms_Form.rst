Class **Phalcon\\Forms\\Form**
==============================

*extends* abstract class :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, Countable, Iterator, Traversable

This component allows to build forms using an object-oriented interface


Methods
-------

public  **__construct** ([*object* $entity], [*array* $userOptions])

Phalcon\\Forms\\Form constructor



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setAction** (*string* $action)

Sets the form's action



public *string*  **getAction** ()

Returns the form's action



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setUserOption** (*string* $option, *mixed* $value)

Sets an option for the form



public *mixed*  **getUserOption** (*string* $option, [*mixed* $defaultValue])

Returns the value of an option if present



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **setUserOptions** (*array* $options)

Sets options for the element



public *array*  **getUserOptions** ()

Returns the options for the element



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **setEntity** (*object* $entity)

Sets the entity related to the model



public *object*  **getEntity** ()

Returns the entity related to the model



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>` [] **getElements** ()

Returns the form elements added to the form



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **bind** (*array* $data, *object* $entity, [*array* $whitelist])

Binds data to the entity



public *boolean*  **isValid** ([*array* $data], [*object* $entity])

Validates the form



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ([*boolean* $byItemName])

Returns the messages generated in the validation



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>` [] **getMessagesFor** (*unknown* $name)

Returns the messages generated for a specific element



public *boolean*  **hasMessagesFor** (*unknown* $name)

Check if messages were generated for a specific element



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **add** (:doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>` $element, [*string* $postion], [*unknown* $type])

Adds an element to the form



public *string*  **render** (*string* $name, [*array* $attributes])

Renders a specific item in the form



public :doc:`Phalcon\\Forms\\ElementInterface <Phalcon_Forms_ElementInterface>`  **get** (*string* $name)

Returns an element added to the form by its name



public *string*  **label** (*string* $name, [*unknown* $attributes])

Generate the label of a element added to the form including HTML



public *string*  **getLabel** (*string* $name)

Returns a label for an element



public *mixed*  **getValue** (*string* $name)

Gets a value from the internal related entity or from the default value



public *boolean*  **has** (*string* $name)

Check if the form contains an element



public *boolean*  **remove** (*string* $name)

Removes an element from the form



public :doc:`Phalcon\\Forms\\Form <Phalcon_Forms_Form>`  **clear** ([*array* $fields])

Clears every element in the form to its default value



public *int*  **count** ()

Returns the number of elements in the form



public  **rewind** ()

Rewinds the internal iterator



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **current** ()

Returns the current element in the iterator



public *int*  **key** ()

Returns the current position/key in the iterator



public  **next** ()

Moves the internal iteration pointer to the next position



public *boolean*  **valid** ()

Check if the current element in the iterator is valid



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



