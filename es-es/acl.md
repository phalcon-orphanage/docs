---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#acl'
title: 'Listas de control de acceso (ACL)'
keywords: 'acl, lista de control de acceso, permisos'
---

# Listas de control de acceso (ACL)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Acl](api/Phalcon_Acl) proporciona una gestión fácil y ligera de las ACLs así como de los permisos adjuntos a ellas. Las [Listas de Control de Acceso](https://en.wikipedia.org/wiki/Access_control_list) (ACL en inglés) permite a una aplicación controlar el acceso de las solicitudes a sus áreas y objetos subyacentes.

En resumen, ACLs tienen dos objetos: El objeto que necesita acceso, y el objeto al que necesitamos acceder. En el mundo de la programación, se denominan normalmente Roles y Componentes. En el mundo Phalcon, usamos la terminología [Rol](api/Phalcon_Acl#acl-role) y [Componente](api/Phalcon_Acl#acl-component).

> **Caso de Uso**
> 
> Una aplicación contable necesita tener diferentes grupos de usuarios que tengan acceso a varias áreas de la aplicación.
> 
> **Rol** - Acceso al Administrador - Acceso al Departamento de Contabilidad - Acceso al Administrador - Acceso al Invitado
> 
> **Componente** - Página de inicio de sesión - Página de administración - Página de facturas - Página de informes
{:.alert .alert-info}

Como se ha visto en el caso de uso anterior, un [Rol](api/Phalcon_Acl#acl-role) se define como quién necesita acceder a un [Componente](api/Phalcon_Acl#acl-component) particular, es decir un área de la aplicación. Un [Componente](api/Phalcon_Acl#acl-component) se define como el área de la aplicación a la que se necesita acceder.

Usando el componente [Phalcon\Acl](api/Phalcon_Acl), podemos vincular ambos, y reforzar la seguridad de nuestra aplicación, permitiendo sólo roles específicos estén vinculados a componentes específicos.

## Activación

[Phalcon\Acl](api/Phalcon_Acl) usa adaptadores para almacenar y trabajar con roles y componentes. El único adaptador disponible por ahora es [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl#acl-adapter-memory). Si el adaptador usa la memoria, incrementa significativamente la velocidad en la que se accede a la ACL pero también presenta inconvenientes. El principal inconveniente es que la memoria no es persistente, con lo que el desarrollador necesita implementar una estrategia de almacenamiento de los datos de la ACL, para que no se genere la ACL en cada petición. Esto fácilmente puede suponer retrasos y procesamiento innecesario, especialmente si la ACL es bastante grande y/o se almacena en una base de datos o sistema de ficheros.

El constructor [Phalcon\Acl](api/Phalcon_Acl) toma como primer parámetro un adaptador usado para obtener la información relativa a la lista de control.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();
```

La acción por defecto es **`Phalcon\Acl\Enum::DENY`** para cualquier [Rol](api/Phalcon_Acl#acl-role) o [Componente](api/Phalcon_Acl#acl-component). Esto tiene como propósito asegurar que sólo el desarrollador o la aplicación permiten el acceso a componentes específicos y no el propio componente ACL.

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->setDefaultAction(Enum::ALLOW);
```

## Constantes

La clase [Phalcon\Acl\Enum](api/Phalcon_Acl#acl-enum) ofrece dos constantes que se pueden usar cuando se definen niveles de acceso.

* `Phalcon\Acl\Enum::ALLOW` (`1`)
* `Phalcon\Acl\Enum::DENY` (`0` - predeterminado)

Puede usar estas constantes para definir los niveles de acceso para su ACL.

## Añadir Roles

Como se ha mencionado anteriormente, un [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) es un objeto que puede o no acceder a un conjunto de [Componentes](api/Phalcon_Acl#acl-component) en la lista de acceso.

Hay dos maneras de añadir roles a nuestra lista. * usando un objeto [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) o * usando una cadena, que representa el nombre del rol

Para ver esto en acción, usando el ejemplo descrito arriba, añadiremos los objetos [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) relevantes a nuestra lista.

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

Un [Componente](api/Phalcon_Acl#acl-component) es el área de la aplicación donde se controla el acceso. En una aplicación MVC, esto podría ser un Controlador. Aunque no es obligatorio, la clase [Phalcon\Acl\Component](api/Phalcon_Acl#acl-component) se podría usar para definir los componentes de la aplicación. También es importante añadir acciones relativas a un componente para que la ACL pueda comprender qué debería controlar.

Hay dos maneras de añadir componentes a nuestra lista. * usando un objeto [Phalcon\Acl\Component](api/Phalcon_Acl#acl-component) o * usando una cadena, que representa el nombre del componente

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

Después de definir los `Roles` y `Componentes`, necesitamos unirlos para poder crear la lista de acceso. Este es el paso más importante en la operación, ya que un pequeño error aquí puede permitir el acceso de los roles a componentes a los que el desarrollador no tenía intención de hacerlo. Como ya se ha mencionado anteriormente, la acción de acceso predeterminada para [Phalcon\Acl](api/Phalcon_Acl) es `Phalcon\Acl\Enum::DENY`, siguiendo el enfoque de [lista blanca](https://es.wikipedia.org/wiki/Lista_blanca).

Para unir `Roles` y `Componentes` usamos los métodos `allow()` y `deny()` expuestos por la clase [Phalcon\Acl\Memory](api/Phalcon_Acl#acl-adapter-memory).

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Add the roles
 */
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


/**
 * Add the Components
 */

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

/**
 * Now tie them all together 
 */
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

> **NOTA**: Por favor hay que ser **MUY** cuidadoso al usar el comodín `*`. Es muy fácil cometer un error y el comodín, aunque parezca conveniente, puede permitir a los usuarios acceder a áreas de su aplicación a las que no debería. La mejor manera de estar 100% seguro es escribir pruebas específicamente para probar los permisos y la ACL. Estos se pueden hacer en el conjunto de pruebas `unit` instanciando el componente y luego comprobando si `isAllowed()` es `true` o `false`.
> 
> [Codeception](https://codeception.com) es el framework de pruebas elegido por Phalcon, hay muchas pruebas en nuestro repositorio GitHub (carpeta `tests`) para ofrecer orientación e ideas.
{:.alert .alert-danger}

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

/**
 * Setup the ACL
 */
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

// ....



// true - defined explicitly
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - defined with wildcard
$acl->isAllowed('manager', 'session', 'login');

// true - defined with wildcard
$acl->isAllowed('accounting', 'reports', 'view');

// false - defined explicitly
$acl->isAllowed('guest', 'reports', 'view');

// false - default access level
$acl->isAllowed('guest', 'reports', 'add');
```

## Acceso Basado en Función

Dependiendo de las necesidades de su aplicación, podría necesitar otra capa de cálculos para permitir o denegar el acceso a los usuarios mediante la ACL. El método `isAllowed()` acepta un cuarto parámetro que es un `callable` como una función anónima.

Para aprovechar esta funcionalidad, necesita definir su función cuando llama el método `allow()` para el rol y componente que necesita. Supongamos que necesitamos permitir el acceso a todos los roles `manager` al componente `admin` excepto si su nombre es 'Bob' (¡Pobre Bob!). Para conseguir esto registraremos una función anónima que compruebe esta condición.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

Ahora que el *callable* está definido en la ACL, necesitaremos llamar al método `isAllowed()` con un vector como cuarto parámetro:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns true
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// Returns false
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> **NOTA**: El cuarto parámetro debe ser un vector. Cada elemento del vector representa un parámetro que acepta su función anónima. La clave del elemento es el nombre del parámetro, mientras que el valor es el que se pasará como valor del parámetro a la función.
{:.alert .alert-info}

También puede omitir el paso del cuarto parámetro a `isAllowed()` si lo desea. El valor por defecto para una llamada a `isAllowed()` sin el último parámetro es `Acl\Enum::DENY`. Para cambiar este comportamiento, puede hacer una llamada a `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns false
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(
    Enum::ALLOW
);

// Returns true
$acl->isAllowed('manager', 'admin', 'dashboard');
```

## Objetos Personalizados

Phalcon permite a los desarrolladores definir sus propios objetos rol y componente. Estos objetos deben implementar las interfaces facilitadas:

* [Phalcon\Acl\RoleAware](api/Phalcon_Acl#acl-roleaware) para Rol
* [Phalcon\Acl\ComponentAware](api/Phalcon_Acl#acl-componentaware) para Componente

### Rol

Podemos implementar [Phalcon\Acl\RoleAware](api/Phalcon_Acl#acl-roleaware) en nuestra clase personalizada con su propia lógica. El siguiente ejemplo muestra un nuevo objeto rol llamado `ManagerRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// Create our class which will be used as roleName
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

    // Implemented function from RoleAware Interface
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

### Componente

Podemos implementar [Phalcon\Acl\ComponentAware](api/Phalcon_Acl#acl-componentaware) en nuestra clase personalizada con su propia lógica. El siguiente ejemplo muestra un nuevo objeto componente llamado `ReportsComponent`:

```php
<?php

use Phalcon\Acl\ComponentAware;

// Create our class which will be used as componentName
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

    // Implemented function from ComponentAware Interface
    public function getComponentName()
    {
        return $this->componentName;
    }
}
```

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

/**
 * Add the roles
 */
$acl->addRole('manager');

/**
 * Add the Components
 */
$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

/**
 * Now tie them all together with a custom function. The ManagerRole and
 * ModelSbject parameters are necessary for the custom function to work 
 */
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerRole $manager, ModelComponent $model) {
        return boolval($manager->getId() === $model->getUserId());
    }
);

// Create the custom objects
$levelOne = new ManagerRole(1, 'manager-1');
$levelTwo = new ManagerRole(2, 'manager');
$admin    = new ManagerRole(3, 'manager');

// id - name - userId
$reports  = new ModelComponent(2, 'reports', 2);

// Check whether our user objects have access 
// Returns false
$acl->isAllowed($levelOne, $reports, 'list');

// Returns true
$acl->isAllowed($levelTwo, $reports, 'list');

// Returns false
$acl->isAllowed($admin, $reports, 'list');
```

La segunda llamada de `$levelTwo` evalúa `true` ya que `getUserId()` devuelve `2` que a su vez es evaluado en nuestra función personalizada. También tenga en cuenta que en la función personalizada `allow()` los objetos son automáticamente vinculados, proporcionando todos los datos necesarios para que la función personalizada funcione. La función personalizada puede aceptar cualquier número de parámetros adicionales. El orden de los parámetros definidos en el constructor `function()` no importa, porque los objetos serán descubiertos y vinculados automáticamente.

## Herencia de Roles

Para eliminar la duplicación y aumentar la eficiencia en su aplicación, la ACL ofrece herencia de roles. Esto significa que puede definir un [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) como base y después heredar de él ofreciendo acceso a superconjuntos o subconjuntos de componentes. Para utilizar la herencia de roles, necesita pasar el rol heredado como el segundo parámetro de la llamada del método, al añadir ese rol en la lista.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

/**
 * Create the roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Add the `guest` role to the ACL 
 */
$acl->addRole($guest);

/**
 * Add the `accounting` inheriting from `guest` 
 */
$acl->addRole($accounting, $guest);

/**
 * Add the `manager` inheriting from `accounting` 
 */
$acl->addRole($manager, $accounting);
```

Sea cual sea el acceso que tenga `guests`, se propagará a `accounting` y a su vez `accounting` se propagará a `manager`. También puede pasar un vector de roles como segundo parámetro de `addRole` ofreciendo más flexibilidad.

## Relaciones de Roles

Basado en el diseño de aplicación, podría preferir añadir primero todos los roles y después definir la relación entre ellos.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

/**
 * Create the roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Add all the roles
 */
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

/**
 * Add the inheritance 
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```

## Serialización

[Phalcon\Acl](api/Phalcon_Acl) se puede serializar y almacenar en un sistema de caché para mejorar la eficiencia. Puede almacenar el objeto serializado en APC, sesión, sistema de ficheros, base de datos, Redis, etc. De esta manera puede recuperar la ACL rápidamente sin tener que leer los datos subyacentes que crea la ACL, ni tendrá que calcular la ACL en cada petición.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$aclFile = 'app/security/acl.cache';
// Check whether ACL data already exist
if (true !== is_file($aclFile)) {

    // The ACL does not exist - build it
    $acl = new Memory();

    // ... Define roles, components, access, etc

    // Store serialized list into plain file
    file_put_contents(
        $aclFile,
        serialize($acl)
    );
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(
        file_get_contents($aclFile)
    );
}

// Use ACL list as needed
if (true === $acl->isAllowed('manager', 'admin', 'dashboard')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

Es una buena práctica no usar serialización de la ACL durante el desarrollo, para asegurarse que su ACL se reconstruye en cada petición, mientras que se usan otros adaptadores o medios de serializado y almacenamiento para la ACL en producción.

## Eventos

[Phalcon\Acl](api/Phalcon_Acl) puede trabajar junto con el [EventsManager](events) si está presente, para disparar eventos a tu aplicación. Los eventos se disparan usando el tipo `acl`. Los eventos que devuelven `false` pueden detener el rol activo. Los siguientes eventos están disponibles:

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

// Create an event manager
$eventsManager = new Manager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new Memory();

// Setup the $acl
// ...

// Bind the eventsManager to the ACL component
$acl->setEventsManager($eventsManager);
```

## Excepciones

Cualquier excepción lanzada en el espacio de nombres `Phalcon\Acl` será de tipo [Phalcon\Acl\Exception](api/Phalcon_Acl#acl-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

Para poder crear sus propios adaptadores o extender los existentes debe implementar la interfaz [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl#acl-adapter-adapterinterface).
