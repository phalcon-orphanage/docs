---
layout: article
language: 'en'
version: '4.0'
category: 'request'
---
# HTTP Request Component
<hr/>

# Request Environment
Every HTTP request (usually originated by a browser) contains additional information regarding the request such as header data, files, variables, etc. A web based application needs to parse that information in order to perform a particular action and send the correct response back to the requester. [Phalcon\Http\Request](api/Phalcon_Http_Request) encapsulates the request information in a simple value object.

```php
<?php

use Phalcon\Http\Request;

// Getting a request instance
$request = new Request();

// Check whether the request was made with method POST
if (true === $request->isPost()) {
    // Check whether the request was made with Ajax
    if (true === $request->isAjax()) {
        echo 'Request was made using POST and AJAX';
    }
}
```

- [Getting Values](request-getting-values)
- [Preset sanitizers](request-preset-sanitizers)
- [Accessing the Request from Controllers](request-controller-access)
- [Checking operations](request-checking-operations)
- [Request information](request-information)
- [Dependency Injection](request-di)
- [Working with Headers](request-working-with-headers)
- [Uploading Files](request-uploading-files)
- [Events](request-events)
