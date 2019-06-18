---
layout: default
language: 'th-th'
version: '4.0'
title: 'Phalcon\Acl\AdapterInterface'
---

# Interface **Phalcon\Acl\AdapterInterface**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapterinterface.zep)

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

abstract public **isComponent** (*mixed* $componentName)

Check whether component exist in the components list

abstract public **addComponent** (*mixed* $componentObject, *mixed* $accessList)

Adds a component to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them

abstract public **addComponentAccess** (*mixed* $componentName, *mixed* $accessList)

Adds access to components

abstract public **dropComponentAccess** (*mixed* $componentName, *mixed* $accessList)

Removes an access from a component

abstract public **allow** (*mixed* $roleName, *mixed* $componentName, *mixed* $access, [*mixed* $func])

Allow access to a role on a component

abstract public **deny** (*mixed* $roleName, *mixed* $componentName, *mixed* $access, [*mixed* $func])

Deny access to a role on a component

abstract public **isAllowed** (*mixed* $roleName, *mixed* $componentName, *mixed* $access, [*array* $parameters])

Check whether a role is allowed to access an action from a component

abstract public **getActiveRole** ()

Returns the role which the list is checking if it's allowed to certain component/access

abstract public **getActiveComponent** ()

Returns the component which the list is checking if some role can access it

abstract public **getActiveAccess** ()

Returns the access which the list is checking if some role can access it

abstract public **getRoles** ()

Return an array with every role registered in the list

abstract public **getComponents** ()

Return an array with every component registered in the list