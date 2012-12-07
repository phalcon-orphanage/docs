Returning Responses
===================

Part of the HTTP cycle is return responses to the clients. :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` is the Phalcon
component designed to achieve this task. HTTP responses are usually composed by headers and body. The basic usage is the following:

.. code-block:: php

    <?php

    // Getting a request instance
    $request = new \Phalcon\Http\Request();

    //Set status code
    $response->setRawHeader(404, "Not Found");

    //Set the content of the response
<<<<<<< HEAD
    $response->setContent("Sorry, the page doesn't exists");
=======
    $response->setContent("Sorry, the page doesn't exist");
>>>>>>> 0.7.0

    //Send response to the client
    $response->send();

Working with Headers
--------------------
Headers are an important part of the whole HTTP response. It contains useful information about the response state like the HTTP status,
type of response and much more.

You can set headers in the following way:

.. code-block:: php

    <?php

    //Setting it by its name
    $response->setHeader("Content-Type", "application/pdf");
    $response->setHeader("Content-Disposition", 'attachment; filename="downloaded.pdf"');

    //Setting a raw header
    $response->setRawHeader("HTTP/1.1 200 OK");

A :doc:`Phalcon\\HTTP\\Response\\Headers <../api/Phalcon_Http_Response_Headers>` bag internally manages headers. This class
allows to manage headers before sent it to client:

.. code-block:: php

    <?php

    //Get the headers bag
    $headers = $response->getHeaders();

    //Get a header by its name
    $contentType = $response->getHeaders()->get("Content-Type");

Making Redirections
-------------------
With :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` you can also make HTTP redirections:

.. code-block:: php

    <?php

    //Making a redirection using the local base uri
    $response->redirect("posts/index");

    //Making a redirection to an external URL
    $response->redirect("http://en.wikipedia.org", true);

    //Making a redirection specifyng the HTTP status code
    $response->redirect("http://www.example.com/new-location", true, 301);

<<<<<<< HEAD
=======
All internal URIs are generated using the 'url' service (by default :doc:`Phalcon\\Mvc\\Url <url>`), in this way you can make redirections
based on the routes you've currently defined in the application:

.. code-block:: php

    <?php

    //Making a redirection based on a named route
    $response->redirect(array(
        "for" => "index-lang",
        "lang" => "jp",
        "controller" => "index"
    ));

Note that making a redirection doesn't disable the view component, so if there is a view asociated with the current action it
will be executed anyways. You can disable the view from a controller by executing $this->view->disable();


>>>>>>> 0.7.0
