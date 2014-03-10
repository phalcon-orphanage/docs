%{tools_f16ba89ee7afed1f5adf9ccfab7fc774}%

=======================
%{tools_5f86a37a76c402c9a7ef8e85ea9b8fe9}%


.. highlights::
    **Important:** Phalcon Framework version 0.5.0 or greater is needed to use developer tools. It is highly recommended
    to use PHP 5.3.6 or greater. If you prefer to use the web version instead of the console, this `blog post`_ offers more information.


%{tools_d779ffb4113a9aa6902414524b888ae6}%

--------
%{tools_e0d8720ef3987ed002683da3d43b08b9}%


%{tools_c0277e63a218ee84b1414b2c467dfbe2}%

^^^^^^^^^^^^
%{tools_618388d79fb02b4b00cdda6d5a1f4242}%


.. toctree::
   :maxdepth: 1

   wintools
   mactools
   linuxtools


%{tools_16dcaef43f145e3d6763695db14944f3}%

--------------------------
%{tools_111c7ef624beb6d4338c718ef0d22708}%


.. code-block:: sh

   $ phalcon commands
   
   Phalcon DevTools (1.2.3)
   
   Available commands:
     commands (alias of: list, enumerate)
     controller (alias of: create-controller)
     model (alias of: create-model)
     all-models (alias of: create-all-models)
     project (alias of: create-project)
     scaffold
     migration
     webtools


%{tools_6a9c831bc5c1ae5b32aabbc1fe4a3788}%

-----------------------------
%{tools_6ae7fb5b78692a0f18c712f21f66682c}%


.. code-block:: sh

      $ pwd
      
      /Applications/MAMP/htdocs
      
      $ phalcon create-project store

%{tools_c1e0d3d651727e5163a3f4250dc7ff45}%

.. figure:: ../_static/img/tools-2.png
   :align: center


%{tools_dd36a0f52c3ae7025e3b72d5e380e40e}%

.. code-block:: sh

%{tools_f911e2ec92e2456b37496da17a606409}%

%{tools_23ac6acc0e34590f4de7567323ba9276}%

%{tools_eb4f9090943e6671f13c7881aae28c56}%

%{tools_46378e7968dc488b8ee87396d91c52ac}%

%{tools_61204847703c2789b23a92c79e1833ea}%

%{tools_04f17bfd175fbc6c9ddc99f5d75fec62}%

%{tools_89bd1ab95dfdabc96068f90960c91a31}%

.. figure:: ../_static/img/tools-6.png
   :align: center


%{tools_d7281d770a3c367a891c86662c961e99}%

----------------------
%{tools_40d723c00197dab564136975660379ab}%


.. code-block:: sh
         
         $ phalcon create-controller --name test

%{tools_3b61a911a3744d3ff3959a2502bb4e16}%

.. code-block:: php

    <?php

    class TestController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

    }

%{tools_26686a2cd6d0eae99caeca53e31c49e6}%

---------------------------
%{tools_2476ca1c4e1fdf94a9a720dd10d3cae8}%


%{tools_efc2231631071970e3c45b53b4bc2840}%

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = "127.0.0.1"
    username = "root"
    password = "secret"
    dbname   = "store_db"

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"
    baseUri        = "/store/"

%{tools_103eb217645d47c61117060bf3a071b9}%

-----------------
%{tools_bbc4c78364dd5d44f17b00b7f76a6b30}%


%{tools_e3f69c7f20b479a18d7035ceb3674fce}%

%{tools_806d1bdc5625ca89cb015ee23299a7e2}%

.. code-block:: sh
         
         $ phalcon model products

.. code-block:: sh

         $ phalcon model --name tablename

%{tools_887926b8b25f33cc752b00608d55a548}%

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        /**
         * @var integer
         */
        public $id;

        /**
         * @var integer
         */
        public $types_id;

        /**
         * @var string
         */
        public $name;

        /**
         * @var string
         */
        public $price;

        /**
         * @var integer
         */
        public $quantity;

        /**
         * @var string
         */
        public $status;

    }

%{tools_b697bd502539c77c3cb6107ecc595ce8}%

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        /**
         * @var integer
         */
        protected $id;

        /**
         * @var integer
         */
        protected $types_id;

        /**
         * @var string
         */
        protected $name;

        /**
         * @var string
         */
        protected $price;

        /**
         * @var integer
         */
        protected $quantity;

        /**
         * @var string
         */
        protected $status;


        /**
         * Method to set the value of field id
         * @param integer $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * Method to set the value of field types_id
         * @param integer $types_id
         */
        public function setTypesId($types_id)
        {
            $this->types_id = $types_id;
        }

        ...

        /**
         * Returns the value of field status
         * @return string
         */
        public function getStatus()
        {
            return $this->status;
        }

    }

%{tools_d1cae8a930c6e65aab57aa3cb21832e2}%

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/39213020" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>


%{tools_444dcb6e4ab792f7a397678de08b5b12}%

---------------
%{tools_dcce99b2bb012a713c31b24feddf3d1b}%


%{tools_547d2484a1540272d09dc63d614bb925}%

.. code-block:: sh

         $ phalcon scaffold --table-name test

%{tools_499e3e858ae84fcd7bc4c32289d2244e}%

+----------------------------------------+--------------------------------+
| File                                   | Purpose                        |
+========================================+================================+
| app/controllers/ProductsController.php | The Products controller        |
+----------------------------------------+--------------------------------+
| app/models/Products.php                | The Products model             |
+----------------------------------------+--------------------------------+
| app/views/layout/products.phtml        | Controller layout for Products |
+----------------------------------------+--------------------------------+
| app/views/products/new.phtml           | View for the action "new"      |
+----------------------------------------+--------------------------------+
| app/views/products/edit.phtml          | View for the action "edit"     |
+----------------------------------------+--------------------------------+
| app/views/products/search.phtml        | View for the action "search"   |
+----------------------------------------+--------------------------------+
| app/views/products/edit.phtml          | View for the action "edit"     |
+----------------------------------------+--------------------------------+

%{tools_4ccaf4063adc4214d4aef23d413ac506}%

.. figure:: ../_static/img/tools-10.png
   :align: center


%{tools_c15d7b85481e3cf75e363a0483bf475e}%

.. figure:: ../_static/img/tools-11.png
   :align: center


%{tools_4ef7d998c728fa863b606b964af5285b}%

.. figure:: ../_static/img/tools-12.png
   :align: center


%{tools_45996c72348c9fda516a66dcf9992659}%

----------------------
%{tools_eccae8f5452d061f5aa2cdbfa332b277}%


.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>


%{tools_642c39544aab1f7c922b02712472d40a}%

-----------------------------------
%{tools_919b2a529039394c56937519d3027c74}%


.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/43455647" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>


%{tools_ee50f1d496b9cd00d5955f10f6dc7517}%

----------
%{tools_c7953dac4a7034ef255b13fdac1919f3}%


