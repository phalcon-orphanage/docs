---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Security'
---
# Class **Phalcon\Security**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/security.zep)

Este componente provee un conjunto de funciones para mejorar la seguridad en aplicaciones Phalcon

```php
<?php

$login    = $this->request->getPost("login");
$password = $this->request->getPost("password");

$user = Users::findFirstByLogin($login);

if ($user) {
    if ($this->security->checkHash($password, $user->password)) {
        // La contraseña es válida
    }
}

```

## Constantes

*integer* **CRYPT_DEFAULT**

*integer* **CRYPT_STD_DES**

*integer* **CRYPT_EXT_DES**

*integer* **CRYPT_MD5**

*integer* **CRYPT_BLOWFISH**

*integer* **CRYPT_BLOWFISH_A**

*integer* **CRYPT_BLOWFISH_X**

*integer* **CRYPT_BLOWFISH_Y**

*integer* **CRYPT_SHA256**

*integer* **CRYPT_SHA512**

## Métodos

public **setWorkFactor** (*mixed* $workFactor)

...

public **getWorkFactor** ()

...

public **__construct** ()

Phalcon\Security constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setRandomBytes** (*mixed* $randomBytes)

Establece un número de bytes a ser generado por el generador pseudo aleatorio de openssl

public **getRandomBytes** ()

Retorna el número de bytes a ser generado por el generador pseudo aleatorio de openssl

public **getRandom** ()

Devuelve una instancia del generador seguro de números aleatorio

public **getSaltBytes** ([*mixed* $numberBytes])

Generar una cadena pseudo aleatoria de longitud >22-longitud para ser utilizado como sal para contraseñas

public **hash** (*mixed* $password, [*mixed* $workFactor])

Crea un hash de contraseña utilizando bcrypt con una sal pseudo aleatoria

public **checkHash** (*mixed* $password, *mixed* $passwordHash, [*mixed* $maxPassLength])

Comprueba si una contraseña de texto plano y su versión hash coinciden

public **isLegacyHash** (*mixed* $passwordHash)

Comprueba si una contraseña hash es un hash bcrypt válido

public **getTokenKey** ()

Genera un token pseudo aleatorio para ser usando como nombre en inputs en el chequeo de CSRF

public **getToken** ()

Genera un token pseudo aleatorio para ser usando como valor en inputs en el chequeo de CSRF

public **checkToken** ([*mixed* $tokenKey], [*mixed* $tokenValue], [*mixed* $destroyIfValid])

Comprueba si el token CSRF enviado en la consulta es el mismo que el almacenado en la sesión actual

public **getSessionToken** ()

Regresa el valor del token CSRF almacenado en sesión

public **destroyToken** ()

Remueve el valor del token CSTF y la clave de la sesión

public **computeHmac** (*mixed* $data, *mixed* $key, *mixed* $algo, [*mixed* $raw])

Computa un HMAC

public **setDefaultHash** (*mixed* $defaultHash)

Establece el hash por defecto

public **getDefaultHash** ()

Regresa el hash por defecto

public **hasLibreSsl** ()

Probando para LibreSSL

public **getSslVersionNumber** ()

Obtiene la versión de OpenSSL o LibreSSL. Analiza el valor OPENSSL_VERSION_TEXT porque OPENSSL_VERSION_NUMBER no es utilizado por LibreSSL.

```php
<?php

if ($security->getSslVersionNumber() >= 20105) {
    // ...
}

```