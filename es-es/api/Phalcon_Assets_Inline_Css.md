* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Assets\Inline\Css'

* * *

# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](/3.4/en/api/Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/assets/inline/css.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Representa un CSS en línea

## Métodos

public **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline\Css Constructor

public *string* **getType** () inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Gets the resource's type.

public *string* **getContent** () inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Gets the content.

public *boolean* **getFilter** () inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Gets if the resource must be filtered or not.

public *array* **getAttributes** () inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Gets extra HTML attributes.

public [*self*](/3.4/en/api/Phalcon_Assets_Inline_Css) **setType** (*string* $type) inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Establece el tipo "en línea"

public [*self*](/3.4/en/api/Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Establece si el recurso debe ser filtrado o no

public [*self*](/3.4/en/api/Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Establece los atributos HTML extras

public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](/3.4/en/api/Phalcon_Assets_Inline)

Obtiene la llave del recurso.