---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Assets\Inline\Css'
---
# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/inline/css.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Represents an inlined CSS


## Methods
public  **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

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

Sets the inline's type



public [*self*](Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Sets if the resource must be filtered or not



public [*self*](Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Sets extra HTML attributes



public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

Gets the resource's key.



