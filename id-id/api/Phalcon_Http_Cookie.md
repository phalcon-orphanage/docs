---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookie.zep)

Berikan bungkus OO untuk mengelola cookie HTTP

## Metode

public **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

Menetapkan nilai cookie

public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

Kembali cookie nilai

publik **kirim** ()

Mengirimkan cookie ke klien HTTP Menyimpan definisi cookie dalam sesi

publik **mengembalikan** ()

Membaca info terkait cookie dari SESI untuk mengembalikan kuki seperti yang ditetapkan Metode ini secara otomatis dipanggil secara internal sehingga biasanya Anda tidak perlu menyebutnya

public **delete** ()

Menghapus kuki dengan menetapkan waktu berakhir di masa lalu

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Menetapkan apakah cookie harus dienkripsi / didekripsi secara otomatis

public **isUsingEncryption** ()

Periksa apakah cookie menggunakan enkripsi implisit

public **setExpiration** (*mixed* $expire)

Mengatur waktu kadaluarsa cookie

public **getExpiration** ()

Mengatur waktu kadaluarsa cookie

public **setPath** (*mixed* $path)

Mengatur waktu kadaluarsa cookie

publik **getNama** ()

Mengembalikan nama cookie saat ini

public **getPath** ()

Mengembalikan nama cookie saat ini

public **setDomain** (*mixed* $domain)

Tentukan domain tempat kuki yang tersedia untuk

public **getDomain** ()

Tentukan domain tempat kuki yang tersedia untuk

public **setSecure** (*mixed* $secure)

Set jika cookie harus hanya dikirim Bila sambungan aman (HTTPS)

public **getSecure** ()

Set jika cookie harus hanya dikirim Bila sambungan aman (HTTPS)

public **setHttpOnly** (*mixed* $httpOnly)

Set jika cookie ini hanya dapat diakses melalui protokol HTTP

public **getHttpOnly** ()

Mengembalikan jika cookie hanya dapat diakses melalui protokol HTTP

publik **__keString** ()

Sihir __toString metode mengkonversi nilai cookie ke string