---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\Request'
---
# Class **Phalcon\Http\Request**

*implements* [Phalcon\Http\RequestInterface](Phalcon_Http_RequestInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/request.zep)

Encapsulates informasi permintaan untuk akses mudah dan aman dari pengontrol aplikasi.

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

## Metode

publik **mendapatkan Http Metode Mengesampingkan Parameter** ()

...

publik **set Http Metode Mengesampingkan Parameter** (*mixed* $httpMethodParameterOverride)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

publik **mendapatkan** ([*campur aduk* $name], [*campur aduk* $filters], [*campur aduk* $defaultValue], [*campur aduk* $notAllowEmpty], [*campur aduk* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned

```php
<?php

// Mengembalikan nilai dari $_REQUEST["user_email"] tanpa sanitasi
$userEmail = $request->get("user_email");

// Mengembalikan nilai dari $_REQUEST["user_email"] tanpa sanitasi
$userEmail = $request->get("user_email", "email");

```

publik **mendapatkan postingan** ([*campur aduk* $name], [*campur aduk* $filters], [*campur aduk* $defaultValue], [*campur aduk* $notAllowEmpty], [*campur aduk* $noRecursive])

Dapatkan variabel dari penerapan $_POST superglobal jika diperlukan Jika tidak ada parameter yang diberi superglobal $_POST dikembalikan

```php
<?php

// Mengembalikan nilai dari $_POST["user_email"] tanpa sanitasi
$userEmail = $request->getPost("user_email");

// Mengembalikan nilai dari $_POST["user_email"] tanpa sanitasi
$userEmail = $request->getPost("user_email", "email");

```

publik **mendapatkan Put** ([*campur aduk* $name], [*campur aduk* $filters], [*campur aduk* $defaultValue], [*campur aduk* $notAllowEmpty], [*campur aduk* $noRecursive])

Mendapatkan variabel dari permintaan

```php
<?php

// Mengembalikan nilai dari $_PUT["user_email"] tanpa sanitasi
$userEmail = $request->getPut("user_email");

// Mengembalikan nilai dari $_PUT["user_email"] tanpa sanitasi
$userEmail = $request->getPut("user_email", "email");

```

publik **mendapatkan Kueri** ([*campur aduk* $name], [*campur aduk* $filters], [*campur aduk* $defaultValue], [*campur aduk* $notAllowEmpty], [*campur aduk* $noRecursive])

Mendapat variabel dari $_GET superglobal menerapkan filter jika diperlukan Jika tidak ada parameter yang diberi superglobal $_GET dikembalikan

```php
<?php

// Mengembalikan nilai dari $_GET["id"] tanpa sanitasi
$id = $request->getQuery("id");

// Mengembalikan nilai dari $_GET["id"] tanpa sanitasi
$id = $request->getQuery("id", "int");

// Mengembalikan nilai dari $_GET["id"] dengan nilai default
$id = $request->getQuery("id", null, 150);

```

akhir dilindungi **mendapatkan Pembantu** (*array* $source, [*campur aduk* $name], [*campur aduk* $filters], [*campur aduk* $defaultValue], [*campur aduk* $notAllowEmpty], [*campur aduk* $noRecursive])

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.

publik **mendapatkan Server** (*campur aduk* $name)

Mendapatkan nilai-nilai dari $_SERVER superglobal

publik **telah** (*campuran* $name)

Memeriksa apakah superglobal $_REQUEST memiliki indeks tertentu

publik **telah memposting** (*campur aduk* $name)

Memeriksa apakah $_POST superglobal memiliki indeks tertentu

publik **telah memposing** (*campur aduk* $name)

Memeriksa apakah data PUT memiliki indeks tertentu

publik **telah Kuery** (*campur aduk* $name)

Memeriksa apakah superglobal $_GET memiliki indeks tertentu

publik akhir **memiliki Server** (*campur aduk* $name)

Periksa apakah $_SERVER superglobal memiliki indeks tertentu

final public **getHeader** (*mixed* $header)

Mendapat header HTTP dari data permintaan

public **getScheme** ()

Mendapat skema HTTP (http / https)

public **isAjax** ()

Memeriksa apakah permintaan telah dilakukan dengan menggunakan ajax

public **isSoap** ()

Memeriksa apakah permintaan telah dilakukan dengan menggunakan SOAP

public **isSoapRequested** ()

Alias of isSoap(). It will be deprecated in future versions

public **isSecure** ()

Memeriksa apakah permintaan telah dilakukan dengan menggunakan lapisan yang aman

public **isSecureRequest** ()

Alias of isSecure(). It will be deprecated in future versions

public **getRawBody** ()

Mendapat HTTP raw request body

public **getJsonRawBody** ([*mixed* $associative])

Mendapat kode permintaan mentah JSON HTTP

public **getServerAddress** ()

Gets aktif alamat server IP

public **getServerName** ()

Mendapatkan nama server aktif

public **getHttpHost** ()

Mendapat nama host yang digunakan oleh permintaan. `Request::getHttpHost` trying to find host name in following order: - `$_SERVER["HTTP_HOST"]` - `$_SERVER["SERVER_NAME"]` - `$_SERVER["SERVER_ADDR"]` Optionally `Request::getHttpHost` validates and clean host name. The `Request::$_strictHostCheck` can be used to validate host name. Catatan: validasi dan pembersihan memiliki dampak kinerja negatif karena mereka menggunakan ekspresi reguler.

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

Sets if the `Request::getHttpHost` method must be use strict validation of host name or not

public **isStrictHostCheck** ()

Checks if the `Request::getHttpHost` method will be use strict validation of host name or not

public **getPort** ()

Mendapatkan informasi tentang port tempat permintaan dibuat.

final public **getURI** ()

Mendapat URI HTTP yang permintaannya telah dibuat

public **getClientAddress** ([*mixed* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method searches in $_SERVER["REMOTE_ADDR"] and optionally in $_SERVER["HTTP_X_FORWARDED_FOR"]

final public **getMethod** ()

Mendapat metode HTTP yang permintaannya telah dibuat Jika header X-HTTP-Method-Override diset, dan jika metodenya adalah POST, maka itu digunakan untuk menentukan metode HTTP "sebenarnya" yang dimaksud. Parameter permintaan _method juga dapat digunakan untuk menentukan metode HTTP, tapi hanya jika setHttpMethodParameterOverride (true) telah dipanggil. Metode ini selalu merupakan string bertingkat.

public **getUserAgent** ()

Mendapat agen pengguna HTTP yang digunakan untuk mengajukan permintaan

public **isValidHttpMethod** (*mixed* $method)

Memeriksa apakah metode adalah metode HTTP yang valid

public **isMethod** (*mixed* $methods, [*mixed* $strict])

Periksa apakah metode HTTP sesuai dengan metode yang dilewatkan Bila benar itu benar apakah metode yang divalidasi adalah metode HTTP yang sesungguhnya

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

Memeriksa apakah permintaan menyertakan file terlampir

final protected **hasFileHelper** (*mixed* $data, *mixed* $onlySuccessful)

Secara rekursif menghitung file dalam array file

public **getUploadedFiles** ([*mixed* $onlySuccessful])

Gets attached files as Phalcon\Http\Request\File instances

final protected **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *mixed* $prefix)

Smooth out $_FILES to have plain array with all files uploaded

public **getHeaders** ()

Mengembalikan header yang tersedia sesuai permintaan

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

Proseskan header request dan kembalikan yang satu dengan kualitas terbaik

public **getContentType** ()

Mendapat jenis konten yang permintaannya telah dibuat

public **getAcceptableContent** ()

Mendapatkan array dengan mime/jenis dan kualitasnya diterima oleh browser/klien dari _SERVER["HTTP_ACCEPT"]

public **getBestAccept** ()

Memanfaatkan mime/type terbaik yang diterima oleh browser/client dari _SERVER["HTTP_ACCEPT"]

public **getClientCharsets** ()

Mendapatkan array charsets dan kualitasnya diterima oleh browser/client dari _SERVER ["HTTP_ACCEPT_CHARSET"]

public **getBestCharset** ()

Mendapatkan charset terbaik yang diterima oleh browser/klien dari _SERVER ["HTTP_ACCEPT_CHARSET"]

public **getLanguages** ()

Mendapat bahasa array dan kualitas mereka diterima oleh browser/client dari _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBestLanguage** ()

Mendapatkan bahasa terbaik yang diterima oleh browser/klien dari _SERVER["HTTP_ACCEPT_LANGUAGE"]

public **getBasicAuth** ()

Gets auth info accepted by the browser/client from $_SERVER["PHP_AUTH_USER"]

public **getDigestAuth** ()

Mendapatkan info auth yang diterima oleh browser/klien dari $_SERVER["PHP_AUTH_DIGEST"]

final protected **_getQualityHeader** (*mixed* $serverIndex, *mixed* $name)

Proseskan header permintaan dan kembalikan sejumlah nilai dengan kualitasnya