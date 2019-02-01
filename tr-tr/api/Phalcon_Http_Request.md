---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Http\Request'
---
# Class **Phalcon\Http\Request**

*implements* [Phalcon\Http\RequestInterface](Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request.zep)

Uygulama denetleyicilerinden kolay ve güvenli erişim için istek bilgilerini saklar.

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

## Metodlar

public **getHttpMethodParameterOverride** ()

...

public **setHttpMethodParameterOverride** (*mixed* $httpMethodParameterOverride)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjektörünü ayarlar

public **getDI** ()

Returns the internal dependency injector

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

Gerekirse $_POST süperküreseli uygulama filtrelerinden bir değişken alır Parametre verilmemişse $_POST süperküreseli döndürülür

```php
<?php

// Returns value from $_POST["user_email"] without sanitizing
$userEmail = $request->getPost("user_email");

// Returns value from $_POST["user_email"] with sanitizing
$userEmail = $request->getPost("user_email", "email");

```

public **getPut** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Put isteğinden bir değişken alır

```php
<?php

// Returns value from $_PUT["user_email"] without sanitizing
$userEmail = $request->getPut("user_email");

// Returns value from $_PUT["user_email"] with sanitizing
$userEmail = $request->getPut("user_email", "email");

```

public **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue], [*mixed* $notAllowEmpty], [*mixed* $noRecursive])

Gerekirse $_GET süperküreseli uygulama filtrelerinden bir değişken alır Parametre verilmemişse $_GET süperküreseli döndürülür

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

$_SERVER süperküreselinden değişken alır

public **has** (*mixed* $name)

$_REQUEST süperküreselinin kesin indekse sahip olup olmadığını kontrol eder

public **hasPost** (*mixed* $name)

$_POST süperküreselinin kesin indekse sahip olup olmadığını kontrol eder

public **hasPut** (*mixed* $name)

PUT verisinin kesin indekse sahip olup olmadığını kontrol eder

public **hasQuery** (*mixed* $name)

$_GET süperküreselinin kesin indekse sahip olup olmadığını kontrol eder

final public **hasServer** (*mixed* $name)

$_SERVER süperküreselinin kesin indekse sahip olup olmadığını kontrol eder

final public **getHeader** (*mixed* $header)

İstek verisinden HTTP başlığını alır

public **getScheme** ()

HTTP taslağını (http/https) alır

public **isAjax** ()

İsteğin ajax kullanılarak yapılıp yapılmadığını kontrol eder

public **isSoap** ()

İsteğin SOAP kullanılarak yapılıp yapılmadığını kontrol eder

public **isSoapRequested** ()

Alias of isSoap(). It will be deprecated in future versions

public **isSecure** ()

İsteğin herhangi bir güvenli katman kullanılarak yapılıp yapılmadığını kontrol eder

public **isSecureRequest** ()

Alias of isSecure(). It will be deprecated in future versions

public **getRawBody** ()

HTTP ham istek gövdesini alır

public **getJsonRawBody** ([*mixed* $associative])

Deşifre edilmiş JSON HTTP ham istek gövdesini alır

public **getServerAddress** ()

Etkin sunucu IP adresini alır

public **getServerName** ()

Aktif sunucu adını alır

public **getHttpHost** ()

İstek tarafından kullanılan ana bilgisayar adını alır. `Request::getHttpHost` aşağıdaki sırada ana bilgisayar adını bulmayı dener; - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]` İsteğe bağlı olarak `Request::getHttpHost` ana bilgisayar adını doğrular ve temizler. Ana bilgisayar adını doğrulama için `Request::$_strictHostCheck` kullanılabilir. Not: doğrulama ve temizleme negatif performans etkisine sahiptir çünkü onlar düzenli ifadeler kullanırlar.

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

`Request::getHttpHost` metodu ana bilgisayar adına tam doğrulama kullanılmalı mı kullanılmamalı mı ayarlar

public **isStrictHostCheck** ()

`Request::getHttpHost` metodu ana bilgisayar adına tam doğrulama kullanılacak mı kullanılmayacak mı denetler

public **getPort** ()

Yapılan isteğin hangi bağlantı noktası üzerinde bulunduğu bilgisini alır.

final public **getURI** ()

Hangi istekte bulunulduğu HTTP URI'sini alır

public **getClientAddress** ([*mixed* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

final public **getMethod** ()

Gets HTTP method which request has been made If the X-HTTP-Method-Override header is set, and if the method is a POST, then it is used to determine the "real" intended HTTP method. The _method request parameter can also be used to determine the HTTP method, but only if setHttpMethodParameterOverride(true) has been called. Yöntem her zaman bir büyük harfli dizedir.

public **getUserAgent** ()

İstek yapmak için kullanılan HTTP kullanıcı aracısını alır

public **isValidHttpMethod** (*mixed* $method)

Bir metodun geçerli bir HTTP metodu olup olmadığını denetler

public **isMethod** (*mixed* $methods, [*mixed* $strict])

HTTP metodunun geçilen herhangi bir metotla eşleşip eşleşmediğini denetler Doğru olduğunda onaylanmış metotların gerçek HTTP metotları olup olmadığını denetler

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

İsteğin ekli dosya içerip içermediğini kontrol eder

final protected **hasFileHelper** (*mixed* $data, *mixed* $onlySuccessful)

Bir dizi dosyadaki dosyayı tekrar tekrar sayar

public **getUploadedFiles** ([*mixed* $onlySuccessful])

Gets attached files as Phalcon\Http\Request\File instances

final protected **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *mixed* $prefix)

Smooth out $_FILES to have plain array with all files uploaded

public **getHeaders** ()

İstekteki kullanılabilir başlıkları döndürür

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

Bir istek başlığını işle ve en iyi kaliteyle döndür

public **getContentType** ()

Yapılan istekteki içerik türünü alır

public **getAcceptableContent** ()

Tarayıcı/istemci vasıtasıyla kalitesi _SERVER["HTTP_ACCEPT"] tarafından kabul gören mime/tipli bir diziyi alır

public **getBestAccept** ()

Tarayıcı/istemci vasıtasıyla _SERVER["HTTP_ACCEPT"] tarafından kabul gören en iyi mime/tipi alır

public **getClientCharsets** ()

Tarayıcı/istemci vasıtasıyla kalitesi _SERVER["HTTP_ACCEPT_CHARSET"] tarafından kabul gören bir karakter seti dizisini alır

public **getBestCharset** ()

Tarayıcı/istemci vasıtasıyla _SERVER["HTTP_ACCEPT_CHARSET"] tarafından kabul gören en iyi karakter setini alır

public **getLanguages** ()

Tarayıcı/istemci vasıtasıyla kalitesi _SERVER["HTTP_ACCEPT_LANGUAGE"] tarafından kabul gören diller dizisini alır

public **getBestLanguage** ()

Tarayıcı/istemci vasıtasıyla _SERVER["HTTP_ACCEPT_LANGUAGE"] tarafından kabul gören en iyi dili alır

public **getBasicAuth** ()

Tarayıcı/istemci vasıtasıyla $_SERVER["PHP_AUTH_USER"] tarafından kabul gören yetki bilgisini alır

public **getDigestAuth** ()

Tarayıcı/istemci vasıtasıyla $_SERVER["PHP_AUTH_DIGEST"] tarafından kabul gören yetki bilgisini alır

final protected **_getQualityHeader** (*mixed* $serverIndex, *mixed* $name)

Bir istek başlığını işle ve kaliteleriyle birlikte değerlerin bir dizisini döndür