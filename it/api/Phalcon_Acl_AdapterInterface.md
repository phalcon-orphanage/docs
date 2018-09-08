# Interface **Phalcon\\Acl\\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **setDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

abstract public **getDefaultAction** ()

Returns the default ACL access level

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY) for no arguments provided in isAllowed action if there exists func for accessKey

abstract public **getNoArgumentsDefaultAction** ()

Returns the default ACL access level for no arguments provided in isAllowed action if there exists func for accessKey

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits])

Adds a role to the ACL list. Second parameter lets to inherit access data from other existing role

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

Do a role inherit from another existing role

abstract public **isRole** (*mixed* $roleName)

Check whether role exist in the roles list

abstract public **isResource** (*mixed* $resourceName)

Check whether resource exist in the resources list

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList)

Adds a resource to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

Adds access to resources

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

Removes an access from a resource

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Allow access to a role on a resource

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Deny access to a role on a resource

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

Check whether a role is allowed to access an action from a resource

abstract public **getActiveRole** ()

Returns the role which the list is checking if it's allowed to certain resource/access

abstract public **getActiveResource** ()

Returns the resource which the list is checking if some role can access it

abstract public **getActiveAccess** ()

Returns the access which the list is checking if some role can access it

abstract public **getRoles** ()

Return an array with every role registered in the list

abstract public **getResources** ()

Return an array with every resource registered in the list