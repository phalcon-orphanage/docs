---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Model View Controller (MVC)'
keywords: 'model, view, controller, model view controller, mvc'
---

# MVC - Model View Controller

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

Model View Controller ([MVC](https://en.wikipedia.org/wiki/Model–view–controller)) is a software architectural pattern, which divides the application logic into three interconnected elements, separating internal representations of information of the application.

Phalcon offers the object-oriented classes, necessary to implement the Model View Controller in your application. This design pattern is widely used by other web frameworks and desktop applications.

MVC benefits include:

* ビジネスロジックをユーザインタフェースとデータベース層から分離
* 異なる種類のコードがどこに属するかを明確にし、メンテナンスを容易にする

If you decide to use MVC, every request to your application resources will be managed by the MVC architecture. Phalcon classes are written in Zephir, which is translated to C, offering a high performance implementation of the MVC pattern in PHP applications.

## モデル

モデルは、アプリケーションの情報 (データ) と、そのデータを操作するためのルールを表します。 モデルは主に、それに対応するテーブルとの対話のルールを管理するために使用されます。 ほとんどの場合、データベース内の各テーブルは、アプリケーション内の1つのモデルと対応します。 アプリケーションのビジネスロジックの大半は、モデルに集中します。 [more...](db-models)

## Views

ビューはアプリケーションのユーザインタフェースを表します。 ビューは、多くの場合にデータの表示のみに関連するタスクを実行する、埋め込みの PHP コードを含む HTML ファイルです。 ビューは、ウェブブラウザやその他のツールにデータを提供するための、アプリケーションからの要求を処理します。 [more...](views)

## コントローラ

The controllers provide the *flow* between models and views. Controllers are responsible for processing the incoming requests from the web browser, interrogating the models for data, and passing that data on to the views for presentation. [more...](controllers)