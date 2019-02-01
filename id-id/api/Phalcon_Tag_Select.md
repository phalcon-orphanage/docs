---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Tag\Select'
---
# Abstract class **Phalcon\Tag\Select**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/tag/select.zep)

Generates a SELECT html tag using a static array of values or a Phalcon\Mvc\Model resultset

## Metode

public static **selectField** (*array* $parameters, [*array* $data])

Menghasilkan MEMILIH menandai

private static **_optionsFromResultset** ([Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset) $resultset, *array* $using, *mixed* $value, *string* $closeOption)

Hasilkan PILIHAN menandai berdasarkan hasil

private static **_optionsFromArray** (*array* $data, *mixed* $value, *string* $closeOption)

Menghasilkan PILIHAN menandai berdasarkan sebuah susunan