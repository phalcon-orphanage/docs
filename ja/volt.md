<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">概要</a> <ul>
        <li>
          <a href="#introduction">はじめに</a>
        </li>
        <li>
          <a href="#setup">Voltを使うために</a>
        </li>
        <li>
          <a href="#basic-usage">基本的な使い方</a>
        </li>
        <li>
          <a href="#variables">変数</a>
        </li>
        <li>
          <a href="#filters">フィルター</a>
        </li>
        <li>
          <a href="#comments">コメント</a>
        </li>
        <li>
          <a href="#control-structures">制御構文の一覧</a> <ul>
            <li>
              <a href="#control-structures-for">for文</a>
            </li>
            <li>
              <a href="#control-structures-loops">ループ制御</a>
            </li>
            <li>
              <a href="#control-structures-loop">ループ変数</a> <ul>
                <li>
                  <a href="#assignments">変数割り当て</a>
                </li>
                <li>
                  <a href="#expressions">条件式</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#expressions-literals">定数</a>
            </li>
            <li>
              <a href="#expressions-arrays">配列</a>
            </li>
            <li>
              <a href="#expressions-math">計算</a>
            </li>
            <li>
              <a href="#expressions-comparisons">比較</a>
            </li>
            <li>
              <a href="#expressions-logic">演算子</a>
            </li>
            <li>
              <a href="#expressions-other-operators">その他演算子</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tests">テスト</a>
        </li>
        <li>
          <a href="#macros">マクロ</a>
        </li>
        <li>
          <a href="#tag-helpers">タグヘルパーを使用する</a>
        </li>
        <li>
          <a href="#functions">関数</a>
        </li>
        <li>
          <a href="#view-integrations">Viewとの連携</a> <ul>
            <li>
              <a href="#view-integration-include">include文</a>
            </li>
            <li>
              <a href="#view-integration-partial-vs-include">partial文 vs include文</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#template-inheritance">テンプレートの継承</a> <ul>
            <li>
              <a href="#template-inheritance-multiple">多重継承</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#autoescape">自動エスケープ モード</a>
        </li>
        <li>
          <a href="#extending">Volt の拡張</a> <ul>
            <li>
              <a href="#extending-functions">関数</a>
            </li>
            <li>
              <a href="#extending-filters">フィルター</a>
            </li>
            <li>
              <a href="#extending-extensions">エクステンション</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#caching-view-fragments">Viewの断片のキャッシュ</a>
        </li>
        <li>
          <a href="#services-in-templates">テンプレートへのサービス注入</a>
        </li>
        <li>
          <a href="#stand-alone">独立コンポーネント</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Volt: テンプレートエンジン

Volt は、PHPのためにCで記述されており、とても速く、デザイナにも扱いやすいテンプレート言語です。 簡単にビューを書けるように、ヘルパーセットを提供します。 Volt はPhalconの他のコンポーネントと高度に統合されていて、アプリケーションの中で独立したコンポーネントとしても利用できます。

![](/images/content/volt.jpg)

Volt は、[Armin Ronacher](https://github.com/mitsuhiko)によって作られた[Jinja](http://jinja.pocoo.org/)にインスパイアされています。 そのため、よく似た既存のテンプレートエンジンと同じ記法を採用しており、利用する多くの開発者にとって親しみやすくなっています。 Voltの記法と機能は、Phalconを使う開発者が慣れ親しんだ多くの要素を備え、当然パフォーマンスの点においても強化されています。

<a name='introduction'></a>

## はじめに

Voltによるビューは純粋なPHPコードにコンパイルされるので、基本的には手でPHPコードを書く労力を節約することができます:

```twig
{# app/views/products/show.volt #}

{% block last_products %}

{% for product in products %}
    * Name: {{ product.name|e }}
    {% if product.status === 'Active' %}
       Price: {{ product.price + product.taxes/100 }}
    {% endif  %}
{% endfor  %}

{% endblock %}
```

<a name='setup'></a>

## Voltを使うために

他のテンプレートエンジンと同じように、新しい拡張子や標準的な拡張子`.phtml`を用いて、Voltをビューコンポーネントに登録することもできます:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Voltをサービスとして登録
$di->set(
    'voltService',
    function ($view, $di) {
        $volt = new Volt($view, $di);

        $volt->setOptions(
            [
                'compiledPath'      => '../app/compiled-templates/',
                'compiledExtension' => '.compiled',
            ]
        );

        return $volt;
    }
);

// Voltをテンプレートエンジンとして登録
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => 'voltService',
            ]
        );

        return $view;
    }
);
```

標準的な`.phtml`という拡張子を用いる:

```php
<?php

$view->registerEngines(
    [
        '.phtml' => 'voltService',
    ]
);
```

DIでVoltサービスを指定する必要はありません。 デフォルトの設定でVoltエンジンを利用することができます:

```php
<?php

$view->registerEngines(
    [
        '.volt' => Phalcon\Mvc\View\Engine\Volt::class,
    ]
);
```

サービスとしてVoltを再利用したくない場合は、無名関数を渡すことでサービス名の代わりにエンジンを登録することができます。

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// 無名関数によってVoltをテンプレートエンジンとして登録
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            [
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    // Set some options here

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
```

Voltで使用できるオプション:

| オプション               | 説明                                                         | デフォルト   |
| ------------------- | ---------------------------------------------------------- | ------- |
| `compiledPath`      | コンパイルされたPHPテンプレートが保存される書き込み可能なパス                           | `./`    |
| `compiledExtension` | コンパイル済みのPHPファイルに追加する拡張子                                    | `.php`  |
| `compiledSeparator` | Voltはコンパイルされたディレクトリに単一のファイルを作成するために、この区切り文字/を¥に置き換えます      | `%%`    |
| `stat`              | テンプレートファイルとコンパイルされたパスの違いが存在するかどうかをPhalconがチェックするかどうか       | `true`  |
| `compileAlways`     | リクエスト毎にテンプレートをコンパイルしなければならない場合、または変更が必要な場合にのみ、Voltに伝えてください | `false` |
| `prefix`            | コンパイルパスのテンプレートにプレフィックスを付加することができます                         | `null`  |
| `autoescape`        | HTMLの自動エスケープをグローバルに利用可能にする                                 | `false` |

コンパイルパスは、上記のオプションに従って生成されます。開発者がコンパイルパスを自由に定義したい場合は、無名関数を使用して生成することができます。この関数は、viewsディレクトリのテンプレートへの相対パスを受け取ります。 次の例は、コンパイルパスを動的に変更する方法を示しています:

```php
<?php

// .php拡張子をテンプレートパスに追加するだけ
// コンパイルされたテンプレートは同じディレクトリに残す
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            return $templatePath . '.php';
        }
    ]
);

// 他のディレクトリに同じ構造で作成
$volt->setOptions(
    [
        'compiledPath' => function ($templatePath) {
            $dirName = dirname($templatePath);

            if (!is_dir('cache/' . $dirName)) {
                mkdir('cache/' . $dirName);
            }

            return 'cache/' . $dirName . '/'. $templatePath . '.php';
        }
    ]
);
```

<a name='basic-usage'></a>

## 基本的な使い方

ビューは、VoltやPHP、HTMLのコードで構成されます。 Voltモードでは特別なデリミタが使用できます。 `{% ... %}`は、forループや値の代入などの構文を実行するために使用され、`{{ }}`が式の結果をテンプレートに出力します。

下記は、いくつかの基本を示す最小限のテンプレートです:

```twig
{# app/views/posts/show.phtml #}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }} - An example blog</title>
    </head>
    <body>

        {% if show_navigation %}
            <ul id='navigation'>
                {% for item in menu %}
                    <li>
                        <a href='{{ item.href }}'>
                            {{ item.caption }}
                        </a>
                    </li>
                {% endfor %}
            </ul>
        {% endif %}

        <h1>{{ post.title }}</h1>

        <div class='content'>
            {{ post.content }}
        </div>

    </body>
</html>
```

`Phalcon\Mvc\View`を使うことで、コントローラからビューへ変数を渡すことができます。 上記の例では次の変数がビューに渡されています。`show_navigation`、`menu`、`title`、`post`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function showAction()
    {
        $post = Post::findFirst();
        $menu = Menu::findFirst();

        $this->view->show_navigation = true;
        $this->view->menu            = $menu;
        $this->view->title           = $post->title;
        $this->view->post            = $post;

        // Or...

        $this->view->setVar('show_navigation', true);
        $this->view->setVar('menu',            $menu);
        $this->view->setVar('title',           $post->title);
        $this->view->setVar('post',            $post);
    }
}
```

<a name='variables'></a>

## 変数

オブジェクト変数は、`foo.bar`というシンタックスを用いてアクセスできる属性を持っています。もし配列を渡すなら、`foo['bar']`という角括弧のシンタックスを使ってください。

```twig
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
```

<a name='filters'></a>

## フィルター

変数は、フォーマットしたり、フィルタを用いて加工することができます。変数にフィルタを適用するには、パイプ演算子`|`を使います:

```twig
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
```

以下は、Voltで利用可能な、ビルトインのフィルタのリストです:

| フィルター              | 説明                                                                                                            |
| ------------------ | ------------------------------------------------------------------------------------------------------------- |
| `abs`              | [abs](http://php.net/manual/en/function.abs.php) PHP関数を値に適用します。                                               |
| `capitalize`       | [ucwords](http://php.net/manual/en/function.ucwords.php) PHP関数を値に適用して文字列を大文字にします                              |
| `convert_encoding` | 文字列をある文字セットから別の文字セットに変換します                                                                                    |
| `default`          | 評価された式が空（設定されていないかfalse）である場合のデフォルト値を設定します                                                                    |
| `e`                | `Phalcon\Escaper->escapeHtml()` を値に適用します                                                                  |
| `escape`           | `Phalcon\Escaper->escapeHtml()` を値に適用します                                                                  |
| `escape_attr`      | `Phalcon\Escaper->escapeHtmlAttr()` を値に適用します                                                              |
| `escape_css`       | `Phalcon\Escaper->escapeCss()` を値に適用します                                                                   |
| `escape_js`        | `Phalcon\Escaper->escapeJs()` を値に適用します                                                                    |
| `format`           | [sprintf](http://php.net/manual/en/function.sprintf.php) を使って文字列をフォーマットします。                                   |
| `json_encode`      | 値を [JSON](http://php.net/manual/en/function.json-encode.php) に変換します                                           |
| `json_decode`      | 値を [JSON](http://php.net/manual/en/function.json-encode.php) からPHP形式に変換します                                    |
| `join`             | 区切り文字で配列を結合します [join](http://php.net/manual/en/function.join.php)                                             |
| `keys`             | [array_keys](http://php.net/manual/en/function.array-keys.php) を使って配列のキーを返します                                 |
| `left_trim`        | PHPの [ltrim](http://php.net/manual/en/function.ltrim.php) 関数を値に適用します。 余分なスペースを削除します                           |
| `length`           | 文字列の長さ、または配列、オブジェクトに含まれるアイテムの数を数えます                                                                           |
| `lower`            | 文字列を小文字に変更します。                                                                                                |
| `nl2br`            | 改行コード `\n` をHTMLの改行（`<br />`）に変更します。 PHP関数 [nl2br](http://php.net/manual/en/function.nl2br.php) を使用します |
| `right_trim`       | [rtrim](http://php.net/manual/en/function.rtrim.php)PHP関数を値に適用して、余分なスペースを削除します。                               |
| `slashes`          | [slashes](http://php.net/manual/en/function.slashes.php) PHP 関数を値に適用して、値をエスケープします。                            |
| `sort`             | PHP 関数 [asort](http://php.net/manual/en/function.asort.php) を使用して配列をソートします。                                   |
| `stripslashes`     | [stripslashes](http://php.net/manual/en/function.stripslashes.php) PHP 関数を値に適用して、エスケープされた引用符を削除します。           |
| `striptags`        | [striptags](http://php.net/manual/en/function.striptags.php) PHP 関数を値に適用して、HTMLタグを削除します。                      |
| `trim`             | [trim](http://php.net/manual/en/function.trim.php) PHP 関数を値に適用して、余分な半角スペースを削除します。                             |
| `upper`            | 文字列を大文字に変更します。                                                                                                |
| `url_encode`       | [urlencode](http://php.net/manual/en/function.urlencode.php) PHP 関数を値に適用します。                                  |

例:

```twig
{# e or escape filter #}
{{ '<h1>Hello<h1>'|e }}
{{ '<h1>Hello<h1>'|escape }}

{# trim filter #}
{{ '   hello   '|trim }}

{# striptags filter #}
{{ '<h1>Hello<h1>'|striptags }}

{# slashes filter #}
{{ ''this is a string''|slashes }}

{# stripslashes filter #}
{{ '\'this is a string\''|stripslashes }}

{# capitalize filter #}
{{ 'hello'|capitalize }}

{# lower filter #}
{{ 'HELLO'|lower }}

{# upper filter #}
{{ 'hello'|upper }}

{# length filter #}
{{ 'robots'|length }}
{{ [1, 2, 3]|length }}

{# nl2br filter #}
{{ 'some\ntext'|nl2br }}

{# sort filter #}
{% set sorted = [3, 1, 2]|sort %}

{# keys filter #}
{% set keys = ['first': 1, 'second': 2, 'third': 3]|keys %}

{# join filter #}
{% set joined = 'a'..'z'|join(',') %}

{# format filter #}
{{ 'My real name is %s'|format(name) }}

{# json_encode filter #}
{% set encoded = robots|json_encode %}

{# json_decode filter #}
{% set decoded = '{'one':1,'two':2,'three':3}'|json_decode %}

{# url_encode filter #}
{{ post.permanent_link|url_encode }}

{# convert_encoding filter #}
{{ 'désolé'|convert_encoding('utf8', 'latin1') }}
```

<a name='comments'></a>

## コメント

コメントも、`{# ... #}`というデリミタを用いることで、テンプレートに含めることができます。このデリミタの内側にあるテキストはすべて、最終的な出力の際に無視されます:

```twig
{# note: this is a comment
    {% set price = 100; %}
#}
```

<a name='control-structures'></a>

## 制御構文の一覧

Volt には、テンプレートで使用するための基本的かつ強力な制御構文が用意されています。

<a name='control-structures-for'></a>

### for文

シーケンス中のそれぞれのアイテムを繰り返し処理します。以下の例では、「robots」のセットを横断して処理し、彼/彼女らの名前を表示する方法を示しています:

```twig
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        <li>
            {{ robot.name|e }}
        </li>
    {% endfor %}
</ul>
```

forループは入れ子にすることもできます:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    {% for part in robot.parts %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
    {% endfor %}
{% endfor %}
```

以下のシンタックスを用いることで、PHPにおける要素の`keys`を得ることができます:

```twig
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
```

必要に応じて`if`の評価を設定することができます:

```twig
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for value in numbers if value < 2 %}
    Value: {{ value }}
{% endfor %}

{% for name, value in numbers if name !== 'two' %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
```

もし、`for`の中で`else`を定義した場合は、イテレータの結果が 0回のときに、そこに記述した文が実行されるでしょう:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% else %}
    There are no robots to show
{% endfor %}
```

代替構文:

```twig
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% elsefor %}
    There are no robots to show
{% endfor %}
```

<a name='control-structures-loops'></a>

### ループ制御

`break`と`continue`文は、ループから抜けたり、現在のブロック内で強制的に次のイテレーションへ移ったりすることができます:

```twig
{# skip the even robots #}
{% for index, robot in robots %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
```

```twig
{# exit the foreach on the first even robot #}
{% for index, robot in robots %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
```

<a name='control-structures-if'></a>

### If文

PHPと同じように、`if`文は、条件式が true または false に評価されるかをチェックします:

```twig
<h1>Cyborg Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% endif %}
    {% endfor %}
</ul>
```

else 文もサポートされています:

```twig
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type === 'cyborg' %}
            <li>{{ robot.name|e }}</li>
        {% else %}
            <li>{{ robot.name|e }} (not a cyborg)</li>
        {% endif %}
    {% endfor %}
</ul>
```

`switch`ブロックをエミュレートするifと一緒に、`elseif`制御フロー構造を使用することができます:

```twig
{% if robot.type === 'cyborg' %}
    Robot is a cyborg
{% elseif robot.type === 'virtual' %}
    Robot is virtual
{% elseif robot.type === 'mechanical' %}
    Robot is mechanical
{% endif %}
```

<a name='control-structures-loop'></a>

### ループ変数

`for` ループで使用できる特別な変数の情報を提供します。

| 変数               | 説明                   |
| ---------------- | -------------------- |
| `loop.index`     | ループの現在の反復回数。（1始まり）   |
| `loop.index0`    | ループの現在の反復回数。（0始まり）   |
| `loop.revindex`  | ループの終わりからの反復回数（1始まり） |
| `loop.revindex0` | ループの終わりからの反復回数（0始まり） |
| `loop.first`     | ループの最初ならtrue。        |
| `loop.last`      | ループの最後ならtrue。        |
| `loop.length`    | ループするアイテムの数          |

例:

```twig
{% for robot in robots %}
    {% if loop.first %}
        <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Name</th>
            </tr>
    {% endif %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ robot.id }}</td>
                <td>{{ robot.name }}</td>
            </tr>
    {% if loop.last %}
        </table>
    {% endif %}
{% endfor %}
```

<a name='assignments'></a>

## 変数の割り当て

'set' を使用した場合、テンプレートの変数が変更されることがあります。

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
```

ひとつの命令で複数の代入が可能です。

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
```

加えて複合代入命令も使用できます:

```twig
{% set price += 100.00 %}

{% set age *= 5 %}
```

次の演算子が使用できます。

| 演算子     | 説明    |
| ------- | ----- |
| `=`     | 代入    |
| `+=`    | 値を足す  |
| `-=`    | 値を引く  |
| `\*=` | 値を掛ける |
| `/=`    | 値で割る  |

<a name='expressions'></a>

## 条件式

Voltは基本的な式をサポートします。この式にはリテラルと基本演算子が含まれます。式は評価でき、これらは`{{;crwdn;ht;1;ht;crwdn; and ;crwdn;ht;2;ht;crwdn;}}` 区切りを使用して表示されます。

```twig
{{ (1 + 1) * 2 }}
```

表示を行わずに式を評価する必要がある場合、 `do` ステートメントを使用します。

```twig
{% do (1 + 1) * 2 %}
```

<a name='expressions-literals'></a>

### 定数

以下のリテラルがサポートされています。

| フィルター                | 説明                               |
| -------------------- | -------------------------------- |
| `'this is a string'` | 二重引用符または一重引用符間のテキストは文字列として扱われます  |
| `100.25`             | 小数点以下の桁数はdouble / floatとして扱われます。 |
| `100`                | 小数部のない数値は整数として扱われます              |
| `false`              | 定数 'false' はbool値のfalseです        |
| `true`               | 定数 'true' はbool値のtrueです          |
| `null`               | 定数 'null' はNULLの値です              |

<a name='expressions-arrays'></a>

### 配列

あなたが PHP 5.3 または 5.4以上を使用している場合、角括弧 [] でリストの値を囲んで配列を作成できます。

```twig
{# Simple array #}
{{ ['Apple', 'Banana', 'Orange'] }}

{# Other simple array #}
{{ ['Apple', 1, 2.5, false, null] }}

{# Multi-Dimensional array #}
{{ [[1, 2], [3, 4], [5, 6]] }}

{# Hash-style array #}
{{ ['first': 1, 'second': 4/2, 'third': '3'] }}
```

中括弧 {} もまた配列やハッシュを定義するために使用します。

```twig
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
```

<a name='expressions-math'></a>

### 計算

次の演算子を使用して、テンプレートで計算を行えます。

| 演算子 | 説明                                 |
|:---:| ---------------------------------- |
| `+` | 足し算を実行します。 `{{ 2 + 3 }}` は5を返します   |
| `-` | 引き算を実行します。 `{{ 2 - 3 }}` は-1を返します  |
| `*` | 掛け算を実行します。 `{{ 2 * 3 }}` は6を返します   |
| `/` | 割り算を実行します。 `{{ 10 / 2 }}` は5を返します  |
| `%` | 整数の剰余を計算します `{{ 10 ％ 3 }}` は1を返します |

<a name='expressions-comparisons'></a>

### 比較

次の比較演算が使用できます。

|    演算子     | 説明                                    |
|:----------:| ------------------------------------- |
|    `==`    | 両方のオペランドが等しいかどうかをチェックする               |
|    `!=`    | 両方のオペランドが等しくないかをチェックする                |
| `<>` | 両方のオペランドが等しくないかをチェックする                |
|   `>`   | 左オペランドが右オペランドより大きいかどうかをチェックする         |
|   `<`   | 左オペランドが右オペランドより小さいかどうかをチェックする         |
|  `<=`   | 左オペランドが右オペランドより小さい、もしくは等しいかどうかをチェックする |
|  `>=`   | 左オペランドが右オペランドより大きい、もしくは等しいかどうかをチェックする |
|   `===`    | 両方のオペランドが同一かどうかをチェックする                |
|   `!==`    | 両方のオペランドが同一では無いかをチェックする               |

<a name='expressions-logic'></a>

### 演算子

論理演算子は、複数のテストを組合せた`if` 式で使用します。

|    演算子     | 説明                                   |
|:----------:| ------------------------------------ |
|    `or`    | 左または右のオペランドがtrueと評価された場合はtrueを返します。  |
|   `and`    | 左と右の両方のオペランドがtrueと評価された場合はtrueを返します。 |
|   `not`    | 式を否定します                              |
| `( expr )` | 式のグルーピング                             |

<a name='expressions-other-operators'></a>

### その他演算子

以下の追加の演算子が利用できます。

| 演算子               | 説明                                                   |
| ----------------- | ---------------------------------------------------- |
| `~`               | 両方のオペランドを連結する `{{ 'hello ' ~ 'world' }}`             |
| `|`               | 右側のオペランドのフィルタを左のオペランドに適用します`{{ 'hello'|uppercase }}` |
| `..`              | 範囲を作成します `{{ 'a'..'z' }}` `{{ 1..10 }}`              |
| `is`              | ==（equals）と同じですが、テストも実行します                           |
| `in`              | 式が他の式に含まれている事をチェックする `if 'a' in 'abc'`               |
| `is not`          | != (not equals) と同じ                                  |
| `'a' ? 'b' : 'c'` | 三項演算子。 PHPの三項演算子と同じ                                  |
| `++`              | 値を増やす                                                |
| `--`              | 値を減らす                                                |

演算子を使用方法を示します。

```twig
{% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

{% for index in 0..robots|length %}
    {% if robots[index] is defined %}
        {{ 'Name: ' ~ robots[index] }}
    {% endif %}
{% endfor %}
```

<a name='tests'></a>

## テスト

テストは、その変数が期待された有効な値を持っているかを調べるために使用できます。演算子の`is`はテストの実行に使用します。

```twig
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
```

Voltで使用できるビルトインのテスト:

| テスト           | 説明                                  |
| ------------- | ----------------------------------- |
| `defined`     | 変数が定義されているかどうかをチェックします (`isset()`)  |
| `divisibleby` | 値が他の値で割り切れるかどうかをチェックします             |
| `empty`       | 変数が空であるかどうかをチェックします                 |
| `even`        | 数値が偶数であるかどうかをチェックします。               |
| `iterable`    | 値が反復可能かどうかをチェックします。 'for' 文で取得できます  |
| `numeric`     | 値が数値かどうかをチェックします                    |
| `odd`         | 数値が奇数かどうかをチェックします                   |
| `sameas`      | 値が他の値と等しいかどうかをチェックします               |
| `scalar`      | 値がスカラー（配列またはオブジェクトではない）かどうかをチェックします |
| `type`        | 値が指定された型かどうかをチェックします                |

その他の例

```twig
{% if robot is defined %}
    The robot variable is defined
{% endif %}

{% if robot is empty %}
    The robot is null or isn't defined
{% endif %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is even %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is odd %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 'third': 'Bender'] %}
    {% if key is numeric %}
        {{ name }}
    {% endif %}
{% endfor %}

{% set robots = [1: 'Voltron', 2: 'Astroy Boy'] %}
{% if robots is iterable %}
    {% for robot in robots %}
        ...
    {% endfor %}
{% endif %}

{% set world = 'hello' %}
{% if world is sameas('hello') %}
    {{ 'it's hello' }}
{% endif %}

{% set external = false %}
{% if external is type('boolean') %}
    {{ 'external is false or true' }}
{% endif %}
```

<a name='macros'></a>

## マクロ

マクロは、テンプレート内のロジックを再利用するために使用できます。マクロは PHP関数として機能し、パラメータを受け取り、値を返すことができます。

```twig
{# Macro 'display a list of links to related topics' #}
{%- macro related_bar(related_links) %}
    <ul>
        {%- for link in related_links %}
            <li>
                <a href='{{ url(link.url) }}' title='{{ link.title|striptags }}'>
                    {{ link.text }}
                </a>
            </li>
        {%- endfor %}
    </ul>
{%- endmacro %}

{# Print related links #}
{{ related_bar(links) }}

<div>This is the content</div>

{# Print related links again #}
{{ related_bar(links) }}
```

マクロを呼び出すとき、パラメーターは名前渡しです:

```twig
{%- macro error_messages(message, field, type) %}
    <div>
        <span class='error-type'>{{ type }}</span>
        <span class='error-field'>{{ field }}</span>
        <span class='error-message'>{{ message }}</span>
    </div>
{%- endmacro %}

{# Call the macro #}
{{ error_messages('type': 'Invalid', 'message': 'The name is invalid', 'field': 'name') }}
```

マクロは値を返します:

```twig
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

またオプションのパラメーターを受け取ります:

```twig
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

<a name='tag-helpers'></a>

## タグヘルパーを使用する

Voltは高度に`Phalcon\Tag`と統合しています。そのためVoltテンプレートのコンポーネントによって提供されたヘルパーを簡単に使用できます。

```twig
{{ javascript_include('js/jquery.js') }}

{{ form('products/save', 'method': 'post') }}

    <label for='name'>Name</label>
    {{ text_field('name', 'size': 32) }}

    <label for='type'>Type</label>
    {{ select('type', productTypes, 'using': ['id', 'name']) }}

    {{ submit_button('Send') }}

{{ end_form() }}
```

以下のPHPが生成できます。

```php
<?php echo Phalcon\Tag::javascriptInclude('js/jquery.js') ?>

<?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

    <label for='name'>Name</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for='type'>Type</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>

{{ end_form() }}
```

`Phalcon\Tag` ヘルパーを呼び出すには、そのメソッド名をスネークケース化した名前にするだけです:

| メソッド                              | Volt関数               |
| --------------------------------- | -------------------- |
| `Phalcon\Tag::checkField`        | `check_field`        |
| `Phalcon\Tag::dateField`         | `date_field`         |
| `Phalcon\Tag::emailField`        | `email_field`        |
| `Phalcon\Tag::endForm`           | `end_form`           |
| `Phalcon\Tag::fileField`         | `file_field`         |
| `Phalcon\Tag::form`              | `form`               |
| `Phalcon\Tag::friendlyTitle`     | `friendly_title`     |
| `Phalcon\Tag::getTitle`          | `get_title`          |
| `Phalcon\Tag::hiddenField`       | `hidden_field`       |
| `Phalcon\Tag::image`             | `image`              |
| `Phalcon\Tag::javascriptInclude` | `javascript_include` |
| `Phalcon\Tag::linkTo`            | `link_to`            |
| `Phalcon\Tag::numericField`      | `numeric_field`      |
| `Phalcon\Tag::passwordField`     | `password_field`     |
| `Phalcon\Tag::radioField`        | `radio_field`        |
| `Phalcon\Tag::select`            | `select`             |
| `Phalcon\Tag::selectStatic`      | `select_static`      |
| `Phalcon\Tag::stylesheetLink`    | `stylesheet_link`    |
| `Phalcon\Tag::submitButton`      | `submit_button`      |
| `Phalcon\Tag::textArea`          | `text_area`          |
| `Phalcon\Tag::textField`         | `text_field`         |

<a name='functions'></a>

## 関数

Voltで使用できるビルトインの関数:

| 名前            | 説明                           |
| ------------- | ---------------------------- |
| `content`     | 以前のレンダリング段階で作成されたコンテンツが含まれます |
| `get_content` | `content` と同じです              |
| `partial`     | 現在のテンプレートにパーシャルビューを動的にロードする  |
| `super`       | 親ブロックの内容をレンダリングする            |
| `time`        | 同じ名前のPHP関数を呼び出します            |
| `date`        | 同じ名前のPHP関数を呼び出します            |
| `dump`        | PHP関数を呼び出します `var_dump()`    |
| `version`     | フレームワークの現在のバージョンを返します        |
| `constant`    | PHP定数を読み込む                   |
| `url`         | 'url' サービスを使用してURLを生成する      |

<a name='view-integrations'></a>

## Viewとの連携

またVolt は `Phalcon\Mvc\View` と統合しており、ビューの階層構造を利用したり、パーシャルをインクルードすることもできます:

```twig
{{ content() }}

<!-- Simple include of a partial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Passing extra variables -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
```

パーシャルはランタイムに含まれています。Voltは`include`を提供しており、これはビューのコンテンツをコンパイルし、インクルードされたビューのパーツとしてそのコンテンツを返します:

```twig
{# Simple include of a partial #}
<div id='footer'>
    {% include 'partials/footer' %}
</div>

{# Passing extra variables #}
<div id='footer'>
    {% include 'partials/footer' with ['links': links] %}
</div>
```

<a name='view-integration-include'></a>

### include文

Voltを使う上で、`include` は性能を改善するために特別な働きをします。ファイルをインクルードするときにこの拡張モジュールを指定した場合、このテンプレートをコンパイルしたときにこの拡張モジュールがあった場合、 それがインクルードされる親テンプレート中にそのテンプレートの内容をインライン化できます。 ただし`include` が `with`で渡された変数を持っている場合、テンプレートはインライン化されません。

```twig
{# 'partials/footer.volt' の内容がコンパイルされ、インライン展開されます #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
```

<a name='view-integration-partial-vs-include'></a>

### partial文 vs include文

`partial`関数や`include`を使用するときは、以下の点に注意してください:

- `partial` は、Voltと他のテンプレートエンジンで作成されたテンプレートをインクルードすることができます
- `partial` は、他のビューのコンテンツを動的に含めることができる、変数のような式を渡すことができます
- 含める必要のあるコンテンツを頻繁に変更のする場合`partial`はよい選択です。

- `include` は、コンパイルされたコンテンツをビューにコピーしてパフォーマンスを向上させます

- `include` は、 Voltで作成したテンプレートのみインクルードできます
- `include` は、コンパイル時に既存のテンプレートが必要です

<a name='template-inheritance'></a>

## テンプレートの継承

テンプレートの継承を使用すると、他のテンプレートで拡張してコードを再利用できる基本テンプレートを作成できます。 ベーステンプレートは子テンプレートによって上書きできる*blocks*を定義します。 次のベーステンプレートがあるとしましょう:

```twig
{# templates/base.volt #}
<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel='stylesheet' href='style.css' />
        {% endblock %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        <div id='content'>{% block content %}{% endblock %}</div>

        <div id='footer'>
            {% block footer %}&copy; Copyright 2015, All rights reserved.{% endblock %}
        </div>
    </body>
</html>
```

他のテンプレートからは、ブロックを置き換えて基本テンプレートを拡張することができます:

```twig
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>
{% endblock %}
```

すべてのブロックを子テンプレートで置き換える必要はなく、必要なもののみを置き換える必要があります。 生成される最終出力は次のようになります:

```html
<!DOCTYPE html>
<html>
    <head>
        <style type='text/css'>.important { color: #336699; }</style>

        <title>Index - My Webpage</title>
    </head>

    <body>
        <div id='content'>
            <h1>Index</h1>
            <p class='important'>Welcome on my awesome homepage.</p>
        </div>

        <div id='footer'>
            &copy; Copyright 2015, All rights reserved.
        </div>
    </body>
</html>
```

<a name='template-inheritance-multiple'></a>

### 多重継承

拡張テンプレートは他のテンプレートを拡張することができます。 次の例はそれを示しています:

```twig
{# main.volt #}
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>
        {% block content %}{% endblock %}
    </body>
</html>
```

`layout.volt` テンプレートで `main.volt` を拡張します。

```twig
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
```

最終的に`layout.volt`を拡張したビューは次のようになります:

```twig
{# index.volt #}
{% extends 'layout.volt' %}

{% block content %}

    {{ super() }}

    <ul>
        <li>Some option</li>
        <li>Some other option</li>
    </ul>

{% endblock %}
```

`index.volt` のレンダリングは次のようになります:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>

        <h1>Table of contents</h1>

        <ul>
            <li>Some option</li>
            <li>Some other option</li>
        </ul>

    </body>
</html>
```

関数 `super()` の呼び出しに注意してください。 その関数がある場合、親ブロックの内容をレンダリングできます。 partials のように、`extends`に設定されているパスは、現在の Viewディレクトリからの相対パスになります。(つまり `app/views/`です。)

<h5 class='alert alert-warning'>デフォルトでは、パフォーマンス上の理由から、Voltは子テンプレートの変更をチェックして、プレーンなPHPにいつ再コンパイルするかを知るため、オプション <code>'compileAlways' =&gt; true</code> でVoltを初期化することをお勧めします。 したがって、テンプレートは常に親テンプレートの変更を考慮してコンパイルされます。 </h5>

<a name='autoescape'></a>

## 自動エスケープ モード

自動エスケープモードを使用して、ブロックに出力されたすべての変数の自動エスケープを有効にすることができます:

```twig
Manually escaped: {{ robot.name|e }}

{% autoescape true %}
    Autoescaped: {{ robot.name }}
    {% autoescape false %}
        No Autoescaped: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
```

<a name='extending'></a>

## Volt の拡張

他のテンプレートエンジンとは異なり、Volt自体はコンパイルされたテンプレートを実行する必要はありません。 テンプレートがコンパイルされると、Voltには依存しません。 パフォーマンスの独立性を念頭において、VoltはPHPテンプレート用のコンパイラとしてのみ機能します。

Voltコンパイラでは、関数、テスト、フィルタを追加して既存のものに追加することができます。

<a name='extending-functions'></a>

### 関数

関数は通常のPHP関数として機能し、関数名としては有効な文字列名が必要です。 関数は、単純な文字列を返すか、または無名関数を使用する2つの方法を使用して追加できます。 選択した方法で、常に有効なPHP文字列式を返すことが必要です。

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// これは、Voltの関数名 'shuffle'をPHP関数 'str_shuffle'にバインドします
$compiler->addFunction('shuffle', 'str_shuffle');
```

関数を無名関数に登録します。 このケースでは、 `$resolvedArgs` を使用して、引数で渡されたとおりに引数を渡します。

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

個別で未解決の引数を扱う:

```php
<?php

$compiler->addFunction(
    'repeat',
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        // 最初の引数を解決する
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // 2番目の引数が渡されたかどうかをチェックする
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // デフォルトで '10' を使用
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    }
);
```

いくつかの機能の可用性に基づいてコードを生成する:

```php
<?php

$compiler->addFunction(
    'contains_text',
    function ($resolvedArgs, $exprArgs) {
        if (function_exists('mb_stripos')) {
            return 'mb_stripos(' . $resolvedArgs . ')';
        } else {
            return 'stripos(' . $resolvedArgs . ')';
        }
    }
);
```

組み込み関数をオーバーライドして、その関数の名前を追加することができます:

```php
<?php

// 組み込み関数のdumpを置き換える
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### フィルター

フィルタは、テンプレート内に次の形式を持ちます: leftExpr|name(オプション引数)。新しいフィルタを追加することは、関数で見られるのと似ています:

```php
<?php

// これにより、PHP関数 'md5'を使用するフィルタ 'hash' が作成されます。
$compiler->addFilter('hash', 'md5');
```

```php
<?php

$compiler->addFilter(
    'int',
    function ($resolvedArgs, $exprArgs) {
        return 'intval(' . $resolvedArgs . ')';
    }
);
```

組み込みフィルターをオーバーライドして、その関数の名前を追加することができます:

```php
<?php

// 組み込みフィルタを置き換える 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### エクステンション

拡張機能を使用すると、開発者はテンプレートエンジンを拡張したり、特定の命令のコンパイルをオーバーライドしたり、式や演算子の動作を変更したり、関数やフィルタを追加したりすることができます。

エクステンションは、それ自身のメソッドとしてVoltによってトリガされたイベントを実装するクラスです。 たとえば、以下のクラスでは、VoltでPHP関数を使用することができます:

```php
<?php

class PhpFunctionExtension
{
    /**
     * このメソッドは、関数呼び出しをコンパイルしようとすると呼び出されます
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }
}
```

上記のクラスは、どのテンプレートでも関数呼び出しをコンパイルしようとする前に呼び出されるメソッド `compileFunction` を実装しています。 拡張の目的は、コンパイルされる関数がテンプレートからPHP関数を呼び出すことができるかどうかを検証することです。 拡張機能のイベントは、有効なPHPコードを返す必要があります。これは、Voltによって生成されたものの代わりにコンパイルの結果として使用されます。 イベントが文字列を返さない場合、コンパイルはエンジンによって提供されるデフォルトの動作を使用して行われます。

エクステンションに実装できるコンパイルイベントは次のとおりです:

| イベント/関数             | 説明                                               |
| ------------------- | ------------------------------------------------ |
| `compileFunction`   | テンプレート内の任意の関数呼び出しをコンパイルしようとする前にトリガされる            |
| `compileFilter`     | テンプレート内の任意のフィルター呼び出しをコンパイルしようとする前にトリガされる         |
| `resolveExpression` | 任意の式をコンパイルする前にトリガされます。 これにより、開発者は演算子をオーバーライドできます |
| `compileStatement`  | 任意の式をコンパイルする前にトリガされます。 これにより、開発者は式をオーバーライドできます   |

Volt拡張はコンパイラに登録して、コンパイル時に利用できるようにする必要があります:

```php
<?php

// コンパイラに拡張機能を登録する
$compiler->addExtension(
    new PhpFunctionExtension()
);
```

<a name='caching-view-fragments'></a>

## Viewの断片のキャッシュ

Voltを使うと、ビュー断片のキャッシュが簡単になります。 このキャッシュにより、ビューが表示されるたびにPHPのブロックの内容が実行されないため、パフォーマンスが向上します:

```twig
{% cache 'sidebar' %}
    <!-- このコンテンツを生成するのが遅いのでキャッシュします -->
{% endcache %}
```

特定の秒数を設定する:

```twig
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- このコンテンツを生成するのが遅いのでキャッシュします -->
{% endcache %}
```

任意の有効な式をキャッシュキーとして使用できます:

```twig
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
```

キャッシングは、ビューコンポーネントを介して `Phalcon\Cache` コンポーネントによって行われます。 このインテグレーションの仕組みについて詳しくは、 [Viewの断片のキャッシュ](/[[language]]/[[version]]/views#caching-fragments) を参照してください。

<a name='services-in-templates'></a>

## テンプレートへのサービス注入

サービスコンテナ（DI）がVoltで使用可能な場合は、テンプレート内のサービス名にアクセスするだけでサービスを使用できます:

```twig
{# Inject the 'flash' service #}
<div id='messages'>{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
```

<a name='stand-alone'></a>

## 独立コンポーネント

スタンドアロンモードでVoltを使用すると、次のようになります:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// コンパイラーを生成
$compiler = new VoltCompiler();

// オプションでいくつかのオプションを追加する
$compiler->setOptions(
    [
        // ...
    ]
);

// PHPコードを返すテンプレート文字列をコンパイルする
echo $compiler->compileString(
    "{{ 'hello' }}"
);

// コピー先のファイルを指定してファイル内のテンプレートをコンパイルする
$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

// コンパイラに渡されるオプションに基づいてファイル内のテンプレートをコンパイルする
$compiler->compile(
    'layouts/main.volt'
);

// コンパイルされたテンプレートをrequire（オプション）
require $compiler->getCompiledTemplatePath();
```

## 外部リソース

- Sublime/Textmate用のバンドルは [こちら](https://github.com/phalcon/volt-sublime-textmate)
- [Album-O-Rama](https://album-o-rama.phalconphp.com) は、テンプレートエンジンとしてVoltを使用するサンプルアプリケーションです [Github](https://github.com/phalcon/album-o-rama)
- [私たちのウェブサイト](https://phalconphp.com) は、Voltをテンプレートエンジンとして使用しています。 [Github](https://github.com/phalcon/website)
- [Phosphorum](https://forum.phalconphp.com) PhalconのフォーラムではもちろんVoltを使っています。 [Github](https://github.com/phalcon/forum)
- [Vökuró](https://vokuro.phalconphp.com) その他のサンプルアプリケーションはVoltを利用しています [Github](https://github.com/phalcon/vokuro)