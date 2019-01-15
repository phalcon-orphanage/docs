* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 多言語サポート

The component `Phalcon\Translate` aids in creating multilingual applications. Applications using this component, display content in different languages, based on the user's chosen language supported by the application.

<a name='adapters'></a>

## Adapters

This component makes use of adapters to read translation messages from different sources in a unified way.

| アダプター                                                                                 | Description                                      |
| ------------------------------------------------------------------------------------- | ------------------------------------------------ |
| [Phalcon\Translate\Adapter\NativeArray](api/Phalcon_Translate_Adapter_NativeArray) | PHP配列を使用してメッセージを格納します。 これは、パフォーマンスの面で最適なオプションです。 |

<a name='adapters-factory'></a>

### Factory

Loads Translate Adapter class using `adapter` option

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

## コンポーネントの使い方

Translation strings are stored in files. The structure of these files could vary depending of the adapter used. Phalcon gives you the freedom to organize your translation strings. A simple structure could be:

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
        // どの言語がベストかブラウザにたずねる
        $language = $this->request->getBestLanguage();
        $messages = [];

        $translationFile = 'app/messages/' . $language . '.php';

        // そのベスト言語の翻訳ファイルがあるかを確認する
        if (file_exists($translationFile)) {
            require $translationFile;
        } else {
            // なかった場合デフォルト言語にフォールバック
            require 'app/messages/en.php';
        }

        // 上の要求したステートメントからの翻訳オブジェクト $messages を
        // 返す
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

Some applications implement multilingual on the URL such as `https://www.mozilla.org/**es-ES**/firefox/`. Phalcon can implement this by using a [Router](/4.0/en/routing).

The implementation above is helpful but it requires a base controller to implement the `_getTranslation()` and return the `Phalcon\Translate\Adapter\NativeArray` component. Additionaly the component needs to be set in the view as seen above in the `$t` variable.

You can always wrap this functionality in its own class and register that class in the DI container:

```php
<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Component
{
    public function getTranslator()
    {
        // ベストな言語が何であるかブラウザに問い合せる
        $language = $this->request->getBestLanguage();

        /**
         * 翻訳の保存にJSON形式のファイルを使用 
         * ファイルが存在するかを確認する必要あり! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language . '.json'),
            true
        );

        // 翻訳オブジェクトを返す$messagesは上記のrequire文から来る
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
        $text = $this->locale->_('hi-name', ['name' => $name]);

        $this->view->text = $text;
    }
}
```

or in a view directly

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

<a name='custom'></a>

## Implementing your own adapters

The [Phalcon\Translate\AdapterInterface](api/Phalcon_Translate_AdapterInterface) interface must be implemented in order to create your own translate adapters or extend the existing ones:

```php
<?php

use Phalcon\Translate\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * アダプタのコンストラクタ
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
     * 指定されたキーの翻訳文字列を返す
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * 指定されたキーに関連する翻訳を返す
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * 内部の配列に翻訳キーが定義されているかを確認
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)