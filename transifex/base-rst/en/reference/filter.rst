%{filter_754b623fb3822e02354394a3bd087dff}%
========================
%{filter_22df063654e4541ad4a79e048ea25624}%

.. figure:: ../_static/img/sql.png
   :align: center

`Full image (from xkcd)`_



%{filter_48352cae72aba688a0bff1c16ef6f2d9|:doc:`Phalcon\\Filter <../api/Phalcon_Filter>`}%

%{filter_2876899f6219389c80f3cc9e78e9e97b}%
---------------
%{filter_894165cfe7953925c85eab1191f3c867}%

.. code-block:: php

    <?php

    $filter = new \Phalcon\Filter();

    // {%filter_d5821a95e7aaa55ed43b72ef0e14775c%}
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // {%filter_8f053e796ba85cac6d9b8898fa350974%}
    $filter->sanitize("hello<<", "string");

    // {%filter_7b16cae913f7b66b3cede60e5a001159%}
    $filter->sanitize("!100a019", "int");

    // {%filter_75dbb39ae8c53bfa2516d1529db41588%}
    $filter->sanitize("!100a019.01a", "float");



%{filter_e026d5e41103bb84d12f065f4aa23934}%
---------------------------
%{filter_dc5420fbbc9b9c4f41a8a90335d54f47|:doc:`Phalcon\\Filter <../api/Phalcon_Filter>`}%

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // {%filter_7fc505adf1a1a7d2187f5ecc5a950365%}
            $price = $this->request->getPost("price", "double");

            // {%filter_277769acea0ca776c101d2c17a5d2466%}
            $email = $this->request->getPost("customerEmail", "email");

        }

    }


%{filter_36ff741b070e90b755ef99fbde9b438c}%
---------------------------
%{filter_33e0ab6879b0a768bd0b2097153d4d49}%

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }

    }


%{filter_4ebfda3361a1fabe7be70fedcf157699}%
--------------
%{filter_4b94af7039a1ab25a7b967ac26588f92|:doc:`Phalcon\\Filter <../api/Phalcon_Filter>`}%

.. code-block:: php

    <?php

    $filter = new \Phalcon\Filter();

    // {%filter_42431b9e9fde0176fb943ee5374eefb6%}
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // {%filter_42431b9e9fde0176fb943ee5374eefb6%}
    $filter->sanitize("  Hello   ", "trim");



%{filter_2e03a6d1ccdcf7c081406aad372249a5}%
-------------------------
%{filter_8a608152ff5bd1cce8bb0fbf62695c80}%

+-----------+---------------------------------------------------------------------------+
| Name      | Description                                                               |
+===========+===========================================================================+
| string    | Strip tags                                                                |
+-----------+---------------------------------------------------------------------------+
| email     | Remove all characters except letters, digits and !#$%&*+-/=?^_`{|}~@.[].  |
+-----------+---------------------------------------------------------------------------+
| int       | Remove all characters except digits, plus and minus sign.                 |
+-----------+---------------------------------------------------------------------------+
| float     | Remove all characters except digits, dot, plus and minus sign.            |
+-----------+---------------------------------------------------------------------------+
| alphanum  | Remove all characters except [a-zA-Z0-9]                                  |
+-----------+---------------------------------------------------------------------------+
| striptags | Applies the strip_tags_ function                                          |
+-----------+---------------------------------------------------------------------------+
| trim      | Applies the trim_ function                                                |
+-----------+---------------------------------------------------------------------------+
| lower     | Applies the strtolower_ function                                          |
+-----------+---------------------------------------------------------------------------+
| upper     | Applies the strtoupper_ function                                          |
+-----------+---------------------------------------------------------------------------+


%{filter_c39f0d2625dc1cb85a72aa84a008fb93}%
-------------------------
%{filter_1e4204abe542cfdcabd014c47678555b|:doc:`Phalcon\\Filter <../api/Phalcon_Filter>`}%

.. code-block:: php

    <?php

    $filter = new \Phalcon\Filter();

    //{%filter_2f1fffb20b38514cec7ec9556bcc1901%}
    $filter->add('md5', function($value) {
        return preg_replace('/[^0-9a-f]/', '', $value);
    });

    //{%filter_5b19073aeb2a943879f05d2c76037094%}
    $filtered = $filter->sanitize($possibleMd5, "md5");


%{filter_bfb683456199b8d1bbb9099dbcb683c8}%

.. code-block:: php

    <?php

    class IPv4Filter
    {

        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }

    }

    $filter = new \Phalcon\Filter();

    //{%filter_15ee45d5412f00b058e56a81d26eef58%}
    $filter->add('ipv4', new IPv4Filter());

    //{%filter_c8cb3781e384f6e59fbf4e7e75d76fe9%}
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");


%{filter_029798e03ad6c063f6300b5224a5776a}%
--------------------------------
%{filter_e930612d5387062f0589cb3ea5865cb7|`Data Filtering at PHP Documentation`_}%

%{filter_03a91ce6525a43a0db6b9e5e4cd2a8a0}%
----------------------------
%{filter_8422e15128d4c2bc11fec87586a93b2a|:doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>`}%

