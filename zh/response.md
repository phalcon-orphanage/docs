<div class='article-menu'>
  <ul>
    <li>
      <a href="总览">返回的响应</a> 
      <ul>
        <li>
          <a href="#working-with-headers">使用Headers</a>
        </li>
        <li>
          <a href="#redirections">重定向</a>
        </li>
        <li>
          <a href="#http 缓存">HTTP 缓存</a> 
          <ul>
            <li>
              <a href="#http-cache-expiration-time">设置过期时间</a>
            </li>
            <li>
              <a href="#http-cache-control">缓存控制</a>
            </li>
            <li>
              <a href="#http 缓存-etag">E-Tag</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 返回的响应

HTTP周期的一部分是向客户机返回响应。 `Phalcon\Http\Response`是Phalcon设计来完成这项任务的组件。 HTTP响应通常由标题和正文组成。 下面是一个基本用法的例子:

```php
<?php

use Phalcon\Http\Response;

// 获取一个response 实例
$response = new Response();

// 设置状态码
$response->setStatusCode(404, 'Not Found');

// 设置内容
$response->setContent("Sorry, the page doesn't exist");

// 发送给客户端
$response->send();
```

如果您使用的是完整的MVC栈，则不需要手动创建响应。但是，如果您需要直接从控制器的操作返回响应，请遵循以下示例:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class FeedController extends Controller
{
    public function getAction()
    {
        // Getting a response instance
        $response = new Response();

        $feed = // ... Load here the feed

        // Set the content of the response
        $response->setContent(
            $feed->asString()
        );

        // Return the response
        return $response;
    }
}
```

<a name='working-with-headers'></a>

## 使用Headers

标头是HTTP响应的重要部分。它包含关于响应状态的有用信息，比如HTTP状态、响应类型等等。

您可以通过以下方式设置headers:

```php
<?php

// Setting a header by its name
$response->setHeader('Content-Type', 'application/pdf');
$response->setHeader('Content-Disposition', "attachment; filename='downloaded.pdf'");

// Setting a raw header
$response->setRawHeader('HTTP/1.1 200 OK');
```

一个`Phalcon\Http\Response\Headers` 包内部用于管理header。这个类在发送给客户端之前检索报头:

```php
<?php

// 获取包头
$headers = $response->getHeaders();

// 根据名字获取包头
$contentType = $headers->get('Content-Type');
```

<a name='redirections'></a>

## 重定向

使用`Phalcon\Http\Response`，您还可以执行Http重定向:

```php
<?php

// Redirect to the default URI
$response->redirect();

// Redirect to the local base URI
$response->redirect('posts/index');

// Redirect to an external URL
$response->redirect('http://en.wikipedia.org', true);

// Redirect specifying the HTTP status code
$response->redirect('http://www.example.com/new-location', true, 301);
```

所有内部uri都使用[url](/[[language]]/[[version]]/url)服务(默认情况下`Phalcon\Mvc\ url</ 1>) 生成。 这个示例演示了如何使用在应用程序中定义的路由重定向:</p>

<pre><code class="php"><?php

// Redirect based on a named route
return $response->redirect(
    [
        'for'        => 'index-lang',
        'lang'       => 'jp',
        'controller' => 'index',
    ]
);
`</pre> 

即使有一个视图与当前操作相关联，它也不会被呈现，因为`重定向`会禁用视图。

<a name='http-cache'></a>

## HTTP Cache

提高应用程序性能和减少流量的最简单方法之一是使用HTTP缓存。 大多数现代浏览器都支持HTTP缓存，这也是许多网站目前速度很快的原因之一。

在第一次服务页时, 应用程序发送的以下标头值可以更改 HTTP 缓存:

* **` Expires: `**使用此标头, 应用程序可以设置将来的日期, 或在页面必须过期时告知浏览器。
* **` Cache-Control: `**此标头允许指定在浏览器中应将页面视为新鲜的时间。
* **` Last-Modified: `**此标头告诉浏览器这是最后一次更新站点, 避免页面重新加载。
* **` ETag: `**etag 是必须创建的唯一标识符, 包括当前页的修改时间戳。

<a name='http-cache-expiration-time'></a>

### 设置过期时间

过期日期是在客户端 (浏览器) 中缓存页面的最简单、最有效的方法之一。 从当前日期开始, 我们将添加页面在浏览器缓存中存储的时间量。 在此日期到期之前, 不会从服务器请求任何新内容:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('+2 months');

$response->setExpires($expiryDate);
```

响应组件按预期的过期标头自动显示 GMT 时区中的日期。

如果我们将此值设置为过去的某个日期, 浏览器将始终刷新请求的页面:

```php
<?php

$expiryDate = new DateTime();
$expiryDate->modify('-10 minutes');

$response->setExpires($expiryDate);
```

浏览器依赖于客户的时钟来评估此日期是否已通过。可以修改客户端时钟以使页面过期, 这是此缓存机制的限制。

<a name='http-cache-control'></a>

### 缓存控制

此标头提供了一种更安全的方式来缓存所服务的页面。我们必须指定一个时间 (以秒为单位), 告知浏览器必须在其缓存中保留该页的长度:

```php
<?php

// Starting from now, cache the page for one day
$response->setHeader('Cache-Control', 'max-age=86400');
```

相反的效果(避免页面缓存) 是这样实现的:

```php
<?php

// Never cache the served page
$response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
```

<a name='http-cache-etag'></a>

### E-Tag

` entity-tag` 或 ` E-tag` 是一个唯一标识符, 可帮助浏览器实现页面是否已更改或不在两个请求之间。 必须计算标识符, 考虑到如果以前服务的内容已更改, 则必须更改:

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