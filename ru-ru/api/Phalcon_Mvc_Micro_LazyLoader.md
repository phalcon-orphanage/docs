---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Mvc\Micro\LazyLoader'
---
# Class **Phalcon\Mvc\Micro\LazyLoader**

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/lazyloader.zep)

Загрузка обработчиков по требованию для Mvc\Micro используя автозагрузку

## Методы

public **getDefinition** ()

...

public **__construct** (*mixed* $definition)

Phalcon\Mvc\Micro\LazyLoader constructor

public *mixed* **__call** (*string* $method, *array* $arguments)

Инициализирует внутренний обработчик, вызывая функции в нем

public *mixed* **callMethod** (*string* $method, *array* $arguments, [[Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder])

Calling __call method