# Abstract class **Phalcon\\Acl\\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

Phalcon\\Acl 用アダプター

## メソッド

public **getActiveRole** ()

特定のリソース/アクセスを許可するかどうかをチェックするリストの役割

public **getActiveResource** ()

いくつかのロールがアクセスできるかをチェックするリストのリソース

public **getActiveAccess** ()

いくつかのロールがアクセスできるかをチェックするリストのアクティブなアクセス

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

イベントマネージャーをセットします

public **getEventsManager** ()

内部イベントマネージャーを返します

public **setDefaultAction** (*mixed* $defaultAccess)

デフォルトのアクセスレベルをセットします (Phalcon\\Acl::ALLOW または Phalcon\\Acl::DENY)

public **getDefaultAction** ()

デフォルトのACLアクセスレベルを返します

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getNoArgumentsDefaultAction** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isRole** (*mixed* $roleName) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isResource** (*mixed* $resourceName) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters]) inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getRoles** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...

abstract public **getResources** () inherited from [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

...