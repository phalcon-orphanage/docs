Class **Phalcon\Acl\Adapter\Memory**
====================================

*extends* :doc:`Phalcon\\Acl <Phalcon_Acl>`

Constants
---------

integer **ALLOW**

integer **DENY**

Methods
---------

public **__construct** ()

public **setDefaultAction** (*unknown* $defaultAccess)

public **getDefaultAction** ()

public **addRole** (*unknown* $roleObject, *unknown* $accessInherits)

public **addInherit** (*unknown* $roleName, *unknown* $roleToInherit)

public **isRole** (*unknown* $roleName)

public **isResource** (*unknown* $resourceName)

public **addResource** (*unknown* $resource, *unknown* $accessList)

public **addResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

public **dropResourceAccess** (*unknown* $resourceName, *unknown* $accessList)

protected **_allowOrDeny** ()

public **allow** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

public **deny** (*unknown* $roleName, *unknown* $resourceName, *unknown* $access)

public **isAllowed** (*unknown* $role, *unknown* $resource, *unknown* $access)

public **getActiveRole** ()

public **getActiveResource** ()

public **getActiveAccess** ()

protected **_rebuildAccessList** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

