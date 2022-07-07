---
layout: default
language: 'es-es'
version: '5.0'
title: 'Traducciones'
keywords: 'traducir, traducciones, adaptadores de traducción, vector nativo, csv, gettest'
---

# Componente de traducción
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
The component [Phalcon\Translate][translate] offers multilingual capabilities to applications. Este componente le permite mostrar contenido en diferentes idiomas, basado en la elección de idioma del usuario, disponible en la aplicación.

## Uso
Introducir traducciones en su aplicación es una tarea relativamente fácil. Sin embargo, no hay dos implementaciones iguales, y por supuesto la implementación dependerá de las necesidades de su aplicación. Some of the options available can be an automatic detection of the visitor's language using the server headers (parsing the `HTTP_ACCEPT_LANGUAGE` contents or using the `getBestLanguage()` method of the [Phalcon\Http\Request][request] object).

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

/**
 * @property Phalcon\Http\Request $request
 * @property Phalcon\Mvc\View     $view
 */
class UserController extends Controller
{

    public function indexAction()
    {
        $this->view->name = 'Mike';
        $this->view->t    = $this->getTranslator();
    }

    /**
     * @return NativeArray
     */
    private function getTranslator(): NativeArray
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = 'app/messages/en.php';
        }

        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);

        return $factory->newInstance(
            'array',
            [
                'content' => $messages,
            ]
        );
    }
}
```

El método `getTranslator()` está disponible en el controlador para todas las acciones que lo requieran. Por supuesto, podría introducir un mecanismo de caché para almacenar el adaptador de traducción en el caché (basado en el idioma seleccionado ej. `en.cache`, `de-cache` etc.)

La variable `t` se pasa a la vista, y, con ella, podemos realizar traducciones en la capa de vista.

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

y para Volt:

```twig
<p>{% raw %}{{ t._('hi') }} {{ name }}{% endraw %}</p>
```

### Marcadores de Posición

El método `_()` devolverá la cadena traducida de la clave pasada. En el ejemplo anterior, devolverá el valor almacenado para la clave `hi`. El componente también puede analizar marcadores de posición usando \[interpolation\]\[#interpolation\]. Por lo tanto para una traducción de:

```text
Hello %name%!
```

necesitará pasar la variable `$name` en la llamada `_()` y el componente realizará el reemplazo por usted.

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

y para Volt:

```twig
<p>{% raw %}{{ t._('hi-name', ['name' => name]) }}{% endraw %}</p>
```

### Plugin
La implementación anterior se puede extender para ofrecer capacidades de traducción en toda la aplicación. Por supuesto, podemos mover el método `getTranslator()` a un controlador base y cambiar su visibilidad a `protected`. Sin embargo, podríamos querer usar traducciones en otros componentes que están fuera del alcance de un controlador.

Para solucionar esto, podemos implementar un nuevo componente como un Plugin y registrarlo en nuestro contenedor [Di](di).

```php
<?php

namespace MyApp;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

class Locale extends Injectable
{
    /**
     * @return NativeArray
     */
    public function getTranslator(): NativeArray
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = 'app/messages/en.php';
        }

        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);

        return $factory->newInstance(
            'array',
            [
                'content' => $messages,
            ]
        );
    }
}
```

Entonces podemos registrarlo en el contenedor Di, cuando configuramos los servicios durante el arranque:

```php
<?php

use MyApp\Locale;

$container->set('locale', (new Locale())->getTranslator());
```

Y ahora puede acceder al plugin `Locale` desde sus controladores y desde cualquier lugar que necesite.

```php
<?php

use Phalcon\Mvc\Controller;

/**
 * @property MyApp\Locale $locale
 */
class MyController extends Controller
{
    public function indexAction()
    {
        $name = 'Mike';

        $text = $this->locale->_(
            'hi-name',
            [
                'name' => $name,
            ]
        );

        $this->view->text = $text;
    }
}
```

o en una vista directamente

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

y para Volt:

```twig
<p>{% raw %}{{ locale._('hi-name', ['name' => 'Mike']) }}{% endraw %}</p>
```

### Ruteo
Algunas aplicaciones usan la URL de la petición para distinguir el contenido basado en distintos idiomas, para ayudar con SEO. A sample URL is:
 ```bash
https://mozilla.org/es-ES/firefox/
```

Phalcon can implement this functionality by using a [Router](routing).

## Translate Factory
Loads Translate Adapter class using `adapter` option, the remaining options will be passed to the adapter constructor.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'content' => [
        'hi'  => 'Hello',
        'bye' => 'Good Bye',
    ],
];

$translator = $factory->newInstance('array', $options);
```

## Adaptadores
Este componente hace uso de adaptadores para leer los mensajes de traducción de diferentes fuentes de una forma unificada.

| Adaptador                                               | Descripción                                                         |
| ------------------------------------------------------- | ------------------------------------------------------------------- |
| [Phalcon\Translate\Adapter\NativeArray][nativearray] | Usa vectores PHP para almacenar los mensajes.                       |
| [Phalcon\Translate\Adapter\Csv][csv]                 | Utiliza un archivo `.csv` para almacenar los mensajes de un idioma. |
| [Phalcon\Translate\Adapter\Gettext][gettext]         | Utiliza gettext para recuperar los mensajes de un archivo `.po`.    |

### Vector Nativo
Este adaptador almacena las cadenas traducidas en un vector PHP. Este adaptador es claramente el más rápido ya que las cadenas se almacenan en memoria. Adicionalmente, el hecho de que use vectores PHP facilita el mantenimiento. Las cadenas también se pueden almacenar en ficheros JSON que a su vez se pueden traducir al formato nativo de vector PHP cuando se consultan.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'content' => [
        'hi'  => 'Hello',
        'bye' => 'Good Bye',
    ],
];

$translator = $factory->newInstance('array', $options);
```

El uso recomendado debería ser crear un fichero por idioma y almacenarlo en el sistema de ficheros. Después de eso, puede cargar el fichero relevante, basado en el idioma seleccionado. Una estructura de ejemplo puede ser:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```
o en formato JSON
```bash
app/messages/en.json
app/messages/es.json
app/messages/fr.json
app/messages/zh.json
```
Cada fichero contiene vectores PHP, donde la clave es la clave de la cadena traducida y el valor del mensaje traducido. Cada fichero contiene las mismas claves pero los valores son, por supuesto, el mensaje traducido en el idioma correspondiente.

```php
<?php

// app/messages/en.php
$messages = [
    'hi'      => 'Hello',
    'bye'     => 'Good Bye',
    'hi-name' => 'Hello %name%',
    'song'    => 'This song is %song%',
];
```

```php
<?php

// app/messages/fr.php
$messages = [
    'hi'      => 'Bonjour',
    'bye'     => 'Au revoir',
    'hi-name' => 'Bonjour %name%',
    'song'    => 'La chanson est %song%',
];
```
Crear este adaptador se puede conseguir usando la [Fábrica de Traducción](#translate-factory), pero lo puede instanciar directamente:
```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\Adapter\NativeArray;

$interpolator = new InterpolatorFactory();
$options      = [
    'content' => [
        'hi'  => 'Hello',
        'bye' => 'Good Bye',
    ],
];

$translator = new NativeArray($interpolator, $options);
```

**No Encontrado**

Si se pasa la opción `triggerError` y se establece a `true` entonces el método `notFound()` se llamará cuando una clave no se encuentre. El método lanzará un error.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'content'      => [
        'hi'  => 'Hello',
        'bye' => 'Good Bye',
    ],
    'triggerError' => true,
];

$translator = $factory->newInstance('array', $options);

echo $translator->query('unknown');
```

El código anterior lanzará un error cuando intentemos acceder a una entrada `desconocida`.

### Csv
Si sus cadenas de traducción se almacenan en un fichero `.csv`. The [Phalcon\Translate\Adapter\Csv][csv] adapter accepts the interpolator factory and an array with options necessary for loading the translations. El vector de opciones acepta:
- `content`: The location of the CSV file on the file system
- `delimiter`: The delimiter the CSV file uses (optional - defaults to `;`)
- `enclosure`: The character that surrounds the text (optional - defaults to `"`)

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

// `sample-key`|`sample-translated-text`
$options = [
    'content'   => '/path/to/translation-file.csv',
    'delimiter' => '|',
    'enclosure' => '`',
];

$translator = $factory->newInstance('csv', $options);
```

En el ejemplo anterior puede ver el uso de `delimiter` y `enclosure`. En la mayoría de casos no necesitará proporcionar estas opciones pero en caso de que sus ficheros CSV sean algo diferentes, tiene la opción de indicar al adaptador cómo debe analizar los contenidos del fichero de traducción.

Crear este adaptador se puede conseguir usando la [Fábrica de Traducción](#translate-factory), pero lo puede instanciar directamente:
```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\Adapter\Csv;

$interpolator = new InterpolatorFactory();
$options      = [
    'content'   => '/path/to/translation-file.csv',
    'delimiter' => '|',
    'enclosure' => '`',
];

$translator = new Csv($interpolator, $options);
```

### Gettext

> **NOTE**: This adapter **requires** the [gettext][php-gettext] PHP extension. Please make sure that your system has it installed so that you can take advantage of this adapter's functionality 
> 
> {: .alert .alert-warning }

The [gettext][wiki-gettext] format has been around for years and many applications are using it because it has become a standard and it is easy to use. The translations are stored in `.po` and `.mo` files, and content can be easily added or changed using online editors or tools such as [POEdit][poedit]. Este adaptador requiere que los fichero estén en carpetas específicas para poder localizar los ficheros de traducción. El vector de opciones acepta:

- `locale`: El *locale* del idioma que necesita
- `defaultDomain`: El dominio para los ficheros. Este es el nombre actual de los ficheros. Ambos ficheros `po` y `mo` deben tener el mismo nombre.
- `directory`: El directorio donde se encuentran los ficheros de traducción
- `category`: Una variable PHP `LC*` que define la categoría que se debería usar. Esto mapea a una carpeta (como se ve a continuación en el ejemplo de estructura de directorios).

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
];

$translator = $factory->newInstance('gettext', $options);
```

Una estructura de directorios de ejemplo para los ficheros de traducción es:

```bash
translations/
    en_US.UTF-8/
        LC_MESSAGES/
            translations.mo
            translations.po
    de_DE.UTF-8
        LC_MESSAGES/
            translations.mo
            translations.po
```

Crear este adaptador se puede conseguir usando la [Fábrica de Traducción](#translate-factory), pero lo puede instanciar directamente:
```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\Adapter\Gettext;

$interpolator = new InterpolatorFactory();
$options      = [
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
];

$translator = new Gettext($interpolator, $options);
```



## Personalizado
The [Phalcon\Translate\Adapter\AdapterInterface][adapterinterface] interface must be implemented in order to create your own translate adapters or extend the existing ones:

```php
<?php

use Phalcon\Translate\Adapter\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param  string $translateKey
     * @param  array  $placeholders
     * 
     * @return string
     */
    public function t(string $translateKey, array $placeholders = []);

    /**
     * @param   string $translateKey
     * @param   array  $placeholders
     * 
     * @return  string
     */
    public function _(
        string $translateKey, 
        array $placeholders = []
    ): string;

    /**
     * @param   string $index
     * @param   array  $placeholders
     * 
     * @return  string
     */
    public function query(string $index, array $placeholders = []): string;

    /**
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

There are more adapters available for this components in the [Phalcon Incubator][incubator]

## Interpolación
En muchos casos, las cadenas traducidas se necesitan con datos. Con la interpolación puede inyectar una variable desde su código al mensaje traducido en un lugar específico. El marcador de posición en el mensaje está encerrado entre caracteres `%`.

```text
Hello %name, good %time%!
Salut %name%, bien %time%!
```

Suponiendo que el contexto no cambiará basado en las cadenas de cada idioma, puede añadir estos marcadores de posición a sus cadenas traducidas. Entonces, el componente `Translate` con sus adaptadores realizará correctamente la interpolación por tí.

### Cambiar el Interpolador
Para cambiar el interpolador que usa su adaptador, todo lo que tiene que hacer es pasar el nombre del interpolador en las opciones usando la clave `defaultInterpolator`.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'defaultInterpolator' => 'indexedArray',
    'content'             => [
        'hi-name' => 'Hello %1$s, it\'s %2$d o\'clock',
    ],
];

$translator = $factory->newInstance('array', $options);
```

### AssociatedArray
[Phalcon\Translate\Interpolator\AssociativeArray][associativearray] is the default interpolator. Le permite realizar un reemplazo de clave/valor de los marcadores de posición.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'content' => [
        'hi-name' => 'Hello %name%, good %time% !',
    ],
];

$translator = $factory->newInstance('array', $options);

$name = 'Henry';

$translator->_(
    'hi-name',
    [
        'name' => $name,
        'time' => 'day',
    ]
); // Hello Henry, good day !

$translator->_(
    'hi-name',
    [
        'name' => $name,
        'time' => 'night',
    ]
); // Hello Henry, good night !
```

### IndexedArray
[Phalcon\Translate\Interpolator\IndexedArray][indexedarray] is another option that you can use as the interpolator. This interpolator follows the [sprintf][sprintf] convention.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$options = [
    'defaultInterpolator' => 'indexedArray',
    'content'             => [
        'hi-name' => 'Hello %1$s, it\'s %2$d o\'clock',
    ],
];

$translator = $factory->newInstance('array', $options);

$name = 'Henry';

$translator->_(
    'hi-name',
    [
        $name,
        8,
    ]
); // Hello Henry, it's 8 o'clock
```

### Interpoladores Personalizados
The [Phalcon\Translate\Interpolator\InterpolatorInterface][interpolatorinterface] interface must be implemented in order to create your own interpolators or extend the existing ones:

### Fábrica de Interpoladores
The [Phalcon\Translate\InterpolatorFactory][interpolatorfactory] factory offers an easy way to create interpolators. Es un objeto requerido para pasar a los adaptadores y fábrica de traducción, para que a su vez pueda crear la clase de interpolación relevante que usará el adaptador.

```php
<?php

use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

$interpolator = new InterpolatorFactory();
$factory      = new TranslateFactory($interpolator);

$translator = $factory->newInstance(
    'array',
    [
        'content' => [
            'hi'  => 'Hello',
            'bye' => 'Good Bye',
        ],
    ]
);
```

[adapterinterface]: api/phalcon_translate#translate-adapter-adapterinterface
[associativearray]: api/phalcon_translate#translate-interpolator-associativearray
[csv]: api/phalcon_translate#translate-adapter-csv
[gettext]: api/phalcon_translate#translate-adapter-gettext
[incubator]: https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter
[indexedarray]: api/phalcon_translate#translate-interpolator-indexedarray
[interpolatorinterface]: api/phalcon_translate#translate-interpolator-interpolatorinterface
[interpolatorfactory]: api/phalcon_translate#translate-interpolatorfactory
[nativearray]: api/phalcon_translate#translate-adapter-nativearray
[php-gettext]: https://www.php.net/manual/book.gettext.php
[poedit]: https://poedit.net/
[request]: api/phalcon_http#request
[sprintf]: https://www.php.net/manual/en/function.sprintf.php
[translate]: api/phalcon_translate
[wiki-gettext]: https://en.wikipedia.org/wiki/Gettext
