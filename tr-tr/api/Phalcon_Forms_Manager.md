---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Forms\Manager'
---
# Class **Phalcon\Forms\Manager**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/forms/manager.zep)

## Metodlar

public **create** (*string* $name, [*object* $entity])

Creates a form registering it in the forms manager

public **get** (*mixed* $name)

Bir formu adıyla döndürür

public **has** (*mixed* $name)

Bir formun form yöneticisinde kayıtlı olup olmadığını kontrol eder

public **set** (*mixed* $name, [Phalcon\Forms\Form](Phalcon_Forms_Form) $form)

Form Yöneticisi'ne bir form kaydeder