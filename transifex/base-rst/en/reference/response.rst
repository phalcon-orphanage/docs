%{response_96018889300caae7d7d05f83cd8e858c}%
===================
%{response_4aa13d66c64755d60950cd5c4cd6f2eb}%

.. code-block:: php

    <?php

    //{%response_1fbb6c758e419fa3efbf4d3a0c956c99%}
    $response = new \Phalcon\Http\Response();

    //{%response_914758add4c694d28dadec4dd7c6ef5f%}
    $response->setStatusCode(404, "Not Found");

    //{%response_9c076963f5e3331719a1f8db1d2af585%}
    $response->setContent("Sorry, the page doesn't exist");

    //{%response_aa1a37369701ddc784751431397df792%}
    $response->send();

%{response_6a4ab19f81223959f4ee8a1f7d9e0906}%

.. code-block:: php

    <?php

    class FeedController extends Phalcon\Mvc\Controller
    {

        public function getAction()
        {
            // {%response_1fbb6c758e419fa3efbf4d3a0c956c99%}
            $response = new \Phalcon\Http\Response();

            $feed = //{%response_cdba798da6f0e1b6eb9297e81fbe6ed8%}

            //{%response_9c076963f5e3331719a1f8db1d2af585%}
            $response->setContent($feed->asString());

            //{%response_0511ba07cfb3ddd1a0fced413a2fe537%}
            return $response;
        }

    }

%{response_58c353e11cfea9c1d6ef0400e69c35a4}%
--------------------
%{response_06f96555b3a97dae4120c22caa515138}%

%{response_040c328569c535b4a7a8542911d38a67}%

.. code-block:: php

    <?php

    //{%response_c98f280c75ec46f7936f592d213cba50%}
    $response->setHeader("Content-Type", "application/pdf");
    $response->setHeader("Content-Disposition", 'attachment; filename="downloaded.pdf"');

    //{%response_d226b4fe440905826f7b70a11486e790%}
    $response->setRawHeader("HTTP/1.1 200 OK");

%{response_41a2b129cf88a20c4428a7fa3027d461}%

.. code-block:: php

    <?php

    //{%response_2ffbc7f9f7c644be708651dbbd5fac18%}
    $headers = $response->getHeaders();

    //{%response_55586855a40b549141ac56733ae91a42%}
    $contentType = $response->getHeaders()->get("Content-Type");

%{response_85ebb8b1fe35876ecb488660ec541ddb}%
-------------------
%{response_0e05cb1ea142cac273618b77cc428e5b}%

.. code-block:: php

    <?php

    //{%response_27650a5399862211ca8aa3c4e344f388%}
    $response->redirect();

    //{%response_cef659bc53ea809b5b8b70d7fa9d82a4%}
    $response->redirect("posts/index");

    //{%response_8e030e877e3f99149b0a994107b881b5%}
    $response->redirect("http://{%response_dfe658f4ac7fd3102141cdf6881a2c65%}

    //{%response_88eeb693f326e0e11441130f002200ab%}
    $response->redirect("http://{%response_4d30e4d9515c27ce97e5ebf7259f9d55%}

%{response_c4d63c5ab656959797d68ed59d14fd18}%

.. code-block:: php

    <?php

    //{%response_6e1daebce48ccd4d93872c8322e9c909%}
    return $response->redirect(array(
        "for" => "index-lang",
        "lang" => "jp",
        "controller" => "index"
    ));

%{response_1c0880121fbd5fbb3ec25161f3f89ee2}%

%{response_c39d99e2c813a3297d5010729c65001d}%
----------
%{response_dde8dc5a1c8921320d8383726bdf80cc}%

%{response_a1b56a2d3c1bf4146eff9541966fb92d}%

%{response_c3a695bc001a06d635789bb46fb1a5ce}%

%{response_241e831b798a5b2b7d5a163e9d381113}%
^^^^^^^^^^^^^^^^^^^^^^^^^^
%{response_b2fa40bfebca062b4674810e4352266f}%

.. code-block:: php

    <?php

    $expireDate = new DateTime();
    $expireDate->modify('+2 months');

    $response->setExpires($expireDate);

%{response_fdf5c10ec31fbeea93f8b6dae9e8cbf8}%

%{response_795dfff0f4595f60ff9da72900dff158}%

.. code-block:: php

    <?php

    $expireDate = new DateTime();
    $expireDate->modify('-10 minutes');

    $response->setExpires($expireDate);

%{response_5c02e69f9df0a1141eac838690110ed9}%

%{response_8e676f776be373f5471d3db1665683fa}%
^^^^^^^^^^^^^
%{response_637975a76962dc440ceb603a263c1464}%

.. code-block:: php

    <?php

    //{%response_670d40994bd62b5d72f6de24627a93e0%}
    $response->setHeader('Cache-Control', 'max-age=86400');

%{response_4e89ba02099c4b7eee0e1c421b42dcf8}%

.. code-block:: php

    <?php

    //{%response_6353bb62bb3473693f12934ef1ae7c4c%}
    $response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');

%{response_5b261d26baa708955489b948c0a8496e}%
^^^^^
%{response_d7f987ce71ea42374b851bae4a1252d5}%

