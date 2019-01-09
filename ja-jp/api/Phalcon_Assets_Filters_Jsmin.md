* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Assets\Filters\Jsmin'

* * *

# Class **Phalcon\Assets\Filters\Jsmin**

*implements* [Phalcon\Assets\FilterInterface](/3.4/en/api/Phalcon_Assets_FilterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/assets/filters/jsmin.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

JavaScript に解釈されない不要な文字を削除します。 コメントは削除されます。 タブをスペースに置き換えます。 キャリッジリターンをラインフィードに置き換えます。 ほとんどのスペースやラインフィードが削除されます。

## メソッド

public **filter** (*mixed* $content)

JSMIN を使用してコンテンツをフィルタします。