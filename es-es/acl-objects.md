---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

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