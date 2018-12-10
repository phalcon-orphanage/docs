<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">レスポンスを返す</a> <ul>
        <li>
          <a href="#working-with-headers">HTTPヘッダの利用</a>
        </li>
        <li>
          <a href="#redirections">リダイレクト</a>
        </li>
        <li>
          <a href="#http-cache">HTTPキャッシュ</a> <ul>
            <li>
              <a href="#http-cache-expiration-time">期限の設定</a>
            </li>
            <li>
              <a href="#http-cache-control">キャッシュコントロール</a>
            </li>
            <li>
              <a href="#http-cache-etag">E-Tag</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# レスポンスを返す

HTTP サイクルの一部は、クライアントへレスポンスを返すことです。 `Phalcon\Http\Response` は、このタスクを達成するために設計されたPhalconコンポーネントです。 HTTP 応答は通常、ヘッダーとボディで構成されます。 以下に、基本的な使い方の例を示します。

```php
<?php

use Phalcon\Http\Response;

// Responseインスタンスの取得
$response = new Response();

// ステータスコードの設定
$response->setStatusCode(404, 'Not Found');

// レスポンスの内容の設定
$response->setContent("Sorry, the page doesn't exist");

// クライアントにレスポンスを送信
$response->send();
```

完全な MVC スタックを使用している場合、手動で反応を作成する必要はありません。しかし、コントローラーのアクションから直接応答を返す必要がある場合この例に従います。

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class FeedController extends Controller
{
    public function getAction()
    {
        // Responseインスタンスの取得
        $response = new Response();

        $feed = // ... ここでfeedをロード

        // レスポンスの内容をセット
        $response->setContent(
            $feed->asString()
        );

        // レスポンスを返す
        return $response;
    }
}
```

<a name='working-with-headers'></a>

## HTTPヘッダの利用

ヘッダーはHTTPレスポンスの重要な部分です。 HTTPステータス、レスポンスタイプなどのレスポンスの状態に関する有用な情報が含まれています。

次のようにしてヘッダを設定できます。

```php
<?php

// 名前でヘッダーを指定
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// 直接ヘッダーを指定
$response->setRawHeader('HTTP/1.1 200 OK');
```

`Phalcon\Http\Response\Headers` バッグは内部でヘッダを管理します。このクラスはクライアントに送信する前にヘッダを取得します。

```php
<?php

// ヘッダーバッグの取得
$headers = $response->getHeaders();

// 名前でヘッダーを取得
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## リダイレクト

`Phalcon\Http\Response` で HTTPリダイレクトを実行できます:

```php
<?php

// デフォルトのURIへリダイレクト
$response->redirect();

// ローカルベースURIへリダイレクト
$response->redirect('posts/index');

// 外部 URL へリダイレクト
$response->redirect('http://en.wikipedia.org', true);

// HTTP ステータスコードを指定してリダイレクト
$response->redirect('http://www.example.com/new-location', true, 301);
```

[url](/[[language]]/[[version]]/url)サービス（デフォルトでは `Phalcon\Mvc\Url`）を使用して、すべての内部URIを生成します。 この例では、アプリケーションで定義したルートを使用してリダイレクトする方法を示します。

```php
<?php

// 名前付きルートでリダイレクト
return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
```

リダイレクトではビューコンポーネントが無効になるわけではないので、現在のアクションに関連付けられたビューが存在する場合は、それは常に実行されます。 次のようにして、コントローラーからこのビューを無効にできます。 `$this->view->disable()`;

<a name='http-cache'></a>

## HTTPキャッシュ

アプリケーションのパフォーマンスを向上させ、トラフィックを削減する最も簡単な方法の 1 つに、HTTP キャッシュの使用があります。 最新のブラウザーは HTTP キャッシュをサポートしています。そしてそれが多くのウェブサイトが高速な理由の 1 つです。

HTTPキャッシュは、ページを最初に提供するときにアプリケーションによって送信される次のヘッダー値で変更できます:

- **`Expires:`**このヘッダーを使用すると、アプリケーションは将来の日付を設定したり、ページが期限切れになったときにブラウザに通知したりすることができます。
- **`Cache-Control:`**このヘッダーは、ページをブラウザーが新しいと判断する時間を指定できます。
- **`Last-Modified:`**このヘッダーはブラウザへ、サイトの最終更新時を伝えて、ページの再読み込みを回避させます。
- **`ETag:`**Etag はユニークなIDです。その中には現在のページの変更のタイムスタンプを含んでいます。

<a name='http-cache-expiration-time'></a>

### 期限の設定

有効期限の日付は、クライアント (ブラウザー) にページをキャッシュさせる最も簡単なで効果的な方法です。 現在の日付から、その時間の間、そのページはブラウザのキャッシュに保存されます。 この有効期限が切れるまでは、サーバーへ新しいコンテンツを要求しません。

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

Responseコンポーネントは自動でExpiresヘッダーにGMTタイムゾーンの日付を設定します。

この値を過去の日付に設定した場合、ブラウザーは常にリクエストされたページを更新します:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

ブラウザーは、クライアントの時計を利用して、この日付が過ぎたかどうかを判断します。 ページを期限切れにするようにクライアントの時計を変更することができ、これはこのキャッシュメカニズムの制限を表している可能性があります。

<a name='http-cache-control'></a>

### キャッシュコントロール

このヘッダーは、保存されたページをキュッシュするより安全な方法を提供します。キャッシュにページを維持する必要がある時間をブラウザに、秒単位で時間を指定します。

```php
<?php

// 今から1日間ページをキャシュ
$response->setHeader('Cache-Control', 'max-age=86400');
```

このように、反対の効果（ページキャッシュを避ける）が実現されます。

```php
<?php

// 提供したページをキャッシュさせない
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

`entity-tag`または`E-tag`は、ページが2つのリクエストの間に変更されたかどうかをブラウザが認識するのに役立つ一意の識別子です。 この識別子は、以前に提供したコンテンツが変更された場合に変更する必要があることを考慮して計算する必要があります。

```php
<?php

// 最新Newsの修正時間を元にE-Tagを計算する。
$mostRecentDate = News::maximum(
    [
        'column' => 'created_at'
    ]
);

$eTag = md5($mostRecentDate);

// E-Tag ヘッダを送信
$response->setHeader('E-Tag', $eTag);
```