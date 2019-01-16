* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Mensajes Flash

Flash messages are used to notify the user about the state of actions he/she made or simply show information to the users. These kinds of messages can be generated using this component.

<a name='adapters'></a>

## Adaptadores

This component makes use of adapters to define the behavior of the messages after being passed to the Flasher:

| Adaptador | Descripción                                                                                                         | API                                                  |
| --------- | ------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| Direct    | Las salidas de los mensajes se transfieren directamente al flasher                                                  | [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct)   |
| Session   | Se almacena temporalmente los mensajes en la sesión, luego se pueden imprimir los mensajes en la siguiente consulta | [Phalcon\Flash\Session](api/Phalcon_Flash_Session) |

<a name='usage'></a>

## Uso

Usually the Flash Messaging service is requested from the services container. If you're using [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) then [Phalcon\Flash\Direct](api/Phalcon_Flash_Direct) is automatically registered as `flash` service and [Phalcon\Flash\Session](api/Phalcon_Flash_Session) is automatically registered as `flashSession` service. You can also manually register it:

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

This way, you can use it in controllers or views:

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

There are four built-in message types supported:

```php
<?php

$this->flash->error('Que mal! el formulario tiene errores');

$this->flash->success('Si!, todo esta muy bien');

$this->flash->notice('Esta es una información muy importante');

$this->flash->warning("Mejor que te revisen, no te ves muy bien.");
```

You can also add messages with your own types using the `message()` method:

```php
<?php

$this->flash->message('debug', "Este es un mensaje de depuración, no lo digas");
```

<a name='printing'></a>

## Imprimiendo Mensajes

Messages sent to the flash service are automatically formatted with HTML:

```html
<div class='errorMessage'>Que mal! el formulario tiene errores</div>

<div class='successMessage'>Si!,todo esta muy bien</div>

<div class='noticeMessage'>Esta es una información muy importante</div>

<div class='warningMessage'>Mejor que te revisen, no te ves muy bien.</div>
```

As you can see, CSS classes are added automatically to the `<div>`s. These classes allow you to define the graphical presentation of the messages in the browser. The CSS classes can be overridden, for example, if you're using Twitter Bootstrap, classes can be configured as:

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

Then the messages would be printed as follows:

```html
<div class='alert alert-danger'>Que mal! el formulario tiene errores</div>

<div class='alert alert-success'>Si!,todo esta muy bien</div>

<div class='alert alert-info'>Esta es una información muy importante</div>

<div class='alert alert-warning'>Mejor que te revisen, no te ves muy bien.</div>
```

<a name='implicit-flush-vs-session'></a>

## Flush Implícito vs Sesión

Depending on the adapter used to send the messages, it could be producing output directly, or be temporarily storing the messages in session to be shown later. When should you use each? That usually depends on the type of redirection you do after sending the messages. For example, if you make a `forward` is not necessary to store the messages in session, but if you do a HTTP redirect then, they need to be stored in session:

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

Or using a HTTP redirection:

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

In this case you need to manually print the messages in the corresponding view:

```php
<!-- app/views/contact/index.phtml -->

<p><?php $this->flashSession->output() ?></p>
```

The attribute `flashSession` is how the flash was previously set into the dependency injection container. You need to start the [session](/4.0/en/session) first to successfully use the `flashSession` messenger.