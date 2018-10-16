<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">フィルターとサニタイズ</a> <ul>
        <li>
          <a href="#types">ビルトインフィルターの種類</a>
        </li>
        <li>
          <a href="#sanitizing">データのサニタイズ</a>
        </li>
        <li>
          <a href="#sanitizing-from-controllers">コントローラーからのサニタイズ</a>
        </li>
        <li>
          <a href="#filtering-action-parameters">アクションパラメーターのフィルタリング</a>
        </li>
        <li>
          <a href="#filtering-data">データのフィルタリング</a>
        </li>
        <li>
          <a href="#combining-filters">フィルターの組合せ</a>
        </li>
        <li>
          <a href="#adding-filters">フィルターの追加</a>
        </li>
        <li>
          <a href="#complex-sanitization-filtering">複雑なサニタイズとフィルタリング</a>
        </li>
        <li>
          <a href="#custom">独自のフィルターを実装</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# フィルターとサニタイズ

ユーザー入力のサニタイズは、ソフトウェア開発の重要な部分です。 ユーザー入力を信頼したり無視してしまうと、アプリケーションのコンテンツ、主にユーザーデータ、またはアプリケーションがホストされているサーバーにも不正にアクセスさせてしまう可能性があります。

![](/images/content/filter-sql.png)

[XKCD の完全なイメージ](http://xkcd.com/327)

`Phalcon\Filter` コンポーネントは、一般的に使用されるフィルターとサニタイズヘルパーのデータのセットを提供します。またオブジェクト指向の PHP フィルター拡張機能ラッパーも提供します。

<a name='types'></a>

## ビルトインフィルターの種類

このコンポーネントによって提供される、ビルドインフィルターを次に示します。

| 名前        | 説明                                                                           |
| --------- | ---------------------------------------------------------------------------- |
| string    | タグを除去し、シングルクォートとダブルクォートでHTML エンティティをエンコードします。                                |
| email     | 文字・数字`!#$%&*+-/=?^_`{\|}~@.[]`以外のすべての文字を削除し、                           |
| int       | 数字、プラス記号、マイナス記号以外のすべての文字を削除します。                                              |
| float     | 数字、ドット、プラス記号、マイナス記号以外のすべての文字を削除します。                                          |
| alphanum  | [a-zA-Z0-9] 以外のすべての文字を削除します。                                                 |
| striptags | [strip_tags](http://www.php.net/manual/en/function.strip-tags.php) 関数を適用します。 |
| trim      | [trim](http://www.php.net/manual/en/function.trim.php) 関数を適用します。             |
| lower     | [strtolower](http://www.php.net/manual/en/function.strtolower.php) 関数を適用します。 |
| url       | 英字、数字、`|`$-_.+!*'(),{}[]<>#%";/?:@&=.^~\\`を除くすべての文字を削除                    |
| upper     | [strtoupper](http://www.php.net/manual/en/function.strtoupper.php) 関数を適用します。 |

<a name='sanitizing'></a>

## データのサニタイズ

サニタイズは、ユーザーまたはアプリケーションに必要ではないまたは望まれていない、特定の文字を値から削除するプロセスです。 入力値のサニタイズによって、アプリケーションの整合性を確かめます。

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// 'someone@example.com' を返す
$filter->sanitize('some(one)@exa\mple.com', 'email');

// 'hello' を返す
$filter->sanitize('hello<<', 'string');

// '100019' を返す
$filter->sanitize('!100a019', 'int');

// '100019.01' を返す
$filter->sanitize('!100a019.01a', 'float');
```

<a name='sanitizing-from-controllers'></a>

## コントローラーからのサニタイズ

（リクエストオブジェクトを通じて）`GET` または `POST` の入力データにアクセスするとき、コントローラーから `Phalcon\Filter` オブジェクトにアクセスできます。 最初のパラメータは、取得する変数の名前です。 2番目はそれに適用されるフィルタです。

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // 入力されたpriceをサニタイズ
        $price = $this->request->getPost('price', 'double');

        // 入力されたemailをサニタイズ
        $email = $this->request->getPost('customerEmail', 'email');
    }
}
```

<a name='filtering-action-parameters'></a>

## アクションパラメーターのフィルタリング

次の例では、コント ローラーのアクションの中でアクションパラメーターをサニタイズする方法を示します。

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($productId)
    {
        $productId = $this->filter->sanitize($productId, 'int');
    }
}
```

<a name='filtering-data'></a>

## データのフィルタリング

サニタイズに加えて、`Phalcon\Filter` は、入力データを私達が期待する形式に修正したり、削除したりすることで、フィルタリング機能を提供します。

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// 'hello' を返す
$filter->sanitize('<h1>Hello</h1>', 'striptags');

// 'hello' を返す
$filter->sanitize('  Hello   ', 'trim');
```

<a name='combining-filters'></a>

## フィルターの組合せ

2 番目のパラメーターとしてフィルターのIDの配列を渡すことによって、同時に複数のフィルターを文字列に対して実行することもできます:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// 'hello' を返す
$filter->sanitize(
    '   <h1> Hello </h1>   ',
    [
        'striptags',
        'trim',
    ]
);
```

<a name='adding-filters'></a>

## フィルターの追加

自身のフィルターを`Phalcon\Filter`に追加できます。このフィルタ関数は無名関数でも問題ありません。:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// 無名関数を使う
$filter->add(
    'md5',
    function ($value) {
        return preg_replace('/[^0-9a-f]/', '', $value);
    }
);

// 'md5' フィルターでサニタイズ
$filtered = $filter->sanitize($possibleMd5, 'md5');
```

また、必要に応じて、クラス内にフィルタを実装することもできます:

```php
<?php

use Phalcon\Filter;

class IPv4Filter
{
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

$filter = new Filter();

// オブジェクトを使う
$filter->add(
    'ipv4',
    new IPv4Filter()
);

// 'ipv4' フィルターでサニタイズ
$filteredIp = $filter->sanitize('127.0.0.1', 'ipv4');
```

<a name='complex-sanitization-filtering'></a>

## 複雑なサニタイズとフィルタリング

PHP自体、あなたが使用できる素晴らしいフィルタ拡張モジュールを提供します。ドキュメントをチェックしてみてください: [Data Filtering at PHP Documentation](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## 独自のフィルターを実装

Phalconが提供するフィルタリングサービスの代わりに独自のフィルタリングサービスを作成するには、`Phalcon\FilterInterface`インターフェイスを実装する必要があります。