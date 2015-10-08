アクセス制御リスト (ACL)
=================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` はACLだけでなく、それらに付随するアクセス権を簡単かつ軽量に管理する機能を提供します。 `Access Control Lists`_ (ACL) は、アプリケーションがリクエストによるその領域や背後にあるオブジェクトへのアクセスを制御することを可能にします。あなたがその概念を十分に理解できるよう、ACLの方法論についての詳細を読むことをお勧めします。

要約すると、ACLsは役割とリソースを持っています。リソースとは、ACLsによって定義されたパーミッションに沿うオブジェクトのことです。役割とはACLメカニズムによって、リソースへのアクセスをリクエストしたり、アクセスが許可されたり拒否されたりするオブジェクトのことです。

ACLの生成
--------
このコンポーネントはメモリー上で最初に動くように設計されています。これにより、利用したり、リストのすべての面に早くアクセスすることが出来る様になります。 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` コンストラクターは、コントロールリストに関連する情報を回収するアダプターを第一パラメーターにとります。メモリーアダプターを利用する例が以下の様になります。

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

デフォルトで、 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` は、未だ定義されていないリソースに対するアクションにアクセスすることを許可します。アクセスリストのセキュリティレベルを上げるに、デフォルトのアクセスレベルである "deny"を定義できます。

.. code-block:: php

    <?php

    // デフォルトアクションへのアクセスを拒否
    $acl->setDefaultAction(Phalcon\Acl::DENY);

ACLにロールの追加
------------
ロールは、アクセスリストの特定のリソースへのアクセスの可否を決定されるオブジェクトです。一例として、組織の中のグループをロールとして定義してみます。:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` によって、ロールをより構造化された方法で作成できます。リストにロールを追加してみましょう：

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // いくつかのロールを作成
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // ACLに「ゲスト」のロールを追加する
    $acl->addRole($roleGuests);

    // Phalcon\Acl\Roleを利用せずに"デザイナー"ロールを追加
    $acl->addRole("Designers");

ご覧のように、インスタンスを使用せずにロールを直接定義することができます。

リソースの追加
---------
リソースはアクセスが制御されるオブジェクトです。通常、MVCアプリケーションではリソースはコントローラーを参照します。必須ではないものの、 :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` を使ってリソースを定義することができます。関連するアクションや操作をリソースに追加しておくことは、ACLに何をコントロールすべきか知らせることができるため重要です。

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // 「顧客」リソースを定義
    $customersResource = new Resource("Customers");

    // いくつかのオペレーションとともに"顧客"リソースを追加する
    $acl->addResource($customersResource, "search");
    $acl->addResource($customersResource, array("create", "update"));

アクセス制御の定義
------------------------
ロールとリソースが定義できました。次に、ACLを定義しましょう。要は、どのロールがどのリソースにアクセスするかの定義です。ここは、非常に重要です。特に、デフォルトのアクセスレベルを「allow」にするか「deny」にするかは、慎重に考えましょう。

.. code-block:: php

    <?php

    // ロールのリソースへのアクセルレベルを設定する。
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

:code:`allow()`メソッドは特定のロールが特定のリソースへのアクセス権を与えられたことを明示します。:code:`deny()`メソッドはその反対です。

ACLの照会
---------------
リストが全て定義できました。これで、ロールがパーミッションを与えられているか否か、照会できるようになります。

.. code-block:: php

    <?php

    // ロールが操作を行う権限を持っているかチェック
    $acl->isAllowed("Guests", "Customers", "edit");   // 0が返る
    $acl->isAllowed("Guests", "Customers", "search"); // 1が返る
    $acl->isAllowed("Guests", "Customers", "create"); // 1が返る

ロールの継承
-----------------
:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` の提供する継承機能を用いることで、複雑なロールの構造を作ることができます。ロールは別のロールを継承することができ、リソースのスーパーセットやサブセットへのアクセスを許可することができます。ロールの継承を使うには、ロールをリストに追加する際、継承されるロールを第2パラメータに渡す必要があります。

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // Create some roles
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // Add "Guests" role to ACL
    $acl->addRole($roleGuests);

    // 「Administrators」ロールに、「Guests」ロールから継承したアクセス権を与える
    $acl->addRole($roleAdmins, $roleGuests);

ACLリストのシリアライズ
-------------
パフォーマンス向上のため、 :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` のインスタンスをシリアライズして、APC、セッション、テキストファイルやデータベースのテーブルに保存しておくことができます。こうすることで、リスト全体の再定義を行うことなく、好きな時にリストを呼び出すことができます。以下のように実装できます:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // ACLデータが既に存在するかどうかをチェックする
    if (!is_file("app/security/acl.data")) {

        $acl = new AclList();

        // ロール、リソース、アクセスなどを定義

        // シリアライズされたリストをファイルに格納
        file_put_contents("app/security/acl.data", serialize($acl));
    } else {

         // シリアライズされたファイルからACLオブジェクトを復元
         $acl = unserialize(file_get_contents("app/security/acl.data"));
    }

    // 必要に応じてACLリストを使用します
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

ACLイベント
-------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` は、 :doc:`EventsManager <events>` にイベントを送れます。イベントは"acl"というタイプで発火します。falseを返すイベントは、現在の処理を中断させることがあります。以下のイベントがサポートされています:

+-------------------+---------------------------------------------------------+---------------------+
| Event Name        | Triggered                                               | Can stop operation? |
+===================+=========================================================+=====================+
| beforeCheckAccess | Triggered before checking if a role/resource has access | Yes                 |
+-------------------+---------------------------------------------------------+---------------------+
| afterCheckAccess  | Triggered after checking if a role/resource has access  | No                  |
+-------------------+---------------------------------------------------------+---------------------+

以下の例では、リスナーにこのコンポーネントを紐付けています:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // イベントマネージャーを作成
    $eventsManager = new EventsManager();

    // リスナーに「acl」タイプを紐付け
    $eventsManager->attach("acl", function ($event, $acl) {
        if ($event->getType() == "beforeCheckAccess") {
             echo   $acl->getActiveRole(),
                    $acl->getActiveResource(),
                    $acl->getActiveAccess();
        }
    });

    $acl = new AclList();

    // $acl をセットアップ
    // ...

    // aclコンポーネントにイベントマネージャーを紐付け
    $acl->setEventsManager($eventManagers);

独自アダプタの実装
-------------
:doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` インターフェースを実装することで、独自のACLアダプタを作成したり、既存のアダプタを継承したりできます。

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
