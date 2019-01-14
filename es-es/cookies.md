* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Gestión de cookies

[Cookies](https://en.wikipedia.org/wiki/HTTP_cookie) are a very useful way to store small pieces of data on the client's machine that can be retrieved even if the user closes his/her browser. `Phalcon\Http\Response\Cookies` actúa como una bolsa global de cookies. Las cookies se almacenan en esta bolsa durante la ejecución de la solicitud y se envían automáticamente al final de la misma.

<a name='usage'></a>

## Uso básico

Se puede poner/obtener cookies con sólo acceder al servicio de `cookies` en cualquier parte de la aplicación, donde los servicios pueden ser accedidos:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        // Chequeamos si la cookie esta previamente seteada
        if ($this->cookies->has('remember-me')) {
            // Obtenemos la cookie
            $rememberMeCookie = $this->cookies->get('remember-me');

            // Obtenemos el valor de la cookie
            $value = $rememberMeCookie->getValue();
        }
    }

    public function startAction()
    {
        $this->cookies->set(
            'remember-me',
            'some value',
            time() + 15 * 86400
        );

        $this->cookies->send();
    }

    public function logoutAction()
    {
        $rememberMeCookie = $this->cookies->get('remember-me');

        // Borramos la cookie
        $rememberMeCookie->delete();
    }
}
```

<a name='encryption-decryption'></a>

## Encriptado / Desencriptado de cookies

De forma predeterminada, las cookies se encriptan automáticamente antes de ser enviadas al cliente y se desencriptan cuando regresan del mismo. Esta protección evita que usuarios no autorizados vean el contenido de las cookies en el cliente (navegador). A pesar de esta protección, los datos sensibles no deben almacenarse en cookies.

Puede deshabilitar el encriptado de la siguiente manera:

```php
<?php

use Phalcon\Http\Response\Cookies;

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    }
);
```

If you wish to use encryption, a global key must be set in the [crypt](/4.0/en/crypt) service:

```php
    <?php

    use Phalcon\Crypt;

    $di->set(
        'crypt',
        function () {
            $crypt = new Crypt();

            /**
             * Establecer el algoritmo cipher.
             *
             * El cifrado `aes-256-gcm' es el preferido, pero no se puede utilizar
             * hasta que la librería openssl este actualizada. Disponible desde PHP 7.1.
             *
             * El `aes-256-ctr' es posiblemente la mejor opción de algoritmo de cifrado
             * en estos días.
             */
            $crypt->setCipher('aes-256-ctr');

            /**
             * Estableciendo la clave de encriptado.
             *
             * La clave debe ser generado previamente de una manera criptográficamente segura.
             *
             * Bad key:
             * "le password"
             *
             * Better (but still unsafe):
             * "#1dj8$=dp?.ak//j1V$~%*0X"
             *
             * Good key:
             * "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\x5c"
             *
             * Use your own key. No copiar y pegar esta clave de ejemplo.
             */
            $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\x5c";

            $crypt->setKey($key);

            return $crypt;
        }
    );
```

<div class="alert alert-danger">
    <p>
        Sending cookies data without encryption to clients including complex objects structures, resultsets, service information, etc. could expose internal application details that could be used by an attacker to attack the application. If you do not want to use encryption, we highly recommend you only send very basic cookie data like numbers or small string literals.
    </p>
</div>
