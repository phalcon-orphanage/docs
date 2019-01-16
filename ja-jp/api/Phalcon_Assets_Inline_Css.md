* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Assets\Inline\Css'

* * *

# Class **Phalcon\Assets\Inline\Css**

*extends* class [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/assets/inline/css.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

インラインCSSを表します。

## メソッド

public **__construct** (*string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline\Css Constructor

public *string* **getType** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

リソースの型を取得します。

public *string* **getContent** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

コンテンツを取得します。

public *boolean* **getFilter** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

リソースをフィルターするかどうかを取得します。

public *array* **getAttributes** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

追加の HTML 属性を取得します。

public [*self*](Phalcon_Assets_Inline_Css) **setType** (*string* $type) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

インラインのタイプを設定します。

public [*self*](Phalcon_Assets_Inline_Css) **setFilter** (*boolean* $filter) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

リソースをフィルターするかどうかを設定します。

public [*self*](Phalcon_Assets_Inline_Css) **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

追加の HTML 属性を設定します

public *string* **getResourceKey** () inherited from [Phalcon\Assets\Inline](Phalcon_Assets_Inline)

リソースのキーを取得します。