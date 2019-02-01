---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Assets\Inline\Css'
---
# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline/css.zep)

Represents an inlined CSS

## Methoden

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

Legt den Inline-Typ fest

public [*self*](Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Legt fest, ob die Ressource gefiltert werden muss oder nicht

public [*self*](Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Sets extra HTML attributes

public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gibt den Ressourcenschlüssel zurück.