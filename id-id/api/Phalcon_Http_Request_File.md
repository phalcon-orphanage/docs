---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Request\File'
---
# Class **Phalcon\Http\Request\File**

*implements* [Phalcon\Http\Request\FileInterface](Phalcon_Http_Request_FileInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request/file.zep)

Menyediakan bungkus OO ke superglobal $_FILES

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
            // Print the real file names and their sizes
            foreach ($this->request->getUploadedFiles() as $file) {
                echo $file->getName(), " ", $file->getSize(), "\n";
            }
       }
    }
}

```

## Metode

umum **getError** ()

public **getKey** ()

umum **getExtension** ()

umum **__construct** (*array* $file, [*mixed* $key])

Phalcon\Http\Request\File constructor

public **getSize** ()

Mengembalikan ukuran berkas dari berkas yang diunggah

publik **getNama** ()

Mengembalikan nama sebenarnya dari berkas yang diunggah

umum **getTempName** ()

Mengembalikan nama sementara dari berkas yang diunggah

publik **berhenti** ()

Mengembalikan jenis mime yang dilaporkan oleh browser Jenis mime ini tidak sepenuhnya aman, gunakan getRealType () sebagai gantinya

umum **getRealType** ()

Mendapat jenis mime sebenarnya dari unggah berkas menggunakan finfo

umum **isUploadedFile** ()

Memeriksa apakah berkas telah diunggah melalui Pos.

umum **moveTo** (*mixed* $destination)

Memindahkan berkas sementara ke tujuan dalam aplikasi