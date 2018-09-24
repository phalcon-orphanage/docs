<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">レスポンスを返す</a> 
      <ul>
        <li>
          <a href="#working-with-headers">HTTPヘッダの利用</a>
        </li>
        <li>
          <a href="#redirections">リダイレクト</a>
        </li>
        <li>
          <a href="#http-cache">HTTPキャッシュ</a> 
          <ul>
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

次のようにしてヘッダを設定できます:

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

現在のアクションに関連付けられたビューがある場合でも、`redirect`がビューを無効にするためレンダリングしません。

<a name='http-cache'></a>

## HTTPキャッシュ

One of the easiest ways to improve the performance in your applications and reduce the traffic is using HTTP Cache. Most modern browsers support HTTP caching and is one of the reasons why many websites are currently fast.

HTTP Cache can be altered in the following header values sent by the application when serving a page for the first time:

* **`Expires:`** With this header the application can set a date in the future or the past telling the browser when the page must expire.
* **`Cache-Control:`** This header allows to specify how much time a page should be considered fresh in the browser.
* **`Last-Modified:`** This header tells the browser which was the last time the site was updated avoiding page re-loads.
* **`ETag:`** An etag is a unique identifier that must be created including the modification timestamp of the current page.

<a name='http-cache-expiration-time'></a>

### Setting an Expiration Time

The expiration date is one of the easiest and most effective ways to cache a page in the client (browser). Starting from the current date we add the amount of time the page will be stored in the browser cache. Until this date expires no new content will be requested from the server:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

The Response component automatically shows the date in GMT timezone as expected in an Expires header.

If we set this value to a date in the past the browser will always refresh the requested page:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

Browsers rely on the client's clock to assess if this date has passed or not. The client clock can be modified to make pages expire and this may represent a limitation for this cache mechanism.

<a name='http-cache-control'></a>

### Cache-Control

This header provides a safer way to cache the pages served. We simply must specify a time in seconds telling the browser how long it must keep the page in its cache:

```php
<?php

// Starting from now, cache the page for one day
$response->setHeader('Cache-Control', 'max-age=86400');
```

The opposite effect (avoid page caching) is achieved in this way:

```php
<?php

// Never cache the served page
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

An `entity-tag` or `E-tag` is a unique identifier that helps the browser realize if the page has changed or not between two requests. The identifier must be calculated taking into account that this must change if the previously served content has changed:

```php
<?php

// Calculate the E-Tag based on the modification time of the latest news
$mostRecentDate = News::maximum(
    [
        'column' => 'created_at'
    ]
);

$eTag = md5($mostRecentDate);

// Send an E-Tag header
$response->setHeader('E-Tag', $eTag);
```