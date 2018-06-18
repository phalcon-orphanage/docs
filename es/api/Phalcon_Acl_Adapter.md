# Clase Abstracta **Phalcon\\Acl\\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Adaptador para Phalcon\\Acl

## Métodos

public **getActiveRole** ()

Rol que es verificado por la lista para determinar si permite cierto recurso/acceso

public **getActiveResource** ()

Recurso es que verificado por la lista para determinar si un rol puede tener acceso a el

public **getActiveAccess** ()

Acceso activo que es verificado por la lista para determinar si algún rol puede acceder a este

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager)

Establece el administrador de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **setDefaultAction** (*mixed* $defaultAccess)

Establece el nivel de acceso por defecto (Phalcon\\Acl::ALLOW o Phalcon\\Acl::DENY)

public **getDefaultAction** ()

Devuelve el nivel de acceso ACL por defecto

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getNoArgumentsDefaultAction** () inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isRole** (*mixed* $roleName) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isResource** (*mixed* $resourceName) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters]) inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getRoles** () inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getResources** () inherited from [Phalcon\Acl\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Acl_AdapterInterface)

...