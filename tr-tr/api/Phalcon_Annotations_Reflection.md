---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Ek açıklamalar yansımasını OO tarzında manipüle etmeye izin verir

```php
<?php

use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// Parse the annotations in a class
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// Create the reflection
$reflection = new Reflection($parsing);

// Get the annotations in the class docblock
$classAnnotations = $reflection->getClassAnnotations();

```

## Metodlar

herkese açık **__düzenle** ([*dizi* $Yansıma Verileri])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

Docblock sınıfında bulunan açıklamalar döndürür

public **getMethodsAnnotations** ()

Yöntemlerin doküman bloklarında bulunan açıklamalar döndürür

public **getPropertiesAnnotations** ()

Özelliklerin doküman bloklarında bulunan açıklamalarını geri getirir

public *array* **getReflectionData** ()

Yansımayı oluşturmak için kullanılan ham ayrıştırma ara tanımlarını döndürür

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export