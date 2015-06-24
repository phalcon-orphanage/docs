%{request_a50294fe0538101f2bfedce1815453aa}%
===================
%{request_2f435d803fad403c05876324d0a7b6ec|:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`}%

.. code-block:: php

    <?php

    // {%request_19eb4b9c4e266a3822f3d8083911f599%}
    $request = new \Phalcon\Http\Request();

    // {%request_c9e98245beed95fd652a2682b771cd56%}
    if ($request->isPost() == true) {

        // {%request_4e019698bb9685f8beb2a830672970e7%}
        if ($request->isAjax() == true) {
            echo "Request was made using POST and AJAX";
        }
    }


%{request_899ae8c8c6f297e6f17a0e342ee1c8d7}%
--------------
%{request_37e9f6d7a2193eea17a3a32a85db4be8|`SQL injection`_|`Cross Site Scripting (XSS)`_}%

%{request_d461eeca6203f16ba181388e0ea3b83f|:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`|:doc:`Phalcon\\Filter <filter>`}%

.. code-block:: php

    <?php

    // {%request_4afe48265ac499e0f703be47c118db15%}
    $filter = new Phalcon\Filter();

    $email  = $filter->sanitize($_POST["user_email"], "email");

    // {%request_fa7737760531508cb38f1218b2781e3e%}
    $filter = new Phalcon\Filter();
    $email  = $filter->sanitize($request->getPost("user_email"), "email");

    // {%request_9025fdaefa38abc33dc58eaef7aa7136%}
    $email = $request->getPost("user_email", "email");

    // {%request_b1cd4d7a0c707635d3398a4e5d43928f%}
    $email = $request->getPost("user_email", "email", "some@example.com");

    // {%request_8d04f54895c220dcfbb08e37558197af%}
    $email = $request->getPost("user_email", null, "some@example.com");



%{request_1f06d150904fb2ba123010b2372d8c20}%
--------------------------------------
%{request_cc550a9c713528ac1964917901bd9c8d|:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // {%request_eeef46c52d2f8fda1b6593681b414c9f%}
            if ($this->request->isPost() == true) {

                // {%request_7bc4b7c3a07971acba3c23c3ae0de905%}
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");

            }

        }

    }


%{request_07281573ecd855c65543d67cc8843963}%
---------------
%{request_b8e048181f6b8dd735e39dc704871d5f|:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {

        public function uploadAction()
        {
            // {%request_22c08743ae48bdf32897571caee40414%}
            if ($this->request->hasFiles() == true) {

                // {%request_ec560cec4db2cb9ab9f57c78dcf221d7%}
                foreach ($this->request->getUploadedFiles() as $file) {

                    //{%request_84ef21579fd9fb268ff0067e2b735725%}
                    echo $file->getName(), " ", $file->getSize(), "\n";

                    //{%request_27ad6dac0ad15d19643a05ed6f81e5b7%}
                    $file->moveTo('files/' . $file->getName());
                }
            }
        }

    }


%{request_e4e08fd578ce1f71a6312ddda25b1e8f|:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>`|:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>`}%

%{request_58c353e11cfea9c1d6ef0400e69c35a4}%
--------------------
%{request_37f5d0719b1f0054959ab5fc7b6ea44a}%

