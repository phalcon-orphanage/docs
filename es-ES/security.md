* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Seguridad

Este componente ayuda al desarrollador en tareas comunes de seguridad como el hashing de contraseñas y la protección de falsificación de petición de sitios cruzados o [ CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery).

<a name='hashing'></a>

## Hashing de contraseñas

Almacenar contraseñas en texto plano es una mala práctica de seguridad. Cualquier persona con acceso a la base de datos inmediatamente tendrá acceso a todas las cuentas de usuario, pudiendo así participar en actividades no autorizadas. Para combatir esto, muchas aplicaciones usan un forma familar de métodos de hash como el [`md5`](http://php.net/manual/en/function.md5.php) y el [`sha1`](http://php.net/manual/en/function.sha1.php). Sin embargo, el hardware evoluciona cada día y se vuelve más rápido, estos algoritmos se están volviendo vulnerables a los ataques por fuerza bruta. Estos ataques también son conocidos como [Tablas Arcoíris](http://en.wikipedia.org/wiki/Rainbow_table).

The security component uses [bcrypt](http://en.wikipedia.org/wiki/Bcrypt) as the hashing algorithm. Thanks to the '[Eksblowfish](http://en.wikipedia.org/wiki/Bcrypt#Algorithm)' key setup algorithm, we can make the password encryption as `slow` as we want. Slow algorithms minimize the impact of bruce force attacks.

Bcrypt, is an adaptive hash function based on the Blowfish symmetric block cipher cryptographic algorithm. It also introduces a security or work factor, which determines how slow the hash function will be to generate the hash. This effectively negates the use of FPGA or GPU hashing techniques.

Should hardware becomes faster in the future, we can increase the work factor to mitigate this.

This component offers a simple interface to use the algorithm:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function registerAction()
    {
        $user = new Users();

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user->login = $login;

        // Almacenar la contraseña con hash
        $user->password = $this->security->hash($password);

        $user->save();
    }
}
```

We saved the password hashed with a default work factor. A higher work factor will make the password less vulnerable as its encryption will be slow. We can check if the password is correct as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = Users::findFirstByLogin($login);
        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                // La contraseña es válida
            }
        } else {
            // Para protegernos de reiterados ataques. Independientemente de si un usuario existe o no,
            // el script tomará aproximadamente la misma cantidad
            // ya que siempre se computará un hash.
            $this->security->hash(rand());
        }

        // La validación ha fallado
    }
}
```

La sal es generada usando bytes pseudo-aleatorios con la función [ openssl_random_pseudo_bytes](http://php.net/manual/en/function.openssl-random-pseudo-bytes.php) de PHP, así se requiere que este cargada la extensión [OpenSSL](http://php.net/manual/en/book.openssl.php).

<a name='csrf'></a>

## Protección de Falsificación de Petición en Sitios Cruzados (CSRF)

This is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments are vulnerable to this attack.

La idea es evitar que los valores del formulario puedan enviarse desde fuera de nuestra aplicación. Para solucionar este problema, se puede generar un [Random Nonce](http://en.wikipedia.org/wiki/Cryptographic_nonce) o token en cada formulario, agregar el token en la sesión y luego validar el token una vez que el formulario envía los datos de regreso a nuestra aplicación, comparando el token almacenado en la sesión con el enviado por el formulario:

```php
<?php echo Tag::form('session/login') ?>

    <!-- Iniciar sesión e ingresar contraseña ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

Entonces en la acción del controlador es posible comprobar si el token CSRF es válido:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                // El token es correcto
            }
        }
    }
}
```

Recuerde añadir un adaptador de sesión al inyector de dependencias, de lo contrario no funcionará el chequeo:

```php
<?php

$di->setShared(
    'session',
    function () {
        $session = new \Phalcon\Session\Adapter\Files();

        $session->start();

        return $session;
    }
);
```

Añadir un [captcha](http://www.google.com/recaptcha) al formulario también es recomendado para evitar por completo los riesgos de este tipo de ataque.

<a name='setup'></a>

## Configurar el componente

Este componente se registra automáticamente en el contenedor de servicios con el nombre `security`, usted puede volver a registrarlo para establecer sus opciones de configuración:

```php
<?php

use Phalcon\Security;

$di->set(
    'security',
    function () {
        $security = new Security();

        // Establecer el hash de contraseña en un factor de 12 rondas
        $security->setWorkFactor(12);

        return $security;
    },
    true
);
```

<a name='random'></a>

## Aleatorio

The [Phalcon\Security\Random](api/Phalcon_Security_Random) class makes it really easy to generate lots of types of random data.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

// ...
$bytes      = $random->bytes();

// Genera una cadena aleatoria hexadecimal con largo $len.
$hex        = $random->hex($len);

// Genera una cadena base64 aleatoria de largo $len.
$base64     = $random->base64($len);

// Genera una cadena base64 de URL-segura con largo $len.
$base64Safe = $random->base64Safe($len);

// Genera un UUID (versión 4).
// Más información en https://en.wikipedia.org/wiki/Universally_unique_identifier
$uuid       = $random->uuid();

// Genera un entero aleatorio entre 0 y $n.
$number     = $random->number($n);
```

<a name='resources'></a>

## Recursos externos

* [Vökuró](https://vokuro.phalconphp.com), es una aplicación de ejemplo que utiliza el componente de seguridad para evitar CSRF y contraseña hash, [Código fuente en Github](https://github.com/phalcon/vokuro)