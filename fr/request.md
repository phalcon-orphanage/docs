<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Request Environment</a> <ul>
        <li>
          <a href="#getting-values">Getting Values</a>
        </li>
        <li>
          <a href="#controller-access">Accessing the Request from Controllers</a>
        </li>
        <li>
          <a href="#uploading-files">Uploading Files</a>
        </li>
        <li>
          <a href="#working-with-headers">Working with Headers</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Request Environment

Every HTTP request (usually originated by a browser) contains additional information regarding the request such as header data, files, variables, etc. A web based application needs to parse that information so as to provide the correct response back to the requester. `Phalcon\Http\Request` encapsulates the information of the request, allowing you to access it in an object-oriented way.

```php
<?php

use Phalcon\Http\Request;

// Getting a request instance
$request = new Request();

// Check whether the request was made with method POST
if ($request->isPost()) {
    // Check whether the request was made with Ajax
    if ($request->isAjax()) {
        echo 'Request was made using POST and AJAX';
    }
}
```

<a name='getting-values'></a>

## Getting Values

PHP automatically fills the superglobal arrays `$_GET` and `$_POST` depending on the type of the request. These arrays contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to [SQL injection](http://en.wikipedia.org/wiki/SQL_injection) or [Cross Site Scripting (XSS)](http://en.wikipedia.org/wiki/Cross-site_scripting) attacks.

`Phalcon\Http\Request` allows you to access the values stored in the `$_REQUEST`, `$_GET` and `$_POST` arrays and sanitize or filter them with the [filter](/[[language]]/[[version]]/filter) service, (by default `Phalcon\Filter`). The following examples offer the same behavior:

```php
<?php

use Phalcon\Filter;

$filter = new Filter();

// Manually applying the filter
$email = $filter->sanitize($_POST['user_email'], 'email');

// Manually applying the filter to the value
$email = $filter->sanitize($request->getPost('user_email'), 'email');

// Automatically applying the filter
$email = $request->getPost('user_email', 'email');

// Setting a default value if the param is null
$email = $request->getPost('user_email', 'email', 'some@example.com');

// Setting a default value if the param is null without filtering
$email = $request->getPost('user_email', null, 'some@example.com');
```

<a name='controller-access'></a>

## Accessing the Request from Controllers

The most common place to access the request environment is in an action of a controller. To access the `Phalcon\Http\Request` object from a controller you will need to use the `$this->request` public property of the controller:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Check if request has made with POST
        if ($this->request->isPost()) {
            // Access POST data
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

<a name='uploading-files'></a>

## Uploading Files

Another common task is file uploading. `Phalcon\Http\Request` offers an object-oriented way to achieve this task:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            // Print the real file names and sizes
            foreach ($files as $file) {
                // Print file details
                echo $file->getName(), ' ', $file->getSize(), '\n';

                // Move the file into the application
                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the `Phalcon\Http\Request\File` class. Using the `$_FILES` superglobal array offers the same behavior. `Phalcon\Http\Request\File>` encapsulates only the information related to each file uploaded with the request.

<a name='working-with-headers'></a>

## Working with Headers

As mentioned above, request headers contain useful information that allow us to send the proper response back to the user. The following examples show usages of that information:

```php
<?php

// Get the Http-X-Requested-With header
$requestedWith = $request->getHeader('HTTP_X_REQUESTED_WITH');

if ($requestedWith === 'XMLHttpRequest') {
    echo 'The request was made with Ajax';
}

// Same as above
if ($request->isAjax()) {
    echo 'The request was made with Ajax';
}

// Check the request layer
if ($request->isSecure()) {
    echo 'The request was made using a secure layer';
}

// Get the servers's IP address. ie. 192.168.0.100
$ipAddress = $request->getServerAddress();

// Get the client's IP address ie. 201.245.53.51
$ipAddress = $request->getClientAddress();

// Get the User Agent (HTTP_USER_AGENT)
$userAgent = $request->getUserAgent();

// Get the best acceptable content by the browser. ie text/xml
$contentType = $request->getAcceptableContent();

// Get the best charset accepted by the browser. ie. utf-8
$charset = $request->getBestCharset();

// Get the best language accepted configured in the browser. ie. en-us
$language = $request->getBestLanguage();
```