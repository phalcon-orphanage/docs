* * *

layout: default language: 'en' version: '4.0' title: 'Phalcon\Acl\AdapterInterface'

* * *

# Interface **Phalcon\Acl\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

abstract public **setDefaultAction** (*mixed* $defaultAccess)

设置默认的访问级别（Phalcon\Acl::ALLOW 或者 Phalcon\Acl::DENY）

abstract public **getDefaultAction** ()

返回默认 ACL 访问级别

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

设置任何参数，如果存在方法 accessKey 在讲课行动中提供的默认访问级别 （Phalcon\\Acl::ALLOW 或 Phalcon\\Acl::DENY）

abstract public **getNoArgumentsDefaultAction** ()

如果存在用于 accessKey 的函数, 则返回 isAllowed 操作中提供的任何参数的默认 ACL 访问级别。

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits])

将角色添加到 ACL 列表。第二个参数允许继承其他现有角色的访问数据

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

做一个角色继承自另一个现有角色

abstract public **isRole** (*mixed* $roleName)

检查角色列表中是否存在角色

abstract public **isResource** (*mixed* $resourceName)

检查资源列表中是否存在资源

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList)

将资源添加到 ACL 列表访问名称可以是特定的操作, 例如搜索、更新、删除等或列表。

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

给资源添加访问权限

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

删除资源的访问权限

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

允许角色访问资源

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

禁止角色访问资源

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

检查角色是否可以访问资源

abstract public **getActiveRole** ()

列表检查是否它允许对某些资源/访问的作用

abstract public **getActiveResource** ()

如果某个角色可以访问它，则返回列表正在检查的资源

abstract public **getActiveAccess** ()

返回列表正在检查的访问, 如果某个角色可以访问它

abstract public **getRoles** ()

以数组形式返回已经注册的角色

abstract public **getResources** ()

以数组形式返回已经注册的资源