---
layout: default
title: 'Seguridad'
upgrade: '#security'
keywords: 'seguridad, hash, contraseñas'
---

# Seguridad
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

> **NOTE**: Requires PHP's [openssl][openssl] extension to be present in the system 
> 
> {: .alert .alert-info }

[Phalcon\Encryption\Security][security] is a component that helps developers with common security related tasks, such as password hashing and Cross-Site Request Forgery protection ([CSRF][wiki-csrf]).

## Hashing de contraseñas
Almacenar contraseñas en texto plano es una práctica de seguridad mala. Cualquiera con acceso a la base de datos tendrá inmediatamente acceso a las cuentas de todos los usuarios, y podrá realizar actividades no autorizadas. To combat that, many applications use popular one way hashing methods [md5][md5] and [sha1][sha1]. Sin embargo, el hardware evoluciona cada día y los procesadores se vuelven más rápidos, estos algoritmos se están volviendo vulnerables contra ataques de fuerza bruta. These attacks are also known as [rainbow tables][rainbow-tables].

The security component uses [bcrypt][bcrypt] as the hashing algorithm. Thanks to the [Eksblowfish][eksblowfish] key setup algorithm, we can make the password encryption as `slow` as we want. Los algoritmos lentos minimizan el impacto de ataques por fuerza bruta.

[Bcrypt][bcrypt], is an adaptive hash function based on the Blowfish symmetric block cipher cryptographic algorithm. También introduce un factor de seguridad o trabajo, que determina cómo de lenta será la función hash para generar el hash. Esto niega efectivamente el uso de técnicas de hashing FPGA o GPU.

Si en el futuro el hardware se vuelve más rápido, podemos aumentar el factor de trabajo para mitigar esto. The salt is generated using pseudo-random bytes with the PHP's function [openssl_random_pseudo_bytes][openssl-random-pseudo-bytes].

Este componente ofrece un interfaz simple para usar el algoritmo:

```php
<?php

use Phalcon\Encryption\Security;

$security = new Security();

echo $security->hash('Phalcon'); 
// $2y$08$ZUFGUUk5c3VpcHFoVUFXeOYoA4NPFEP4G9gcm6rdo3jFPaNFdR2/O
```

El hash creado usó el factor de trabajo predeterminado, que está establecido en `10`. Usar un factor de trabajo más alto tomará un poco más de tiempo para calcular el hash.

Ahora podemos comprobar si un valor enviado a nosotros por un usuario, a través del interfaz de usuario de nuestra aplicación, es idéntico a nuestra cadena hash:

```php
<?php

use Phalcon\Encryption\Security;

$password = $_POST['password'] ?? '';

$security = new Security();
$hashed = $security->hash('Phalcon');

echo $security->checkHash($password, $hashed); // true / false
```

El ejemplo anterior simplemente muestra cómo se puede usar `checkHash()`. In production applications we will definitely need to sanitize input, and also we need to store the hashed password in a data store such as a database. Usando controladores, el ejemplo anterior se podría mostrar como:

```php
<?php

use MyApp\Models\Users;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Encryption\Security;

/**
 * @property Request  $request
 * @property Security $security
 */
class SessionController extends Controller
{
    public function loginAction()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = Users::findFirst(
            [
                'conditions' => 'login = :login:',
                'bind'       => [
                    'login' => $login,
                ],
            ]
        );

        if (false !== $user) {
            $check = $this
                ->security
                ->checkHash($password, $user->password);

            if (true === $check) {
                // OK
            }
        } else {
            $this->security->hash(rand());
        }

        // ERROR
    }

    public function registerAction()
    {
        $login    = $this->request->getPost('login', 'string');
        $password = $this->request->getPost('password', 'string');

        $user = new Users();

        $user->login    = $login;
        $user->password = $this->security->hash($password);

        $user->save();
    }

}
```

> **NOTE** The code snippet above is incomplete and **must not be used as is for production applications** 
> 
> {: .alert .alert-danger }

El `registerAction()` anterior acepta datos publicados desde el interfaz del usuario. Se limpian con el filtro `string` y entonces crea un nuevo objeto del modelo `User`. Entonces asigna los datos pasados a las propiedades relevantes antes de guardarlos. Notice that for the password, we use the `hash()` method of the [Phalcon\Encryption\Security][security] component so that we do not save it as plain text in our database.

El `loginAction()` acepta datos publicados desde la interfaz de usuario y entonces intenta encontrar el usuario en la base de datos basándose en el campo `login`. If the user does exist, it will use the `checkHash()` method of the [Phalcon\Encryption\Security][security] component, to assess whether the supplied password hashed is the same as the one stored in the database.

> **NOTE**: You do not need to hash the supplied password (first parameter) when using `checkHash()` - the component will do that for you. 
> 
> {: .alert .alert-info }

Si la contraseña no es correcta, entonces puede informar al usuario de que algo está mal con las credenciales. Siempre es una buena idea no proporcionar información específica sobre sus usuarios a gente que quiere hackear su sitio. Así que por ejemplo, en nuestro ejemplo anterior podemos producir dos mensajes:

- Usuario no encontrado en la base de datos
- La contraseña es incorrecta

Separar los mensajes de error no es una buena idea. Si un hacker que usa un ataque por fuerza bruta detecta el segundo mensaje, puede parar de intentar adivinar el `login` y concentrarse en la contraseña, lo que incrementa sus posibilidades de obtener el acceso. Un mensaje más apropiado para ambas posibles condiciones de error podía ser

`Combinación Usuario/Contraseña inválida`

Finally, you will notice in the example that when the user is not found, we call:

```php
$this->security->hash(rand());
```

Esto se hace para proteger contra ataques temporales. Independientemente de si un usuario existe o no, el script tomará aproximadamente la misma cantidad de tiempo para ejecutarse, ya que está calculando el hash otra vez, aunque nunca usemos ese resultado.

## Excepciones
Any exceptions thrown in the Security component will be of type [Phalcon\Encryption\Security\Exception][security-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente. Las excepciones se pueden lanzar si el algoritmo de hashing es desconocido, si el servicio `session` no está presente en el contenedor Di, etc.

```php
<?php

use Phalcon\Encryption\Security\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->security->hash('123');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Protección CSRF
Cross-Site Request Forgery (CSRF) is another common attack against websites and applications. Los formularios destinados a realizar tareas como registro de usuarios o añadir comentarios son vulnerables a este ataque.

La idea es prevenir que los valores del formulario sean enviados fuera de nuestra aplicación. To fix this, we generate a [random nonce][random-nonce] (token) in each form, add the token in the session and then validate the token once the form posts data back to our application by comparing the stored token in the session to the one submitted by the form:

```php
<form method='post' action='session/login'>

    <!-- Login and password inputs ... -->

    <input type='hidden' 
           name='<?php echo $this->security->getTokenKey() ?>'
           value='<?php echo $this->security->getToken() ?>'/>

</form>
```

Posteriormente, en la acción del controlador puede comprobar si el token CSRF es válido:

```php
<?php

use Phalcon\Mvc\Controller;

/**
 * @property Request  $request
 * @property Security $security
 */
class SessionController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                // OK
            }
        }
    }
}
```

> **NOTE**: It is important to remember that you will need to have a valid `session` service registered in your Dependency Injection container. Otherwise, the `checkToken()` will not work. 
> 
> {: .alert .alert-warning }

Adding a [captcha][captcha] to the form is also recommended to completely avoid the risks of this attack.

## Funcionalidad

### Hash

**getDefaultHash() / setDefaultHash()**

*Getter* y *setter* que usará el componente para el hash predeterminado. By default, the hash is set to `CRYPT_DEFAULT` (`0`). Las opciones disponibles son:

* `CRYPT_BLOWFISH_A`
* `CRYPT_BLOWFISH_X`
* `CRYPT_BLOWFISH_Y`
* `CRYPT_MD5`
* `CRYPT_SHA256`
* `CRYPT_SHA512`
* `CRYPT_DEFAULT`

**hash()**

Cifra una cadena o contraseña y devuelve la cadena cifrada de vuelta. El segundo parámetro es opcional, y le permite establecer temporalmente un `factorTrabajo` específico o pasarlo, que sobreescribirá el predeterminado.

**checkHash()**

Acepta una cadena (normalmente la contraseña), y una cadena ya cifrada (la contraseña cifrada) y un tamaño de contraseña mínimo opcional. Los comprueba ambos y devuelve `true` si son idénticos y `false` en caso contrario.

**isLegacyHash()**

Returns `true` if the passed hashed string is a valid [bcrypt][bcrypt] hash.

### HMAC

**computeHmac()**

Genera un valor hash clave usando el método HMAC. It uses PHP's [hash_hmac][hash-hmac] method internally, therefore all the parameters it accepts are the same as the [hash_hmac][hash-hmac].

### Aleatorio
**`getRandom()`**

Returns a [Phalcon\Encryption\Security\Random][security-random] object, which is secure random number generator instance. El componente se explica en detalle a continuación.

**`getRandomBytes()` / `setRandomBytes()`**

Métodos *getter* y *setter* para especificar el número de bytes a ser generados por el pseudo generador aleatorio openssl. Por defecto es `16`.

**`getSaltBytes()`**

Genera una pseudo cadena aleatoria para usar como sal para contraseñas. Usa el valor de `getRandomBytes()` para el tamaño de la cadena. Sin embargo, se puede sobreescribir por el parámetro numérico pasado.

### Token
**`getToken()`**

Genera un pseudo valor aleatorio de token a usar como valor de campo en una comprobación CSRF.

**`getTokenKey()`**

Genera una pseudo clave aleatoria de token a usar como nombre de campo en una comprobación CSRF.

**`getRequestToken()`**

Devuelve el valor del token CSRF para la petición actual.

**`checkToken()`**

Comprueba si el token CSRF enviado en la petición es el mismo que el actual en sesión. El primer parámetro es la clave del token y el segundo el valor del token. It also accepts a third boolean parameter `destroyIfValid` which, if set to `true` will destroy the token if the method returns `true`.

**`getSessionToken()`**

Devuelve el valor del token CSRF en sesión

**`destroyToken()`**

Elimina el valor y clave del token CSRF de la sesión

## Aleatorio
The [Phalcon\Encryption\Security\Random][security-random] class makes it really easy to generate lots of types of random data to be used in salts, new user passwords, session keys, complicated keys, encryption systems etc. This class partially borrows [SecureRandom][secure-random] library from Ruby.

It supports following secure random number generators:
* `random_bytes`
* `libsodium`
* `openssl`, `libressl`
* `/dev/urandom`

Para utilizar lo anterior necesitará asegurarse que los generadores están disponibles en su sistema. Por ejemplo, para usar `openssl` su aplicación PHP necesita soportarla.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->hex(10);       // a29f470508d5ccb8e289
echo $random->base62();      // z0RkwHfh8ErDM1xw
echo $random->base64(16);    // SvdhPcIHDZFad838Bb0Swg==
echo $random->base64Safe();  // PcV6jGbJ6vfVw7hfKIFDGA
echo $random->uuid();        // db082997-2572-4e2c-a046-5eefe97b1235
echo $random->number(256);   // 84
echo $random->base58();      // 4kUgL2pdQMSCQtjE
```

**`base58()`**

Genera una cadena `base58` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. It may be larger in the future. El resultado puede contener caracteres alfanuméricos excepto `0` (zero), `O` (`o` mayúscula), `I` (`i` mayúscula) y `l` (`L` minúscula).

Es similar a `base64()` pero se ha modificado para evitar tanto caracteres no alfanuméricos como letras que podrían parecer ambiguas cuando se muestran.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

**`base62()`**

Genera una cadena `base62` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. It may be larger in the future. Es similar a `base58()` pero se ha modificado para proporcionar un valor más largo que se pueda usar de forma segura en URLs sin necesidad de tomar en consideración caracteres extra porque son `[A-Za-z0-9]`

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

**`base64()`**

Genera una cadena `base64` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. It may be larger in the future. El tamaño de la cadena resultante suele ser mayor de `$len`. La fórmula de tamaño es:

`4 * ($len / 3)` redondeado hasta un múltiplo de 4.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8
```

**`base64Safe()`**

Genera una cadena `base64` aleatoria segura para URL. Si no se especifica el parámetro `$len`, se asume `16`. It may be larger in the future. El tamaño de la cadena resultante suele ser mayor de `$len`.

Por defecto, no se genera relleno porque `=` se puede usar como delimitador de URL. El resultado puede contener `A-Z`, `a-z`, `0-9`, `-` y `_`. `=` también se usa si `$padding` es `true`. See [RFC 3548][rfc-3548] for the definition of URL-safe `base64`.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug
```

**`bytes()`**

Genera una cadena binaria aleatoria y acepta como entrada un entero que representa el tamaño en bytes a devolver. Si no se especifica `$len`, se asume `16`. It may be larger in the future. El resultado puede contener cualquier byte: `x00` - `xFF`.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"
```

**`hex()`**

Genera una cadena hexadecimal aleatoria. Si no se especifica `$len`, se sume 16. It may be larger in the future. El tamaño de la cadena resultante suele ser mayor de `$len`.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

**`number()`**

Genera un número aleatorio entre `0` y `$len`. Devuelve un entero: `0 <= result <= $len`.

```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->number(16); // 8
```

**`uuid()`**

Genera un UUID (*Universally Unique IDentifier*) aleatorio v4. La versión 4 de UUID es puramente aleatoria (excepto la versión). No contiene información significativa como dirección MAC, hora, etc. See [RFC 4122][rfc-4122] for details of UUID.

Este algoritmo establece el número de versión (4 bits) así como dos bits reservados. Todos los demás bits (los 122 bits restantes) se establecen usando una fuente de datos aleatoria o pseudoaleatoria. Las UUIDs Version 4 tienen la forma `xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx` donde x es cualquier dígito hexadecimal e `y` es uno de `8`, `9`, `A`, o `B` (ej., `f47ac10b-58cc-4372-a567-0e02b2c3d479`).
*
```php
<?php

use Phalcon\Encryption\Security\Random;

$random = new Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

## Inyección de Dependencias
If you use the [Phalcon\Di\FactoryDefault][factorydefault] container, the [Phalcon\Encryption\Security][security] is already registered for you. However, you might want to override the default registration in order to set your own `workFactor()`. Alternatively if you are not using the [Phalcon\Di\FactoryDefault][factorydefault] and instead are using the [Phalcon\Di\Di](di) the registration is the same. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Encryption\Security;

// Create a container
$container = new FactoryDefault();

$container->set(
    'security',
    function () {
        $security = new Security();

        $security->setWorkFactor(12);

        return $security;
    },
    true
);
```
En el ejemplo anterior, `setWorkFactor()` establece el factor de cifrado de contraseña a 12 rondas.

El componente ahora está disponible en sus controladores usando la clave `security`

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Encryption\Security;

/**
 * @property Security $security
 */
class MyController extends Controller
{
    private function getHash(string $password): string
    {
        return $this->security->hash($password);
    }
}
```

También en sus vistas (sintaxis Volt)

```twig
{% raw %}{{ security.getToken() }}{% endraw %}
```

[bcrypt]: https://en.wikipedia.org/wiki/Bcrypt

[bcrypt]: https://en.wikipedia.org/wiki/Bcrypt
[captcha]: https://en.wikipedia.org/wiki/ReCAPTCHA
[eksblowfish]: https://en.wikipedia.org/wiki/Bcrypt#Algorithm
[factorydefault]: api/phalcon_di#di-factorydefault
[hash-hmac]: https://www.php.net/manual/en/function.hash-hmac.php
[md5]: https://php.net/manual/en/function.md5.php
[openssl]: https://php.net/manual/en/book.openssl.php
[openssl-random-pseudo-bytes]: https://php.net/manual/en/function.openssl-random-pseudo-bytes.php
[random-nonce]: https://en.wikipedia.org/wiki/Cryptographic_nonce
[rainbow-tables]: https://en.wikipedia.org/wiki/Rainbow_table
[rfc-3548]: https://www.ietf.org/rfc/rfc3548.txt
[rfc-4122]: https://www.ietf.org/rfc/rfc4122.txt
[secure-random]: https://ruby-doc.org/stdlib-2.2.2/libdoc/securerandom/rdoc/SecureRandom.html
[security]: api/phalcon_encryption#encryption-security
[security-exception]: api/phalcon_encryption#encryption-security-exception
[security-random]: api/phalcon_encryption#encryption-security-random
[sha1]: https://php.net/manual/en/function.sha1.php
[wiki-csrf]: https://en.wikipedia.org/wiki/Cross-site_request_forgery
