<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">多言語サポート</a> <ul>
        <li>
          <a href="#adapters">アダプター</a> <ul>
            <li>
              <a href="#adapters-factory">ファクトリー</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#usage">コンポーネントの使い方</a>
        </li>
        <li>
          <a href="#custom">独自のアダプターを実装</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 多言語サポート

`Phalcon\\Translate` コンポーネントは多言語アプリケーションの作成に役立ちます。 Applications using this component, display content in different languages, based on the user's chosen language supported by the application.

<a name='adapters'></a>

## アダプター

This component makes use of adapters to read translation messages from different sources in a unified way.

| アダプター                                      | 説明                                                                                      |
| ------------------------------------------ | --------------------------------------------------------------------------------------- |
| `Phalcon\Translate\Adapter\NativeArray` | Uses PHP arrays to store the messages. This is the best option in terms of performance. |

<a name='adapters-factory'></a>

### ファクトリー

`adaper`オプションを使用してTranslate Adapterクラスをロードします

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

翻訳文字列はファイルに格納されます。 これらのファイルの構造は、使用しているアダプタによって変化する可能性があります。 Phalcon はあなたの翻訳文字列を組織化する自由を与えます。 単純な構造は以下のようになりえます。

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
        // どの言語がベストかブラウザに尋ねる
        $language = $this->request->getBestLanguage();

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

.. code-block:: html+php

    <!-- welcome -->
    <!-- String: hi => 'Hello' -->
    <p><?php echo $t->_('hi'), ' ', $name; ?></p>
    

The `_()` method is returning the translated string based on the index passed. Some strings need to incorporate placeholders for calculated data i.e. `Hello %name%`. These placeholders can be replaced with passed parameters in the `_()` method. The passed parameters are in the form of a key/value array, where the key matches the placeholder name and the value is the actual data to be replaced:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

Some applications implement multilingual on the URL such as `http://www.mozilla.org/**es-ES**/firefox/`. Phalcon can implement this by using a [Router](/[[language]]/[[version]]/routing).

<a name='custom'></a>

## 独自のアダプターを実装

The `Phalcon\Translate\AdapterInterface` interface must be implemented in order to create your own translate adapters or extend the existing ones:

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

[Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter) には、このコンポーネントを利用するための複数のアダプターが用意されています。