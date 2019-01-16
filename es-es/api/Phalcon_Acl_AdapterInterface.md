---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\AdapterInterface'
---
# Interface **Phalcon\Acl\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

abstract public **setDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\Acl::ALLOW o Phalcon\Acl::DENY)

abstract public **getDefaultAction** ()

Devuelve el nivel de acceso ACL por defecto

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\Acl::ALLOW o Phalcon\Acl::DENY) cuando no se reciben argumentos en la acción isAllowed acción si existe func para accessKey

abstract public **getNoArgumentsDefaultAction** ()

Devuelve el nivel de acceso de ACL por defecto sin argumentos en la acción isAllowed si existe la función para accessKey

abstract public **addOperation** (*mixed* $operation, [*mixed* $accessInherits])

Adds a operation to the ACL list. Second parameter lets to inherit access data from other existing operation

abstract public **addInherit** (*mixed* $operationName, *mixed* $operationToInherit)

Do a operation inherit from another existing operation

abstract public **isOperation** (*mixed* $operationName)

Check whether operation exist in the operations list

abstract public **isSubject** (*mixed* $subjectName)

Check whether subject exist in the subjects list

abstract public **addSubject** (*mixed* $subjectObject, *mixed* $accessList)

Adds a subject to the ACL list Access names can be a particular action, by example search, update, delete, etc or a list of them

abstract public **addSubjectAccess** (*mixed* $subjectName, *mixed* $accessList)

Adds access to subjects

abstract public **dropSubjectAccess** (*mixed* $subjectName, *mixed* $accessList)

Removes an access from a subject

abstract public **allow** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, [*mixed* $func])

Allow access to a operation on a subject

abstract public **deny** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, [*mixed* $func])

Deny access to a operation on a subject

abstract public **isAllowed** (*mixed* $operationName, *mixed* $subjectName, *mixed* $access, [*array* $parameters])

Check whether a operation is allowed to access an action from a subject

abstract public **getActiveOperation** ()

Returns the operation which the list is checking if it's allowed to certain subject/access

abstract public **getActiveSubject** ()

Returns the subject which the list is checking if some operation can access it

abstract public **getActiveAccess** ()

Returns the access which the list is checking if some operation can access it

abstract public **getOperations** ()

Return an array with every operation registered in the list

abstract public **getSubjects** ()

Return an array with every subject registered in the list