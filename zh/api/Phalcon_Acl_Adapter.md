# 抽象类 **Phalcon\\Acl\\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/en/3.1.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Phalcon\\Acl 适配器

## 方法

public **getActiveRole** ()

获取 资源/权限 列表

public **getActiveResource** ()

获取角色的可访问资源列表

public **getActiveAccess** ()

获取角色权限类表

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.1.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **setDefaultAction** (*mixed* $defaultAccess)

设置的默认访问级别 （Phalcon\\Acl::ALLOW 或 Phalcon\\Acl::DENY）

public **getDefaultAction** ()

返回默认 ACL 访问级别

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getNoArgumentsDefaultAction** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isRole** (*mixed* $roleName) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isResource** (*mixed* $resourceName) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getRoles** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getResources** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.1.2/api/Phalcon_Acl_AdapterInterface)

...