%{url_ed236d03ec3edd1f8e21243f33a3d69a}%
=========================
%{url_3985fcf30af8470b326c4128948ce37c}%

%{url_68b8722ef7564d65fa4a9ed509690f52}%
------------------
%{url_ce8911656909797c0f7cfdd8650db8bc}%

%{url_1d5e74ff02459454bd68d8addd28a2d7}%

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();
    echo $url->getBaseUri();

%{url_75aca106f3cfa3b32ae8ca3ca717e72d}%

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //{%url_c17f15740b429bfa48aa04f3d7b46b6b%}
    $url->setBaseUri('/invo/');

    //{%url_1b6850414fe016e6b7bcc0975688e434%}
    $url->setBaseUri('//{%url_9bc870016c7bac71e69efe1f17ca1382%}

    //{%url_1b6850414fe016e6b7bcc0975688e434%}
    $url->setBaseUri('http://{%url_8980a049ee5372310fcf3f9147c4c43d%}

%{url_16b2458da6a88dbf842ecaf98a9c0799}%

.. code-block:: php

    <?php

    $di->set('url', function(){
        $url = new Phalcon\Mvc\Url();
        $url->setBaseUri('/invo/');
        return $url;
    });

%{url_2f1af28e614976174560c19d608f2b30}%
---------------
%{url_6ceb5ad349a020c2d651901ef0007c04}%

.. code-block:: php

    <?php echo $url->get("products/save") ?>

%{url_844faad4ac343c10f1c849720a37d7ac}%

.. code-block:: php

    <?php

    $route->add('/blog/{$year}/{month}/{title}', array(
        'controller' => 'posts',
        'action' => 'show'
    ))->setName('show-post');

%{url_95e0dc4052583f7ec7119bf377a7e581}%

.. code-block:: php

    <?php

    //{%url_6f0aecd30d615e06077ae4e785812b7b%}
    $url->get(array(
        'for' => 'show-post',
        'year' => 2012,
        'month' => '01',
        'title' => 'some-blog-post'
    ));

%{url_11b9173b9cb6348134181f0b0d2c37bb}%
----------------------------------
%{url_37df3ff3aa072c2251501097b64e80bf}%

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //{%url_935fc536f68caebf9c9faf63e4559b7f%}
    $url->setBaseUri('/invo/index.php?_url=/');

    //{%url_b879417b4817eea81c28c7a6402aa074%}
    echo $url->get("products/save");

%{url_3e1ff6aff3ea47fe0dfb9bcf8c571a40}%

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //{%url_935fc536f68caebf9c9faf63e4559b7f%}
    $url->setBaseUri('/invo/index.php?_url=/');

    //{%url_0cefbeb70df9035bd4a81aef37f37aac%}
    $url->setBaseUri('/invo/index.php/');

%{url_64f135d7cb051d65eefc0a808e0e42a7}%

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();

    // {%url_4822e91785d2fa3e605512148232f114%}

    $uri = str_replace($_SERVER["SCRIPT_NAME"], '', $_SERVER["REQUEST_URI"]);
    $router->handle($uri);

%{url_83cb5acbb2c739341716699cb5bc09ed}%

.. code-block:: php

    <?php

    //{%url_7504bcfefab476c8ec86bd902a64a612%}
    echo $url->get("products/save");

%{url_85f519884f68b0fc2ce37a5a7fb3c9b3}%
------------------------
%{url_87db31c993564f594288f7af54b06a86}%

.. code-block:: html+jinja

    <a href="{{ url("posts/edit/1002") }}">Edit</a>

%{url_6c18d17ad2db305abcc46c92691abb52}%

.. code-block:: html+jinja

    <link rel="stylesheet" href="{{ static_url("css/style.css") }}" type="text/css" />

%{url_7f68eed15a0101a787422e177b90b8fb}%
-----------------------
%{url_80bb958627f146f8ba26b15d8d8c54fa}%

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //{%url_d2169d8236878569814560a7f750afde%}
    $url->setBaseUri('/');

    //{%url_bec86b0c6304d0b51011148525a6edb8%}
    $url->setStaticBaseUri('http://{%url_b4790759b34907309d0d3e32a7c6a3a9%}

:doc:`Phalcon\\Tag <tags>` will request both dynamical and static URIs using this component.

