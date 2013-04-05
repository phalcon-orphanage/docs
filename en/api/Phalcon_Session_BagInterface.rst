Interface **Phalcon\\Session\\BagInterface**
============================================

Methods
---------

abstract public  **initialize** ()

Initializes the session bag. This method must not be called directly, the class calls it when its internal data is accesed



abstract public  **destroy** ()

Destroyes the session bag



abstract public  **set** (*string* $property, *string* $value)

Setter of values



abstract public *mixed*  **get** (*string* $property, [*mixed* $defaultValue])

Getter of values



abstract public *boolean*  **has** (*string* $property)

Isset property



abstract public  **__set** (*string* $property, *string* $value)

Setter of values



abstract public *mixed*  **__get** (*string* $property)

Getter of values



abstract public *boolean*  **__isset** (*string* $property)

Isset property



