---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#acl'
title: 'Listas de control de acceso (ACL)'
keywords: 'acl, lista de control de acceso, permisos'
---

# Listas de control de acceso (ACL)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
[Phalcon\Acl][acl-acl] provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists][acl] (ACL) allow an application to control access to its areas and the underlying objects from requests.

En resumen, ACLs tienen dos objetos: El objeto que necesita acceso, y el objeto al que necesitamos acceder. In the programming world, these are usually referred to as Roles and Resources. In the Phalcon world, we use the terminology [Role][acl-role] and [Component][acl-component].

> **Caso de Uso**
> 
> Una aplicación contable necesita tener diferentes grupos de usuarios que tengan acceso a varias áreas de la aplicación.
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page 
> 
> {: .alert .alert-info }

As seen above in the use case, an [Role][acl-role] is defined as who needs to access a particular [Component][acl-component] i.e. an area of the application. A [Component][acl-component] is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl][acl-acl] component, we can tie those two together, and strengthen the security of our application, allowing only specific roles to be bound to specific components.

## Activación
[Phalcon\Acl][acl-acl] uses adapters to store and work with roles and components. The only adapter available right now is [Phalcon\Acl\Adapter\Memory][acl-adapter-memory]. Si el adaptador usa la memoria, incrementa significativamente la velocidad en la que se accede a la ACL pero también presenta inconvenientes. El principal inconveniente es que la memoria no es persistente, con lo que el desarrollador necesita implementar una estrategia de almacenamiento de los datos de la ACL, para que no se genere la ACL en cada petición. Esto fácilmente puede suponer retrasos y procesamiento innecesario, especialmente si la ACL es bastante grande y/o se almacena en una base de datos o sistema de ficheros.

The [Phalcon\Acl][acl-acl] constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();
```
The default action is **`Phalcon\Acl\Enum::DENY`** for any [Role][acl-role] or [Component][acl-component]. Esto tiene como propósito asegurar que sólo el desarrollador o la aplicación permiten el acceso a componentes específicos y no el propio componente ACL.

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->setDefaultAction(Enum::ALLOW);
```

## Constantes
The [Phalcon\Acl\Enum][acl-enum] class offers two constants that can be used when defining access levels.

- `Phalcon\Acl\Enum::ALLOW` (`1`)
- `Phalcon\Acl\Enum::DENY` (`0` - predeterminado)

Puede usar estas constantes para definir los niveles de acceso para su ACL.

## Añadir Roles
As mentioned above, a [Phalcon\Acl\Role][acl-role] is an object that can or cannot access a set of [Component][acl-component] in the access list.

Hay dos maneras de añadir roles a nuestra lista.
* by using a [Phalcon\Acl\Role][acl-role] object or
* using a string, representing the name of the role

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Role][acl-role] objects in our list.

Objetos Rol. El primer parámetro es el nombre del rol, el segundo la descripción

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleAccounting = new Role('accounting', 'Accounting Department Access'); 

$acl->addRole($roleAdmins);
$acl->addRole($roleAccounting);
```

Cadenas. Añade el rol justo con ese nombre directamente a la ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->addRole('manager');
$acl->addRole('guest');
```

## Añadir Componentes
A [Component][acl-component] is the area of the application where access is controlled. En una aplicación MVC, esto podría ser un Controlador. Although not mandatory, the [Phalcon\Acl\Component][acl-component] class can be used to define components in the application. También es importante añadir acciones relativas a un componente para que la ACL pueda comprender qué debería controlar.

Hay dos maneras de añadir componentes a nuestra lista.
* by using a [Phalcon\Acl\Component][acl-component] object or
* using a string, representing the name of the role

Similar a `addRole`, `addComponent` requiere un nombre para el componente y una descripción opcional.

Objetos Componente. El primer parámetro es el nombre del componente, el segundo la descripción

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;

$acl = new Memory();

$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

$acl->addComponent(
    $admin,
    [
        'dashboard',
        'users',
    ]
);

$acl->addComponent(
    $reports,
    [
        'list',
        'add',
    ]
);
```

Cadenas. Añade el componente justo con ese nombre directamente a la ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
    ]
);
```

## Definición de Controles de Acceso
Después de definir los `Roles` y `Componentes`, necesitamos unirlos para poder crear la lista de acceso. Este es el paso más importante en la operación, ya que un pequeño error aquí puede permitir el acceso de los roles a componentes a los que el desarrollador no tenía intención de hacerlo. As mentioned earlier, the default access action for [Phalcon\Acl][acl-acl] is `Phalcon\Acl\Enum::DENY`, following the [white list][whitelist] approach.

To tie `Roles` and `Components` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory][acl-adapter-memory] class.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

$acl->addComponent(
    'session',
    [
        'login',
        'logout',
    ]
);

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');
```

Lo que nos dicen las líneas anteriores:

```php
$acl->allow('manager', 'admin', 'users');
```

Para el rol `manager`, se permite el acceso al componente `admin` y acción `users`. Para llevar esto a la perspectiva de una aplicación MVC, la línea anterior dice que al grupo `manager` se le permite el acceso al controlador `admin` y acción `users`.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

También puede pasar un vector como parámetro `action` cuando se invoca al comando `allow()`. Lo anterior significa que para el rol `manager`, se permite el acceso al componente `reports` y las acciones `list` y `add`. Otra vez llevando esta perspectiva a una aplicación MVC, la línea anterior dice que al grupo `manager` se permite el acceso al controlador `reports` y acciones `list` y `add`.

```php
$acl->allow('*', 'session', '*');
```

También se pueden usar comodines para hacer un emparejamiento masivo para roles, componentes o acciones. En el ejemplo anterior, permitimos a todos los roles acceder a todas las acciones del componente `session`. Este comando dará acceso a los roles `manager`, `accounting` y `guest`, acceso al componente `session` y las acciones `login` y `logout`.

```php
$acl->allow('*', '*', 'view');
```

Del mismo modo, lo anterior da acceso para cualquier rol, a cualquier componente que tenga la acción `view`. En una aplicación MVC, lo anterior es equivalente a permitir a cualquier grupo acceder a cualquier controlador que expone un `viewAction`.

> **NOTE**: Please be **VERY** careful when using the `*` wildcard. Es muy fácil cometer un error y el comodín, aunque parezca conveniente, puede permitir a los usuarios acceder a áreas de su aplicación a las que no debería. La mejor manera de estar 100% seguro es escribir pruebas específicamente para probar los permisos y la ACL. Estos se pueden hacer en el conjunto de pruebas `unit` instanciando el componente y luego comprobando si `isAllowed()` es `true` o `false`.
> 
> [Codeception][codeception] is the chosen testing framework for Phalcon and there are plenty of tests in our GitHub repository (`tests` folder) to offer guidance and ideas. 
> 
> {:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

Para el rol `guest`, denegamos el acceso a todos los componentes con la acción `view`. A pesar de que el nivel de acceso por defecto es `Acl\Enum::DENY` en nuestro ejemplo anterior, hemos permitido específicamente la acción `view` para todos los roles y componentes. Esto incluye el rol `guest`. Queremos permitir que el rol `guest` acceda únicamente al componente `session` y las acciones `login` y `logout`, ya que `guests` no están autenticados en nuestra aplicación.

```php
$acl->allow('*', '*', 'view');
```

Esto da acceso a `view` a todo el mundo, pero queremos que el rol `guest` sea excluido de éste, así que la siguiente línea hace lo que necesitamos.

```php
$acl->deny('guest', '*', 'view');
```

## Consultar
Una vez definida la lista, podemos consultarla para comprobar si un rol particular tiene acceso a un componente y acción particular. Para ello, necesitamos usar el método `isAllowed()`.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

$acl->addComponent(
    'session',
    [
        'login',
        'logout',
    ]
);

// #03
$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

// #04
$acl->deny('guest', '*', 'view');

// ....

// #05
$acl->isAllowed('manager', 'admin', 'dashboard');

// #06
$acl->isAllowed('manager', 'session', 'login');

// #07
$acl->isAllowed('accounting', 'reports', 'view');

// #08
$acl->isAllowed('guest', 'reports', 'view');

// #09
$acl->isAllowed('guest', 'reports', 'add');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set up the `allow` list
> 
> 04: Set up the `deny` list
> 
> 05: `true` - defined explicitly
> 
> 06: `true` - defined with wildcard
> 
> 07: `true` - defined with wildcard
> 
> 08: `false` - defined explicitly
> 
> 09: `false` - default access level 
> 
> {: .alert .alert-info }

## Acceso Basado en Función
Dependiendo de las necesidades de su aplicación, podría necesitar otra capa de cálculos para permitir o denegar el acceso a los usuarios mediante la ACL. El método `isAllowed()` acepta un cuarto parámetro que es un `callable` como una función anónima.

Para aprovechar esta funcionalidad, necesita definir su función cuando llama el método `allow()` para el rol y componente que necesita. Supongamos que necesitamos permitir el acceso a todos los roles `manager` al componente `admin` excepto si su nombre es 'Bob' (¡Pobre Bob!). Para conseguir esto registraremos una función anónima que compruebe esta condición.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function 
> 
> {: .alert .alert-info }

Ahora que el *callable* está definido en la ACL, necesitaremos llamar al método `isAllowed()` con un vector como cuarto parámetro:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// #04
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// #05
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function
> 
> 04: Returns `true`
> 
> 05: Returns `false` 
> 
> {: .alert .alert-info }

> **NOTE**:The fourth parameter must be an array. Cada elemento del vector representa un parámetro que acepta su función anónima. La clave del elemento es el nombre del parámetro, mientras que el valor es el que se pasará como valor del parámetro a la función. 
> 
> {: .alert .alert-info }

También puede omitir el paso del cuarto parámetro a `isAllowed()` si lo desea. El valor por defecto para una llamada a `isAllowed()` sin el último parámetro es `Acl\Enum::DENY`. Para cambiar este comportamiento, puede hacer una llamada a `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// #04
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(
    Enum::ALLOW
);

// #05
$acl->isAllowed('manager', 'admin', 'dashboard');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function
> 
> 04: Returns `false`
> 
> 05: Returns `true` 
> 
> {: .alert .alert-info }

## Objetos Personalizados
Phalcon permite a los desarrolladores definir sus propios objetos rol y componente. Estos objetos deben implementar las interfaces facilitadas:

* [Phalcon\Acl\RoleAware][acl-roleaware] for Role
* [Phalcon\Acl\ComponentAware][acl-componentaware] for Component

### Rol
We can implement the [Phalcon\Acl\RoleAware][acl-roleaware] in our custom class with its own logic. El siguiente ejemplo muestra un nuevo objeto rol llamado `ManagerRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// #01
class ManagerRole implements RoleAware
{
    protected $id;

    protected $roleName;

    public function __construct($id, $roleName)
    {
        $this->id       = $id;
        $this->roleName = $roleName;
    }

    public function getId()
    {
        return $this->id;
    }

    // #02
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

> **Legend**
> 
> 01: Create our class which will be used as roleName
> 
> 02: Implemented function from RoleAware Interface 
> 
> {: .alert .alert-info }

### Componente
We can implement the [Phalcon\Acl\ComponentAware][acl-componentaware] in our custom class with its own logic. El siguiente ejemplo muestra un nuevo objeto componente llamado `ReportsComponent`:

```php
<?php

use Phalcon\Acl\ComponentAware;

// #01
class ReportsComponent implements ComponentAware
{
    protected $id;

    protected $componentName;

    protected $userId;

    public function __construct($id, $componentName, $userId)
    {
        $this->id            = $id;
        $this->componentName = $componentName;
        $this->userId        = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // #02
    public function getComponentName()
    {
        return $this->componentName;
    }
}
```

> **Legend**
> 
> 01: Create our class which will be used as componentName
> 
> 02: Implemented function from ComponentAware Interface 
> 
> {: .alert .alert-info }

### ACL
Estos objetos ahora ya se pueden usar en nuestra ACL.

```php
<?php

use ManagerRole;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use ReportsComponent;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

// #03
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerRole $manager, ModelComponent $model) {
        return boolval($manager->getId() === $model->getUserId());
    }
);

// #04
$levelOne = new ManagerRole(1, 'manager-1');
$levelTwo = new ManagerRole(2, 'manager');
$admin    = new ManagerRole(3, 'manager');

// #05
$reports  = new ModelComponent(2, 'reports', 2);

// #06
$acl->isAllowed($levelOne, $reports, 'list');

// #07
$acl->isAllowed($levelTwo, $reports, 'list');

// #08
$acl->isAllowed($admin, $reports, 'list');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Now tie them all together with a custom function. The `ManagerRole` and `ModelSubject` parameters are necessary for the custom function to work
> 
> 04: Create the custom objects
> 
> 05: id - name - userId
> 
> 06: Check whether our user objects have access. Returns `false`
> 
> 07: Returns `true`
> 
> 08: Returns `false` 
> 
> {: .alert .alert-info }

La segunda llamada de `$levelTwo` evalúa `true` ya que `getUserId()` devuelve `2` que a su vez es evaluado en nuestra función personalizada. También tenga en cuenta que en la función personalizada `allow()` los objetos son automáticamente vinculados, proporcionando todos los datos necesarios para que la función personalizada funcione. La función personalizada puede aceptar cualquier número de parámetros adicionales. El orden de los parámetros definidos en el constructor `function()` no importa, porque los objetos serán descubiertos y vinculados automáticamente.

## Herencia de Roles
Para eliminar la duplicación y aumentar la eficiencia en su aplicación, la ACL ofrece herencia de roles. This means that you can define one [Phalcon\Acl\Role][acl-role] as a base and after that inherit from it offering access to supersets or subsets of components. Para utilizar la herencia de roles, necesita pasar el rol heredado como el segundo parámetro de la llamada del método, al añadir ese rol en la lista.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

// #01
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

// #02
$acl->addRole($guest);

// #03
$acl->addRole($accounting, $guest);

// #04
$acl->addRole($manager, $accounting);
```

> **Legend**
> 
> 01: Create roles
> 
> 02: Add the `guest` role to the ACL
> 
> 03: Add the `accounting` inheriting from `guest`
> 
> 04: Add the `manager` inheriting from `accounting` 
> 
> {: .alert .alert-info }

Sea cual sea el acceso que tenga `guests`, se propagará a `accounting` y a su vez `accounting` se propagará a `manager`. También puede pasar un vector de roles como segundo parámetro de `addRole` ofreciendo más flexibilidad.

## Relaciones de Roles
Basado en el diseño de aplicación, podría preferir añadir primero todos los roles y después definir la relación entre ellos.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

// #01
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

// #02
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

// #03
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);
```

> **Legend**
> 
> 01: Create roles
> 
> 02: Add all the roles
> 
> 03: Add the inheritance 
> 
> {: .alert .alert-info }

## Serialización
[Phalcon\Acl][acl-acl] can be serialized and stored in a cache system to improve efficiency. Puede almacenar el objeto serializado en APC, sesión, sistema de ficheros, base de datos, Redis, etc. De esta manera puede recuperar la ACL rápidamente sin tener que leer los datos subyacentes que crea la ACL, ni tendrá que calcular la ACL en cada petición.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$aclFile = 'app/security/acl.cache';
// #01
if (true !== is_file($aclFile)) {

    // #02
    $acl = new Memory();

    // #03
    // ...

    // #04
    file_put_contents(
        $aclFile,
        serialize($acl)
    );
} else {
    // #05
    $acl = unserialize(
        file_get_contents($aclFile)
    );
}

// #06
if (true === $acl->isAllowed('manager', 'admin', 'dashboard')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

> **Legend**
> 
> 01: Check whether ACL data already exist
> 
> 02: The ACL does not exist - build it
> 
> 03: Define roles, components, access, etc.
> 
> 04: Store serialized list into a plain file
> 
> 05: Restore the ACL object from the serialized file
> 
> 06: Use the ACL list as needed 
> 
> {: .alert .alert-info }

Es una buena práctica no usar serialización de la ACL durante el desarrollo, para asegurarse que su ACL se reconstruye en cada petición, mientras que se usan otros adaptadores o medios de serializado y almacenamiento para la ACL en producción.

## Eventos
[Phalcon\Acl][acl-acl] can work in conjunction with the [Events Manager](events) if present, to fire events to your application. Los eventos se disparan usando el tipo `acl`. Los eventos que devuelven `false` pueden detener el rol activo. Los siguientes eventos están disponibles:

| Nombre de evento    | Disparado                                                        | ¿Puede detener el rol? |
| ------------------- | ---------------------------------------------------------------- |:----------------------:|
| `afterCheckAccess`  | Lanzado después de comprobar si un rol o componente tiene acceso |           No           |
| `beforeCheckAccess` | Lanzado antes de comprobar si un rol o componente tiene acceso   |           Si           |

El siguiente ejemplo demuestra como adjuntar oyentes a la ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

// ...

// #01
$eventsManager = new Manager();

// #02
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new Memory();

// #03
// ...

// #04
$acl->setEventsManager($eventsManager);
```

> **Legend**
> 
> 01: Create an event manager
> 
> 02: Attach a listener for type `acl`
> 
> 03: Setup the `$acl`
> 
> 04: Bind the eventsManager to the ACL component 
> 
> {: .alert .alert-info }

## Excepciones
Any exceptions thrown in the `Phalcon\Acl` namespace will be of type [Phalcon\Acl\Exception][acl-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Exception;

try {
    $acl   = new Memory();
    $admin = new Component('*');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Personalizado
The [Phalcon\Acl\AdapterInterface][acl-adapter-adapterinterface] interface must be implemented in order to create your own ACL adapters or extend the existing ones.

[acl]: https://en.wikipedia.org/wiki/Access_control_list
[acl-acl]: api/Phalcon_Acl
[acl-adapter-adapterinterface]: api/Phalcon_Acl#acl-adapter-adapterinterface
[acl-adapter-memory]: api/Phalcon_Acl#acl-adapter-memory
[acl-adapter-memory]: api/Phalcon_Acl#acl-adapter-memory
[acl-component]: api/Phalcon_Acl#acl-component
[acl-component]: api/Phalcon_Acl#acl-component
[acl-componentaware]: api/Phalcon_Acl#acl-componentaware
[acl-enum]: api/Phalcon_Acl#acl-enum
[acl-exception]: api/Phalcon_Acl#acl-exception
[acl-role]: api/Phalcon_Acl#acl-role
[acl-role]: api/Phalcon_Acl#acl-role
[acl-roleaware]: api/Phalcon_Acl#acl-roleaware
[codeception]: https://codeception.com
[whitelist]: https://en.wikipedia.org/wiki/Whitelisting
