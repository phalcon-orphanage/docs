* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='architecture'></a>

# MVC アーキテクチャ

Phalcon offers the object-oriented classes, necessary to implement the Model, View, Controller architecture (often referred to as [MVC](https://en.wikipedia.org/wiki/Model–view–controller)) in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* ビジネスロジックをユーザインタフェースとデータベース層から分離
* 異なる種類のコードがどこに属するかを明確にし、メンテナンスを容易にする

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in C language, offering a high performance approach of this pattern in a PHP based application.

<a name='models'></a>

## Models

モデルは、アプリケーションの情報 (データ) と、そのデータを操作するためのルールを表します。 モデルは主に、それに対応するテーブルとの対話のルールを管理するために使用されます。 ほとんどの場合、データベース内の各テーブルは、アプリケーション内の1つのモデルと対応します。 アプリケーションのビジネスロジックの大半は、モデルに集中します。 [Learn more](/4.0/en/models)

<a name='views'></a>

## Views

ビューはアプリケーションのユーザインタフェースを表します。 ビューは、多くの場合にデータの表示のみに関連するタスクを実行する、埋め込みの PHP コードを含む HTML ファイルです。 ビューは、ウェブブラウザやその他のツールにデータを提供するための、アプリケーションからの要求を処理します。 [Learn more](/4.0/en/views)

<a name='controllers'></a>

## Controllers

The controllers provide the 'flow' between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [Learn more](/4.0/en/controllers)