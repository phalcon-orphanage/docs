%{built-in_f4e44f5b67bc461492c485de3482861f}%
============================

%{built-in_34d6fa77a4b13cf9bfc63b2fea4aac90}%

%{built-in_0140884a37f0765e4896b5d62697a5c3}%

.. code-block:: bash

    php -S localhost:8000 -t /web_root

%{built-in_1b20c836cc0e00031150a50f170c15ea}%

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

%{built-in_699feca0985169a909f4d4beb52e11aa}%

.. code-block:: bash

    php -S localhost:8000 -t /web_root .htrouter.php

%{built-in_13e0be028514dcaf51fb75036408c591}%

