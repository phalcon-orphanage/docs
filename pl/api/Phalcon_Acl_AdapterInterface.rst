Interface **Phalcon\\Acl\\AdapterInterface**
============================================

Methods
-------

abstract public  **setDefaultAction** (*unknown* $defaultAccess)

...


abstract public  **getDefaultAction** ()

...


abstract public  **addRole** (*unknown* $role, [*unknown* $accessInherits])

...


abstract public  **addInherit** (*unknown* $roleName, *unknown* $roleToInherit)

...


abstract public  **isRole** (*unknown* $roleName)

...


abstract public  **isResource** (*unknown* $resourceName)

...


abstract public  **addResource** (*unknown* $resourceObject, *unknown* $accessList)

...


abstract public  **addResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

...


abstract public  **dropResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

...


abstract public  **allow** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

...


abstract public  **deny** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

...


abstract public  **isAllowed** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

...


abstract public  **getActiveRole** ()

...


abstract public  **getActiveResource** ()

...


abstract public  **getActiveAccess** ()

...


abstract public  **getRoles** ()

...


abstract public  **getResources** ()

...


