Class **Phalcon\\Session\\Bag**
===============================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Session\\BagInterface <Phalcon_Session_BagInterface>`

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application  

.. code-block:: php

    <?php

     $user = new Phalcon\Session\Bag();
     $user->name = "Kimbra Johnson";
     $user->age = 22;



Methods
---------

public  **__construct** (*unknown* $name)

Phalcon\\Session\\Bag constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **initialize** ()

Initializes the session bag. This method must not be called directly, the class calls it when its internal data is accesed



public  **destroy** ()

Destroyes the session bag



public  **__set** (*string* $property, *string* $value)

Setter of values



public *string*  **__get** (*string* $property)

Getter of values



public *boolean*  **__isset** (*string* $property)

Isset property



