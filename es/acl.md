<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Access Control Lists</a> <ul>
        <li>
          <a href="#setup">Creando una ACL</a>
        </li>
        <li>
          <a href="#adding-roles">Agregando Roles en ACL</a>
        </li>
        <li>
          <a href="#adding-resources">Agregando Recursos</a>
        </li>
        <li>
          <a href="#access-controls">Definición de controles de acceso</a>
        </li>
        <li>
          <a href="#querying">Consultando una ACL</a>
        </li>
        <li>
          <a href="#function-based-access">Acceso basado en una función</a>
        </li>
        <li>
          <a href="#objects">Objetos como nombre de rol y recurso</a>
        </li>
        <li>
          <a href="#roles-inheritance">Herencia de roles</a>
        </li>
        <li>
          <a href="#serialization">Serializando listas ACL</a>
        </li>
        <li>
          <a href="#events">Eventos</a>
        </li>
        <li>
          <a href="#custom-adapters">Implementando sus propios adaptadores</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Listas de control de acceso (ACL)

`Phalcon\Acl` proporciona una fácil y ligera gestión de las ACL, así como los permisos que se les asignan. [Listas de Control de Acceso](http://en.wikipedia.org/wiki/Access_control_list) (ACL) permiten a una aplicación controlar el acceso a sus áreas y a los objetos subyacentes de las solicitudes. Te recomendamos leer más sobre la metodología ACL para familiarizarse con sus conceptos.

En Resumen, las ACL tienen roles y recursos. Los recursos son objetos que cumplen con los permisos definidos por las ACL. Los Roles son objetos que solicitan acceso a recursos y se puede permitir o denegar el acceso por el mecanismo ACL.

<a name='setup'></a>

## Creando una ACL

Este componente está diseñado para trabajar inicialmente en la memoria. Esto proporciona facilidad de uso y rapidez en el acceso a todos los aspectos de la lista. El constructor de `Phalcon\Acl` toma como primer parámetro un adaptador que se utiliza para recuperar la información relacionada a la lista de control. Un ejemplo usando el adaptador de memoria es el siguiente:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

Por defecto `Phalcon\Acl` permite el acceso a la acción sobre los recursos que aún no han sido definidos. Para aumentar el nivel de seguridad de la lista de acceso podemos definir el nivel de acceso predeterminado en `deny`.

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

Un rol es un objeto que puede o no acceder a ciertos recursos en la lista de acceso. Como ejemplo, vamos a definir roles como grupos de personas en una organización. La clase `Phalcon\Acl\Role` está disponible para crear roles de una manera más estructurada. Vamos a añadir algunos roles a la lista recién creada:

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

Recursos son objetos donde se controla el acceso. Normalmente en aplicaciones MVC los recursos se refieren a los controladores. Aunque esto no es obligatorio, se puede utilizar la clase `Phalcon\Acl\Resource` en la definición de recursos. Es importante agregar acciones relacionadas u operaciones a un recurso para que la ACL pueda entender lo que debe controlar.

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

El método `allow()` señala que un determinado rol tiene permitido el acceso a un recurso determinado. El método `deny()` hace lo contrario, osea, restringe el acceso.

<a name='querying'></a>

## Consultando una ACL

Una vez que la lista ha sido completamente definida. Nosotros podemos consultar para comprobar si un rol tiene permiso o no a un recurso.

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
use Phalcon\Acl;

<?php
// Establecer el nivel de acceso a un rol en un recurso con una función personalizada
$acl->allow(
    'Invitado',
    'Clientes',
    'buscar',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Verificar que el rol tenga acceso a la operación con la función personalizada

// Devuelve true
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar'
);

// Cambiamos el funcionamiento cuando no hay parámetros a acción predeterminada
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Devuelve false
$acl->isAllowed(
    'Invitado',
    'Clientes',
    'buscar'
);
```

<a name='objects'></a>

## Objetos como nombre de rol y recurso

Puede pasar objetos como `roleName` y `resourceName`. Las clases deben implementar `Phalcon\Acl\RoleAware` para `roleName` y `Phalcon\Acl\ResourceAware` para `resourceName`.

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

También puede acceder a los objetos en su función anónima personalizada en `allow()` o `deny()`. Son automáticamente pasados como parámetros en la función.

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

Puede agregar cualquier parámetro a la función y pasar un array asociativo en el método `isAllowed()`. No importa el orden.

<a name='roles-inheritance'></a>

## Herencia de roles

Se pueden construir estructuras complejas usando la herencia que `Phalcon\Acl\Role` proporciona. Los roles pueden heredar de otros roles, permitiendo acceso a super conjuntos o subconjuntos de recursos. Para utilizar herencia de roles, debe pasar el rol hereditario como segundo parámetro al método `addRole()`, cuando agrega el rol a la lista.

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

<a name='serialization'></a>

## Serializado de listas ACL

Para mejorar el rendimiento de las instancias de `Phalcon\Acl`, estas pueden ser serializadas y almacenadas en APC, sesión, archivos de texto o una tabla de base de datos por lo que pueden ser cargados a voluntad sin tener que redefinir toda la lista. Usted puede hacer lo siguiente:

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

`Phalcon\Acl` puede enviar eventos a un `EventsManager` si está presente. Los eventos son disparados usando el tipo 'acl'. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

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

Debe implementar la interfaz `Phalcon\Acl\AdapterInterface` para crear sus propios adaptadores ACL o extender los ya existentes.