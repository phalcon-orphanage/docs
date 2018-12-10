# Class **Phalcon\\Acl\\Adapter\\Memory**

*extends* abstract class [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](/en/3.2/api/Phalcon_Acl_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/acl/adapter/memory.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

メモリ上のアクセス制御リストを管理します

```php
<?php

$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// ロールの登録
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// 非公開エリアのリソース
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

// 公開エリアのリソース
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

// ユーザーとゲストの両方に公開エリアへのアクセスを許可する
foreach ($roles as $role){
    foreach ($publicResources as $resource => $actions) {
        $acl->allow($role->getName(), $resource, "*");
    }
}

// Usersロールにプライベートエリアへのアクセスを許可する
foreach ($privateResources as $resource => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $resource, $action);
    }
}

```

## メソッド

public **__construct** ()

Phalcon\\Acl\\Adapter\\Memory コンストラクタ

public **addRole** (*RoleInterface* | *string* $role, [*array* | *string* $accessInherits])

アクセス制御リストにロールを追加します。第二引数は、その他の既存のロールからアクセスデータを継承します。 例:

```php
<?php

$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");

```

public **addInherit** (*mixed* $roleName, *mixed* $roleToInherit)

既存のロールからロールを継承する。

public **isRole** (*mixed* $roleName)

ロールリストにロールが存在するかどうかをチェックします。

public **isResource** (*mixed* $resourceName)

リソースリストにリソースが存在するかどうかをチェックします

public **addResource** ([Phalcon\Acl\Resource](/en/3.2/api/Phalcon_Acl_Resource) | *string* $resourceValue, *array* | *string* $accessList)

リソースをアクセス制御リストリストに追加します。 アクセス名は特定のアクションで使用します。例えば search(検索), update(更新), delete(削除)などで、これらのリストになります。 例:

```php
<?php

// リソースをリストに追加して、アクションへのアクセスを許可します。
$acl->addResource(
    new Phalcon\Acl\Resource("customers"),
    "search"
);

$acl->addResource("customers", "search");

// リソースをアクセスリストに追加します。
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

リソースへのアクセスを追加します

public **dropResourceAccess** (*mixed* $resourceName, *array* | *string* $accessList)

リソースからのアクセスを削除します

protected **_allowOrDeny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, *mixed* $action, [*mixed* $func])

ロールがリソースへのアクセスを許可されているかをチェックします

public **allow** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

リソース上のロールへのアクセスを許可します ワイルドカードとして'*'を使用できます 例:

```php
<?php

// guestsロールに対して、customersリソースのsearchアクションを許可
$acl->allow("guests", "customers", "search");

// guestsロールに対して、customersリソースのsearchとcreateアクションを許可
$acl->allow("guests", "customers", ["search", "create"]);

// 全ロールに対して、productsリソースのbrowseアクションを許可
$acl->allow("*", "products", "browse");

// 全ロールに対して、全リソースのbrowseアクションを許可
$acl->allow("*", "*", "browse");

```

public **deny** (*mixed* $roleName, *mixed* $resourceName, *mixed* $access, [*mixed* $func])

リソース上のロールへのアクセスを禁止します。 ワイルドカードとして'*'を使用できます。 例:

```php
<?php

// guestsロールに対して、customersリソースのsearchアクションを禁止
$acl->deny("guests", "customers", "search");

// guestsロールに対して、customersリソースのsearchとcreateアクションを禁止
$acl->deny("guests", "customers", ["search", "create"]);

// 全ロールに対して、productsリソースのbrowseアクションを禁止
$acl->deny("*", "products", "browse");

// 全ロールに対して、全リソースのbrowseアクションを禁止
$acl->deny("*", "*", "browse");

```

public **isAllowed** (*RoleInterface* | *RoleAware* | *string* $roleName, *ResourceInterface* | *ResourceAware* | *string* $resourceName, *mixed* $access, [*array* $parameters])

リソースへのアクションが、ロールに対して許可されているかどうかを確認する

```php
<?php

// andresロールに対して、customersリソースのcreateアクションが許可されているか？
$acl->isAllowed("andres", "Products", "create");

// guestsロールに対して、全てのリソースに対するeditアクションが許可されているか？
$acl->isAllowed("guests", "*", "edit");

```

public **setNoArgumentsDefaultAction** (*mixed* $defaultAccess)

isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベル(Phalcon\\Acl::ALLOW または Phalcon\\Acl::DENY)を設定します。ただしaccessKeyのfuncは存在しているものとします。

public **getNoArgumentsDefaultAction** ()

isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベルを返します。ただしaccessKeyのfuncは存在しているものとします。

public **getRoles** ()

リストに登録されている全ロールの配列を返します。

public **getResources** ()

リストに登録されている全リソースの配列を返します。

public **getActiveRole** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

特定のリソース/アクセスが許可されているかをチェックするための、ロールリストを返します

public **getActiveResource** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

ロールがアクセスできるかをチェックするための、リソースリストを返します

public **getActiveAccess** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

ロールがアクセスできるかをチェックするための、有効なアクセス制御リストを返します

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

イベントマネージャーをセットします

public **getEventsManager** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

内部イベントマネージャーを返します

public **setDefaultAction** (*mixed* $defaultAccess) inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

デフォルトのアクセスレベル (Phalcon\\Acl::ALLOW または Phalcon\\Acl::DENY)をセットします。

public **getDefaultAction** () inherited from [Phalcon\Acl\Adapter](/en/3.2/api/Phalcon_Acl_Adapter)

デフォルトのACLアクセスレベルを返します