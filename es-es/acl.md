---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#acl'
title: 'Listas de control de acceso (ACL)'
---

# Listas de Control de Acceso (ACL)

* * *

## Listas de control de acceso (ACL)

[Phalcon\Acl](api/Phalcon_Acl) proporciona una fácil y ligera gestión de las ACL, así como los permisos que se les asignan. [Listas de Control de Acceso](https://en.wikipedia.org/wiki/Access_control_list) (ACL) permiten a una aplicación controlar el acceso a sus áreas y a los objetos subyacentes de las solicitudes.

En resumen, las ACL tienen dos objetos: El objeto que necesita acceso, y el objeto al que necesitamos acceder. En el mundo de la programación, estos se denominan habitualmente Roles y Componentes. En el mundo de Phalcon, usamos la terminología [Rol](api/Phalcon_Acl_Role) y [Componente](api/Phalcon_Acl_Component).

> **Caso de Uso**
> 
> Una aplicación contable necesita tener diferentes grupos de usuarios que tengan acceso a varias áreas de la aplicación.
> 
> **Rol** - Acceso al Administrador - Acceso al Departamento de Contabilidad - Acceso al Gestor - Acceso al Invitado
> 
> **Componente** - Página de inicio de sesión - Página de administración - Página de facturas - Página de reportes
{:.alert .alert-info}

Como se ha visto arriba en el caso de uso, un [Role](api/Phalcon_Acl_Role) se define como quién necesita acceder a un [Component](api/Phalcon_Acl_Component) en particular, es decir, un área de la aplicación. Un [Component](api/Phalcon_Acl_Component) se define como el área de la aplicación que necesita ser accedida.

Usando el componente [Phalcon\Acl](api/Phalcon_Acl), podemos atar estos dos juntos, y fortalecer la seguridad de nuestra aplicación, permitiendo que sólo los roles específicos estén vinculados a componentes específicos.

## Creando una ACL

[Phalcon\Acl](api/Phalcon_Acl) utiliza adaptadores para almacenar y trabajar con roles y componentes. El único adaptador disponible ahora es [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Si el adaptador utiliza la memoria, aumenta significativamente la velocidad a la que se accede a la ACL, pero también presenta inconvenientes. El principal inconveniente es que la memoria no es persistente, por lo que el desarrollador tendrá que implementar una estrategia de almacenamiento de datos ACL, para que no se genere la ACL en cada petición. Esto fácilmente puede llevar a retrasos y procesamientos innecesario, especialmente si la ACL es bastante grande o esta almacenada en un sistema de base de datos o archivo.

Phalcon también ofrece una manera fácil a los desarrolladores para construir sus propios adaptadores, mediante la implementación de la interfaz [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface).

### En acción

El constructor de [Phalcon\Acl](api/Phalcon_Acl) toma como primer parámetro un adaptador que se utiliza para recuperar la información relacionada a la lista de control.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

Hay dos acciones autoexplicativas que proporciona [Phalcon\Acl](api/Phalcon_Acl): - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

La acción predeterminada es **`Phalcon\Acl::DENY`** para todos los [Role](api/Phalcon_Acl_Role) o [Component](api/Phalcon_Acl_Component). Esto tiene como propósito asegurar que sólo el desarrollador o la aplicación permiten el acceso a componentes específicos y no el propio componente ACL.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Default action is deny access

// Change it to allow
$acl->setDefaultAction(
    Acl::ALLOW
);
```

## Agregando Roles

Como se ha mencionado anteriormente, un [Phalcon\Acl\Role](api/Phalcon_Acl_Role) es un objeto que puede o no puede acceder a un conjunto de [Component](api/Phalcon_Acl_Component) en la lista de acceso.

Hay dos maneras de agregar roles a nuestra lista. * Usando un objecto [Phalcon\Acl\Role](api/Phalcon_Acl_Role) * Usando una cadena, representando el nombre del rol

Para ver esto en acción, usando el ejemplo descrito arriba, añadiremos los objetos [Phalcon\Acl\Role](api/Phalcon_Acl_Role) relevantes en nuestra lista:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Crear algunos Roles.
 * 
 * El primer parámetro es el nombre del rol, 
 * el segundo, es opcional, es la descripción
 */

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleAccounting = new Role('accounting', 'Accounting Department Access'); 

/**
 * Agregar esos roles a la lista
 */
$acl->addRole($roleAdmins);
$acl->addRole($roleAccounting);

/**
 * Agregar roles sin crear un objecto
 */
$acl->addRole('manager');
$acl->addRole('guest');
```

## Agregando Componentes

Un [Component](api/Phalcon_Acl_Component) es el área de la aplicación donde se controla el acceso. En una aplicación MVC, esto sería un controlador. Aunque no es obligatorio, la clase [Phalcon\Acl\Component](api/Phalcon_Acl_Component) puede utilizarse para definir componentes en la aplicación. También es importante añadir acciones relacionadas a un componente para que la ACL pueda entender lo que debe controlar.

Hay dos maneras de agregar componentes a nuestra lista. * Usando un objecto [Phalcon\Acl\Component](api/Phalcon_Acl_Component) * Usando una cadena, representando el nombre del rol

Similar a la `addRole`, `addComponent` requiere un nombre para el tema y una descripción opcional.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Create some Components and add their respective actions in the ACL
 */
$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

/**
 * Add the components to the ACL and attach them to relevant actions 
 */

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

/**
 * Add components without creating an object first 
 */

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

Después que los `Roles` y los `Components` fueron definidos, tenemos que atarlos juntos para que la lista de acceso pueda ser creada. Este es el paso más importante en el rol, ya que un pequeño error aquí, puede permitir el acceso de roles a componentes a los que el desarrollador no pretende. Como se mencionó anteriormente, la acción de acceso predeterminada para [Phalcon\Acl](api/Phalcon_Acl) es `Acl::DENY`, siguiendo el enfoque de [lista blanca](https://en.wikipedia.org/wiki/Whitelisting).

Para atar `Roles` y `Components` juntos, utilizamos los métodos `allow()` y `deny()` expuestos por la clase [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory).

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

Las líneas anteriores nos dicen:

```php
$acl->allow('manager', 'admin', 'users');
```

Para el rol `manager`, permitir el acceso al componente `admin` y la acción `users`. Para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `admin` y a la acción `users`.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

También puede pasar una matriz como parámetro `action` al invocar el comando `allow()`. Lo anterior significa, para el rol `manager`, permitir el acceso al componente `reports` y a las acciones `list` y `add`. Una vez más para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `reports` y a las acciones `list` y `add`.

```php
$acl->allow('*', 'session', '*');
```

Las comodines también se pueden utilizar para hacer coincidencias en masa para roles, componentes o acciones. En el ejemplo anterior, permitimos que todos los roles accedan a todas las acciones del componente `session`. Este comando dará acceso a los roles `manager`, `accounting` y `guest`, accediendo al componente `session` y a las acciones `login` y `logout`.

```php
$acl->allow('*', '*', 'view');
```

Del mismo modo, lo anterior da acceso a cualquier rol o a cualquier componente que tenga la acción `view`. En una aplicación MVC, lo anterior es el equivalente a permitir que cualquier grupo acceda a cualquier controlador que exponga una `viewAction`.

> Por favor, tenga **MUCHO** cuidado al usar el comodín `*`. Es muy fácil cometer un error y el comodín, aunque parece conveniente, puede permitir que los usuarios accedan a áreas de su aplicación que no se supone que lo hagan. La mejor manera de estar 100% seguro es escribir pruebas específicamente para probar los permisos y la ACL. Estos pueden hacerse en la `unit` de las pruebas instanciando el componente y luego comprobando el `isAllowed()` si es `true` o `false`.
> 
> [Codeception](https://codeception.com) es el framework de pruebas elegido por Phalcon, hay muchas pruebas en nuestro repositorio GitHub (carpeta `tests`) para ofrecer orientación e ideas.
{:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

Para el rol `guest`, negamos el acceso a todos los componentes con la acción `view`. A pesar del hecho de que el nivel de acceso por defecto es `Acl::DENY` en nuestro ejemplo anterior, hemos permitido específicamente la acción `view` a todos los roles y componentes. Esto incluye al rol `guest`. Queremos permitir el acceso del rol `guest` solo al componente `session` y a las acciones `login` y `logout`, ya que los `guests` no están logeados en nuestra aplicación.

```php
$acl->allow('*', '*', 'view');
```

Esto da acceso al acceso `view` a todo el mundo, pero queremos que el rol `guest` debe ser excluido de ahí, entonces lo que necesitamos es la siguiente linea.

```php
$acl->deny('guest', '*', 'view');
```

## Consultando una ACL

Una vez definida la lista, podemos consultarla para comprobar si un rol, en particular, tiene acceso a un componente y una acción. Para hacerlo, necesitamos usar el método `isAllowed()`.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

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

## Acceso basado en una función

Dependiendo de las necesidades de su aplicación, podría necesitar otra capa de cálculos para permitir o no el acceso a los usuarios a través de la ACL. El método `isAllowed()` acepta un cuarto parámetro que es un callable como una función anónima.

Para aprovechar esta funcionalidad, necesitará definir su función al llamar el método `allow()` para el rol y componente que necesita. Supongamos que necesitamos permitir el acceso a todos los roles `manager` al componente `admin` excepto si su nombre es 'Bob' (¡Pobre Bob!). Para lograrlo, registraremos una función anónima que verificará esta condición.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

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

Ahora que el callable esta definido en la ACL, necesitaremos llamar al método `isAllowed()` con un array como cuarto parámetro:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

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

> El cuarto parámetro debe ser un array. Cada elemento del array representa un parámetro que su función anónima aceptará. La clave del elemento es el nombre del parámetro, mientras que el valor es lo que se pasará como valor de ese parámetro en la función.
{:.alert .alert-info}

También puede omitir pasar el cuarto parámetro a `isAllowed()` si lo desea. La acción por defecto para una llamada a `isAllowed()` sin el último parámetro es `Acl::DENY`. Para cambiar este comportamiento, puede hacer una llamada a `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

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
    Acl::ALLOW
);

// Returns true
$acl->isAllowed('manager', 'admin', 'dashboard');
```

## Objetos como nombre de rol y nombre de componente

Phalcon permite a los desarrolladores definir sus propios objetos de rol y componente. Estos objetos deben implementar las interfaces suministradas:

* [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) para Rol
* [Phalcon\Acl\ComponentAware](api/Phalcon_Acl_ComponentAware) para Componente

### Rol

Podemos implementar el [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) en nuestra clase personalizada con su propia lógica. El ejemplo siguiente muestra un nuevo objeto de rol llamado `ManagerRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// Crear nuestra clase que se utilizará como roleName
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

    // Implementamos esta función desde RoleAware Interface
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

### Componente

Podemos implementar el [Phalcon\Acl\ComponentAware](api/Phalcon_Acl_ComponentAware) en nuestra clase personalizada con su propia lógica. El ejemplo siguiente muestra un nuevo objeto de rol llamado `ReportsComponent`:

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

Estos objetos pueden ser utilizados ahora en nuestra ACL.

```php
<?php

use ManagerRole;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use ReportsComponent;

$acl = new AclList();

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

La segunda llamada para `$levelTwo` evalúa a `true` desde el `getUserId()` devuelve `2` que a su vez se evalúa en nuestra función personalizada. También ten en cuenta que en la función personalizada para `allow()` los objetos están automáticamente vinculados, proporcionando todos los datos necesarios para que la función personalizada funcione. La función personalizada puede aceptar cualquier número de parámetros adicionales. El orden de los parámetros definidos en el constructor de la `function()` no importa, porque los objetos serán automáticamente descubiertos y enlazados.

## Herencia de roles

Para eliminar la duplicación y aumentar la eficiencia en su aplicación, ACL ofrece herencia en roles. Esto significa que puedes definir un [Phalcon\Acl\Role](api/Phalcon_Acl_Role) como base y después que hereden de él, ofreciendo acceso a superconjuntos o subconjuntos de componentes. Para utilizar la herencia de roles, necesita pasar el rol heredado como el segundo parámetro de la llamada del método, al añadir ese rol en la lista.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Crear los roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Agregar el rol `guest` al ACL 
 */
$acl->addRole($guest);

/**
 * Agregar `accounting` heredando desde `guest` 
 */
$acl->addRole($accounting, $guest);

/**
 * Agregar `manager` heredando de `accounting` 
 */
$acl->addRole($manager, $accounting);
```

Sea cual sea el acceso que tenga `guests`, se propagará a `acoounting` y a su vez `accounting` se propagará a `manager`

### Configurar relaciones después que se agregan los roles

Basado en el diseño de aplicaciones, podría preferir añadir primero todos los roles y luego definir la relación entre ellos.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Crear los roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Agregar todos los roles
 */
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

/**
 * Agregar las herencias
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```

## Serializando listas ACL

[Phalcon\Acl](api/Phalcon_Acl) puede ser serializado y almacenado en un sistema de caché para mejorar la eficiencia. Puede almacenar el objeto serializado en APC, sesión, sistema de archivos, base de datos, Redis, etc. De esta manera puede recuperar la ACL rápidamente sin tener que leer los datos subyacentes que crean la ACL ni tendrá que calcular la ACL en cada petición.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$aclFile = 'app/security/acl.cache';
// Comprobar si los datos de la ACL ya existen
if (true !== is_file($aclFile)) {

    // La ACL no existe, crearla
    $acl = new AclList();

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

Es una buena práctica no utilizar serialización de la ACL durante el desarrollo, para garantizar que su ACL se construya en cada petición, mientras que otros adaptadores o medios de serialización y almacenamiento de la ACL se pueden utilizar en producción.

## Eventos

[Phalcon\Acl](api/Phalcon_Acl) puede trabajar junto con el [EventsManager](events) si está presente, para disparar eventos a tu aplicación. Los eventos se desencadenan mediante el tipo `acl`. Los eventos que devuelven `false` pueden detener el rol activo. Los siguientes eventos están disponibles:

| Nombre de evento    | Disparado                                                        | ¿Puede detener el rol? |
| ------------------- | ---------------------------------------------------------------- |:----------------------:|
| `afterCheckAccess`  | Lanzado después de comprobar si un rol o componente tiene acceso |           No           |
| `beforeCheckAccess` | Lanzado antes de comprobar si un rol o componente tiene acceso   |           Si           |

En el ejemplo siguiente se muestra cómo adjuntar oyentes al ACL:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Crear un gestor de eventos
$eventsManager = new EventsManager();

// Adjuntar un oyente de tipo 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRol() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new AclList();

// Configurar el $acl
// ...

// Vincular el eventsManager al componente ACL
$acl->setEventsManager($eventsManager);
```

## Implementando sus propios adaptadores

Debe implementar la interfaz [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) para crear sus propios adaptadores ACL o extender los ya existentes.