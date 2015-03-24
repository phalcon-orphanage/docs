モチベーション
==============
現在、多くのPHPフレームワークがありますが、その中でPhalconのようなものはまだありません。

ほとんどのプログラマーは、フレームワークを使うことを好みます。第一の理由としては、既にテストされた多くの機能があるからです。
それにより、「DRY」なコードを担保できます。
しかし、フレームワークは、アプリケーションからのリクエストごとに解釈＆実行される数百行のコードを含む多くのファイルを必要とします。
また、オブジェクト指向のフレームワークの場合、複雑なアプリケーションの実行速度を遅くさせてしまうという短所があります。
全ての操作がアプリケーションの遅さ、さらにはUXに悪い影響を与えてしまいます。

質問
------------
ほとんどが強みである堅牢なフレームワークがなぜないのか？

これはPhalconが生まれた理由です！

ここ数ヶ月間、大々的にPHPの振る舞いや有効な最適化などについて研究してきました。
この調査結果を通して、不要な検証を除いたり、コードをコンパクトにしたり、パフォーマンスを最適化したりして、Phalconによってパフォーマンスが最大化できるような
低レベルでのソリューションを構築してきました。

なぜ?
----
* フレームワークを使うことは、PHPの開発者の中で一般的になってきました
* フレームワークを使うことで、プロジェクトを簡単にメンテナンスできたり、少ないコードでより速く動作できるようにします
* 我々はPHPを愛しており、大規模で壮大なプロジェクトを作れることを考えています

PHPの内部での動作は?
----------------------
* PHP has dynamic and weak variable types. Every time a binary operation is made (ex. 2 + "2"), PHP checks the operand types to perform potential conversions
* PHP is interpreted and not compiled. The major disadvantage is performance loss
* Every time a script is requested it must be first interpreted
* If a bytecode cache (like APC) isn't used, syntax checking is performed every time for every file in the request

従来のPHPフレームワークはどう動作するか?
---------------------------------------
* Many files with classes and functions are read on every request made. Disk reading is expensive in terms of performance, especially when the file structure includes deep folders
* Modern frameworks use lazy loading (autoload) to increase performance (for load and execute only the code needed)
* Some of these classes contain methods that aren't used in every request but they're loaded always consuming memory
* Continuous loading or interpreting is expensive and impacts performance
* The framework code does not change very often, therefore an application needs to load and interpret it every time a request is made

PHPのC拡張はどう動作するか?
--------------------------------
* C extensions are loaded together with PHP one time on the web server's daemon start process
* Classes and functions provided by the extension are ready to use for any application
* The code isn't interpreted because is already compiled to a specific platform and processor

Phalconはどう動作するか?
----------------------
* Components are loosely coupled. With Phalcon, nothing is imposed on you: you're free to use the full framework, or just some parts of it as a glue components.
* Low-level optimizations provides the lowest overhead for MVC-based applications
* Interact with databases with maximum performance by using a C-language ORM for PHP
* Phalcon directly accesses internal PHP structures optimizing execution in that way as well

なぜPhalconを必要とするのか?
----------------------
Each application requirements and tasks are different than another's. Some for instance are designed to do a set
of tasks and generate content that rarely changes. These applications can be created with any programming language or
framework. Using a front-end cache, usually makes such an application, no matter how poorly designed or slow it might be,
perform very fast.

Other applications generate content almost immediately that changes from request to request. In this case, PHP is used
to address all requests and generate the content. These applications can be APIs, discussion forums with high traffic loads,
blogs with a high number of comments and contributors, statistic applications, admin dashboards, enterprise resource
planners (ERP), business-intelligence software dealing with real time data and more.

An application will be as slow as its slowest component/process. Phalcon offers a very fast yet feature rich framework
that allows developers to concentrate on making their applications/code faster. Following proper coding processes,
Phalcon can deliver a lot more functionality/requests with less memory consumption and processing cycles.

結論
----------
PhalconはPHPの最速フレームワークです。「重要なのはパフォーマンスである」という指針に基づいて実装されたフレームワークであり、
これを使ったアプリケーションの構築は簡単で堅牢な方法でできます！ぜひ楽しんでください！
