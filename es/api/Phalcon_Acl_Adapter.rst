Class **Phalcon\\Acl\\Adapter**
===============================

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



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setDefaultAction** (*unknown* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public *int*  **getDefaultAction** ()

Returns the default ACL access level



