---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Response\Headers'
---
# Class **Phalcon\Http\Response\Headers**

*implements* [Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/headers.zep)

Kelas ini adalah tas untuk mengelola header respon

## Metode

public **addInherit** (*mixed* $name, *mixed* $value)

Menetapkan header yang akan dikirim pada akhir permintaan

public **get** (*mixed* $name)

Mendapatkan nilai header dari tas internal

publik **telah**(*campuraduk*$header)

Menetapkan header yang akan dikirim pada akhir permintaan

public **baca** (*mixed* $header)

Menetapkan header yang akan dikirim pada akhir permintaan

publik **kirim** ()

Mengirimkan header ke klien

umum **reset** ()

Setel ulang setel header

publik **kunci** ()

Mengembalikan header saat ini sebagai array

public static **__set_state** (*array* $data)

Restore a \Phalcon\Http\Response\Headers object