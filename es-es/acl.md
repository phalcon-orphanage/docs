---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
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

## Creating an ACL

[Phalcon\Acl](api/Phalcon_Acl) uses adapters to store and work with roles and components. The only adapter available right now is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Having the adapter use the memory, significantly increases the speed that the ACL is accessed but also comes with drawbacks. The main drawback is that memory is not persistent, so the developer will need to implement a storing strategy for the ACL data, so that the ACL is not generated at every request. This could easily lead to delays and unnecessary processing, especially if the ACL is quite big and/or stored in a database or file system.

Phalcon also offers an easy way for developers to build their own adapters by implementing the [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface.

### In action

The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

There are two self explanatory actions that the [Phalcon\Acl](api/Phalcon_Acl) provides: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

The default action is **`Phalcon\Acl::DENY`** for any [Role](api/Phalcon_Acl_Role) or [Component](api/Phalcon_Acl_Component). This is on purpose to ensure that only the developer or application allows access to specific components and not the ACL component itself.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Default action is deny access

// Change it to allow
$acl->setDefaultAction(Acl::ALLOW);
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
 * Crear algunos componentes y agregarles sus repectivas acciones a la ACL
 */
$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

/**
 * Agregar los componentes a la ACL y adjuntarlos a las acciones relacionadas
 */
$acl->addComponent($admin, ['dashboard', 'users']);
$acl->addComponent($reports, ['list', 'add']);

/**
 * Agregar componentes sin crear objectos
 */
$acl->addComponent('admin', ['dashboard', 'users']);
$acl->addComponent('reports', ['list', 'add']);
```

## Defining Access Controls

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
 * Agregar roles
 */
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


/**
 * Agregar Componentes
 */
$acl->addComponent('admin', ['dashboard', 'users', 'view']);
$acl->addComponent('reports', ['list', 'add', 'view']);
$acl->addComponent('session', ['login', 'logout']);

/**
 * Ahora atarlos juntos
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
 * Establecer el ACL
 */
$acl->addRole('manager');                   
$acl->addRole('accounting');                   
$acl->addRole('guest');                       


$acl->addComponent('admin', ['dashboard', 'users', 'view']);
$acl->addComponent('reports', ['list', 'add', 'view']);
$acl->addComponent('session', ['login', 'logout']);

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');

// ....


// true - definido explicitamente
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - definido con comodines
$acl->isAllowed('manager', 'session', 'login');

// true - definido con comodines
$acl->isAllowed('accounting', 'reports', 'view');

// false - definido explicitamente
$acl->isAllowed('guest', 'reports', 'view');

// false - nivel de acceso por defecto
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
 * Establecer el ACL
 */
$acl->addRole('manager');                   
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
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
 * Establecer el ACL
 */
$acl->addRole('manager');                   
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Retornará true
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// Retornará false
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
 * Establecer el ACL
 */
$acl->addRole('manager');                   
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Retornará false
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(Acl::ALLOW);

// Retornará true
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

// Crear nuestra clase la cual se utilizará como componentName
class ReportsComponent implements ComponentAware
{
    protected $id;

    protected $componentName;

    protected $userId;

    public function __construct($id, $componentName, $userId)
    {
        $this->id          = $id;
        $this->componentName = $componentName;
        $this->userId      = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // Función implementada desde la interfaz ComponentAware
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
 * Agregar roles
 */
$acl->addRole('manager');

/**
 * Agregar Componentes
 */
$acl->addComponent('reports', ['list', 'add', 'view']);

/**
 * Ahora unirlos todos juntos con una función personalizada. Los parámetros ManagerRole y 
 * ModelSbject son necesarios para que la función personalizada funcione
 */
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerRole $manager, ModelComponent $model) {
        return $manager->getId() === $model->getUserId();
    }
);

// Crear objectos personalizados
$levelOne = new ManagerRole(1, 'manager-1');
$levelTwo = new ManagerRole(2, 'manager');
$admin    = new ManagerRole(3, 'manager');

// id - name - userId
$reports  = new ModelComponent(2, 'reports', 2);

// Comprobar que objectos de usuarios tienen acceso
// Retorna false
$acl->isAllowed($levelOne, $reports, 'list');

// Retorna true
$acl->isAllowed($levelTwo, $reports, 'list');

// Retorna false
$acl->isAllowed($admin, $reports, 'list');
```

La segunda llamada para `$levelTwo` evalúa a `true` desde el `getUserId()` devuelve `2` que a su vez se evalúa en nuestra función personalizada. También ten en cuenta que en la función personalizada para `allow()` los objetos están automáticamente vinculados, proporcionando todos los datos necesarios para que la función personalizada funcione. La función personalizada puede aceptar cualquier número de parámetros adicionales. El orden de los parámetros definidos en el constructor de la `function()` no importa, porque los objetos serán automáticamente descubiertos y enlazados.

## Roles Inheritance

Para eliminar la duplicación y aumentar la eficiencia en su aplicación, ACL ofrece herencia en roles. Esto significa que puedes definir un [Phalcon\Acl\Role](api/Phalcon_Acl_Role) como base y después que hereden de él, ofreciendo acceso a superconjuntos o subconjuntos de componentes. Para utilizar la herencia de roles, necesita pasar el rol heredado como el segundo parámetro de la llamada del método, al añadir ese rol en la lista.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

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

    // ... Definir roles, componentes, accesos, etc

    // Almacenar la lista serializada en un archivo plano
    file_put_contents($aclFile, serialize($acl));
} else {
    // Restaurar el objecto ACL desde el archivo serializado
    $acl = unserialize(file_get_contents($aclFile));
}

// Utilice la lista ACL como desee
if (true === $acl->isAllowed('manager', 'admin', 'dashboard');) {
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