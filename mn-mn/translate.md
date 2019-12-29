---
layout: default
language: 'en'
version: '4.0'
title: 'Translate'
keywords: 'translate, translations, translation adapters, native array, csv, gettext'
---

# Translation Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

The component [Phalcon\Translate](api/phalcon_translate) offers multilingual capabilities to applications. This component allows you to display content in different languages, based on the user's choice of language, available by the application.

## Хэрэглээ

Introducing translations in your application is a relatively simple task. However no two implementations are the same and of course the implementation will depend on the needs of your application. Some of the options available can be an automatic detection of the visitor's language using the server headers (parsing the `HTTP_ACCEPT_LANGUAGE` contents or using the `getBestLanguage()` method of the [Phalcon\Http\Request](api/phalcon_http#request) object).

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

The `getTranslator()` method is available in the controller for all actions that require it. You could of course introduce a caching mechanism to store the translation adapter in your cache (based on the language selected i.e. `en.cache`, `de-cache` etc.)

The `t` variable is passed then in the view and with it we can perform translations in the view layer.

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

and for Volt:

```twig
<p>{% raw %}{{ t._('hi') }} {{ name }}{% endraw %}</p>
```

### Placeholders

The `_()` method will return the translated string of the key passed. In the above example, it will return the value stored for the key `hi`. The component can also parse placeholders using \[interpolation\]\[#interpolation\]. Therefore for a translation of:

```text
Hello %name%!
```

you will need to pass the `$name` variable in the `_()` call and the component will perform the replacement for you.

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

and for Volt:

```twig
<p>{% raw %}{{ t._('hi-name', ['name' => name]) }}{% endraw %}</p>
```

### Plugin

The implementation above can be extended to offer translation capabilities throughout the application. We can of course move the `getTranslator()` method in a base controller and change its visibility to `protected`. However, we might want to use translations in other components that are outside the scope of a controller.

To achieve this, we can implement a new component as a Plugin and register it in our [Di](di) container.

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

Then we can register it in the Di container, when setting up services during bootstrap:

```php
<?php

use MyApp\Locale;

$container->set('locale', new Locale());
```

And now you can access the `Locale` plugin from your controllers and anywhere you need to.

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

or in a view directly

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

and for Volt:

```twig
<p>{% raw %}{{ locale._('hi-name', ['name' => 'Mike']) }}{% endraw %}</p>
```

### Routing

Some applications use the URL of the request to distinguish content based on different languages, in order to help with SEO. A sample URL is: ```bash https://mozilla.org/es-ES/firefox/

    <br />Phalcon can implement this functionality by using a [Router](routing).
    
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
    

## Adapters

This component makes use of adapters to read translation messages from different sources in a unified way.

| Adapter                                                                                         | Description                                              |
| ----------------------------------------------------------------------------------------------- | -------------------------------------------------------- |
| [Phalcon\Translate\Adapter\NativeArray](api/phalcon_translate#translate-adapter-nativearray) | Uses PHP arrays to store the messages.                   |
| [Phalcon\Translate\Adapter\Csv](api/phalcon_translate#translate-adapter-csv)                 | Uses a `.csv` file to store the messages for a language. |
| [Phalcon\Translate\Adapter\Gettext](api/phalcon_translate#translate-adapter-gettext)         | Uses gettext to retrieve the messages from a `.po` file. |

### Native Array

This adapter stores the translated strings in a PHP array. This adapter is clearly the fastest of all since strings are stored in memory. Additionally the fact that it uses PHP arrays makes maintenance easier. The strings can also be stored in JSON files which in turn can be translated back to the native PHP array format when retrieved.

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

The recommended usage would be to create one file per language and store it in the file system. After that you can load the relevant file, based on the language selected. A sample structure can be:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

or in JSON format

```bash
app/messages/en.json
app/messages/es.json
app/messages/fr.json
app/messages/zh.json
```

Each file contains PHP arrays, where key is the key of the translated string and value the translated message. Each file contains the same keys but the values are of course the message translated in the respective language.

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

Creating this adapter can be achieved by using the [Translate Factory](#translate-factory), but you can instantiate it directly:

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

**Not Found**

If the option `triggerError` is passed and set to `true` then the `notFound()` method will be called when a key is not found. The method will trigger an error.

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

The code above will trigger an error when we try to access the `unknown` entry.

### Csv

If your translation strings are stored in a `.csv` file. The [Phalcon\Translate\Adapter\Csv](api/phalcon_translate#translate-adapter-csv) adapter accepts the interpolator factory and an array with options necessary for loading the translations. The options array accepts: - `content`: The location of the CSV file on the file system - `delimiter`: The delimiter the CSV file uses (optional - defaults to `;`) - `enclosure`: The character that surrounds the text (optional - defaults to `"`)

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

In the above example you can see the usage of `delimiter` and `enclosure`. In most cases you will not need to supply these options but in case your CSV files are somewhat different, you have the option to instruct the adapter as to how it will parse the contents of the translation file.

Creating this adapter can be achieved by using the [Translate Factory](#translate-factory), but you can instantiate it directly:

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

> **NOTE**: This adapter **requires** the [gettext](https://www.php.net/manual/book.gettext.php) PHP extension. Please make sure that your system has it installed so that you can take advantage of this adapter's functionality
{: .alert .alert-warning }

The [gettext](https://en.wikipedia.org/wiki/Gettext) format has been around for years and many applications are using it because it has become a standard and it is easy to use. The translations are stored in `.po` and `.mo` files, and content can be easily added or changed using online editors or tools such as [POEdit](https://poedit.net/). This adapter requires files to be in specific folders so it can locate the translation files. The options array accepts:

- `locale`: The language locale you need
- `defaultDomain`: The domain for the files. This is the actual name of the files. Both `po` and `mo` files must have the same name.
- `directory`: The directory where the translation files are located
- `category`: A `LC*` PHP variable defining what category should be used. This maps to a folder (as seen below in the sample directory structure).

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

A sample directory structure for the translation files is:

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

Creating this adapter can be achieved by using the [Translate Factory](#translate-factory), but you can instantiate it directly:

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

## Custom

The [Phalcon\Translate\Adapter\AdapterInterface](api/phalcon_translate#translate-adapter-adapterinterface) interface must be implemented in order to create your own translate adapters or extend the existing ones:

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

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)

## Interpolation

In many cases, the translated strings need to be with data. With interpolation you can inject a variable from your code to the translated message at a specific place. The placeholder in the message is enclosed with `%` characters.

```text
Hello %name, good %time%!
Salut %name%, bien %time%!
```

Assuming that the context will not change based on each language's strings, you can add these placeholders to your translated strings. The Translate component with its adapters will then correctly perform the interpolation for you.

### Changing the Interpolator

To change the interpolator that your adapter uses, all you have to do is pass the name of the interpolator in the options using the `defaultInterpolator` key.

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

[Phalcon\Translate\Interpolator\AssociativeArray](api/phalcon_translate#translate-interpolator-associativearray) is the default interpolator. It allows you to do a key/value replacement of the placeholders.

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

### AssociatedArray

[Phalcon\Translate\Interpolator\IndexedArray](api/phalcon_translate#translate-interpolator-indexedarray) is another option that you can use as the interpolator. This interpolator follows the [sprintf](https://www.php.net/manual/en/function.sprintf.php) convention.

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

### Custom Interpolators

The [Phalcon\Translate\Interpolator\InterpolatorInterface](api/phalcon_translate#translate-interpolator-interpolatorinterface) interface must be implemented in order to create your own interpolators or extend the existing ones:

### Interpolator Factory

The [Phalcon\Translate\InterpolatorFactory](api/phalcon_translate#translate-interpolatorfactory) factory offers an easy way to create interpolators. It is an object required to be passed to the translate adapters and translate factory, so that in turn can create the relevant interpolation class that the adapter will use.

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