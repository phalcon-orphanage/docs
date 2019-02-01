---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Assets\Inline\Css'
---
# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/css.zep)

Representa un CSS en línea

## Métodos

public **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline\Css Constructor

public *string* **getType** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets the resource's type.

public *string* **getContent** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets the content.

public *boolean* **getFilter** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets if the resource must be filtered or not.

public *array* **getAttributes** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets extra HTML attributes.

public [*self*](Phalcon_Assets_Inline_Css) **setType** (*string* $type) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Establece el tipo de activo en línea

public [*self*](Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Establece si el recurso debe ser filtrado o no

public [*self*](Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Establece los atributos HTML extras

public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Obtiene la llave del recurso.