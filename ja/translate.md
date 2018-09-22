<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">多言語サポート</a> 
      <ul>
        <li>
          <a href="#adapters">アダプター</a>
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

`Phalcon\Translate` コンポーネントは多言語アプリケーションの作成に役立ちます。 このコンポーネントを使用するアプリケーションは、アプリケーションでサポートされているユーザーが選択した言語に基づいて、異なる言語でコンテンツを表示します。

<a name='adapters'></a>

## アダプター

このコンポーネントはアダプターを使用して、異なるソースからの翻訳メッセージを、統一された方法で読み込みます。

| アダプター                                      | 説明                                               |
| ------------------------------------------ | ------------------------------------------------ |
| `Phalcon\Translate\Adapter\NativeArray` | PHP配列を使用してメッセージを格納します。 これは、パフォーマンスの面で最適なオプションです。 |

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

それぞれのファイルには、key/value 形式で、翻訳の配列が含まれます。 それぞれの翻訳ファイルで、Keysは一意です。 それぞれのファイルには同じ配列を使用します。ここでその配列の Keysはそのまま同じとし値はそれぞれの言語によって異なる翻訳文字列とします。

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

あなたのアプリケーションで翻訳メカニズムを実装するのは簡単ですが、実装方法に依存します。 ユーザーのブラウザから自動的に言語を検出することもできれば、ユーザーが言語を選択する設定ページを提供することができます。

ユーザーの言語を検出する最も簡単な方法は`$_SERVER['HTTP_ACCEPT_LANGUAGE']` の内容のパースです。もしくは、あなたが望む場合 action/controller から`$this->request->getBestLanguage()` を呼び出して直接アクセスすることです。

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

`_getTranslation()` メソッドは、翻訳を要求する全てのアクションに対して利用可能です。 `$t`変数がビューに渡され、そのレイヤー内の文字列を翻訳できます。

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

`_()` メソッドは、その渡されたインデックスに基づいて、翻訳された文字列を返します。 例えば、`Hello %name%`のような種類の文字列は計算されたデータのプレースホルダーを組込む必要があります。 これらのプレースホルダーは `_()`メソッドで渡されたパラメータで置き換えることができます。 渡されたパラメータは、key/value配列の形式になっています。ここでkeyはプレースホルダーにマッチする名前で、valueが置き換える実際のデータです。

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_('hi-name', ['name' => $name]); ?></p>
```

いくつかのアプリケーションは、`http://www.mozilla.org/**es-ES**/firefox/`のように、URLの多言語化を実装します。 Phalcon は [Router](/[[language]]/[[version]]/routing)を使ってこれを実装します。

上記の実装は役に立ちますが、`_getTranslation()`を実装し、`Phalcon\Translate\Adapter\NativeArray`コンポーネントを返すためにはベースコントローラが必要です。 さらに、上記のように、`$t`変数でコンポーネントをビューに設定する必要があります。

この機能を常に独自のクラスにラップし、そのクラスをDIコンテナに登録することができます。

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

この方法で、コントローラ内のコンポーネントを使用できます。

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

または直接ビューで

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

<a name='custom'></a>

## 独自のアダプターを実装

独自の変換アダプターを作成したり、既存の変換アダプターを拡張するには、`Phalcon\Translate\AdapterInterface`インターフェースを実装する必要があります。

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

[Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter) には、このコンポーネントを利用するための複数のアダプターが用意されています。