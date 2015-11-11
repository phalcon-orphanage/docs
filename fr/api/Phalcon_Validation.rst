Class **Phalcon\\Validation**
=============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to validate data using custom or built-in validators


Methods
-------

public  **setValidators** (*unknown* $validators)

...


public  **__construct** ([*unknown* $validators])

Phalcon\\Validation constructor



public *\Phalcon\Validation\Message\Group*  **validate** ([*array|object* $data], [*object* $entity])

Validate a set of data according to a set of rules



public  **add** (*unknown* $field, *unknown* $validator)

Adds a validator to a field



public  **rule** (*unknown* $field, *unknown* $validator)

Alias of `add` method



public  **rules** (*unknown* $field, *unknown* $validators)

Adds the validators to a field



public *\Phalcon\Validation*  **setFilters** (*string* $field, *array|string* $filters)

Adds filters to the field



public *mixed*  **getFilters** ([*string* $field])

Returns all the filters or a specific one



public  **getValidators** ()

Returns the validators added to the validation



public *object*  **getEntity** ()

Returns the bound entity



public  **setDefaultMessages** ([*unknown* $messages])

Adds default messages to validators



public  **getDefaultMessage** (*string* $type)

Get default message for validator type



public  **getMessages** ()

Returns the registered validators



public  **setLabels** (*unknown* $labels)

Adds labels for fields



public *string*  **getLabel** (*string* $field)

Get label for field



public  **appendMessage** (*unknown* $message)

Appends a message to the messages list



public *\Phalcon\Validation*  **bind** (*object* $entity, *array|object* $data)

Assigns the data to an entity The entity is used to obtain the validation values



public *mixed*  **getValue** (*string* $field)

Gets the a value to validate in the array/object data source



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



