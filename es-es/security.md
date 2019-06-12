---
layout: default
language: 'es-es'
version: '4.0'
---

# Componente de seguridad

* * *

## Preámbulo

Este componente se encarga de ayudar al desarrollador en tareas comunes de seguridad como el *hashing* de contraseñas y la protección contra ataques [CSRF](https://es.wikipedia.org/wiki/Cross-site_request_forgery).

## Hashing de contraseñas

Almacenar contraseñas en texto plano es una mala práctica de seguridad. Cualquier persona con acceso a la base de datos puede tener acceso inmediato a todas las cuentas de usuario y realizar actividades sin autorización. Para prevenir este abuso, muchas aplicaciones utilizan métodos de hashing como [md5](https://php.net/manual/en/function.md5.php) y [sha1](https://php.net/manual/en/function.sha1.php). Sin embargo, la evolución cotidiana del hardware &mdash;que lo hace más rápido día a día&mdash; hace que se vuelvan vulnerables a los ataques de fuerza bruta, también conocidos como [Tablas Arcoíris](https://en.wikipedia.org/wiki/Rainbow_table).

El componente de seguridad utiliza [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) como algoritmo de hashing. Gracias al algoritmo de configuración de clave [Eksblowfish](https://en.wikipedia.org/wiki/Bcrypt#Algorithm) se puede encriptar la contraseña tan lento (`slow`) como se desee. Los algoritmos lentos reducen el impacto de los ataques de fuerza bruta.

Bcrypt es una función hash adaptativa basada en el algoritmo criptográfico de cifrado de bloque simétrico Blowfish. También contempla un factor de seguridad o trabajo que determina qué tan lenta será la función hash para hacer su trabajo. De esta manera se descarta el uso de técnicas de hash como FPGA o GPU.

Si el hardware se hace más rápido en el futuro se puede aumentar el factor de trabajo o lentitud para contrarrestarlo.

El componente cuenta con una interfaz sencilla para utilizar el algoritmo:

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

La contraseña ha sido almacenada con el factor de trabajo predeterminado. Un factor de trabajo más alto hará que la contraseña sea menos vulnerable puesto que su encriptación será más lenta. Para revisar si la contraseña es correcta:

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
            // Para prevenir ataques sistemáticos Independientemente de si un usuario existe o no,
            // el script tomará aproximadamente la misma cantidad
            // ya que siempre se computará un hash.
            $this->security->hash(
                rand()
            );
        }

        // La validación ha fallado
    }
}
```

La sal es generada usando bytes pseudo-aleatorios con la función [ openssl_random_pseudo_bytes](https://php.net/manual/es/function.openssl-random-pseudo-bytes.php) de PHP, así se requiere que este cargada la extensión [OpenSSL](https://php.net/manual/es/book.openssl.php).

## Protección contra ataques CSRF

Este es otro ataque frecuente contra los sitios web y aplicaciones. Los formularios destinados a tareas como registrarse o agregar comentarios son vulnerables a este ataque.

El objetivo es prevenir que los valores de los formularios de la aplicación sean enviados desde el exterior. Para solucionar este problema, se puede generar un [Random Nonce](https://en.wikipedia.org/wiki/Cryptographic_nonce) o token en cada formulario, agregar el token en la sesión y luego validar el token una vez que el formulario envía los datos de regreso a nuestra aplicación, comparando el token almacenado en la sesión con el enviado por el formulario:

```php
<?php echo Tag::form('session/login') ?>

    <!-- Iniciar sesión e ingresar contraseña ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

En la acción del controlador se puede verificar la validez del token contra CSRF:

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

Es muy importante agregar un adaptador de sesión al inyector de dependencias (`DI`), de lo contrario la validación del token no funcionará:

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

Añadir un [captcha](https://www.google.com/recaptcha) al formulario también es recomendado para evitar por completo los riesgos de este tipo de ataque.

## Configuración del componente

El componente se registra de manera automática en el contenedor de servicios como `security`; es posible registrarlo de nuevo para configurar sus opciones:

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

## Aleatorio

La clase [Phalcon\Security\Random](api/Phalcon_Security_Random) facilita la generación de varios tipos de datos aleatorios.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

// ...
$bytes = $random->bytes();

// Genera una cadena hex de tamaño $len.
$hex = $random->hex($len);

// Genera una cadena base64 de tamaño $len.
$base64 = $random->base64($len);

// Genera una dirección segura URL en base64 con tamaño $len.
$base64Safe = $random->base64Safe($len);

// Genera un UUID (versión 4).
// Véase <a href="https://es.wikipedia.org/wiki/Identificador_%C3%BAnico_universal">Identificador único universal</a>
$uuid = $random->uuid();

// Genera un entero aleatorio entre 0 y $n.
$number = $random->number($n);
```