<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Encriptado / Desencriptado</a> <ul>
        <li>
          <a href="#usage">Uso básico</a>
        </li>
        <li>
          <a href="#options">Opciones de encriptado</a>
        </li>
        <li>
          <a href="#base64">Soporte Base64</a>
        </li>
        <li>
          <a href="#service">Configurando el servicio de encriptación</a>
        </li>
        <li>
          <a href="#links">Enlaces</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Encriptado / Desencriptado

Phalcon proporciona un servicio de cifrado mediante el componente `Phalcon\Crypt`. Esta clase ofrece una envoltura simple orientada a objetos a la biblioteca de cifrado [openssl](http://www.php.net/manual/en/book.openssl.php) de PHP.

De forma predeterminada, este componente proporciona cifrado seguro utilizando AES-256-CFB.

<h5 class='alert alert-warning'>Se debe utilizar una longitud de clave que corresponda con el algoritmo actual. El algoritmo usado por defecto es 32 bytes.</h5>

<a name='usage'></a>

## Uso básico

Este componente está diseñado para proporcionar un uso muy sencillo:

```php
<?php

use Phalcon\Crypt;

// Crear instancia
$crypt = new Crypt();

$key  = 'Esta es mi clave secreta (32 bytes).';
$text = 'Este es el texto que deseamos encriptar.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

Puede utilizar la misma instancia para encriptar/desencriptar varias veces:

```php
<?php

use Phalcon\Crypt;

// Creamos la instancia
$crypt = new Crypt();

$texts = [
    'mi-llave'    => 'Este es un texto secreto',
    'otra-llave' => 'Esta es muy secreta',
];

foreach ($texts as $key => $text) {
    // Realizar el cifrado
    $encrypted = $crypt->encrypt($text, $key);

    // Ahora desencriptar
    echo $crypt->decrypt($encrypted, $key);
}
```

<a name='options'></a>

## Opciones de encriptado

Las siguientes opciones están disponibles para cambiar el comportamiento de cifrado:

| Nombre | Descripción                                                                                                                                                                     |
| ------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | Cipher es uno de los algoritmos de encriptación soportados por openssl. Usted puede ver una lista [ aquí](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Ejemplo:

```php
<?php

use Phalcon\Crypt;

// Creamos la instancia
$crypt = new Crypt();

// Usamos blowfish
$crypt->setCipher('bf-cbc');

$key  = 'La llave secreta';
$text = 'Este es el texto secreto';

echo $crypt->encrypt($text, $key);
```

<a name='base64'></a>

## Soporte Base64

Para que el cifrado se transmita correctamente (correos electrónicos) o se muestre (navegadores), generalmente se aplica el cifrado [base64](http://www.php.net/manual/en/function.base64-encode.php) a textos:

```php
<?php

use Phalcon\Crypt;

// Creamos la instancia
$crypt = new Crypt();

$key  = 'La llave secreta';
$text = 'El texto secreto que queremos ocultar';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Configurando el servicio de encriptación

Puede configurar el componente de encriptación en un contenedor de servicios para su uso desde cualquier parte de la aplicación:

```php
<?php

use Phalcon\Crypt;

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // Clave de seguridad global
        $crypt->setKey(
            '%31.1e$i86e$f!8jz'
        );

        return $crypt;
    },
    true
);
```

Entonces, por ejemplo, en un controller usted puede utilizarlo de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Controller;

class SecretsController extends Controller
{
    public function saveAction()
    {
        $secret = new Secrets();

        $text = $this->request->getPost('text');

        $secret->content = $this->crypt->encrypt($text);

        if ($secret->save()) {
            $this->flash->success(
                '¡Secreto creado correctamente!'
            );
        }
    }
}
```

<a name='links'></a>

## Enlaces

- [Estándar de cifrado avanzado (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
- [Qué es el bloque Cipher](https://en.wikipedia.org/wiki/Block_cipher)
- [Introducción a Blowfish](http://www.splashdata.com/splashid/blowfish.htm)