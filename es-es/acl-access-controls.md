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

Después que las `Operations` y los `Subjects` fueron definidos, tenemos que atarlos juntos para que la lista de acceso pueda ser creada. Este es el paso más importante en la operación, ya que un pequeño error aquí puede permitir el acceso a operaciones para asuntos a los que el desarrollador no tiene intención de hacerlo. Como se mencionó anteriormente, la acción de acceso predeterminada para [Phalcon\Acl](api/Phalcon_Acl) es `Acl::DENY`, siguiendo el enfoque de [lista blanca](https://en.wikipedia.org/wiki/Whitelisting).

Para atar `Operations` y `Subjects` juntos usamos los métodos `allow()` y `deny()` expuestos por la clase [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory).

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Agregar las operaciones
 */
$acl->addOperation('manager');
$acl->addOperation('accounting');
$acl->addOperation('guest');


/**
 * Agregar los asuntos
 */
$acl->addSubject('admin', ['dashboard', 'users', 'view']);
$acl->addSubject('reports', ['list', 'add', 'view']);
$acl->addSubject('session', ['login', 'logout']);

/**
 * Ahora los unimos
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

Para la operación `manager`, permitir el acceso al asunto `admin` y la acción `users`. Para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `admin` y a la acción `users`.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

También puede pasar una matriz como parámetro `action` al invocar el comando `allow()`. Lo anterior significa, para la operación `manager`, permitir el acceso al asunto `reports` y a las acciones `list` y `add`. Una vez más para poner esto en perspectiva con una aplicación MVC, la línea anterior dice que el grupo `manager` tiene permitido acceder al controlador `reports` y a las acciones `list` y `add`.

```php
$acl->allow('*', 'session', '*');
```

Las comodines también se pueden utilizar para hacer coincidencias en masa para operaciones, asuntos o acciones. En el ejemplo anterior, permitimos que todas las operaciones accedan a todas las acciones del asunto `session`. Este comando dará acceso a las operaciones `manager`, `accounting` y `guest`, accediendo al asunto `session` y a las acciones `login` y `logout`.

```php
$acl->allow('*', '*', 'view');
```

Del mismo modo, lo anterior da acceso a cualquier operación, cualquier asunto que tenga la acción `view`. En una aplicación MVC, lo anterior es el equivalente a permitir que cualquier grupo acceda a cualquier controlador que exponga una `viewAction`.

> Por favor, tenga **MUCHO** cuidado al usar el comodín `*`. Es muy fácil cometer un error y el comodín, aunque parece conveniente, puede permitir que los usuarios accedan a áreas de su aplicación que no se supone que lo hagan. La mejor manera de estar 100% seguro es escribir pruebas específicamente para probar los permisos y la ACL. Estos pueden hacerse en la `unit` de las pruebas instanciando el componente y luego comprobando el `isAllowed()` si es `true` o `false`.
> 
> [Codeception](https://codeception.com) es el framework de pruebas elegido por Phalcon, hay muchas pruebas en nuestro repositorio GitHub (carpeta `tests`) para ofrecer orientación e ideas.

```php
$acl->deny('guest', '*', 'view');
```

Para la operación `guest`, negamos el acceso a todos los asuntos con la acción `view`. A pesar del hecho de que el nivel de acceso por defecto es `Acl::DENY` en nuestro ejemplo anterior, hemos permitido específicamente la acción `view` a todas las operaciones y temas. Esto incluye la operación `guest`. Queremos permitir el acceso al `guest` solo al asunto `session` y a las acciones `login` y `logout`, ya que los `guests` no están logeados en nuestra aplicación.

```php
$acl->allow('*', '*', 'view');
```

Esto da acceso al acceso `view` a todo el mundo, pero queremos que la operación de `guest` debe ser excluida de ahí, entonces lo que necesitamos es la siguiente linea.

```php
$acl->deny('guest', '*', 'view');
```