---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Security'
---
# Class **Phalcon\Security**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/security.zep)

Komponen ini menyediakan sebuah set berfungsi untuk meningkatkan keamanan dalam Phalcon aplikasi

```php
<?php

$login    = $this->request->getPost("login");
$password = $this->request->getPost("password");

$user = Users::findFirstByLogin($login);

if ($user) {
    if ($this->security->checkHash($password, $user->password)) {
        // The password is valid
    }
}

```

## Constants

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

## Metode

public **setWorkFactor** (*mixed* $workFactor)

...

public **getWorkFactor** ()

...

publik **__membangun** ()

Phalcon\Security constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setRandomBytes** (*mixed* $randomBytes)

Mengatur sebuah angka dari byte yang akan dihasilkan oleh generator openssl pseudo generator acak

public **getRandomBytes** ()

Mengembalikan sebuah angka dari byte untuk bisa dihasilkan oleh openssl pseudo generator acak

public **getRandom** ()

Mengembalikan sebuah contoh generator bilangan acak yang aman

public **getSaltBytes** ([*mixed* $numberBytes])

Buatlah string pseudo acak 22> untuk digunakan sebagai garam untuk kata kunci

public **hash** (*mixed* $password, [*mixed* $workFactor])

Membuat sebuah kata kunci campuran menggunakan bcrypt dengan sebuah garam pseudo acak

public **checkHash** (*mixed* $password, *mixed* $passwordHash, [*mixed* $maxPassLength])

Memeriksa sebuah kata sandi teks polos dan versi campurannya untuk memeriksa apakah kata sandi cocok

public **isLegacyHash** (*mixed* $passwordHash)

Memeriksa apakah campuran kata sandi itu adalah campuran bcrypt's yang valid

public **getTokenKey** ()

Menghasilkan sebuah token kunci acak pseudo untuk bisa digunakan sebagai nama masukan dalam memeriksa CSRF

public **getToken** ()

Menghasilkan sebuah nilai acak token pseudo untuk bisa digunakan sebagai nilai masukan dalam memeriksa CSRF

public **checkToken** ([*mixed* $tokenKey], [*mixed* $tokenValue], [*mixed* $destroyIfValid])

Memeriksa apakah token dikirim dalam permintaannya sama dengan yang ada saat ini pada sesi

public **getSessionToken** ()

Mengembalikan nilainya dari token CSRF pada sesi

public **destroyToken** ()

Menghapus nilanya dari token CSRF dan kunci dari sesi

public **computeHmac** (*mixed* $data, *mixed* $key, *mixed* $algo, [*mixed* $raw])

Menghitung HMAC

public **setDefaultHash** (*mixed* $defaultHash)

Menetapkan hash default

public **getDefaultHash** ()

Mengembalikan hash default

public **hasLibreSsl** ()

Pengujian untuk LibreSSL

public **getSslVersionNumber** ()

Mendapatkan versi OpenSSL atau LibreSSL Parse OPENSSL_VERSION_TEXT karena OPENSSL_VERSION_NUMBER tidak digunakan untuk LibreSSL.

```php
<?php

if ($security->getSslVersionNumber() >= 20105) {
    // ...
}

```