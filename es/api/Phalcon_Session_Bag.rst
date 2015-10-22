Class **Phalcon\\Session\\Bag**
===============================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Session\\BagInterface <Phalcon_Session_BagInterface>`, IteratorAggregate, Traversable, ArrayAccess, Countable

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/session/bag.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application  

.. code-block:: php

    <?php

    $user = new \Phalcon\Session\Bag('user');
    $user->name = "Kimbra Johnson";
    $user->age = 22;



Methods
-------

public  **__construct** (*unknown* $name)

Phalcon\\Session\\Bag constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **initialize** ()

Initializes the session bag. This method must not be called directly, the class calls it when its internal data is accesed



public  **destroy** ()

Destroyes the session bag 

.. code-block:: php

    <?php

     $user->destroy();




public  **set** (*string* $property, *string* $value)

Sets a value in the session bag 

.. code-block:: php

    <?php

     $user->set('name', 'Kimbra');




public  **__set** (*string* $property, *string* $value)

Magic setter to assign values to the session bag 

.. code-block:: php

    <?php

     $user->name = "Kimbra";




public *mixed*  **get** (*string* $property, [*string* $defaultValue])

Obtains a value from the session bag optionally setting a default value 

.. code-block:: php

    <?php

     echo $user->get('name', 'Kimbra');




public *mixed*  **__get** (*string* $property)

Magic getter to obtain values from the session bag 

.. code-block:: php

    <?php

     echo $user->name;




public  **has** (*unknown* $property)

Check whether a property is defined in the internal bag 

.. code-block:: php

    <?php

     var_dump($user->has('name'));




public  **__isset** (*unknown* $property)

Magic isset to check whether a property is defined in the bag 

.. code-block:: php

    <?php

     var_dump(isset($user['name']));




public  **remove** (*unknown* $property)

Removes a property from the internal bag 

.. code-block:: php

    <?php

     $user->remove('name');




public  **__unset** (*unknown* $property)

Magic unset to remove items using the array syntax 

.. code-block:: php

    <?php

     unset($user['name']);




final public  **count** ()

Return length of bag 

.. code-block:: php

    <?php

     echo $user->count();




final public *\ArrayIterator*  **getIterator** ()

 Returns the bag iterator



final public  **offsetSet** (*string* $property, *mixed* $value)





final public  **offsetExists** (*string* $property)





final public  **offsetUnset** (*string* $property)





final public  **offsetGet** (*string* $property)





