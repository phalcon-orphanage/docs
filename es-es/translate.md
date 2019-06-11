---
layout: default
language: 'es-es'
version: '4.0'
---

# Componente de traducción

* * *

## Soporte Multidioma

El componente `Phalcon\Translate` ayuda en la creación de aplicaciones multilingües. Aplicaciones que utilizan este componente pueden mostrar el contenido en diferentes idiomas, basados en el idioma elegido por el usuario y soportado por la aplicación.

## Factory (Fábrica)

Carga la clase adaptador de traducción usando la opción `adapter`, las opciones restantes se pasarán al constructor del adaptador.

```php
<?php

use Phalcon\Translate\Factory;

$options = [
    'adapter' => 'nativearray',
    'content' => [
        'hi'  => 'Hello',
        'bye' => 'Good Bye',
    ],
];

$translate = Factory::load($options);
```

## Adaptadores

Este componente hace uso de adaptadores para leer los mensajes de traducción de diferentes fuentes en forma unificada.

| Adaptador                                                                             | Descripción                                                                              |
| ------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------- |
| [Phalcon\Translate\Adapter\NativeArray](api/Phalcon_Translate_Adapter_NativeArray) | Uses PHP arrays to store the messages. Esta es la mejor opción en términos de desempeño. |
| [Phalcon\Translate\Adapter\Csv](api/Phalcon_Translate_Adapter_Csv)                 | Utiliza un archivo `.csv` para almacenar los mensajes de un idioma.                      |
| [Phalcon\Translate\Adapter\Gettext](api/Phalcon_Translate_Adapter_Gettext)         | Utiliza gettext para recuperar los mensajes de un archivo `.po`.                         |

### Native Array

Translation strings are stored in a php array.

La mejor opción con este adaptador es almacenarlas en archivos específicos por idioma, con la libertad de organizarlos de la manera más conveniente. Una estructura simple podría ser:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

Each file contains an array of the translations in a key/value manner. Para cada archivo de traducción, las llaves son únicas. The same array is used in different files, where keys remain the same and values contain the translated strings depending on each language.

```php
<?php

// app/messages/es.php
$messages = [
    'hi'      => 'Hola',
    'bye'     => 'Adi&oacute;s',
    'hi-name' => 'Hola %name%',
    'song'    => 'Esta canci&oacute;n es %song%',
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

An example of loading such a file is provided in the *Component Usage* section.

### Csv

Las cadenas de traducción se almacenan en archivos de formato `.csv`.

```php
<?php

$options = [
    'adapter'   => 'csv',
    'content'   => '/path/to/file.csv',
];

$translate = Factory::load($options);
```

### Gettext

Las cadenas de traducción se almacenan en archivos `.po` y `.mo`. More about it on the [official documentation](https://www.php.net/manual/book.gettext.php). La jerarquía de archivos está vinculada a este estándar.

```php
<?php

$options = [
    'adapter'       => 'gettext',
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
];

$translate = Factory::load($options);
```

## Component Usage

Implementar el mecanismo de traducción en tu aplicación es trivial pero depende de cómo desees aplicarlo. Puedes utilizar la detección automática de idioma desde el navegador del usuario o puede proporcionar una página de configuración donde el usuario puede seleccionar su idioma.

A simple way of detecting the user's language is to parse the `$_SERVER['HTTP_ACCEPT_LANGUAGE']` contents, or if you wish, access it directly by calling `$this->request->getBestLanguage()` from an action/controller:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class UserController extends Controller
{
    protected function getTranslation()
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language . '.php';

        // Check if we have a translation file for that lang or fallback to some default
        if (!file_exists($translationFile)) {
            $translationFile = 'app/messages/en.php';
        }

        require $translationFile;

        // Return a translation object $messages comes from the require
        // statement above
        return new NativeArray(
            [
                'content' => $messages,
            ]
        );
    }

    public function indexAction()
    {
        $this->view->name = 'Mike';
        $this->view->t    = $this->getTranslation();
    }
}
```

El método `_getTranslation()` está disponible para todas las acciones que requieran traducciones. The `$t` variable is passed to the views, and with it, we can translate strings in that layer:

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

El método `_()` devuelve la cadena traducida basada en el índice pasado. Algunas cadenas necesitan incorporar marcadores de posición para datos calculados, por ejemplo: `Hola %name%`. Estos marcadores de posición pueden reemplazarse con parámetros pasados al método `_()`. The passed parameters are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

Algunas aplicaciones implementan el soporte multilingüe en la URL como `https://www.mozilla.org/**es-ES**/firefox/`. Phalcon puede implementar esto mediante un [Router](routing).

La implementación anterior es útil pero requiere un controlador base para implementar `_getTranslation()` y devolver el componente `Phalcon\Translate\Adapter\NativeArray`. Además el componente necesita ser agregado a la vista como se ve arriba, en la variable `$t`.

You can always wrap this functionality in its own class and register that class in the DI container:

```php
<?php

use Phalcon\Plugin;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Plugin
{
    public function getTranslator()
    {
        // Consultar al navegador por el mejor idioma
        $language = $this->request->getBestLanguage();

        /**
         * Utilizamos archivos JSON para almacenar las traducciones. 
         * You will need to check if the file exists! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language . '.json'),
            true
        );

        // Regresamos el objecto $messages requerido en la declaración anterior
        return new NativeArray(
            [
                'content' => $translations,
            ]
        );
    }
}
```

De esta manera se puede utilizar el componente en los controladores:

```php
<?php

use Phalcon\Mvc\Controller;

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

or in a view directly

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

## Implementing your own adapters

The [Phalcon\Translate\AdapterInterface](api/Phalcon_Translate_AdapterInterface) interface must be implemented in order to create your own translate adapters or extend the existing ones:

```php
<?php

use Phalcon\Translate\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * Constructor del adaptador
     *
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param  string     $translateKey
     * @param  array|null $placeholders
     * @return string
     */
    public function t($translateKey, $placeholders = null);

    /**
     * Retorna el string de traducción para la clave dada
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * Retorna la traducción relacionada para la clave dada
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * Comprueba que este definida la clave de traducción en el array interno
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

Hay disponibles más adaptadores para estos componentes en la [Incubadora de Phalcon](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)

## Interpolación

En muchos casos, las cadenas traducidas deben ser interpoladas con datos. [Phalcon\Translate\Interpolator\AssociativeArray](api/Phalcon_Translate_Interpolator_AssociativeArray) is the one being used by default.

```php
<?php
$translate = return new NativeArray(
    [
        'content' => [
            'hi-name' => 'Hello %name%, good %time% !',
        ],
    ]
);

$name = 'Henry';

$translate->_(
    'hi-name',
    [
        'name' => $name,
        'time' => 'day',
    ]
); // Hello Henry, good day !

$translate->_(
    'hi-name',
    [
        'name' => $name,
        'time' => 'night',
    ]
); // Hello Henry, good night !
```

[Phalcon\Translate\Interpolator\IndexedArray](api/Phalcon_Translate_Interpolator_IndexedArray) can also be used, it follows the [sprintf](https://www.php.net/manual/en/function.sprintf.php) convention.

```php
<?php
use Phalcon\Translate\Interpolator\IndexedArray;

$translate = return new NativeArray(
    [
        'interpolator' => new IndexedArray(),
        'content'      => [
            'hi-name' => 'Hello %1$s, it\'s %2$d o\'clock',
        ],
    ]
);

$name = 'Henry';

$translate->_(
    'hi-name',
    [
        $name,
        8,
    ]
); // Hello Henry, it's 8 o'clock
```

```php
<?php
use Phalcon\Translate\Interpolator\IndexedArray;

$translate = return new NativeArray(
    [
        'interpolator' => new IndexedArray(),
        'content'      => [
            'hi-name' => 'Son las %2$d, hola %1$s',
        ],
    ]
);

$name = 'Henry';

$translate->_(
    'hi-name',
    [
        $name,
        8,
    ]
); // Son las 8, hola Henry
```