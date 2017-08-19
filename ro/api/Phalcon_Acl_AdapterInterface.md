# Interface **Phalcon\\Acl\\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **setDefaultAction** (*mixed* $defaultAccess)

...

abstract public **getDefaultAction** ()

...

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

...

abstract public **getNoArgumentsDefaultAction** ()

...

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits])

...

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

...

abstract public **isRole** (*mixed* $roleName)

...

abstract public **isResource** (*mixed* $resourceName)

...

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList)

...

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

...

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

...

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

...

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

...

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

...

abstract public **getActiveRole** ()

...

abstract public **getActiveResource** ()

...

abstract public **getActiveAccess** ()

...

abstract public **getRoles** ()

...

abstract public **getResources** ()

...