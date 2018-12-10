<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">フィルタとサニタイズ</a> <ul>
        <li>
          <a href="#types">ビルトインフィルターの種類</a>
        </li>
        <li>
          <a href="#sanitizing">Sanitizing data</a>
        </li>
        <li>
          <a href="#sanitizing-from-controllers">コントローラーからのサニタイズ</a>
        </li>
        <li>
          <a href="#filtering-action-parameters">アクションパラメーターのフィルタリング</a>
        </li>
        <li>
          <a href="#filtering-data">Filtering data</a>
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
          <a href="#custom">Implementing your own Filter</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# フィルタとサニタイズ

ユーザー入力のサニタイズは、ソフトウェア開発の重要な部分です。 ユーザー入力を信頼したり無視してしまうと、アプリケーションのコンテンツ、主にユーザーデータ、またはアプリケーションがホストされているサーバーにも不正にアクセスさせてしまう可能性があります。

![](/images/content/filter-sql.png)

[XKCD の完全なイメージ](http://xkcd.com/327)

`Phalcon\Filter` コンポーネントは、一般的に使用されるフィルターとサニタイズヘルパーのデータのセットを提供します。またオブジェクト指向の PHP フィルター拡張機能ラッパーも提供します。

<a name='types'></a>

## ビルトインフィルターの種類

このコンポーネントによって提供される、ビルドインフィルターを次に示します。

| 名前        | 説明                                                                             |
| --------- | ------------------------------------------------------------------------------ |
| absint    | 値をintegerとしてキャストし、その絶対値を返す。                                                    |
| alphanum  | [a-zA-Z0-9] 以外のすべての文字を削除します。                                                   |
| email     | 文字、数字、`!#$%&*+-/=?^_`{\|}~@.[]`以外のすべての文字を削除します。                          |
| float     | 数字、ドット、プラス記号、マイナス記号以外のすべての文字を削除します。                                            |
| float!    | 数字、ドット、プラス記号、マイナス記号以外のすべての文字を削除し、残りを float としてキャストする。                          |
| int       | 数字、プラス記号、マイナス記号以外のすべての文字を削除します。                                                |
| int!      | 数字、プラス記号、マイナス記号以外のすべての文字を削除し、残りを integer としてキャストする。                            |
| lower     | [ strtolower ](http://www.php.net/manual/en/function.strtolower.php) 関数を適用します。 |
| string    | タグを除去し、シングルクォートとダブルクォートでHTML エンティティをエンコードします。                                  |
| striptags | [strip_tags](http://www.php.net/manual/en/function.strip-tags.php) 関数を適用します。   |
| trim      | [trim](http://www.php.net/manual/en/function.trim.php) 関数を適用します。               |
| upper     | [strtoupper](http://www.php.net/manual/en/function.strtoupper.php) 関数を適用します。   |

コンポーネントが内部的に[filter_var](https://secure.php.net/manual/en/function.filter-var.php) PHP の関数を使用することに注意してください。

定数が利用可能であり、必要なフィルタリングのタイプを定義するために使用できます:

```php
<?php
const FILTER_ABSINT     = "absint";
const FILTER_ALPHANUM   = "alphanum";
const FILTER_EMAIL      = "email";
const FILTER_FLOAT      = "float";
const FILTER_FLOAT_CAST = "float!";
const FILTER_INT        = "int";
const FILTER_INT_CAST   = "int!";
const FILTER_LOWER      = "lower";
const FILTER_STRING     = "string";
const FILTER_STRIPTAGS  = "striptags";
const FILTER_TRIM       = "trim";
const FILTER_UPPER      = "upper";
```

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

You can access a `Phalcon\Filter` object from your controllers when accessing `GET` or `POST` input data (through the request object). The first parameter is the name of the variable to be obtained; the second is the filter to be applied on it.

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

The next example shows you how to sanitize the action parameters within a controller action:

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

You can also run multiple filters on a string at the same time by passing an array of filter identifiers as the second parameter:

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

PHP itself provides an excellent filter extension you can use. Check out its documentation: [Data Filtering at PHP Documentation](http://www.php.net/manual/en/book.filter.php)

<a name='custom'></a>

## 独自のフィルターを実装

Phalconが提供するフィルタリングサービスの代わりに独自のフィルタリングサービスを作成するには、`Phalcon\FilterInterface`インターフェイスを実装する必要があります。