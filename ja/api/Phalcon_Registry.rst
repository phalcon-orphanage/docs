Final class **Phalcon\\Registry**
=================================

*implements* ArrayAccess, Iterator, Traversable, Serializable, Countable, JsonSerializable

A registry is a container for storing objects and values in the application space. By storing the value in a registry, the same object is always available throughout your application.  

.. code-block:: php

    <?php

     	$registry = new \Phalcon\Registry();
    
     	// Set value
     	$registry->something = 'something';
     	// or
     	$registry['something'] = 'something';
    
     	// Get value
     	$value = $registry->something;
     	// or
     	$value = $registry['something'];
    
     	// Check if the key exists
     	$exists = isset($registry->something);
     	// or
     	$exists = isset($registry['something']);
    
     	// Unset
     	unset($registry->something);
     	// or
     	unset($registry['something']);

  In addition to ArrayAccess, Phalcon\\Registry also implements Countable (count($registry) will return the number of elements in the registry), Serializable and Iterator (you can iterate over the registry using a foreach loop) interfaces. For PHP 5.4 and higher, JsonSerializable interface is implemented.  Phalcon\\Registry is very fast (it is typically faster than any userspace implementation of the registry); however, this comes at a price: Phalcon\\Registry is a final class and cannot be inherited from.  Though Phalcon\\Registry exposes methods like __get(), offsetGet(), count() etc, it is not recommended to invoke them manually (these methods exist mainly to match the interfaces the registry implements): $registry->__get('property') is several times slower than $registry->property.  Internally all the magic methods (and interfaces except JsonSerializable) are implemented using object handlers or similar techniques: this allows to bypass relatively slow method calls.


Methods
-------

public  **__get** (*unknown* $property)

...


public  **__set** (*unknown* $property, *unknown* $value)

...


public  **__isset** (*unknown* $property)

...


public  **__unset** (*unknown* $property)

...


public  **__call** (*unknown* $method, [*unknown* $arguments])

...


public  **count** ()

...


public  **offsetGet** (*unknown* $property)

...


public  **offsetSet** (*unknown* $property, *unknown* $value)

...


public  **offsetUnset** (*unknown* $property)

...


public  **offsetExists** (*unknown* $property)

...


public  **current** ()

...


public  **key** ()

...


public  **next** ()

...


public  **rewind** ()

...


public  **valid** ()

...


public  **jsonSerialize** ()

...


public  **serialize** ()

...


public  **unserialize** ([*unknown* $serialized])

...


private  **__wakeup** ()

...


