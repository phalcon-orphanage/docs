---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Response\Cookies'
---
# Class **Phalcon\Http\Response\Cookies**

*implements* [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/cookies.zep)

Kelas ini adalah tas untuk mengelola kue. Kue cookies secara otomatis terdaftar sebagai bagian dari layanan 'tanggapan' di DI

## Metode

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Atur jika cookies di dalam tas harus secara otomatis dienkripsi / didekripsi

public **isUsingEncryption** ()

Mengembalikan jika tas secara otomatis mengenkripsi / mendekripsi kuki

publik **set** (*mixed* $name, [*mixed* $value], [*mixed* $expire], [*mixed* $path], [*mixed* $secure], [*mixed* $domain], [*mixed* $httpOnly])

Menetapkan kuki yang akan dikirim pada akhir permintaan Metode ini menggantikan perintah cookie sebelumnya dengan nama yang sama

public **get** (*mixed* $name)

Mendapatkan kue dari tas

publik **telah** (*campuran* $name)

Periksa apakah kuki didefinisikan di tas atau ada di superglobal _COOKIE

publik **delete** (*mixed* $name)

Menghapus cookie dengan namanya Metode ini tidak menghilangkan cookies dari superglobal _COOKIE

publik **kirim** ()

Mengirimkan cookies ke klien Cookie tidak dikirim jika header dikirim dalam permintaan saat ini

umum **reset** ()

Setel ulang set cookies