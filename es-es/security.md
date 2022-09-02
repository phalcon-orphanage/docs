---
layout: default
language: 'es-es'
version: '4.0'
title: 'Seguridad'
keywords: 'seguridad, hash, contraseñas'
---

# Seguridad

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo

> **NOTA**: Requiere que esté presente en el sistema la extensión [openssl](https://php.net/manual/en/book.openssl.php) de PHP
{: .alert .alert-info }

[Phalcon\Security](api/phalcon_security#security) es un componente que ayuda a los desarrolladores con las tareas comunes relacionadas con la seguridad, como hash de contraseñas y protección *Cross-Site Request Forgery* ([CSRF](https://es.wikipedia.org/wiki/Cross-site_request_forgery)).

## Hashing de contraseñas

Almacenar contraseñas en texto plano es una práctica de seguridad mala. Cualquiera con acceso a la base de datos tendrá inmediatamente acceso a las cuentas de todos los usuarios, y podrá realizar actividades no autorizadas. Para prevenir eso, muchas aplicaciones usan métodos de *hashing* unidireccional [md5](https://php.net/manual/en/function.md5.php) y [sha1](https://php.net/manual/en/function.sha1.php). Sin embargo, el hardware evoluciona cada día y los procesadores se vuelven más rápidos, estos algoritmos se están volviendo vulnerables contra ataques de fuerza bruta. Estos ataques también son conocidos como [tablas arcoiris](https://es.wikipedia.org/wiki/Tabla_arco%C3%Adris).

El componente de seguridad usa [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) como algoritmo de hashing. Gracias al algoritmo de configuración de claves [Eksblowfish](https://en.wikipedia.org/wiki/Bcrypt#Algorithm), podemos hacer la encriptación de la contraseña tan `lenta` como queramos. Los algoritmos lentos minimizan el impacto de ataques por fuerza bruta.

[Bcrypt](https://en.wikipedia.org/wiki/Bcrypt), es una función de hash adaptativo basado en el algoritmo criptográfico de cifrado de bloque simétrico Blowfish. También introduce un factor de seguridad o trabajo, que determina cómo de lenta será la función hash para generar el hash. Esto niega efectivamente el uso de técnicas de hashing FPGA o GPU.

Si en el futuro el hardware se vuelve más rápido, podemos aumentar el factor de trabajo para mitigar esto. La sal se genera usando bytes pseudo-aleatorios con la función de PHP [openssl_random_pseudo_bytes](https://php.net/manual/en/function.openssl-random-pseudo-bytes.php).

Este componente ofrece un interfaz simple para usar el algoritmo:

```php
<?php

use Phalcon\Security;

$security = new Security();

echo $security->hash('Phalcon'); 
// $2y$08$ZUFGUUk5c3VpcHFoVUFXeOYoA4NPFEP4G9gcm6rdo3jFPaNFdR2/O
```

El hash creado usó el factor de trabajo predeterminado, que está establecido en `10`. Usar un factor de trabajo más alto tomará un poco más de tiempo para calcular el hash.

Ahora podemos comprobar si un valor enviado a nosotros por un usuario, a través del interfaz de usuario de nuestra aplicación, es idéntico a nuestra cadena hash:

```php
<?php

use Phalcon\Security;

$password = $_POST['password'] ?? '';

$security = new Security();
$hashed = $security->hash('Phalcon');

echo $security->checkHash($password, $hashed); // true / false
```

El ejemplo anterior simplemente muestra cómo se puede usar `checkHash()`. En aplicaciones de producción definitivamente necesitaremos sanear la entrada y también necesitaremos almacenar las contraseñas cifradas en un almacén de datos como una base de datos. Usando controladores, el ejemplo anterior se podría mostrar como:

```php
<?php

use MyApp\Models\Users;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Security;

/**
 * @property Request  $request
 * @property Security $security
 */
class SessionController extends Controller
{
    /**
     * Login
     */
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

    /**
     * Register
     */
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

> **NOTA** El fragmento de código anterior está incompleto y **no debe usarse tal cual para aplicaciones en producción**
{: .alert .alert-danger }

El `registerAction()` anterior acepta datos publicados desde el interfaz del usuario. Se limpian con el filtro `string` y entonces crea un nuevo objeto del modelo `User`. Entonces asigna los datos pasados a las propiedades relevantes antes de guardarlos. Tenga en cuenta que para la contraseña, usamos el método `hash()` del componente [Phalcon\Security](api/phalcon_security#security) para no guardarlo como texto plano en nuestra base de datos.

El `loginAction()` acepta datos publicados desde la interfaz de usuario y entonces intenta encontrar el usuario en la base de datos basándose en el campo `login`. Si el usuario existe, usará el método `checkHash()` del componente [Phacon\Security](api/phalcon_security#security), para evaluar si la contraseña cifrada proporcionada es la misma que la almacenada en la base de datos.

> **NOTA**: No necesita cifrar la contraseña proporcionada (primer parámetro) cuando usa `checkHash()` - el componente lo hará por usted.
{: .alert .alert-info }

Si la contraseña no es correcta, entonces puede informar al usuario de que algo está mal con las credenciales. Siempre es una buena idea no proporcionar información específica sobre sus usuarios a gente que quiere hackear su sitio. Así que por ejemplo, en nuestro ejemplo anterior podemos producir dos mensajes:

* Usuario no encontrado en la base de datos
* La contraseña es incorrecta

Separar los mensajes de error no es una buena idea. Si un hacker que usa un ataque por fuerza bruta detecta el segundo mensaje, puede parar de intentar adivinar el `login` y concentrarse en la contraseña, lo que incrementa sus posibilidades de obtener el acceso. Un mensaje más apropiado para ambas posibles condiciones de error podía ser

`Combinación Usuario/Contraseña inválida`

Finalmente, notará en el ejemplo que cuando el usuario no se encuentra, llamamos:

```php
$this->security->hash(rand());
```

Esto se hace para proteger contra ataques temporales. Independientemente de si un usuario existe o no, el script tomará aproximadamente la misma cantidad de tiempo para ejecutarse, ya que está calculando el hash otra vez, aunque nunca usemos ese resultado.

## Excepciones

Cualquier excepción lanzada en el componente `Security` será del tipo [Phalcon\Security\Exception](api/phalcon_security#security-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente. Las excepciones se pueden lanzar si el algoritmo de hashing es desconocido, si el servicio `session` no está presente en el contenedor Di, etc.

```php
<?php

use Phalcon\Security\Exception;
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

Cross-Site Request Forgery (CSRF) es otro ataque común contra sitios y aplicaciones web. Los formularios destinados a realizar tareas como registro de usuarios o añadir comentarios son vulnerables a este ataque.

La idea es prevenir que los valores del formulario sean enviados fuera de nuestra aplicación. Para solucionar esto, se puede generar un [nonce aleatorio](https://en.wikipedia.org/wiki/Cryptographic_nonce) (token) en cada formulario, añadir el token en la sesión y luego validar el token una vez que el formulario envía los datos de regreso a nuestra aplicación, comparando el token almacenado en la sesión con el enviado por el formulario:

```php
<form method='post' action='session/login'>

    <!-- Login and password inputs ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
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

> **NOTA**: Es importante recordar que necesitará tener registrado un servicio `session` válido en su contenedor de Inyección de Dependencias. De lo contrario, el `checkToken()` no funcionará.
{: .alert .alert-warning }

También se recomienda añadir un [captcha](https://es.wikipedia.org/wiki/ReCAPTCHA) al formulario para evitar completamente los riesgos de este ataque.

## Funcionalidad

### Hash

**getDefaultHash() / setDefaultHash()**

*Getter* y *setter* que usará el componente para el hash predeterminado. Por defecto, el hash está establecido en `CRYPT_DEFAULT` (`0`). Las opciones disponibles son:

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

Devuelve `true` si la cadena cifrada pasada es un hash [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) válido.

### HMAC

**computeHmac()**

Genera un valor hash clave usando el método HMAC. Internamente usa el método de PHP [`hash_hmac`](https://www.php.net/manual/en/function.hash-hmac.php), por lo tanto todos los parámetros que acepta son los mismos que para [`hash_hmac`](https://www.php.net/manual/en/function.hash-hmac.php).

### Aleatorio

**`getRandom()`**

Devuelve un objeto [Phalcon\Security\Random](api/phalcon_security#security-random), que es una instancia segura del generador de números aleatorios. El componente se explica en detalle a continuación.

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

Comprueba si el token CSRF enviado en la petición es el mismo que el actual en sesión. El primer parámetro es la clave del token y el segundo el valor del token. También acepta un tercer parámetro booleano `destroyIfValid` que si se establece a `true` destruirá el token si el método devuelve `true`.

**`getSessionToken()`**

Devuelve el valor del token CSRF en sesión

**`destroyToken()`**

Elimina el valor y clave del token CSRF de la sesión

## Aleatorio

La clase [Phalcon\Security\Random](api/phalcon_security#security-random) hace realmente fácil generar muchos tipos de datos aleatorios a usarse en sales, nuevas contraseñas de usuario, claves de sesión, claves complicadas, sistemas de encriptación, etc. Esta clase toma prestada parcialmente la librería [SecureRandom](https://ruby-doc.org/stdlib-2.2.2/libdoc/securerandom/rdoc/SecureRandom.html) de Ruby.

Soporta los siguientes generadores seguros de números aleatorios: * random_bytes * libsodium * openssl, libressl * /dev/urandom

Para utilizar lo anterior necesitará asegurarse que los generadores están disponibles en su sistema. Por ejemplo, para usar `openssl` su aplicación PHP necesita soportarla.

```php
<?php

use Phalcon\Security\Random;

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

Genera una cadena `base58` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. Puede ser más grande en el futuro. El resultado puede contener caracteres alfanuméricos excepto `0` (zero), `O` (`o` mayúscula), `I` (`i` mayúscula) y `l` (`L` minúscula).

Es similar a `base64()` pero se ha modificado para evitar tanto caracteres no alfanuméricos como letras que podrían parecer ambiguas cuando se muestran.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

**`base62()`**

Genera una cadena `base62` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. Puede ser más grande en el futuro. Es similar a `base58()` pero se ha modificado para proporcionar un valor más largo que se pueda usar de forma segura en URLs sin necesidad de tomar en consideración caracteres extra porque son `[A-Za-z0-9]`

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

**`base64()`**

Genera una cadena `base64` aleatoria. Si no se especifica el parámetro `$len`, se asume `16`. Puede ser más grande en el futuro. El tamaño de la cadena resultante suele ser mayor de `$len`. La fórmula de tamaño es:

`4 * ($len / 3)` redondeado hasta un múltiplo de 4.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8
```

**`base64Safe()`**

Genera una cadena `base64` aleatoria segura para URL. Si no se especifica el parámetro `$len`, se asume `16`. Puede ser más grande en el futuro. El tamaño de la cadena resultante suele ser mayor de `$len`.

Por defecto, no se genera relleno porque `=` se puede usar como delimitador de URL. El resultado puede contener `A-Z`, `a-z`, `0-9`, `-` y `_`. `=` también se usa si `$padding` es `true`. Vea [RFC 3548](https://www.ietf.org/rfc/rfc3548.txt) para la definición de URL-segura `base64`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug
```

**`bytes()`**

Genera una cadena binaria aleatoria y acepta como entrada un entero que representa el tamaño en bytes a devolver. Si no se especifica `$len`, se asume `16`. Puede ser más grande en el futuro. El resultado puede contener cualquier byte: `x00` - `xFF`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"
```

**`hex()`**

Genera una cadena hexadecimal aleatoria. Si no se especifica `$len`, se sume 16. Puede ser más grande en el futuro. El tamaño de la cadena resultante suele ser mayor de `$len`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

**`number()`**

Genera un número aleatorio entre `0` y `$len`. Devuelve un entero: `0 <= result <= $len`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->number(16); // 8
```

**`uuid()`**

Genera un UUID (*Universally Unique IDentifier*) aleatorio v4. La versión 4 de UUID es puramente aleatoria (excepto la versión). No contiene información significativa como dirección MAC, hora, etc. Vea [RFC 4122](https://www.ietf.org/rfc/rfc4122.txt) para más detalles sobre UUID.

Este algoritmo establece el número de versión (4 bits) así como dos bits reservados. Todos los demás bits (los 122 bits restantes) se establecen usando una fuente de datos aleatoria o pseudoaleatoria. Las UUIDs Version 4 tienen la forma `xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx` donde x es cualquier dígito hexadecimal e `y` es uno de `8`, `9`, `A`, o `B` (ej., `f47ac10b-58cc-4372-a567-0e02b2c3d479`). *

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

## Inyección de Dependencias

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), [Phalcon\Security](api/phalcon_security#security) ya está registrado para usted. Sin embargo, podría querer sobreescribir el registro predeterminado para establecer su propio `workFactor()`. Alternativamente, si no usa [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) y en su lugar está usando [Phalcon\Di](di) el registro es el mismo. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Security;

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
use Phalcon\Security;

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
