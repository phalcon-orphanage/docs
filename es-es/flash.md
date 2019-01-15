* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Mensajes Flash

Los mensajes flash se utilizan para notificar al usuario sobre el estado de las acciones que hacen o simplemente mostrar información a los usuarios. Estos tipos de mensajes se pueden generar utilizando este componente.

<a name='adapters'></a>

## Adaptadores

Este componente hace uso de adaptadores para definir el comportamiento de los mensajes después de ser pasado al Flasher:

| Adaptador | Descripción                                                                                                         | API                                                  |
| --------- | ------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| Direct    | Las salidas de los mensajes se transfieren directamente al flasher                                                  | [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct)   |
| Session   | Se almacena temporalmente los mensajes en la sesión, luego se pueden imprimir los mensajes en la siguiente consulta | [Phalcon\Flash\Session](api/Phalcon_Flash_Session) |

<a name='usage'></a>

## Uso

Generalmente se solicita el servicio de mensajería Flash desde el contenedor de servicios. If you're using [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) then [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct) is automatically registered as `flash` service and [Phalcon\Flash\Session](api/Phalcon_Flash_Session) is automatically registered as `flashSession` service. También es posible registrarlos manualmente:

```php
<?php

use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;

// Configurar el servicio flash
$di->set(
    'flash',
    function () {
        return new FlashDirect();
    }
);

// Configurar el servicio flash session
$di->set(
    'flashSession',
    function () {
        return new FlashSession();
    }
);
```

De esta manera, usted puede utilizarlo en vistas o controladores:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        $this->flash->success('La publicación fue correctamente guardada!');
    }
}
```

Hay cuatro tipos de mensaje incorporados:

```php
<?php

$this->flash->error('Que mal! el formulario tiene errores');

$this->flash->success('Si!, todo esta muy bien');

$this->flash->notice('Esta es una información muy importante');

$this->flash->warning("Mejor que te revisen, no te ves muy bien.");
```

También puede agregar mensajes con sus propios tipos, utilizando el método `message()`:

```php
<?php

$this->flash->message('debug', "Este es un mensaje de depuración, no lo digas");
```

<a name='printing'></a>

## Imprimiendo Mensajes

Los mensajes enviados al servicio flash automáticamente son formateados a HTML:

```html
<div class='errorMessage'>Que mal! el formulario tiene errores</div>

<div class='successMessage'>Si!,todo esta muy bien</div>

<div class='noticeMessage'>Esta es una información muy importante</div>

<div class='warningMessage'>Mejor que te revisen, no te ves muy bien.</div>
```

Como se puede ver, las clases CSS se añaden automáticamente a los `<div>`. Estas clases le permiten definir la presentación gráfica de los mensajes en el navegador. Las clases CSS se pueden redefinir, por ejemplo, si estás utilizando Bootstrap de Twitter, las clases pueden configurarse de la siguiente manera:

```php
<?php

use Phalcon\Flash\Direct as FlashDirect;

// Registrar el servicio flash con clases CSS personalizadas
$di->set(
    'flash',
    function () {
        $flash = new FlashDirect(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );

        return $flash;
    }
);
```

Entonces los mensajes será impresos de la siguiente manera:

```html
<div class='alert alert-danger'>Que mal! el formulario tiene errores</div>

<div class='alert alert-success'>Si!,todo esta muy bien</div>

<div class='alert alert-info'>Esta es una información muy importante</div>

<div class='alert alert-warning'>Mejor que te revisen, no te ves muy bien.</div>
```

<a name='implicit-flush-vs-session'></a>

## Flush Implícito vs Sesión

Dependiendo del adaptador utilizado para enviar mensajes, es posible producir salidas directas o temporales, para este último, almacenando los mensajes en la sesión para ser mostrados luego. ¿Cuándo debo utilizar cada uno? Esto dependerá del tipo de redirección que utilices antes de enviar los mensajes. Por ejemplo, si haces un `forward` no es necesario almacenar los mensajes en sesión, pero si utiliza una redirección HTTP entonces, necesitan ser almacenados en sesión:

```php
<?php

use Phalcon\Mvc\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Almacenar una publicación

        // Utilizar flash directo
        $this->flash->success('Tú información fue almacenada correctamente!');

        // Avanzar a la acción index
        return $this->dispatcher->forward(
            [
                'action' => 'index'
            ]
        );
    }
}
```

O utilizando redirecciones HTTP:

```php
<?php

use Phalcon\Mvc\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Almacenar una publicación

        // Utilizando flash en sesión
        $this->flashSession->success('Tú información fue almacenada correctamente!');

        // Hacer una redirección HTTP completa
        return $this->response->redirect('contact/index');
    }
}
```

En este caso, debe imprimir manualmente los mensajes en la vista correspondiente:

```php
<!-- app/views/contact/index.phtml -->

<p><?php $this->flashSession->output() ?></p>
```

El atributo `flashSession` es como el servicio flash fue previamente registrado en el contenedor de inyección de dependencias. You need to start the [session](/4.0/en/session) first to successfully use the `flashSession` messenger.