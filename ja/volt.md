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
          <a href="#control-structures">制御構文の一覧</a> 
          <ul>
            <li>
              <a href="#control-structures-for">for文</a>
            </li>
            <li>
              <a href="#control-structures-loops">ループ制御</a>
              <ul>
                <li>
                  <a href="#loop-controls-if">If文</a>
                </li>
                <li>
                  <a href="#loop-controls-switch">switch文</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#control-structures-loop">ループ変数</a> 
              <ul>
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
          <a href="#view-integrations">Viewとの連携</a> 
          <ul>
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
          <a href="#extending">Volt の拡張</a> 
          <ul>
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
| `autoescape`        | HTMLの自動エスケープをグローバルに利用可能にする                                 | `false` |
| `compileAlways`     | リクエスト毎にテンプレートをコンパイルしなければならない場合、または変更が必要な場合にのみ、Voltに伝えてください | `false` |
| `compiledExtension` | コンパイル済みのPHPファイルに追加する拡張子                                    | `.php`  |
| `compiledPath`      | コンパイルされたPHPテンプレートが保存される書き込み可能なパス                           | `./`    |
| `compiledSeparator` | Voltはコンパイルされたディレクトリに単一のファイルを作成するために、この区切り文字/を\に置き換えます     | `%%`    |
| `prefix`            | コンパイルパスのテンプレートにプレフィックスを付加することができます                         | `null`  |
| `stat`              | テンプレートファイルとコンパイルされたパスの違いが存在するかどうかをPhalconがチェックするかどうか       | `true`  |

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
                mkdir('cache/' . $dirName , 0777 , true);
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

| フィルター              | 説明                                                                                                                                 |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| `abs`              | Applies the [abs](http://php.net/manual/en/function.abs.php) PHP function to a value.                                              |
| `capitalize`       | Capitalizes a string by applying the [ucwords](http://php.net/manual/en/function.ucwords.php) PHP function to the value            |
| `convert_encoding` | Converts a string from one charset to another                                                                                      |
| `default`          | Sets a default value in case that the evaluated expression is empty (is not set or evaluates to a falsy value)                     |
| `e`                | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                           |
| `escape`           | Applies `Phalcon\Escaper->escapeHtml()` to the value                                                                           |
| `escape_attr`      | Applies `Phalcon\Escaper->escapeHtmlAttr()` to the value                                                                       |
| `escape_css`       | Applies `Phalcon\Escaper->escapeCss()` to the value                                                                            |
| `escape_js`        | Applies `Phalcon\Escaper->escapeJs()` to the value                                                                             |
| `format`           | Formats a string using [sprintf](http://php.net/manual/en/function.sprintf.php).                                                   |
| `json_encode`      | Converts a value into its [JSON](http://php.net/manual/en/function.json-encode.php) representation                                 |
| `json_decode`      | Converts a value from its [JSON](http://php.net/manual/en/function.json-encode.php) representation to a PHP representation         |
| `join`             | Joins the array parts using a separator [join](http://php.net/manual/en/function.join.php)                                         |
| `keys`             | Returns the array keys using [array_keys](http://php.net/manual/en/function.array-keys.php)                                        |
| `left_trim`        | Applies the [ltrim](http://php.net/manual/en/function.ltrim.php) PHP function to the value. Removing extra spaces                  |
| `length`           | Counts the string length or how many items are in an array or object                                                               |
| `lower`            | Change the case of a string to lowercase                                                                                           |
| `nl2br`            | Changes newlines `\n` by line breaks (`<br />`). Uses the PHP function [nl2br](http://php.net/manual/en/function.nl2br.php) |
| `right_trim`       | Applies the [rtrim](http://php.net/manual/en/function.rtrim.php) PHP function to the value. Removing extra spaces                  |
| `sort`             | PHP 関数 [asort](http://php.net/manual/en/function.asort.php) を使用して配列をソートします。                                                        |
| `stripslashes`     | [stripslashes](http://php.net/manual/en/function.stripslashes.php) PHP 関数を値に適用して、エスケープされた引用符を削除します。                                |
| `striptags`        | [striptags](http://php.net/manual/en/function.striptags.php) PHP 関数を値に適用して、HTMLタグを削除します。                                           |
| `trim`             | [trim](http://php.net/manual/en/function.trim.php) PHP 関数を値に適用して、余分な半角スペースを削除します。                                                  |
| `upper`            | 文字列を大文字に変更します。                                                                                                                     |
| `url_encode`       | [urlencode](http://php.net/manual/en/function.urlencode.php) PHP 関数を値に適用します。                                                       |

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

<a name='loop-controls-if'></a>

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

<a name='loop-controls-switch'></a>

### switch文

An alternative to the `if` statement is `switch`, allowing you to create logical execution paths in your application:

```twig
{% switch foo %}
    {% case 0 %}
    {% case 1 %}
    {% case 2 %}
        "foo" is less than 3 but not negative
        {% break %}
    {% case 3 %}
        "foo" is 3
        {% break %}
    {% default %}
        "foo" is {{ foo }}
{% endswitch %}

```

The `switch` statement executes statement by statement, therefore the `break` statement is necessary in some cases. Any output (including whitespace) between a switch statement and the first `case` will result in a syntax error. Empty lines and whitespaces can therefore be cleared to reduce the number of errors [see here](http://php.net/control-structures.alternative-syntax).

#### `case` without `switch`

```twig
{% case EXPRESSION %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Unexpected CASE`.

#### `switch` without `endswitch`

```twig
{% switch EXPRESSION %}
Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected EOF in ..., there is a 'switch' block without 'endswitch'`.
```

#### `default` without `switch`

```twig
{% default %}
```

Will not throw an error because `default` is a reserved word for filters like `{{ EXPRESSION | default(VALUE) }}` but in this case the expression will only output an empty char '' .

#### nested `switch`

```twig
{% switch EXPRESSION %}
  {% switch EXPRESSION %}
  {% endswitch %}
{% endswitch %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: A nested switch detected. There is no nested switch-case statements support in ... on line ...`

#### a `switch` without an expression

```twig
{% switch %}
  {% case EXPRESSION %}
      {% break %}
{% endswitch %}
```

Will throw `Fatal error: Uncaught Phalcon\Mvc\View\Exception: Syntax error, unexpected token %} in ... on line ...`

<a name='control-structures-loop'></a>

### ループ変数

`for` ループで使用できる特別な変数の情報を提供します。

| 変数               | Description                                                   |
| ---------------- | ------------------------------------------------------------- |
| `loop.index`     | The current iteration of the loop. (1 indexed)                |
| `loop.index0`    | The current iteration of the loop. (0 indexed)                |
| `loop.revindex`  | The number of iterations from the end of the loop (1 indexed) |
| `loop.revindex0` | The number of iterations from the end of the loop (0 indexed) |
| `loop.first`     | True if in the first iteration.                               |
| `loop.last`      | True if in the last iteration.                                |
| `loop.length`    | The number of items to iterate                                |

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

Variables may be changed in a template using the instruction 'set':

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
```

Multiple assignments are allowed in the same instruction:

```twig
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
```

Additionally, you can use compound assignment operators:

```twig
{% set price += 100.00 %}

{% set age *= 5 %}
```

次の演算子が使用できます。

| 演算子     | 説明                        |
| ------- | ------------------------- |
| `=`     | Standard Assignment       |
| `+=`    | Addition assignment       |
| `-=`    | Subtraction assignment    |
| `\*=` | Multiplication assignment |
| `/=`    | Division assignment       |

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

The following literals are supported:

| フィルター                | Description                                                        |
| -------------------- | ------------------------------------------------------------------ |
| `'this is a string'` | Text between double quotes or single quotes are handled as strings |
| `100.25`             | Numbers with a decimal part are handled as doubles/floats          |
| `100`                | Numbers without a decimal part are handled as integers             |
| `false`              | Constant 'false' is the boolean false value                        |
| `true`               | Constant 'true' is the boolean true value                          |
| `null`               | Constant 'null' is the Null value                                  |

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

### Math

次の演算子を使用して、テンプレートで計算を行えます。

| Operator | Description                                                             |
|:--------:| ----------------------------------------------------------------------- |
|   `+`    | Perform an adding operation. `{{ 2 + 3 }}` returns 5                    |
|   `-`    | Perform a substraction operation `{{ 2 - 3 }}` returns -1               |
|   `*`    | Perform a multiplication operation `{{ 2 * 3 }}` returns 6              |
|   `/`    | Perform a division operation `{{ 10 / 2 }}` returns 5                   |
|   `%`    | Calculate the remainder of an integer division `{{ 10 % 3 }}` returns 1 |

<a name='expressions-comparisons'></a>

### Comparisons

次の比較演算が使用できます。

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `==`    | Check whether both operands are equal                             |
|    `!=`    | Check whether both operands aren't equal                          |
| `<>` | Check whether both operands aren't equal                          |
|   `>`   | Check whether left operand is greater than right operand          |
|   `<`   | Check whether left operand is less than right operand             |
|  `<=`   | Check whether left operand is less or equal than right operand    |
|  `>=`   | Check whether left operand is greater or equal than right operand |
|   `===`    | Check whether both operands are identical                         |
|   `!==`    | Check whether both operands aren't identical                      |

<a name='expressions-logic'></a>

### Logic

論理演算子は、複数のテストを組合せた`if` 式で使用します。

|  Operator  | Description                                                       |
|:----------:| ----------------------------------------------------------------- |
|    `or`    | Return true if the left or right operand is evaluated as true     |
|   `and`    | Return true if both left and right operands are evaluated as true |
|   `not`    | Negates an expression                                             |
| `( expr )` | Parenthesis groups expressions                                    |

<a name='expressions-other-operators'></a>

### Other Operators

以下の追加の演算子が利用できます。

| Operator          | Description                                                                     |
| ----------------- | ------------------------------------------------------------------------------- |
| `~`               | Concatenates both operands `{{ 'hello ' ~ 'world' }}`                           |
| `|`               | Applies a filter in the right operand to the left `{{ 'hello'|uppercase }}`     |
| `..`              | Creates a range `{{ 'a'..'z' }}` `{{ 1..10 }}`                                  |
| `is`              | Same as == (equals), also performs tests                                        |
| `in`              | To check if an expression is contained into other expressions `if 'a' in 'abc'` |
| `is not`          | Same as != (not equals)                                                         |
| `'a' ? 'b' : 'c'` | Ternary operator. The same as the PHP ternary operator                          |
| `++`              | Increments a value                                                              |
| `--`              | Decrements a value                                                              |

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

## Tests

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

| Test          | Description                                                          |
| ------------- | -------------------------------------------------------------------- |
| `defined`     | Checks if a variable is defined (`isset()`)                          |
| `divisibleby` | Checks if a value is divisible by other value                        |
| `empty`       | Checks if a variable is empty                                        |
| `even`        | Checks if a numeric value is even                                    |
| `iterable`    | Checks if a value is iterable. Can be traversed by a 'for' statement |
| `numeric`     | Checks if value is numeric                                           |
| `odd`         | Checks if a numeric value is odd                                     |
| `sameas`      | Checks if a value is identical to other value                        |
| `scalar`      | Checks if value is scalar (not an array or object)                   |
| `type`        | Checks if a value is of the specified type                           |

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

## Macros

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

When calling macros, parameters can be passed by name:

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

Macros can return values:

```twig
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

And receive optional parameters:

```twig
{%- macro my_input(name, class='input-text') %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
```

<a name='tag-helpers'></a>

## Using Tag Helpers

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

## Functions

Voltで使用できるビルトインの関数:

| Name          | Description                                                 |
| ------------- | ----------------------------------------------------------- |
| `content`     | Includes the content produced in a previous rendering stage |
| `get_content` | Same as `content`                                           |
| `partial`     | Dynamically loads a partial view in the current template    |
| `super`       | Render the contents of the parent block                     |
| `time`        | Calls the PHP function with the same name                   |
| `date`        | Calls the PHP function with the same name                   |
| `dump`        | Calls the PHP function `var_dump()`                         |
| `version`     | Returns the current version of the framework                |
| `constant`    | Reads a PHP constant                                        |
| `url`         | Generate a URL using the 'url' service                      |

<a name='view-integrations'></a>

## View Integration

Also, Volt is integrated with `Phalcon\Mvc\View`, you can play with the view hierarchy and include partials as well:

```twig
{{ content() }}

<!-- Simple include of a partial -->
<div id='footer'>{{ partial('partials/footer') }}</div>

<!-- Passing extra variables -->
<div id='footer'>{{ partial('partials/footer', ['links': links]) }}</div>
```

A partial is included in runtime, Volt also provides `include`, this compiles the content of a view and returns its contents as part of the view which was included:

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

### Include

`include` has a special behavior that will help us improve performance a bit when using Volt, if you specify the extension when including the file and it exists when the template is compiled, Volt can inline the contents of the template in the parent template where it's included. Templates aren't inlined if the `include` have variables passed with `with`:

```twig
{# The contents of 'partials/footer.volt' is compiled and inlined #}
<div id='footer'>
    {% include 'partials/footer.volt' %}
</div>
```

<a name='view-integration-partial-vs-include'></a>

### Partial vs Include

Keep the following points in mind when choosing to use the `partial` function or `include`:

| Type       | Description                                                                                                |
| ---------- | ---------------------------------------------------------------------------------------------------------- |
| `partial`  | allows you to include templates made in Volt and in other template engines as well                         |
|            | allows you to pass an expression like a variable allowing to include the content of other view dynamically |
|            | is better if the content that you have to include changes frequently                                       |
| `includes` | copies the compiled content into the view which improves the performance                                   |
|            | only allows to include templates made with Volt                                                            |
|            | requires an existing template at compile time                                                              |

<a name='template-inheritance'></a>

## Template Inheritance

With template inheritance you can create base templates that can be extended by others templates allowing to reuse code. A base template define *blocks* than can be overridden by a child template. Let's pretend that we have the following base template:

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

From other template we could extend the base template replacing the blocks:

```twig
{% extends 'templates/base.volt' %}

{% block title %}Index{% endblock %}

{% block head %}<style type='text/css'>.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class='important'>Welcome on my awesome homepage.</p>
{% endblock %}
```

Not all blocks must be replaced at a child template, only those that are needed. The final output produced will be the following:

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

### Multiple Inheritance

Extended templates can extend other templates. The following example illustrates this:

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

Template `layout.volt` extends `main.volt`

```twig
{# layout.volt #}
{% extends 'main.volt' %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
```

Finally a view that extends `layout.volt`:

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

Rendering `index.volt` produces:

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

Note the call to the function `super()`. With that function it's possible to render the contents of the parent block. As partials, the path set to `extends` is a relative path under the current views directory (i.e. `app/views/`).

<div class="alert alert-warning">
    <p>
        By default, and for performance reasons, Volt only checks for changes in the children templates to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option <code>'compileAlways' => true</code>. Thus, the templates are compiled always taking into account changes in the parent templates.
    </p>
</div>

<a name='autoescape'></a>

## Autoescape mode

You can enable auto-escaping of all variables printed in a block using the autoescape mode:

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

## Extending Volt

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

<a name='extending-functions'></a>

### Functions

Functions act as normal PHP functions, a valid string name is required as function name. Functions can be added using two strategies, returning a simple string or using an anonymous function. Always is required that the chosen strategy returns a valid PHP string expression:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
$compiler->addFunction('shuffle', 'str_shuffle');
```

Register the function with an anonymous function. This case we use `$resolvedArgs` to pass the arguments exactly as were passed in the arguments:

```php
<?php

$compiler->addFunction(
    'widget',
    function ($resolvedArgs, $exprArgs) {
        return 'MyLibrary\Widgets::get(' . $resolvedArgs . ')';
    }
);
```

Treat the arguments independently and unresolved:

```php
<?php

$compiler->addFunction(
    'repeat',
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        // Resolve the first argument
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // Checks if the second argument was passed
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // Use '10' as default
            $secondArgument = '10';
        }

        return 'str_repeat(' . $firstArgument . ', ' . $secondArgument . ')';
    }
);
```

Generate the code based on some function availability:

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

Built-in functions can be overridden adding a function with its name:

```php
<?php

// Replace built-in function dump
$compiler->addFunction('dump', 'print_r');
```

<a name='extending-filters'></a>

### Filters

A filter has the following form in a template: leftExpr|name(optional-args). Adding new filters is similar as seen with the functions:

```php
<?php

// This creates a filter 'hash' that uses the PHP function 'md5'
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

Built-in filters can be overridden adding a function with its name:

```php
<?php

// Replace built-in filter 'capitalize'
$compiler->addFilter('capitalize', 'lcfirst');
```

<a name='extending-extensions'></a>

### Extensions

With extensions the developer has more flexibility to extend the template engine, and override the compilation of a specific instruction, change the behavior of an expression or operator, add functions/filters, and more.

An extension is a class that implements the events triggered by Volt as a method of itself. For example, the class below allows to use any PHP function in Volt:

```php
<?php

class PhpFunctionExtension
{
    /**
     * This method is called on any attempt to compile a function call
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }
    }
}
```

The above class implements the method `compileFunction` which is invoked before any attempt to compile a function call in any template. The purpose of the extension is to verify if a function to be compiled is a PHP function allowing to call it from the template. Events in extensions must return valid PHP code, this will be used as result of the compilation instead of the one generated by Volt. If an event doesn't return an string the compilation is done using the default behavior provided by the engine.

The following compilation events are available to be implemented in extensions:

| Event/Method        | Description                                                                                            |
| ------------------- | ------------------------------------------------------------------------------------------------------ |
| `compileFunction`   | Triggered before trying to compile any function call in a template                                     |
| `compileFilter`     | Triggered before trying to compile any filter call in a template                                       |
| `resolveExpression` | Triggered before trying to compile any expression. This allows the developer to override operators     |
| `compileStatement`  | Triggered before trying to compile any expression. This allows the developer to override any statement |

Volt extensions must be in registered in the compiler making them available in compile time:

```php
<?php

// Register the extension in the compiler
$compiler->addExtension(
    new PhpFunctionExtension()
);
```

<a name='caching-view-fragments'></a>

## Caching view fragments

With Volt it's easy cache view fragments. This caching improves performance preventing that the contents of a block from being executed by PHP each time the view is displayed:

```twig
{% cache 'sidebar' %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Setting a specific number of seconds:

```twig
{# cache the sidebar by 1 hour #}
{% cache 'sidebar' 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
```

Any valid expression can be used as cache key:

```twig
{% cache ('article-' ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
```

The caching is done by the `Phalcon\Cache` component via the view component. Learn more about how this integration works in the section [Caching View Fragments](/[[language]]/[[version]]/views#caching-fragments).

<a name='services-in-templates'></a>

## Inject Services into a Template

If a service container (DI) is available for Volt, you can use the services by only accessing the name of the service in the template:

```twig
{# Inject the 'flash' service #}
<div id='messages'>{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type='hidden' name='token' value='{{ security.getToken() }}'>
```

<a name='stand-alone'></a>

## Stand-alone component

Using Volt in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// Create a compiler
$compiler = new VoltCompiler();

// Optionally add some options
$compiler->setOptions(
    [
        // ...
    ]
);

// Compile a template string returning PHP code
echo $compiler->compileString(
    "{{ 'hello' }}"
);

// Compile a template in a file specifying the destination file
$compiler->compileFile(
    'layouts/main.volt',
    'cache/layouts/main.volt.php'
);

// Compile a template in a file based on the options passed to the compiler
$compiler->compile(
    'layouts/main.volt'
);

// Require the compiled templated (optional)
require $compiler->getCompiledTemplatePath();
```

## External Resources

* A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
* [Album-O-Rama](https://album-o-rama.phalconphp.com) is a sample application using Volt as template engine, [Github](https://github.com/phalcon/album-o-rama)
* [Our website](https://phalconphp.com) is running using Volt as template engine, [Github](https://github.com/phalcon/website)
* [Phosphorum](https://forum.phalconphp.com), the Phalcon's forum, also uses Volt, [Github](https://github.com/phalcon/forum)
* [Vökuró](https://vokuro.phalconphp.com), is another sample application that use Volt, [Github](https://github.com/phalcon/vokuro)