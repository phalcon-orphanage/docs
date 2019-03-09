---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Definición de Controles de Acceso

Después que los `Roles` y los `Components` fueron definidos, tenemos que atarlos juntos para que la lista de acceso pueda ser creada. This is the most important step in the role since a small mistake here can allow access to roles for components that the developer does not intend to. Como se mencionó anteriormente, la acción de acceso predeterminada para [Phalcon\Acl](api/Phalcon_Acl) es `Acl::DENY`, siguiendo el enfoque de [lista blanca](https://en.wikipedia.org/wiki/Whitelisting).

To tie `Roles` and `Components` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory) class.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Add the roles
 */
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


/**
 * Add the Components
 */
$acl->addComponent('admin', ['dashboard', 'users', 'view']);
$acl->addComponent('reports', ['list', 'add', 'view']);
$acl->addComponent('session', ['login', 'logout']);

/**
 * Now tie them all together 
 */
$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');
```

Las líneas anteriores nos dicen:

```php
$acl->allow('manager', 'admin', 'users');
```

For the `manager` role, allow access to the `admin` component and `users` action. Para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `admin` y a la acción `users`.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

También puede pasar una matriz como parámetro `action` al invocar el comando `allow()`. The above means that for the `manager` role, allow access to the `reports` component and `list` and `add` actions. Una vez más para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `reports` y a las acciones `list` y `add`.

```php
$acl->allow('*', 'session', '*');
```

Wildcards can also be used to do mass matching for roles, components or actions. In the above example, we allow every role to access every action in the `session` component. This command will give access to the `manager`, `accounting` and `guest` roles, access to the `session` component and to the `login` and `logout` actions.

```php
$acl->allow('*', '*', 'view');
```

Similarly the above gives access to any role, any component that has the `view` action. En una aplicación MVC, lo anterior es el equivalente a permitir que cualquier grupo acceda a cualquier controlador que exponga una `viewAction`.

> Por favor, tenga **MUCHO** cuidado al usar el comodín `*`. Es muy fácil cometer un error y el comodín, aunque parece conveniente, puede permitir que los usuarios accedan a áreas de su aplicación que no se supone que lo hagan. La mejor manera de estar 100% seguro es escribir pruebas específicamente para probar los permisos y la ACL. Estos pueden hacerse en la `unit` de las pruebas instanciando el componente y luego comprobando el `isAllowed()` si es `true` o `false`.
> 
> [Codeception](https://codeception.com) is the chosen testing framework for Phalcon and there are plenty of tests in our github repository (`tests` folder) to offer guidance and ideas.
{:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

For the `guest` role, we deny access to all components with the `view` action. Despite the fact that the default access level is `Acl::DENY` in our example above, we specifically allowed the `view` action to all roles and components. This includes the `guest` role. We want to allow the `guest` role access only to the `session` component and the `login` and `logout` actions, since `guests` are not logged into our application.

```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` role to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```