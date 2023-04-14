---
layout: default
title: 'Phalcon\Acl'
---

{%- include env-setup.html -%}

* [Phalcon\Acl\Adapter\AbstractAdapter](#acl-adapter-abstractadapter)
* [Phalcon\Acl\Adapter\AdapterInterface](#acl-adapter-adapterinterface)
* [Phalcon\Acl\Adapter\Memory](#acl-adapter-memory)
* [Phalcon\Acl\Component](#acl-component)
* [Phalcon\Acl\ComponentAwareInterface](#acl-componentawareinterface)
* [Phalcon\Acl\ComponentInterface](#acl-componentinterface)
* [Phalcon\Acl\Enum](#acl-enum)
* [Phalcon\Acl\Exception](#acl-exception)
* [Phalcon\Acl\Role](#acl-role)
* [Phalcon\Acl\RoleAwareInterface](#acl-roleawareinterface)
* [Phalcon\Acl\RoleInterface](#acl-roleinterface)

<h1 id="acl-adapter-abstractadapter">抽象クラス Phalcon\Acl\Adapter\AbstractAdapter</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Acl\Adapter | | Uses       | Phalcon\Acl\Enum, Phalcon\Events\AbstractEventsAware, Phalcon\Events\EventsAwareInterface | | Extends    | AbstractEventsAware | | Implements | AdapterInterface, EventsAwareInterface |

Phalcon\Acl 用アダプター


## Properties
```php
/**
 * Access Granted
 *
 * @var bool
 */
protected accessGranted = false;

/**
 * Active access which the list is checking if some role can access it
 *
 * @var string|null
 */
protected activeAccess;

/**
 * Component which the list is checking if some role can access it
 *
 * @var string|null
 */
protected activeComponent;

/**
 * Role which the list is checking if it's allowed to certain
 * component/access
 *
 * @var string|null
 */
protected activeRole;

/**
 * Default access
 *
 * @var int
 */
protected defaultAccess;

```

## メソッド

```php
public function getActiveAccess(): string | null;
```
Active access which the list is checking if some role can access it


```php
public function getActiveComponent(): string | null;
```
Component which the list is checking if some role can access it


```php
public function getActiveRole(): string | null;
```
Role which the list is checking if it's allowed to certain component/access


```php
public function getDefaultAction(): int;
```
デフォルトのACLアクセスレベルを返します


```php
public function setDefaultAction( int $defaultAccess ): void;
```
Sets the default access level (Phalcon\Acl\Enum::ALLOW or Phalcon\Acl\Enum::DENY)




<h1 id="acl-adapter-adapterinterface">インターフェース Phalcon\Acl\Adapter\AdapterInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Acl\Adapter | | Uses       | Phalcon\Acl\ComponentInterface, Phalcon\Acl\RoleInterface |

Phalcon\Acl adapters用のインターフェース


## メソッド

```php
public function addComponent( mixed $componentValue, mixed $accessList ): bool;
```
アクセス制御リストにコンポーネントを追加します。

Access names can be a particular action, by example search, update, delete, etc. or a list of them


```php
public function addComponentAccess( string $componentName, mixed $accessList ): bool;
```
コンポーネントへのアクセスの追加


```php
public function addInherit( string $roleName, mixed $roleToInherits ): bool;
```
既存のロールからロールを継承する。


```php
public function addRole( mixed $role, mixed $accessInherits = null ): bool;
```
アクセス制御リストにロールを追加します。 第二引数は、その他の既存のロールからアクセスデータを継承します。


```php
public function allow( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```
コンポーネント上のロールへのアクセスを許可します。


```php
public function deny( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```
コンポーネント上のロールへのアクセスを拒否


```php
public function dropComponentAccess( string $componentName, mixed $accessList ): void;
```
Removes access from a component


```php
public function getActiveAccess(): null | string;
```
ロールによるアクセス権の使用可否をチェックし、アクセス権のリストを返します。


```php
public function getActiveComponent(): null | string;
```
ロールによるコンポーネントのアクセス可否をチェックし、コンポーネントのリストを返します。


```php
public function getActiveRole(): null | string;
```
ロールによる特定のコンポーネントまたはアクセス権に対する使用可否をチェックし、ロールのリストを返します。


```php
public function getComponents(): ComponentInterface[];
```
リストに登録されている全コンポーネントの配列を返します。


```php
public function getDefaultAction(): int;
```
デフォルトのACLアクセスレベルを返します


```php
public function getInheritedRoles( string $roleName = string ): array;
```
Returns the inherited roles for a passed role name. If no role name has been specified it will return the whole array. If the role has not been found it returns an empty array


```php
public function getNoArgumentsDefaultAction(): int;
```
isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベルを返します。ただしaccessKeyのfuncは存在しているものとします。


```php
public function getRoles(): RoleInterface[];
```
リストに登録されている全ロールの配列を返します。


```php
public function isAllowed( mixed $roleName, mixed $componentName, string $access, array $parameters = null ): bool;
```
コンポーネントへのアクションが、ロールに対して許可されているかどうかを確認します。


```php
public function isComponent( string $componentName ): bool;
```
コンポーネントリストにコンポーネントが存在するかどうかをチェックします。


```php
public function isRole( string $roleName ): bool;
```
ロールリストにロールが存在するかどうかをチェックします。


```php
public function setDefaultAction( int $defaultAccess ): void;
```
デフォルトのアクセスレベル (Phalcon\Acl\Enum::ALLOW または Phalcon\Acl\Enum::DENY)をセットします。


```php
public function setNoArgumentsDefaultAction( int $defaultAccess ): void;
```
isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベル(Phalcon\Acl\Enum::ALLOW または Phalcon\Acl\Enum::DENY)を設定します。ただしaccessKeyのfuncは存在しているものとします。




<h1 id="acl-adapter-memory">Phalcon\Acl\Adapter\Memoryクラス</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Adapter/Memory.zep)

| Namespace  | Phalcon\Acl\Adapter | | Uses       | Phalcon\Acl\Enum, Phalcon\Acl\Role, Phalcon\Acl\RoleInterface, Phalcon\Acl\Component, Phalcon\Acl\Exception, Phalcon\Acl\RoleAwareInterface, Phalcon\Acl\ComponentAwareInterface, Phalcon\Acl\ComponentInterface, ReflectionFunction | | Extends    | AbstractAdapter |

メモリ上のアクセス制御リストを管理します

```php
$acl = new \Phalcon\Acl\Adapter\Memory();

$acl->setDefaultAction(
    \Phalcon\Acl\Enum::DENY
);

// Register roles
$roles = [
    "users"  => new \Phalcon\Acl\Role("Users"),
    "guests" => new \Phalcon\Acl\Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Private area components
$privateComponents = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(
        new \Phalcon\Acl\Component($componentName),
        $actions
    );
}

// Public area components
$publicComponents = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(
        new \Phalcon\Acl\Component($componentName),
        $actions
    );
}

// Grant access to public areas to both users and guests
foreach ($roles as $role) {
    foreach ($publicComponents as $component => $actions) {
        $acl->allow($role->getName(), $component, "*");
    }
}

// Grant access to private area to role Users
foreach ($privateComponents as $component => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $component, $action);
    }
}
```


## Properties
```php
/**
 * Access
 *
 * @var mixed
 */
protected access;

/**
 * Access List
 *
 * @var mixed
 */
protected accessList;

/**
 * Returns the latest function used to acquire access
 *
 * @var mixed
 */
protected activeFunction;

/**
 * Returns number of additional arguments(excluding role and resource) for active function
 *
 * @var int
 */
protected activeFunctionCustomArgumentsCount = 0;

/**
 * Returns the latest key used to acquire access
 *
 * @var string|null
 */
protected activeKey;

/**
 * Components
 *
 * @var mixed
 */
protected components;

/**
 * Component Names
 *
 * @var mixed
 */
protected componentsNames;

/**
 * Function List
 *
 * @var mixed
 */
protected func;

/**
 * Default action for no arguments is `allow`
 *
 * @var mixed
 */
protected noArgumentsDefaultAction;

/**
 * Roles
 *
 * @var mixed
 */
protected roles;

/**
 * Role Inherits
 *
 * @var mixed
 */
protected roleInherits;

```

## メソッド

```php
public function __construct();
```
Phalcon\Acl\Adapter\Memory コンストラクタ


```php
public function addComponent( mixed $componentValue, mixed $accessList ): bool;
```
アクセス制御リストにコンポーネントを追加します。

Access names can be a particular action, by example search, update, delete, etc. or a list of them

例:
```php
// Add a component to the list allowing access to an action
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    "search"
);

$acl->addComponent("customers", "search");

// Add a component  with an access list
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addComponent(
    "customers",
    [
        "create",
        "search",
    ]
);
```


```php
public function addComponentAccess( string $componentName, mixed $accessList ): bool;
```
コンポーネントへのアクセスの追加


```php
public function addInherit( string $roleName, mixed $roleToInherits ): bool;
```
既存のロールからロールを継承する。

```php
$acl->addRole("administrator", "consultant");
$acl->addRole("administrator", ["consultant", "consultant2"]);
```


```php
public function addRole( mixed $role, mixed $accessInherits = null ): bool;
```
アクセス制御リストにロールを追加します。 第二引数は、既存の他のロールからアクセスデータを継承します。

```php
$acl->addRole(
    new Phalcon\Acl\Role("administrator"),
    "consultant"
);

$acl->addRole("administrator", "consultant");
$acl->addRole("administrator", ["consultant", "consultant2"]);
```


```php
public function allow( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```
コンポーネント上のロールへのアクセスを許可します。 ワイルドカードとして`*` を使用できます。

```php
// Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

// Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

// Allow access to any role to browse on products
$acl->allow("*", "products", "browse");

// Allow access to any role to browse on any component
$acl->allow("*", "*", "browse");


```php
public function deny( string $roleName, string $componentName, mixed $access, mixed $func = null ): void;
```
コンポーネント上のロールへのアクセスを拒否. ワイルドカードとして`*` を使用できます。

```php
// Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

// Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

// Deny access to any role to browse on products
$acl->deny("*", "products", "browse");

// Deny access to any role to browse on any component
$acl->deny("*", "*", "browse");
```


```php
public function dropComponentAccess( string $componentName, mixed $accessList ): void;
```
Removes access from a component


```php
public function getActiveFunction(): mixed;
```
Returns the latest function used to acquire access


```php
public function getActiveFunctionCustomArgumentsCount(): int;
```
Returns number of additional arguments(excluding role and resource) for active function


```php
public function getActiveKey(): string | null;
```
Returns the latest key used to acquire access


```php
public function getComponents(): ComponentInterface[];
```
リストに登録されている全コンポーネントの配列を返します。


```php
public function getInheritedRoles( string $roleName = string ): array;
```
Returns the inherited roles for a passed role name. If no role name has been specified it will return the whole array. If the role has not been found it returns an empty array


```php
public function getNoArgumentsDefaultAction(): int;
```
`isAllowed`アクションに引数が指定されていなかった際のデフォルトのACLアクセスレベルを返します。ただし(呼び出し可能な)`func`の`accessKey`は存在しているものとします。


```php
public function getRoles(): RoleInterface[];
```
リストに登録されている全ロールの配列を返します。


```php
public function isAllowed( mixed $roleName, mixed $componentName, string $access, array $parameters = null ): bool;
```
コンポーネントへのアクションが、ロールに対して許可されているかどうかを確認します。

```php
// Does andres have access to the customers component to create?
$acl->isAllowed("andres", "Products", "create");

// Do guests have access to any component to edit?
$acl->isAllowed("guests", "*", "edit");
```


```php
public function isComponent( string $componentName ): bool;
```
コンポーネントリストにコンポーネントが存在するかどうかをチェックします。


```php
public function isRole( string $roleName ): bool;
```
ロールリストにロールが存在するかどうかをチェックします。


```php
public function setNoArgumentsDefaultAction( int $defaultAccess ): void;
```
isAllowedアクションに引数が指定されていなかった際のデフォルトのアクセスレベル(Phalcon\Enum::ALLOW または Phalcon\Enum::DENY)を設定します。ただしaccessKeyのfuncは存在しているものとします。




<h1 id="acl-component">Phalcon\Acl\Componentクラス</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Component.zep)

| Namespace  | Phalcon\Acl | | Implements | ComponentInterface |

このクラスはコンポーネントエントリとその説明を定義します。


## Properties
```php
/**
 * Component description
 *
 * @var string
 */
private description;

/**
 * Component name
 *
 * @var string
 */
private name;

```

## メソッド

```php
public function __construct( string $name, string $description = null );
```
Phalcon\Acl\Component コンストラクタ


```php
public function __toString(): string;
```

```php
public function getDescription(): string;
```

```php
public function getName(): string;
```





<h1 id="acl-componentawareinterface">Interface Phalcon\Acl\ComponentAwareInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/ComponentAwareInterface.zep)

| Namespace  | Phalcon\Acl |

Interface for classes which could be used in allow method as RESOURCE


## メソッド

```php
public function getComponentName(): string;
```
コンポーネント名を返します。




<h1 id="acl-componentinterface">Phalcon\Acl\ComponentInterfaceインターフェース</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/ComponentInterface.zep)

| Namespace  | Phalcon\Acl |

Phalcon\Acl\Componentインターフェース


## メソッド

```php
public function __toString(): string;
```
マジックメソッド __toString


```php
public function getDescription(): string;
```
コンポーネントの説明を返します。


```php
public function getName(): string;
```
コンポーネント名を返します。




<h1 id="acl-enum">Phalcon\Acl\Enumクラス</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Enum.zep)

| Namespace  | Phalcon\Acl |

Phalcon\Acl\Adapter アダプタの定数


## 定数
```php
const ALLOW = 1;
const DENY = 0;
```


<h1 id="acl-exception">Phalcon\Acl\Exceptionクラス</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Exception.zep)

| Namespace  | Phalcon\Acl | | Extends    | \Exception |

Phalcon\Aclがスローする例外のクラス



<h1 id="acl-role">Phalcon\Acl\Role クラス</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/Role.zep)

| Namespace  | Phalcon\Acl | | Implements | RoleInterface |

このクラスはロールエントリとその説明を定義します。


## Properties
```php
/**
 * Role description
 *
 * @var string
 */
private description;

/**
 * Role name
 *
 * @var string
 */
private name;

```

## メソッド

```php
public function __construct( string $name, string $description = null );
```
Phalcon\Acl\Role コンストラクタ


```php
public function __toString(): string;
```

```php
public function getDescription(): string;
```

```php
public function getName(): string;
```





<h1 id="acl-roleawareinterface">Interface Phalcon\Acl\RoleAwareInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/RoleAwareInterface.zep)

| Namespace  | Phalcon\Acl |

Interface for classes which could be used in allow method as ROLE


## メソッド

```php
public function getRoleName(): string;
```
ロール名を返します。




<h1 id="acl-roleinterface">Phalcon\Acl\RoleInterfaceインターフェース</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Acl/RoleInterface.zep)

| Namespace  | Phalcon\Acl |

Phalcon\Acl\Roleのインターフェース


## メソッド

```php
public function __toString(): string;
```
マジックメソッド __toString


```php
public function getDescription(): string;
```
ロールの説明を返します。


```php
public function getName(): string;
```
ロール名を返します。
