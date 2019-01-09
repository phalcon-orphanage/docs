* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Acl\AdapterInterface'

* * *

# Interface **Phalcon\Acl\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/acl/adapterinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **setDefaultAction** (*mixed* $defaultAccess)

デフォルトのアクセスレベル (Phalcon\Acl::ALLOW または Phalcon\Acl::DENY)をセットします。

abstract public **getDefaultAction** ()

デフォルトのACLアクセスレベルを返します

abstract public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベル(Phalcon\Acl::ALLOW または Phalcon\Acl::DENY)を設定します。ただしaccessKeyのfuncは存在しているものとします。

abstract public **getNoArgumentsDefaultAction** ()

isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベルを返します。ただしaccessKeyのfuncは存在しているものとします。

abstract public **addRole** (*mixed* $role, [*mixed* $accessInherits])

Adds a role to the ACL list. Second parameter lets to inherit access data from other existing role

abstract public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

既存のロールからロールを継承する。

abstract public **isRole** (*mixed* $roleName)

ロールリストにロールが存在するかどうかをチェックします。

abstract public **isResource** (*mixed* $resourceName)

そのリソースリストにリソースが存在するかどうかをチェックします。

abstract public **addResource** (*mixed* $resourceObject, *mixed* $accessList)

リソースをアクセス制御リストリストに追加します。 アクセス名は特定のアクションで使用します。例えば search(検索), update(更新), delete(削除)などで、これらのリストになります。

abstract public **addResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

リソースへのアクセスを追加します。

abstract public **dropResourceAccess** (*mixed* $resourceName, *mixed* $accessList)

リソースからアクセスを削除します。

abstract public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

リソース上のロールへのアクセスを許可します。

abstract public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

リソース上のロールへのアクセスを拒否します。

abstract public **isAllowed** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*array* $parameters])

ロールがリソースからアクションへのアクセスを許可されているかをチェックします。

abstract public **getActiveRole** ()

特定のリソース/アクセスを許可するかどうかをチェックするリストの役割を返します。

abstract public **getActiveResource** ()

いくつかのロールがアクセスできるかをチェックするリストのリソースを返します。

abstract public **getActiveAccess** ()

いくつかのロールがアクセスできるかをチェックするリストのアクセスを返します。

abstract public **getRoles** ()

リストに登録されている全ロールの配列を返します。

abstract public **getResources** ()

リストに登録されている全リソースの配列を返します。