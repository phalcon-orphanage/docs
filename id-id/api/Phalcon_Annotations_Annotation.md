---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

Mewakili anotasi tunggal dalam koleksi anotasi

## Metode

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

publik **getNama** ()

Mengembalikan nama anotasi

publik *campuran* **mendapatkanEkspresi** (*susunan* $expr)

Mengatasi ekspresi anotasi

publik *susunan* **mendapatkanExprArgumen** ()

Kembali ekspresi argumen tanpa menyelesaikan

public *array* **getArguments** ()

Mengembalikan argumen ekspresi

public **numberArguments** ()

Mengembalikan jumlah argumen yang anotasi

publik *campuran* **mendapatkanArgument** (*int* | *tali* $position)

Kembali sebuah argumen di posisi tertentu

publik *boolean* **telahArgumen** (*int* | *tali* $position)

Kembali sebuah argumen di posisi tertentu

publik *campuran* **mendapatkanBernamaArgumen** (*campuran* $name)

Mengembalikan argumen yang bernama

public *mixed* **getNamedParameter** (*dicampur* $name)

Mengembalikan argumen yang bernama