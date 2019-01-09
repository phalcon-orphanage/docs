* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Listas de control de acceso (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Listas de Control de Acceso](http://en.wikipedia.org/wiki/Access_control_list) (ACL) permiten a una aplicación controlar el acceso a sus áreas y a los objetos subyacentes de las solicitudes. Te recomendamos leer más sobre la metodología ACL para familiarizarse con sus conceptos.

En Resumen, las ACL tienen roles y recursos. Los recursos son objetos que cumplen con los permisos definidos por las ACL. Los Roles son objetos que solicitan acceso a recursos y se puede permitir o denegar el acceso por el mecanismo ACL.

<a name='setup'></a>

## Creando una ACL

Este componente está diseñado para trabajar inicialmente en la memoria. Esto proporciona facilidad de uso y rapidez en el acceso a todos los aspectos de la lista. The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list. Un ejemplo usando el adaptador de memoria es el siguiente:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

By default [Phalcon\Acl](api/Phalcon_Acl) allows access to action on resources that have not yet been defined. Para aumentar el nivel de seguridad de la lista de acceso podemos definir el nivel de acceso predeterminado en `deny`.

```php
<?php

use Phalcon\Acl;

// Por defecto denegar acceso
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Agregar roles a la ACL

Un rol es un objeto que puede o no acceder a ciertos recursos en la lista de acceso. Como ejemplo, vamos a definir roles como grupos de personas en una organización. The [Phalcon\Acl\Role](api/Phalcon_Acl_Role) class is available to create roles in a more structured way. Vamos a añadir algunos roles a la lista recién creada:

```php
<?php

use Phalcon\Acl\Role;

// Creamos algunos roles.
// El primer parámetro es el nombre, el segundo parámetro es una descripción opcional.
$roleAdmins = new Role('Administrador', 'Super Usuario');
$roleGuests = new Role('Invitado');

// Agregamos el rol 'Invitado' al ACL
$acl->addRole($roleGuests);

// Agregamos el rol 'Diseñador' sin utilizar Phalcon\Acl\Role
$acl->addRole('Diseñador');
```

Como se puede ver en la última linea, se definieron roles directamente sin utilizar una instancia, utilizando el nombre del mismo.

<a name='adding-resources'></a>

## Agregando Recursos

Recursos son objetos donde se controla el acceso. Normalmente en aplicaciones MVC los recursos se refieren a los controladores. Although this is not mandatory, the [Phalcon\Acl\Resource](api/Phalcon_Acl_Resource) class can be used in defining resources. Es importante agregar acciones relacionadas u operaciones a un recurso para que la ACL pueda entender lo que debe controlar.

```php
<?php

use Phalcon\Acl\Resource;

// Definimos el rescurso 'Clientes'
$customersResource = new Resource('Clientes');

// Agregamos un par de operaciones a los 'Clientes'

$acl->addResource(
    $customersResource,
    'buscar'
);

$acl->addResource(
    $customersResource,
    [
        'crear',
        'actualizar',
    ]
);
```

<a name='access-controls'></a>

## Definir controles de acceso

Ahora que ya tenemos roles y recursos, es hora de definir la ACL (es decir, qué roles pueden acceder a qué recursos). Esta parte es muy importante, especialmente teniendo en cuenta su nivel de acceso nivel por predeterminado `allow` o `deny`.

```php
<?php

// Seteamos el nivel de acceso para roles en recursos

$acl->allow('Invitado', 'Clientes', 'buscar');

$acl->allow('Invitado', 'Clientes', 'crear');

$acl->deny('Invitado', 'Clientes', 'actualizar');
```

The `allow()` method designates that a particular role has granted access to a particular resource. The `deny()` method does the opposite.

<a name='querying'></a>

## Consultando una ACL

Once the list has been completely defined. We can query it to check if a role has a given permission or not.

```php
<?php

// Chequeamos si un rol tiene acceso a las operaciones

// Retorna false
$acl->isAllowed('Invitado', 'Clientes', 'editar');

// Retorna true
$acl->isAllowed('Invitado', 'Clientes', 'buscar');

// Retorna true
$acl->isAllowed('Invitado', 'Clientes', 'crear');
```

<a name='function-based-access'></a>

## Acceso basado en una función

También se puede añadir como cuarto parámetro, una función anónima, que debe devolver un valor booleano. Se llamará cuando se utilice el método `isAllowed()`. Puede pasar parámetros como un array asociativo al método `isAllowed()` en el cuarto argumento, donde las claves del array serán el utilizadas como nombre del parámetro de la función anónima definida. Veamos un ejemplo:

```php
<?php
// Damos acceso a un rol en un recurso con una función anónima 
$acl->allow(
    'Invitado',
    'Clientes',
    'buscar',
    function ($a) {
        return $a % 2 === 0; // $a tiene que ser un número par
    }
);

// Chequeamos si el rol tiene acceso a la operación

// Retorna true
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar',
    [
        'a' => 4,
    ]
);

// Retorna false
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar',
    [
        'a' => 3,
    ]
);
```

Además si usted no proporciona ningún parámetro en el método de `isAllowed()` entonces el comportamiento por defecto será `Acl::ALLOW`. Puede cambiarlo utilizando el método `setNoArgumentsDefaultAction()`.

```php
<?php

use Phalcon\Acl;

// Configurar nivel de acceso para roles en recursos con funciones
$acl->allow(
    'Invitado',
    'Clientes',
    'buscar',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Chequear si el rol tiene acceso a la operación con una función

// Retorna true
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar'
);

// Cambiar el comportamiento de noArgumentsDefaultAction
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Retorna false
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar'
);
```

<a name='objects'></a>

## Objetos como nombre de rol y recurso

Puede pasar objetos como `roleName` y `resourceName`. Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

Nuestra clase `UserRole`

```php
<?php

use Phalcon\Acl\RoleAware;

// Crear nuestra clase que se utilizará como roleName
class UserRole implements RoleAware
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

Y nuestra clase `ModelResource`

```php
<?php

use Phalcon\Acl\ResourceAware;

// Crear nuestra clase que será utilizada como resourceName
class ModelResource implements ResourceAware
{
    protected $id;

    protected $resourceName;

    protected $userId;

    public function __construct($id, $resourceName, $userId)
    {
        $this->id           = $id;
        $this->resourceName = $resourceName;
        $this->userId       = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // Implementamos la función desde ResourceAware Interface
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
```

Luego puede utilizarlos en el método `isAllowed()`.

```php
<?php

use UserRole;
use ModelResource;

// Confirguramos la lista de acceso 
$acl->allow('Invitado', 'Clientes', 'buscar');
$acl->allow('Invitado', 'Clientes', 'crear');
$acl->deny('Invitado', 'Clientes', 'actualizar');

// Creamos nuestros objectos proveyendo roleName y resourceName

$customer = new ModelResource(
    1,
    'Clientes',
    2
);

$designer = new UserRole(
    1,
    'Diseñador'
);

$guest = new UserRole(
    2,
    'Invitado'
);

$anotherGuest = new UserRole(
    3,
    'Invitado'
);

// Chequeamos si nuestro objecto usuario tiene acceso a la operación en el objecto modelo

// Retorna false
$acl->isAllowed(
    $designer,
    $customer,
    'buscar'
);

// Retorna true
$acl->isAllowed(
    $guest,
    $customer,
    'buscar'
);

// Retorna true
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'buscar'
);
```

Also you can access those objects in your custom function in `allow()` or `deny()`. They are automatically bind to parameters by type in function.

```php
<?php

use UserRole;
use ModelResource;

// Configuramos la lista para el rol y la función
$acl->allow(
    'Invitado',
    'Clientes',
    'buscar',
    function (UserRole $user, ModelResource $model) { // Las clases User y Model son necesarias
        return $user->getId == $model->getUserId();
    }
);

$acl->allow(
    'Invitado',
    'Clientes',
    'crear'
);

$acl->deny(
    'Invitado',
    'Clientes',
    'actualizar'
);

// Creamos nuestros objectos proveyendo roleName y resourceName

$customer = new ModelResource(
    1,
    'Clientes',
    2
);

$designer = new UserRole(
    1,
    'Diseñador'
);

$guest = new UserRole(
    2,
    'Invitado'
);

$anotherGuest = new UserRole(
    3,
    'Invitado'
);

// Chequeamos si nuestro objecto usuario tiene acceso a la operación en el modelo

// Retorna false
$acl->isAllowed(
    $designer,
    $customer,
    'buscar'
);

// Retorna true
$acl->isAllowed(
    $guest,
    $customer,
    'buscar'
);

// Retorna false
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'buscar'
);
```

You can still add any custom parameters to function and pass associative array in `isAllowed()` method. Also order doesn't matter.

<a name='roles-inheritance'></a>

## Herencia de roles

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. Los roles pueden heredar de otros roles, permitiendo acceso a super conjuntos o subconjuntos de recursos. Para utilizar herencia de roles, debe pasar el rol hereditario como segundo parámetro al método `addRole()`, cuando agrega el rol a la lista.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Creamos algunos roles

$roleAdmins = new Role('Administrador', 'Super usuario');

$roleGuests = new Role('Invitado');

// Agregamos el rol 'Invitado' al ACL
$acl->addRole($roleGuests);

// Agregamos el rol 'Administrador' heredando los accesos del rol 'Invitado'
$acl->addRole($roleAdmins, $roleGuests);
```

### Configurar relaciones después que se agregan los roles

O puede preferir agregar todos sus roles juntos y luego definir las relaciones de herencia.

```php
// Creamos algunos roles
$roleAdmins = new Role('Administrador', 'Super usuario');
$roleGuests = new Role('Invitado');

// Agregamos los roles al ACL
$acl->addRole($roleAdmins);
$acl->addRole($roleGuests);

// Agregamos el rol 'Administrador' heredando los accesos del rol 'Invitado'
$acl->addRole($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## Serializado de listas ACL

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. Usted puede hacer lo siguiente:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// Chequeamos si los datos del ACL ya existen
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Definimos roles, recursos, accesos, etc.

    // Almacenamos la lista serializada en un archivo
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Restauramos el objecto ACL desde el archivo serializado
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// Utilice la lista ACL como desee
if ($acl->isAllowed('Invitado', 'Clientes', 'editar')) {
    echo 'Accesos obtenidos!';
} else {
    echo 'Accesos denegados :(';
}
```

Es recomendable utilizar el adaptador de memoria durante el desarrollo y uno de los otros adaptadores disponibles en producción.

<a name='events'></a>

## Eventos

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. Los eventos son disparados usando el tipo 'acl'. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento  | Disparado                                                      | ¿Detiene la operación? |
| ----------------- | -------------------------------------------------------------- |:----------------------:|
| beforeCheckAccess | Lanzado antes de comprobar si un rol o recurso tiene acceso    |           Si           |
| afterCheckAccess  | Lanzado después de comprobar si un rol o recursos tiene acceso |           No           |

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Crear un gestor de eventos
$eventsManager = new EventsManager();

// Adjuntar un listener para el tipo 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole();

        echo $acl->getActiveResource();

        echo $acl->getActiveAccess();
    }
);

$acl = new AclList();

// Configuramos el $acl
// ...

// Unimos el eventsManager con el ACL 
$acl->setEventsManager($eventsManager);
```

<a name='custom-adapters'></a>

## Implementando sus propios adaptadores

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.