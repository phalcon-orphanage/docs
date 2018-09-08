<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Gestión de cookies</a>
       <ul>
        <li>
          <a href="#usage">Uso básico</a>
        </li>
        <li>
          <a href="#encryption-decryption">Encriptado / Desencriptado de cookies</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Gestión de cookies

[Las cookies](http://en.wikipedia.org/wiki/HTTP_cookie) son una manera muy útil para almacenar pequeñas piezas de datos en la máquina del cliente que puede ser obtenida aún cuando el usuario cierra su navegador. `Phalcon\Http\Response\Cookies` actúa como una bolsa global de cookies. Las cookies se almacenan en esta bolsa durante la ejecución de la solicitud y se envían automáticamente al final de la misma.

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

Si desea utilizar el encriptado, debe establecer una clave global al servicio [crypt](/[[language]]/[[version]]/crypt):

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
             * Clave mala:
             * "la contraseña"
             *
             * Mejor (Pero aún insegura):
             * "#1dj8$=dp?.ak//j1V$~%*0X"
             *
             * Clave correcta:
             * "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c"
             *
             * Utilice su propia clave. No copiar y pegar esta clave de ejemplo.
             */
            $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";

            $crypt->setKey($key);

            return $crypt;
        }
    );
```

<div class="alert alert-danger">
    <p>
        Enviar cookies sin encriptación al clientes, incluyendo estructuras de objetos complejos, conjuntos de resultados (resultsets), información de servicio, etc. podría exponer los datos de uso interno para que puedan ser utilizados por un atacante y atacar la aplicación. Si no desea utilizar el cifrado, recomendamos que sólo enviar datos muy básicos como números o pequeñas cadenas de texto.
    </p>
</div>
