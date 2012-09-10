Returning Responses
===================

Part of the HTTP cycle is return responses to the clients. :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` is the Phalcon component designed to achieve this task.
HTTP responses are usually composed by headers and body.

Working with Headers
--------------------
Headers are an important part of the whole HTTP response. It contains useful information about the response state like the HTTP status, type of response and much more.

You can set a header in the following way:

.. code-block:: php

    <?php

    // Getting a request instance
    $request = new \Phalcon\Http\Request();

    //Set status code
    $response->setRawHeader(404, "Not Found");

    //Set the content of the response
    $response->setContent("Sorry, the page doesn't exists");

    //Send response to the client
    $response->send();

Headers are internally managed by a

Making Redirections
-------------------
With :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` you can also make HTTP redirections.