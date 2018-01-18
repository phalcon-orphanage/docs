# Interfaz **Phalcon\\Acl\\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

abstract public **setDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\Acl::ALLOW o Phalcon\Acl::DENY)

abstract public **getDefaultAction** ()

Devuelve el nivel de acceso ACL por defecto

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\Acl::ALLOW o Phalcon\Acl::DENY) cuando no se reciben argumentos en la acción isAllowed acción si existe func para accessKey

abstract public **getNoArgumentsDefaultAction** ()

Devuelve el nivel de acceso de ACL por defecto sin argumentos en la acción isAllowed si existe la función para accessKey

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits])

Agrega un rol a la lista ACL. Segundo parámetro permite heredar el acceso a los datos de otro rol existente

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

Hacer un rol, heredando sus características de otro rol existente

abstract public **isRole** (*mixed* $roleName)

Comprueba si existe el rol en la lista de roles

abstract public **isResource** (*mixed* $resourceName)

Comprueba si el recurso existe en la lista de recursos

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList)

Agrega un recurso la lista de acceso ACL. Los nombres de acceso pueden ser una acción específica, por ejemplo: buscar, actualizar, borrar, etc. o una lista de ellos, por ejemplo

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

Agrega el acceso a recursos

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

Elimina un acceso de un recurso

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Permite del accedo de un rol en un recurso

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

Niega el accedo de un rol en un recurso

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

Comprobar si un rol tiene permitido el acceso a una acción de un recurso

abstract public **getActiveRole** ()

Devuelve el rol que se esta verificado por la lista para determinar si permite cierto recurso/acceso

abstract public **getActiveResource** ()

Retorna el recurso que la lista está verificando si algún rol puede acceder a él

abstract public **getActiveAccess** ()

Retorna el acceso que la lista está verificando si algún rol puede acceder a él

abstract public **getRoles** ()

Devuelve un array con cada rol registrado en la lista

abstract public **getResources** ()

Devuelve un array con cada recurso registrado en la lista
