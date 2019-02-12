---
layout: article
language: 'en'
version: '4.0'
category: 'request'
---
# HTTP Request Component
<hr/>

## Checking operations
The [Phalcon\Http\Request](api/Phalcon_Http_Request) component contains a number of methods that help you check the current operation. For instance if you want to check if a particular request was made using AJAX, you can do so by using the `isAjax()` method. All the methods are prefixed with `is`.
- `isAjax()`: Checks whether request has been made using AJAX
- `isConnect()`: Checks whether HTTP method is CONNECT
- `isDelete()`: Checks whether HTTP method is DELETE
- `isGet()`: Checks whether HTTP method is GET
- `isHead()`: Checks whether HTTP method is HEAD
- `isMethod()`: Check if HTTP method match any of the passed methods
- `isOptions()`: Checks whether HTTP method is OPTIONS
- `isPatch()`: Checks whether HTTP method is PATCH
- `isPost()`: Checks whether HTTP method is POST
- `isPurge()`: Checks whether HTTP method is PURGE (Squid and Varnish support)
- `isPut()`: Checks whether HTTP method is PUT
- `isSecure()`: Checks whether request has been made using any secure layer
- `isSoap()`: Checks whether request has been made using SOAP
- `isTrace()`: Checks whether HTTP method is TRACE
- `isValidHttpMethod()`: Checks if a method is a valid HTTP method

## Checking existence
There are a number of methods available that allow you to check the existence of elements in the request. These methods are prefixed with `has`. Depending on the method used, you can check if an element exists in the `$_REQUEST`, `$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, PUT cache and the request headers. 
- `has()`: Checks whether the $_REQUEST superglobal has a certain element
- `hasFiles()`: Checks whether the request has any uploaded files
- `hasHeader()`: Checks whether the headers have a certain element
- `hasPost()`: Checks whether $_POST superglobal has a certain element
- `hasPut()`: Checks whether the PUT data has a certain element
- `hasQuery()`: Checks whether $_GET superglobal has a certain element
- `hasServer()`: Checks whether $_SERVER superglobal has a certain element
