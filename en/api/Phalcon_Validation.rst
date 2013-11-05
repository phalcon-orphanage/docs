Class **Phalcon\\Validation**
=============================

*extends* abstract class :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Allows to validate data using validators


Methods
---------

public  **__construct** ([*array* $validators])

Phalcon\\Validation constructor



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **validate** ([*array|object* $data], [*object* $entity])

Validate a set of data according to a set of rules



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **add** (*string* $attribute, *unknown* $validator)

Adds a validator to a field



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **setFilters** (*array|string* $attribute, *unknown* $filters)

Adds filters to the field



public *mixed*  **getFilters** ([*string* $attribute])

Returns all the filters or a specific one



public *array*  **getValidators** ()

Returns the validators added to the validation



public *object*  **getEntity** ()

Returns the bound entity



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the registered validators



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **appendMessage** (*Phalcon\\Validation\\MessageInterface* $message)

Appends a message to the messages list



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **bind** (*object* $entity, *object|array* $data)

Assigns the data to an entity The entity is used to obtain the validation values



public *mixed*  **getValue** (*string* $attribute)

Gets the a value to validate in the array/object data source



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



