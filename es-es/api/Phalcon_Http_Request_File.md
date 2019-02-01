---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http\Request\File'
---
# Class **Phalcon\Http\Request\File**

*implements* [Phalcon\Http\Request\FileInterface](Phalcon_Http_Request_FileInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request/file.zep)

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

## Métodos

public **getError** ()

public **getKey** ()

public **getExtension** ()

public **__construct** (*array* $file, [*mixed* $key])

Phalcon\Http\Request\File constructor

public **getSize** ()

Devuelve el tamaño del archivo cargado

public **getName** ()

Devuelve el nombre verdadero del archivo cargado

public **getTempName** ()

Devuelve el nombre temporal del archivo cargado

public **getType** ()

Devuelve el tipo mime notificado por el navegador. Este tipo mime no es completamente seguro. Utilice en su lugar getRealType()

public **getRealType** ()

Obtiene el tipo mime verdadero del archivo cargado utilizando finfo

public **isUploadedFile** ()

Comprueba si el archivo ha sido cargado a través de Post.

public **moveTo** (*mixed* $destination)

Mueve el archivo temporal a una ubicación dentro de la aplicación