Abstract class **Phalcon\\Acl\\Adapter**
========================================

*implements* :doc:`Phalcon\\Acl\\AdapterInterface <Phalcon_Acl_AdapterInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

Adapter for Phalcon\\Acl adapters


Methods
-------

public  **getActiveRole** ()

Role which the list is checking if it's allowed to certain resource/access



public  **getActiveResource** ()

Resource which the list is checking if some role can access it



public  **getActiveAccess** ()

Active access which the list is checking if some role can access it



public  **setEventsManager** (*unknown* $eventsManager)

Sets the events manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setDefaultAction** (*unknown* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public  **getDefaultAction** ()

Returns the default ACL access level



abstract public  **addRole** (*unknown* $role, [*unknown* $accessInherits]) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **addInherit** (*unknown* $roleName, *unknown* $roleToInherit) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **isRole** (*unknown* $roleName) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **isResource** (*unknown* $resourceName) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **addResource** (*unknown* $resourceObject, *unknown* $accessList) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **addResourceAccess** (*unknown* $resourceName, *unknown* $accessList) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **dropResourceAccess** (*unknown* $resourceName, *unknown* $accessList) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **allow** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **deny** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **isAllowed** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access) inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **getRoles** () inherited from Phalcon\\Acl\\AdapterInterface

...


abstract public  **getResources** () inherited from Phalcon\\Acl\\AdapterInterface

...


