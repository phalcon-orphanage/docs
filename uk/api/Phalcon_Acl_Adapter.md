# Abstract class **Phalcon\\Acl\\Adapter**

*implements* [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Adapter for Phalcon\\Acl adapters

## Methods

public **getActiveRole** ()

Роль списку перевіривши, якщо це дозволено певний ресурс/доступ

public **getActiveResource** ()

Ресурс списку перевіривши, якщо деякі ролі можуть отримати до нього доступ

public **getActiveAccess** ()

Активний доступ до списку перевіривши, якщо деякі ролі можуть отримати до нього доступ

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Набори менеджера з організації заходів

public **getEventsManager** ()

Повертає внутрішній диспетчер подій

public **setDefaultAction** (*mixed* $defaultAccess)

Встановлює рівень доступу за замовчуванням (в phalcon\\Вбк::дозволити або phalcon\\Вбк::заборонити)

public **getDefaultAction** ()

Повертає рівень доступу ACL за замовчуванням

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