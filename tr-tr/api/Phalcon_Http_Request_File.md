---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Http\Request\File'
---
# Class **Phalcon\Http\Request\File**

*implements* [Phalcon\Http\Request\FileInterface](Phalcon_Http_Request_FileInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request/file.zep)

Provides OO wrappers to the $_FILES superglobal

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

## Metodlar

public **getError** ()

public **getKey** ()

public **getExtension** ()

public **__construct** (*array* $file, [*mixed* $key])

Phalcon\Http\Request\File constructor

public **getSize** ()

Yüklenen dosyanın dosya boyutunu döndürür

herkese açık ** isim al** ()

Yüklenen dosyanın gerçek adını döndürür

public **getTempName** ()

Yüklenen dosyanın geçici adını döndürür

genel **getType** ()

Tarayıcı tarafından bildirilen mime türünü geri getirir. Bu mime türü tamamen güvenli değildir, bunun yerine getRealType() kullanın

public **getRealType** ()

Finfo kullanarak yükleme dosyasının gerçek mime türünü alır

public **isUploadedFile** ()

Dosyanın Post ile yüklenip yüklenmediğini kontrol eder.

public **moveTo** (*mixed* $destination)

Geçici dosyayı uygulama içindeki bir hedef bölgesine taşır taşır