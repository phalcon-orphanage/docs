# Clase **Phalcon\\Tag**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/tag.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

La clase Phalcon\\Tag está diseñada para simplificar la construcción de etiquetas HTML. Proporciona un conjunto de ayudantes para generar HTML de forma dinámica. Este componente es una clase abstracta que se puede ampliar para agregar más ayudantes.

## Constantes

*integer* **HTML32**

*integer* **HTML401_STRICT**

*integer* **HTML401_TRANSITIONAL**

*integer* **HTML401_FRAMESET**

*integer* **HTML5**

*integer* **XHTML10_STRICT**

*integer* **XHTML10_TRANSITIONAL**

*integer* **XHTML10_FRAMESET**

*integer* **XHTML11**

*integer* **XHTML20**

*integer* **XHTML5**

## Métodos

public static *EscaperInterface* **getEscaper** (*array* $params)

Obtiene el servicio 'escaper' si es necesario

public static **renderAttributes** (*mixed* $code, *array* $attributes)

Construye parámetros manteniendo el orden en sus atributos HTML

public static **setDI** ([Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector)

Define el contenedor del inyector de dependencias.

public static **getDI** ()

Internamente obtiene el despachador de solicitudes

public static **getUrlService** ()

Devuelve un servicio de URL del DI predeterminado

public static **getEscaperService** ()

Devuelve un servicio de Escaper del DI predeterminado

public static **setAutoescape** (*mixed* $autoescape)

Establece el modo autoescape en el HTML generado

public static **setDefault** (*string* $id, *string* $value)

Asigna valores predeterminados a las etiquetas generadas por ayudantes

```php
<?php

// Asignando "peter" al componente "name"
Phalcon\Tag::setDefault("name", "peter");

// Después en la vista
echo Phalcon\Tag::textField("name"); // tendrá el valor "peter" como valor predeterminado

```

public static **setDefaults** (*array* $values, [*mixed* $merge])

Asigna valores predeterminados a las etiquetas generadas por los ayudantes

```php
<?php

// Asignando "peter" al componente "name"
Phalcon\Tag::setDefaults(
    [
        "name" => "peter",
    ]
);

// Después en la vista
echo Phalcon\Tag::textField("name"); // tendrá el valor "peter" como valor predeterminado

```

public static **displayTo** (*string* $id, *string* $value)

Alias de Phalcon\\Tag::setDefault

public static *boolean* **hasValue** (*string* $name)

Comprueba si un ayudante tiene un valor predeterminado que se configuró utilizando Phalcon\\Tag::setDefault o el valor desde $_POST

public static *mixed* **getValue** (*string* $name, [*array* $params])

Todos los ayudantes llaman a esta función para verificar si un componente tiene un valor predefinido mediante Phalcon\\Tag::setDefault o por un valor desde $_POST

public static **resetInput** ()

Restablece los valores solicitados y los valores internos para evitar que los campos tengan cualquier valor por defecto.

public static **linkTo** (*array* | *string* $parameters, [*string* $text], [*boolean* $local])

Construye un etiqueta HTML A usando convenciones del framework

```php
<?php

echo Phalcon\Tag::linkTo("signup/register", "Registrarse aquí!");

echo Phalcon\Tag::linkTo(
    [
        "signup/register",
        "Registrarse aquí!"
    ]
);

echo Phalcon\Tag::linkTo(
    [
        "signup/register",
        "Registrarse aquí!",
        "class" => "btn-primary",
    ]
);

echo Phalcon\Tag::linkTo("http://phalconphp.com/", "Phalcon", false);

echo Phalcon\Tag::linkTo(
    [
        "http://phalconphp.com/",
        "Phalcon Página Principal",
        false,
    ]
);

echo Phalcon\Tag::linkTo(
    [
        "http://phalconphp.com/",
        "Phalcon Página Principal",
        "local" => false,
    ]
);

echo Phalcon\Tag::linkTo(
    [
        "action" => "http://phalconphp.com/",
        "text"   => "Phalcon Página Principal",
        "local"  => false,
        "target" => "_new"
    ]
);

```

final protected static *string* **_inputField** (*string* $type, *array* $parameters, [*boolean* $asValue])

Construye etiquetas INPUT genéricas

final protected static *string* **_inputFieldChecked** (*string* $type, *array* $parameters)

Construye etiquetas INPUT que implementan el atributo checked

public static *string* **colorField** (*array* $parameters)

Construye una etiqueta input[type="color"] de HTML

public static *string* **textField** (*array* $parameters)

Construye una etiqueta input[type="text"] de HTML

```php
<?php

echo Phalcon\Tag::textField(
    [
        "name",
        "size" => 30,
    ]
);

```

public static *string* **numericField** (*array* $parameters)

Construye una etiqueta input[type="number"] de HTML

```php
<?php

echo Phalcon\Tag::numericField(
    [
        "price",
        "min" => "1",
        "max" => "5",
    ]
);

```

public static *string* **rangeField** (*array* $parameters)

Construye una etiqueta input[type="range"] de HTML

public static *string* **emailField** (*array* $parameters)

Construye una etiqueta input[type="email"] de HTML

```php
<?php

echo Phalcon\Tag::emailField("email");

```

public static *string* **dateField** (*array* $parameters)

Construye una etiqueta input[type="date"] de HTML

```php
<?php

echo Phalcon\Tag::dateField(
    [
        "born",
        "value" => "14-12-1980",
    ]
);

```

public static *string* **dateTimeField** (*array* $parameters)

Construye una etiqueta input[type="datetime"] de HTML

public static *string* **dateTimeLocalField** (*array* $parameters)

Construye una etiqueta input[type="datetime-local"] de HTML

public static *string* **monthField** (*array* $parameters)

Construye una etiqueta input[type="month"] de HTML

public static *string* **timeField** (*array* $parameters)

Construye una etiqueta Input[type="time"] de HTML

public static *string* **weekField** (*array* $parameters)

Construye una etiqueta input[type="week"] de HTML

public static *string* **passwordField** (*array* $parameters)

Construye una etiqueta Input[type="password"] de HTML

```php
<?php

echo Phalcon\Tag::passwordField(
    [
        "name",
        "size" => 30,
    ]
);

```

public static *string* **hiddenField** (*array* $parameters)

Construye una etiqueta Input[type="hidden"] de HTML

```php
<?php

echo Phalcon\Tag::hiddenField(
    [
        "name",
        "value" => "mike",
    ]
);

```

public static *string* **fileField** (*array* $parameters)

Construye una etiqueta Input[type="file"] de HTML

```php
<?php

echo Phalcon\Tag::fileField("file");

```

public static *string* **searchField** (*array* $parameters)

Construye una etiqueta Input[type="search"] de HTML

public static *string* **telField** (*array* $parameters)

Construye una etiqueta input[type="tel"] de HTML

public static *string* **urlField** (*array* $parameters)

Construye una etiqueta input[type="url"] de HTML

public static *string* **checkField** (*array* $parameters)

Construye una etiqueta input[type="check"] de HTML

```php
<?php

echo Phalcon\Tag::checkField(
    [
        "terms",
        "value" => "Y",
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ check_field("terms") }}

```

public static *string* **radioField** (*array* $parameters)

Construye una etiqueta Input[type="radio"] de HTML

```php
<?php

echo Phalcon\Tag::radioField(
    [
        "weather",
        "value" => "hot",
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ radio_field("Save") }}

```

public static *string* **imageInput** (*array* $parameters)

Construye una etiqueta Input[type="image"] de HTML

```php
<?php

echo Phalcon\Tag::imageInput(
    [
        "src" => "/img/button.png",
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ image_input("src": "/img/button.png") }}

```

public static *string* **submitButton** (*array* $parameters)

Construye una etiqueta input[type="submit"] de HTML

```php
<?php

echo Phalcon\Tag::submitButton("Guardar")

```

Sintaxis Volt:

```php
<?php

{{ submit_button("Guardar") }}

```

public static *string* **selectStatic** (*array* $parameters, [*array* $data])

Construye una etiqueta SELECT de HTML usando un array de PHP para las opciones

```php
<?php

echo Phalcon\Tag::selectStatic(
    "status",
    [
        "A" => "Activo",
        "I" => "Inactivo",
    ]
);

```

public static *string* **select** (*array* $parameters, [*array* $data])

Construye una etiqueta SELECT de HTML usando un conjunto de resultados de Phalcon\\Mvc\\Model para las opciones

```php
<?php

echo Phalcon\Tag::select(
    [
        "robotId",
        Robots::find("type = "mechanical""),
        "using" => ["id", "name"],
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ select("robotId", robots, "using": ["id", "name"]) }}

```

public static *string* **textArea** (*array* $parameters)

Construye una etiqueta TEXTAREA de HTML

```php
<?php

echo Phalcon\Tag::textArea(
    [
        "comments",
        "cols" => 10,
        "rows" => 4,
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ text_area("comments", "cols": 10, "rows": 4) }}

```

public static *string* **form** (*array* $parameters)

Construye una etiqueta FORM de HTML

```php
<?php

echo Phalcon\Tag::form("posts/save");

echo Phalcon\Tag::form(
    [
        "posts/save",
        "method" => "post",
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ form("posts/save") }}
{{ form("posts/save", "method": "post") }}

```

public static **endForm** ()

Construye una etiqueta HTML para cerrar una etiqueta FORM

public static **setTitle** (*mixed* $title)

Establece el título del contenido vizualizado

```php
<?php

Phalcon\Tag::setTitle("Bienvenido a mi Página");

```

public static **setTitleSeparator** (*mixed* $titleSeparator)

Establece el separador de título del contenido vizualizado

```php
<?php

Phalcon\Tag::setTitleSeparator("-");

```

public static **appendTitle** (*mixed* $title)

Añade al final del título un texto para título del documento actual

public static **prependTitle** (*mixed* $title)

Antepone un texto al título del documento actual

public static **getTitle** ([*mixed* $tags])

Obtiene el título del documento actual. El titulo será automáticamente limpiado (escaped)

```php
<?php

echo Phalcon\Tag::getTitle();

```

```php
<?php

{{ get_title() }}

```

public static **getTitleSeparator** ()

Obtiene el separador de título del documento actual

```php
<?php

echo Phalcon\Tag::getTitleSeparator();

```

```php
<?php

{{ get_title_separator() }}

```

public static *string* **stylesheetLink** ([*array* $parameters], [*boolean* $local])

Construye una etiqueta LINK[rel="stylesheet"]

```php
<?php

echo Phalcon\Tag::stylesheetLink("http://fonts.googleapis.com/css?family=Rosario", false);
echo Phalcon\Tag::stylesheetLink("css/style.css");

```

Sintaxis Volt:

```php
<?php

{{ stylesheet_link("http://fonts.googleapis.com/css?family=Rosario", false) }}
{{ stylesheet_link("css/style.css") }}

```

public static *string* **javascriptInclude** ([*array* $parameters], [*boolean* $local])

Construye una etiqueta SCRIPT[ype = "javascript"]

```php
<?php

echo Phalcon\Tag::javascriptInclude("http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js", false);
echo Phalcon\Tag::javascriptInclude("javascript/jquery.js");

```

Sintaxis Volt:

```php
<?php

{{ javascript_include("http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js", false) }}
{{ javascript_include("javascript/jquery.js") }}

```

public static *string* **image** ([*array* $parameters], [*boolean* $local])

Construye etiquetas IMG de HTML

```php
<?php

echo Phalcon\Tag::image("img/bg.png");

echo Phalcon\Tag::image(
    [
        "img/photo.jpg",
        "alt" => "Alguna foto",
    ]
);

```

Sintaxis Volt:

```php
<?php

{{ image("img/bg.png") }}
{{ image("img/photo.jpg", "alt": "Alguna foto") }}
{{ image("http://static.mywebsite.com/img/bg.png", false) }}

```

public static **friendlyTitle** (*mixed* $text, [*mixed* $separator], [*mixed* $lowercase], [*mixed* $replace])

Convierte textos en títulos URL-friendly

```php
<?php

echo Phalcon\Tag::friendlyTitle("Estas son noticias importantes", "-")

```

public static **setDocType** (*mixed* $doctype)

Establece el tipo del documento de contenido

public static **getDocType** ()

Obtener la declaración de tipo del documento de contenido

public static **tagHtml** (*mixed* $tagName, [*mixed* $parameters], [*mixed* $selfClose], [*mixed* $onlyStart], [*mixed* $useEol])

Construye una etiqueta HTML

public static **tagHtmlClose** (*mixed* $tagName, [*mixed* $useEol])

Construye una etiqueta HTML de cierre

```php
<?php

echo Phalcon\Tag::tagHtmlClose("script", true);

```