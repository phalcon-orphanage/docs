<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Поддержка многоязычности</a> 
      <ul>
        <li>
          <a href="#adapters">Адаптеры</a>
        </li>
        <li>
          <a href="#usage">Использование компонента</a>
        </li>
        <li>
          <a href="#custom">Реализация собственных адаптеров</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Поддержка многоязычности

Компонент `Phalcon\Translate` поможет в создании многоязычных приложений. Приложения, использующие этот компонент, отображают содержимое на разных языках, основываясь на выборе пользователя из поддерживаемых приложением.

<a name='adapters'></a>

## Адаптеры

Этот компонент позволяет использовать адаптеры для чтения, перевода сообщений из различных источников в едином виде.

| Адаптер                                    | Описание                                                                                             |
| ------------------------------------------ | ---------------------------------------------------------------------------------------------------- |
| `Phalcon\Translate\Adapter\NativeArray` | Использует PHP массивы для хранения сообщений. Это лучший вариант с точки зрения производительности. |

<a name='adapters-factory'></a>

### Фабрика

Загружает адаптер используя параметр `adapter`:

```php
<?php

use Phalcon\Translate\Factory;

$options = [
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
    'adapter'       => 'gettext',
];

$translate = Factory::load($options);
```

<a name='usage'></a>

## Использование компонента

Translation strings are stored in files. The structure of these files could vary depending of the adapter used. Phalcon gives you the freedom to organize your translation strings. A simple structure could be:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

Каждый файл содержит массив переводов в виде ключ/значение. Для каждого файла перевода ключи уникальны. The same array is used in different files, where keys remain the same and values contain the translated strings depending on each language.

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
    'song'    => 'La chanson est %song%',;
```

Implementing the translation mechanism in your application is trivial but depends on how you wish to implement it. Вы можете использовать автоматическое определение языка из браузера пользователя, или вы можете предоставить выбор языка пользователю.

A simple way of detecting the user's language is to parse the `$_SERVER['HTTP_ACCEPT_LANGUAGE']` contents, or if you wish, access it directly by calling `$this->request->getBestLanguage()` from an action/controller:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class UserController extends Controller
{
    protected function getTranslation()
    {
        // Получение оптимального языка из браузера
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language. '.php';

        // Check if we have a translation file for that lang
        if (file_exists($translationFile)) {
            require $translationFile;
        } else {
            // Fallback to some default
            require 'app/messages/en.php';
        }

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

Метод `_ ()` возвращает переведенные строки на основе индекса, переданного функции. Some strings need to incorporate placeholders for calculated data i.e. `Hello %name%`. These placeholders can be replaced with passed parameters in the `_()` method. The passed parameters are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

Some applications implement multilingual on the URL such as `http://www.mozilla.org/**es-ES**/firefox/`. Реализовать такую схему в приложении на Phalcon можно используя компонент [Router](/[[language]]/[[version]]/routing).

Реализация выше удобна, но она требует наличия базового контроллера для реализации `getTranslation()` и возвращения компонента `Phalcon\Translate\Adapter\NativeArray`. Кроме того, компонент должен быть передан в представление, как в примере выше, в виде переменной `$t`.

Вы всегда можете реализовать эту функциональность в своём собственном классе и зарегистрировать его в DI:

```php
<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Component
{
    public function getTranslator()
    {
        // Получение оптимального языка из браузера
        $language = $this->request->getBestLanguage();

        /**
         * Здесь мы используем JSON-файлы для хранения переводов. 
         * Помните, вам необходимо убедиться, что файл существует! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language. '.json'),
            true
        );

        // Возвращение объекта работы с переводом
        return new NativeArray(
            [
                'content' => $translations,
            ]
        );
    }
}
```

Таким образом, вы можете использовать этот компонент в контроллерах:

```php
<?php

use Phalcon\Mvc\Controller;

class MyController extends Controller
{
    public function indexAction()
    {
        $name = 'Майк';
        $text = $this->locale->_('hi-name', ['name' => $name]);

        $this->view->text = $text;
    }
}
```

или напрямую в представлении

```php
<?php echo $locale->_('hi-name', ['name' => 'Майк']);
```

<a name='custom'></a>

## Реализация собственных адаптеров

The `Phalcon\Translate\AdapterInterface` interface must be implemented in order to create your own translate adapters or extend the existing ones:

```php
<?php

use Phalcon\Translate\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * Конструктор адаптера
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
     * Возвращает перевод строки по ключу
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * Возвращает перевод, связанный с заданным ключом
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * Проверяет существование перевода ключа во внутреннем массиве
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)