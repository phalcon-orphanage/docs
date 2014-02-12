Abstract class **Phalcon\\Acl\\Adapter**
========================================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Acl\\AdapterInterface <Phalcon_Acl_AdapterInterface>`

Phalcon\\Acl\\Adapter initializer


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



abstract public *boolean*  **addRole** (:doc:`Phalcon\\Acl\\RoleInterface <Phalcon_Acl_RoleInterface>` $role, [*string* $accessInherits]) inherited from Phalcon\\Acl\\AdapterInterface

Adds a role to the ACL list. Second parameter lets to inherit access data from other existing role



abstract public  **addInherit** (*string* $roleName, *string* $roleToInherit) inherited from Phalcon\\Acl\\AdapterInterface

Do a role inherit from another existing role



abstract public *boolean*  **isRole** (*string* $roleName) inherited from Phalcon\\Acl\\AdapterInterface

Check whether role exist in the roles list



abstract public *boolean*  **isResource** (*string* $resourceName) inherited from Phalcon\\Acl\\AdapterInterface

Check whether resource exist in the resources list



abstract public *boolean*  **addResource** (:doc:`Phalcon\\Acl\\ResourceInterface <Phalcon_Acl_ResourceInterface>` $resource, [*array* $accessList]) inherited from Phalcon\\Acl\\AdapterInterface

Adds a resource to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them



abstract public  **addResourceAccess** (*string* $resourceName, *mixed* $accessList) inherited from Phalcon\\Acl\\AdapterInterface

Adds access to resources



abstract public  **dropResourceAccess** (*string* $resourceName, *mixed* $accessList) inherited from Phalcon\\Acl\\AdapterInterface

Removes an access from a resource



abstract public  **allow** (*string* $roleName, *string* $resourceName, *mixed* $access) inherited from Phalcon\\Acl\\AdapterInterface

Allow access to a role on a resource



abstract public *boolean*  **deny** (*string* $roleName, *string* $resourceName, *mixed* $access) inherited from Phalcon\\Acl\\AdapterInterface

Deny access to a role on a resource



abstract public *boolean*  **isAllowed** (*string* $role, *string* $resource, *string* $access) inherited from Phalcon\\Acl\\AdapterInterface

Check whether a role is allowed to access an action from a resource



abstract public :doc:`Phalcon\\Acl\\RoleInterface <Phalcon_Acl_RoleInterface>` [] **getRoles** () inherited from Phalcon\\Acl\\AdapterInterface

Return an array with every role registered in the list



abstract public :doc:`Phalcon\\Acl\\ResourceInterface <Phalcon_Acl_ResourceInterface>` [] **getResources** () inherited from Phalcon\\Acl\\AdapterInterface

Return an array with every resource registered in the list



