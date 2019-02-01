---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Http\Request'
---
# Class **Phalcon\Http\Request**

*implements* [Phalcon\Http\RequestInterface](Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request.zep)

封装的一个容易和安全类，用于从应用程序控制器中获取请求信息。

The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.

```php
<?php

use Phalcon\Http\Request;

$request = new Request();

if ($request->isPost() && $request->isAjax()) {
    echo "Request was made using POST and AJAX";
}

$request->getServer("HTTP_HOST"); // Retrieve SERVER variables
$request->getMethod();            // GET, POST, PUT, DELETE, HEAD, OPTIONS, PATCH, PURGE, TRACE, CONNECT
$request->getLanguages();         // An array of languages the client accepts

```

## 方法

public **getHttpMethodParameterOverride** ()

...

public **setHttpMethodParameterOverride** (*mixed* $httpMethodParameterOverride)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public **get** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
<?php

// Returns value from $_REQUEST["user_email"] without sanitizing
$userEmail = $request->get("user_email");

// Returns value from $_REQUEST["user_email"] with sanitizing
$userEmail = $request->get("user_email", "email");

```

public **getPost** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

获取从 $_POST 超全局应用筛选器如果需要如果未给定参数，$_POST 超全局变量返回

```php
<?php

// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");

```

public **getPut** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

从提出请求获取变量

```php
<?php

// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");

```

public **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

获取从 $_GET 超全局应用过滤器，如果需要如果未给定参数，$_GET 超全局变量，则返回

```php
<?php

// Returns value from $_GET["id"] without sanitizing
$id = $request->getQuery("id");

// Returns value from $_GET["id"] with sanitizing
$id = $request->getQuery("id", "int");

// Returns value from $_GET["id"] with a default value
$id = $request->getQuery("id", null, 150);

```

final protected **getHelper** (*array* $source, [*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

public **getServer** (*mixed* $name)

从 $_SERVER 获取超全局变量

public **has** (*mixed* $name)

检查是否 $_REQUEST 超全局变量有一定的指标

public **hasPost** (*mixed* $name)

检查是否 $_POST 超全局变量有一定的指标

public **hasPut** (*mixed* $name)

检查PUT 数据是否存在

public **hasQuery** (*mixed* $name)

检查是否 $_GET 超全局变量有一定的指标

final public **hasServer** (*mixed* $name)

检查是否 $_SERVER 超全局变量有一定的指标

final public **getHeader** (*mixed* $header)

从请求数据获取 HTTP 标头

public **getScheme** ()

获取 HTTP 架构 (http/https)

public **isAjax** ()

检查有否使用 ajax 进行请求

public **isSoap** ()

检查有否使用 SOAP进行请求

public **isSoapRequested** ()

Alias of isSoap(). It will be deprecated in future versions

public **isSecure** ()

检查是否请求已使用任何安全层

public **isSecureRequest** ()

Alias of isSecure(). It will be deprecated in future versions

public **getRawBody** ()

获取 HTTP 原始请求正文

public **getJsonRawBody** ([*mixed* $associative])

获取解码 JSON HTTP 原始请求正文

public **getServerAddress** ()

获取活动服务器 IP 地址

public **getServerName** ()

获取活动服务器名称

public **getHttpHost** ()

获取请求所使用的主机名称。 `Request::getHttpHost` 试图按以下顺序查找主机名称:-`$_SERVER["HTTP_HOST"]`-`$_SERVER["SERVER_NAME"]`-`$_SERVER["SERVER_ADDR"]` 或者 `Request::getHttpHost` 验证和清洁主机名称。 `Request::$_strictHostCheck` 可以用于验证主机名。 注： 验证和清洁有负面的影响，因为他们使用正则表达式。

```php
<?php

use Phalcon\Http\Request;

$request = new Request;

$_SERVER["HTTP_HOST"] = "example.com";
$request->getHttpHost(); // example.com

$_SERVER["HTTP_HOST"] = "example.com:8080";
$request->getHttpHost(); // example.com:8080

$request->setStrictHostCheck(true);
$_SERVER["HTTP_HOST"] = "ex=am~ple.com";
$request->getHttpHost(); // UnexpectedValueException

$_SERVER["HTTP_HOST"] = "ExAmPlE.com";
$request->getHttpHost(); // example.com

```

public **setStrictHostCheck** ([*mixed* $flag])

设置是否 `Request::getHttpHost` 方法必须使用严格验证的主机名或不

public **isStrictHostCheck** ()

检查是否 `Request::getHttpHost` 方法将使用严格验证的主机名或不

public **getPort** ()

获取有关请求的端口的信息。

final public **getURI** ()

获取 HTTP URI 的请求

public **getClientAddress** ([*mixed* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

final public **getMethod** ()

获取如果设置 X HTTP 方法重写标题，并且如果该方法是一个职位，它用来确定"real"意在 HTTP 方法取得了哪个请求的 HTTP 方法。 _Method 请求参数还可以用于确定 HTTP 方法，但只有如果被称为 setHttpMethodParameterOverride(true)。 方法始终是 uppercased 的字符串。

public **getUserAgent** ()

获取用于请求的 HTTP 用户代理

public **isValidHttpMethod** (*mixed* $method)

如果一种方法是有效的 HTTP 方法将检查

public **isMethod** (*mixed* $methods, [*mixed* $strict])

检查如果 HTTP 方法匹配任何严格条件为真，它会检查如果验证方法时传递方法是真正的 HTTP 方法

public **isPost** ()

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"

public **isGet** ()

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"

public **isPut** ()

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"

public **isPatch** ()

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"

public **isHead** ()

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"

public **isDelete** ()

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"

public **isOptions** ()

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"

public **isPurge** ()

Checks whether HTTP method is PURGE (Squid and Varnish support). if _SERVER["REQUEST_METHOD"]==="PURGE"

public **isTrace** ()

Checks whether HTTP method is TRACE. if _SERVER["REQUEST_METHOD"]==="TRACE"

public **isConnect** ()

Checks whether HTTP method is CONNECT. if _SERVER["REQUEST_METHOD"]==="CONNECT"

public **hasFiles** ([*mixed* $onlySuccessful])

检查请求是否包括附加文件

final protected **hasFileHelper** (*mixed* $data, *mixed* $onlySuccessful)

递归计数数组文件中的文件

public **getUploadedFiles** ([*mixed* $onlySuccessful])

Gets attached files as Phalcon\Http\Request\File instances

final protected **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *mixed* $prefix)

理顺 $_FILES 有平原数组与上传的所有文件

public **getHeaders** ()

在请求中返回的可用的标题

```php
<?php

$_SERVER = [
    "PHP_AUTH_USER" => "phalcon",
    "PHP_AUTH_PW"   => "secret",
];

$headers = $request->getHeaders();

echo $headers["Authorization"]; // Basic cGhhbGNvbjpzZWNyZXQ=

```

public **getHTTPReferer** ()

Gets web page that refers active request. ie: https://www.google.com

final protected **_getBestQuality** (*array* $qualityParts, *mixed* $name)

处理请求标头并返回一个以最佳的质量

public **getContentType** ()

获取所请求的内容类型

public **getAcceptableContent** ()

获取数组与 mime/类型和他们从 _SERVER ["HTTP_ACCEPT"] 工作做一个浏览器客户所接受的质量

public **getBestAccept** ()

获取最佳的 mime/type 的浏览器/客户从 _SERVER ["HTTP_ACCEPT"] 所接受

public **getClientCharsets** ()

获取一个数据数组和他们从 _SERVER ["HTTP_ACCEPT_CHARSET"] 工作做一个浏览器/客户端所接受的数据

public **getBestCharset** ()

获取最佳字符集的浏览器/客户从 _SERVER ["HTTP_ACCEPT_CHARSET"] 所接收

public **getLanguages** ()

获取语言数组和他们从 _SERVER ["HTTP_ACCEPT_LANGUAGE"] 工作做一个浏览器客户所接受的质量

public **getBestLanguage** ()

获取最好的语言接受由浏览器/客户端从 _SERVER ["HTTP_ACCEPT_LANGUAGE"]

public **getBasicAuth** ()

获取从 $_SERVER["PHP_AUTH_USER"] 的浏览器/客户所接受的身份验证信息

public **getDigestAuth** ()

获取从 $_SERVER["PHP_AUTH_DIGEST"] 的浏览器/客户所接受的身份验证信息

final protected **_getQualityHeader** (*mixed* $serverIndex, *mixed* $name)

处理一个请求头，并返回一个具有其质量的值数组