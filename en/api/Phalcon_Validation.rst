Class **Phalcon\\Validation**
=============================




Methods
---------

public  **__construct** ([*array* $validators])

Phalcon\\Validation constructor



public  **validate** (*array|object* $data, [*object* $entity])

Validate a set of data according to a set of rules



public *Phalcon\\Validator*  **add** (*string* $attribute, *unknown* $validator)

Adds a validator to a field



public *array*  **getValidators** ()

Returns the data that is currently validated



public *object*  **getEntity** ()

Returns the bound entity



public :doc:`Phalcon\\Validation\\Message\\Group <Phalcon_Validation_Message_Group>`  **getMessages** ()

Returns the registered validators



public  **appendMessage** (*Phalcon\\Validation\\MessageInterface* $message)

Appends a message to the messages list



public *Phalcon\\Validator*  **bind** (*string* $entity, *string* $data)

Assigns the data to an entity The entity is used to obtain the validation values



public *mixed*  **getValue** (*string* $attribute)

Gets the a value to validate in the array/object data source



