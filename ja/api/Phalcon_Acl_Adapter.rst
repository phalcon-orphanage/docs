Abstract class **Phalcon\\Acl\\Adapter**
========================================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

Adapter for Phalcon\\Acl adapters


Methods
-------

public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setDefaultAction** (*int* $defaultAccess)

Sets the default access level (Phalcon\\Acl::ALLOW or Phalcon\\Acl::DENY)



public *int*  **getDefaultAction** ()

Returns the default ACL access level



public *string*  **getActiveRole** ()

Returns the role which the list is checking if it's allowed to certain resource/access



public *string*  **getActiveResource** ()

Returns the resource which the list is checking if some role can access it



public *string*  **getActiveAccess** ()

Returns the access which the list is checking if some role can access it



