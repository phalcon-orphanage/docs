Class **Phalcon\\Validation**
=============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Allows to validate data using custom or built-in validators


Methods
-------

public  **setValidators** (*unknown* $validators)

...


public  **__construct** ([*unknown* $validators])

Phalcon\\Validation constructor



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **validate** ([*unknown* $data], [*unknown* $entity])

Validate a set of data according to a set of rules



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **add** (*unknown* $field, *unknown* $validator)

Adds a validator to a field



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **rule** (*unknown* $field, *unknown* $validator)

Alias of `add` method



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **rules** (*unknown* $field, *unknown* $validators)

Adds the validators to a field



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **setFilters** (*unknown* $field, *unknown* $filters)

Adds filters to the field



public *mixed*  **getFilters** ([*unknown* $field])

Returns all the filters or a specific one



public *array*  **getValidators** ()

Returns the validators added to the validation



public *object*  **getEntity** ()

Returns the bound entity



public *array*  **setDefaultMessages** ([*unknown* $messages])

Adds default messages to validators



public *string*  **getDefaultMessage** (*unknown* $type)

Get default message for validator type



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the registered validators



public  **setLabels** (*unknown* $labels)

Adds labels for fields



public *string*  **getLabel** (*unknown* $field)

Get label for field



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **appendMessage** (*unknown* $message)

Appends a message to the messages list



public :doc:`Phalcon\\Validation <Phalcon_Validation>`  **bind** (*unknown* $entity, *unknown* $data)

Assigns the data to an entity The entity is used to obtain the validation values



public *mixed*  **getValue** (*unknown* $field)

Gets the a value to validate in the array/object data source



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



