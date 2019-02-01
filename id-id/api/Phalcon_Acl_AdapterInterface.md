---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Acl\AdapterInterface'
---
# Interface **Phalcon\Acl\AdapterInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapterinterface.zep)

## Metode

publik abstrak **setDefaultAction** (*campuran* $defaultAccess)

Menetapkan tingkat akses default (Phalcon\Acl::ALLOW atau Phalcon\Acl:: DENY)

abstrak publik **getDefaultAction** ()

Mengembalikan tingkat akses ACL default

abstrak umum **setNoArgumentsDefaultAction** (*campuran* $defaultAccess)

Menetapkan tingkat akses default (Phalcon\Acl::ALLOW atau Phalcon\Acl::DENY) tanpa argumen yang diberikan dalam isAllowed action jika ada func untuk accessKey

abstrak (umum **getNoArgumentsDefaultAction**)

Mengembalikan tingkat akses ACL default tanpa argumen yang diberikan dalam isAllowed action jika ada func untuk accessKey

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

abstrak umum **getActiveAccess** ()

Returns the access which the list is checking if some operation can access it

abstract public **getOperations** ()

Return an array with every operation registered in the list

abstract public **getSubjects** ()

Return an array with every subject registered in the list