Cherokee インストール ノート
============================

Cherokee_ は高パフォーマンスのWebサーバーです。非常に高速かつ柔軟で、設定も簡単です。

PhalconのためのCherokeeの設定
--------------------------------
Cherokee はWebサーバで設定可能なほぼ全ての設定を構成するための、使いやすいグラフィカルインターフェースを提供します。rootで /path-to-cherokee/sbin/cherokee-admin を実行して、Cherokee administratorを起動してください。：

.. figure:: ../_static/img/cherokee-1.jpg
    :align: center

「vServers」をクリックして、新しいバーチャルホストを作成し、新しい仮想サーバーを追加してください。：

.. figure:: ../_static/img/cherokee-2.jpg
    :align: center

最近追加した仮想サーバーが、画面上の左のバーに表示されるはずです。「Behaviors」タブで、仮想サーバーのデフォルトのビヘイビアを見ることができます。「Rule Management」ボタンをクリックし、「Directory /cherokee_themes」と「Directory /icons」を削除します：

.. figure:: ../_static/img/cherokee-3.jpg
    :align: center

ウィザードに従って、PHP言語のビヘイビアを追加します。このビヘイビアによって、PHPアプリケーションを実行できるようになります。：

.. figure:: ../_static/img/cherokee-4.jpg
    :align: center

通常、このビヘイビアには追加の設定は必要ありません。もう1つビヘイビアを追加しましょう。今度は「Manual Configuration」セクションの「Rule Type」で、「File Exists」を選択し、「Match any file」が有効になっていることを確認してください。：

.. figure:: ../_static/img/cherokee-55.jpg
    :align: center

「Handler」タブで、「List & Send」をハンドラーとして選択します。：

.. figure:: ../_static/img/cherokee-7.jpg
    :align: center

URLのリライトエンジンを有効化するため、「Default」ビヘイビアを編集します。ハンドラーを「Redirection」に変更し、「^(.*)$」という正規表現をエンジンに追加します。：

.. figure:: ../_static/img/cherokee-6.jpg
    :align: center

最後に、ビヘイビアが次の順番になっていることを確認してください：

.. figure:: ../_static/img/cherokee-8.jpg
    :align: center

ブラウザでアプリケーションを実行します：

.. figure:: ../_static/img/cherokee-9.jpg
    :align: center

.. _Cherokee: http://www.cherokee-project.com/
