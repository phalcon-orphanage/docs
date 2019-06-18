---
layout: default
language: 'pt-br'
version: '4.0'
---

# Translation Component

* * *

## Multi-lingual Support

The component `Phalcon\Translate` aids in creating multilingual applications. Applications using this component, display content in different languages, based on the user's chosen language supported by the application.

## Factory

Loads Translate Adapter class using `adapter` option, the remaining options will be passed to the adapter constructor.

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

## Adapters

This component makes use of adapters to read translation messages from different sources in a unified way.

| Adapter                                                                               | Description                                                                             |
| ------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| [Phalcon\Translate\Adapter\NativeArray](api/Phalcon_Translate_Adapter_NativeArray) | Uses PHP arrays to store the messages. This is the best option in terms of performance. |
| [Phalcon\Translate\Adapter\Csv](api/Phalcon_Translate_Adapter_Csv)                 | Uses a `.csv` file to store the messages for a language.                                |
| [Phalcon\Translate\Adapter\Gettext](api/Phalcon_Translate_Adapter_Gettext)         | Uses gettext to retrieve the messages from a `.po` file.                                |

### Native Array

Translation strings are stored in a php array.

The recommended usage with this adapter is to store them in specific language files, with the freedom to organize them your way. A simple structure could be:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

Each file contains an array of the translations in a key/value manner. For each translation file, keys are unique. The same array is used in different files, where keys remain the same and values contain the translated strings depending on each language.

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

An example of loading such a file is provided in the *Component Usage* section.

### Csv

The translation strings are stored in a `.csv` format files.

```php
<?php

$options = [
    'adapter'   => 'csv',
    'content'   => '/path/to/file.csv',
];

$translate = Factory::load($options);
```

### Gettext

The translation strings are stored in `.po` and `.mo` files. More about it on the [official documentation](https://www.php.net/manual/book.gettext.php). The files hierarchy is bound to this standard.

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

Implementing the translation mechanism in your application is trivial but depends on how you wish to implement it. You can use an automatic detection of the language from the user's browser or you can provide a settings page where the user can select their language.

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

The `_getTranslation()` method is available for all actions that require translations. The `$t` variable is passed to the views, and with it, we can translate strings in that layer:

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

The `_()` method is returning the translated string based on the index passed. Some strings need to incorporate placeholders for calculated data i.e. `Hello %name%`. These placeholders can be replaced with passed parameters in the `_()` method. The passed parameters are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

Some applications implement multilingual on the URL such as `https://www.mozilla.org/**es-ES**/firefox/`. Phalcon can implement this by using a [Router](routing).

The implementation above is helpful but it requires a base controller to implement the `_getTranslation()` and return the `Phalcon\Translate\Adapter\NativeArray` component. Additionaly the component needs to be set in the view as seen above in the `$t` variable.

You can always wrap this functionality in its own class and register that class in the DI container:

```php
<?php

use Phalcon\Plugin;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Plugin
{
    public function getTranslator()
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();

        /**
         * We are using JSON based files for storing translations. 
         * You will need to check if the file exists! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language . '.json'),
            true
        );

        // Return a translation object $messages comes from the require
        // statement above
        return new NativeArray(
            [
                'content' => $translations,
            ]
        );
    }
}
```

This way you can use the component in controllers:

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
     * Adapter constructor
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
     * Returns the translation string of the given key
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * Returns the translation related to the given key
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * Check whether is defined a translation key in the internal array
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)

## Interpolation

In many cases, the translated strings are to be interpolated with data. [Phalcon\Translate\Interpolator\AssociativeArray](api/Phalcon_Translate_Interpolator_AssociativeArray) is the one being used by default.

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