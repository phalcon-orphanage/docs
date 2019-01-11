* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Acl\Adapter\Memory'

* * *

# Class **Phalcon\Acl\Adapter\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](/3.4/en/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](/3.4/en/api/Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Manages ACL lists in memory

```php
<?php

$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Register roles
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Private area resources
$privateResources = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateResources as $resourceName => $actions) {
    $acl->addResource(
        new \Phalcon\Acl\Resource($resourceName),
        $actions
    );
}

// Public area resources
$publicResources = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicResources as $resourceName => $actions) {
    $acl->addResource(
        new \Phalcon\Acl\Resource($resourceName),
        $actions
    );
}

// Grant access to public areas to both users and guests
foreach ($roles as $role){
    foreach ($publicResources as $resource => $actions) {
        $acl->allow($role->getName(), $resource, "*");
    }
}

// Grant access to private area to role Users
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $resource, $action);
    }
}

```

## 方法

public **__construct** ()

Phalcon\Acl\Adapter\Memory constructor

public **addRole** (*RoleInterface* | *string* $role, [*array* | *string* $accessInherits])

将角色添加到 ACL 列表。第二个参数允许继承访问的数据从其他现有角色的示例：

```php
<?php

$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");

```

public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

Do a role inherit from another existing role

public **isRole** (*mixed* $roleName)

检查角色列表中是否存在的作用

public **isResource** (*mixed* $resourceName)

请检查资源列表中是否存在资源

public **addResource** ([Phalcon\Acl\Resource](/3.4/en/api/Phalcon_Acl_Resource) | *string* $resourceValue, *array* | *string* $accessList)

添加到 ACL 列表访问名称的资源可以是特定的操作，通过示例搜索、 更新、 删除等或它们的列表示例：

```php
<?php

// Add a resource to the the list allowing access to an action
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    "search"
);

$acl->addResource("customers", "search");

// Add a resource  with an access list
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addResource(
    "customers",
    [
        "create",
        "search",
    ]
);

```

public **addResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

将访问添加到资源

public **dropResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

删除从资源的访问权限

protected **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

检查是否角色具有访问权限的资源

public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

允许访问角色上的资源，你可以使用 ' *' 作为通配符的示例：

```php
<?php

//Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

//Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

//Allow access to any role to browse on products
$acl->allow("*", "products", "browse");

//Allow access to any role to browse on any resource
$acl->allow("*", "*", "browse");

```

public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

拒绝访问资源，您可以使用一个角色 ' *' 作为通配符的示例：

```php
<?php

//Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

//Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

//Deny access to any role to browse on products
$acl->deny("*", "products", "browse");

//Deny access to any role to browse on any resource
$acl->deny("*", "*", "browse");

```

public **isAllowed** (*RoleInterface* | *RoleAware* | *string* $roleName, *ResourceInterface* | *ResourceAware* | *string* $resourceName, *mixed* $access, [*array* $parameters])

检查是否允许角色从一个资源访问的行动

```php
<?php

//Does andres have access to the customers resource to create?
$acl->isAllowed("andres", "Products", "create");

//Do guests have access to any resource to edit?
$acl->isAllowed("guests", "*", "edit");

```

public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY) for no arguments provided in isAllowed action if there exists func for accessKey

public **getNoArgumentsDefaultAction** ()

Returns the default ACL access level for no arguments provided in isAllowed action if there exists func for accessKey

public **getRoles** ()

以数组形式返回已经注册的角色

public **getResources** ()

以数组形式返回已经注册的资源

public **getActiveRole** () inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

列表检查是否它允许对某些资源/访问的作用

public **getActiveResource** () inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

获取角色的可访问资源列表

public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

获取角色权限类表

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/3.4/en/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

返回内部事件管理器

public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](/3.4/en/api/Phalcon_Acl_Adapter)

返回默认 ACL 访问级别