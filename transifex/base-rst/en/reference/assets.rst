%{assets_744c3ef6243d76429a95f010a3d47cff}%
=================
%{assets_b0278ad267d2461d3eeafc96122e4a31}%

%{assets_4c79a3fe144f02b4051810553a60c81d|:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>`}%

%{assets_647e8a84d61a2443e8d863a01727bdb8}%
----------------
%{assets_fab89985217fa01f7d36db4a2aae5611}%

%{assets_adae69cdf99e915a88e999a00581ded7}%

.. code-block:: php

    <?php

    class IndexController extends Phalcon\Mvc\Controller
    {
        public function index()
        {

            //{%assets_97b60f20c393002ceb1986abec9f384b%}
            $this->assets
                ->addCss('css/style.css')
                ->addCss('css/index.css');

            //{%assets_541ee5ffa36c80f2738a6aac8cf5fbb5%}
            $this->assets
                ->addJs('js/jquery.js')
                ->addJs('js/bootstrap.min.js');

        }
    }


%{assets_9d066fce3103272821fc1c8a5c911fb0}%

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputCss() ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs() ?>
        </body>
    <html>


%{assets_40aa86d406a1567e2bb210cfccefd275}%
----------------------
%{assets_467802b99de71cf3cdd123387595c997|:doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`}%

%{assets_3f915d0e3e0a36ea435f995608b6919b}%

.. code-block:: php

    <?php

    //{%assets_97b60f20c393002ceb1986abec9f384b%}
    $this->assets
        ->addCss('//{%assets_749e2c3df0bf62ddd51bf3b50e61a2c4%}
        ->addCss('css/style.css', true);


%{assets_ad9b4b4c5b5164f6d3d77012df79c45f}%
-----------
%{assets_b0af0daf04f160e1588b0acba893eb88}%

.. code-block:: php

    <?php

    //{%assets_8a454675029935590059e4a4207f2252%}
    $this->assets
        ->collection('header')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');

    //{%assets_b51c560c9b848906d21798a4e9124a11%}
    $this->assets
        ->collection('footer')
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');


%{assets_4ce74cf3cd3f9c87190cc9cdcdd697de}%

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>
            <?php $this->assets->outputJs('header') ?>
        </head>
        <body>

            <!-- ... -->

            <?php $this->assets->outputJs('footer') ?>
        </body>
    <html>


%{assets_f051468092cd30c784f47c1c1f518b5e}%
--------
%{assets_68847db02bfef9a3f2cbb88f3bb52ebc}%

.. code-block:: php

    <?php

    $scripts = $this->assets->collection('footer');

    if ($config->environment == 'development') {
        $scripts->setPrefix('/');
    } else {
        $scripts->setPrefix('http:://cdn.example.com/');
    }

    $scripts->addJs('js/jquery.js')
            ->addJs('js/bootstrap.min.js');


%{assets_2dd20ca96e294ccca7d0b0498988674e}%

.. code-block:: php

    <?php

    $scripts = $assets
        ->collection('header')
        ->setPrefix('http://{%assets_5aa494e28988749ce9c0590848cf362e%}
        ->setLocal(false)
        ->addJs('js/jquery.js')
        ->addJs('js/bootstrap.min.js');


%{assets_ae62cffd270c3e0cab6f30fefed9136c}%
----------------------
%{assets_3bf58860ebfa7528c3c1159d5e0a9565}%

%{assets_13288958d7900905c0705e80f54a8091}%

.. code-block:: php

    <?php

    $manager

        //{%assets_24d37315fe2dd7cc09472c27e3f5f7f8%}
        ->collection('jsFooter')

        //{%assets_569bb9f943f3f450a88d429c86ce78a2%}
        ->setTargetPath('final.js')

        //{%assets_26d8454d754918be398e0b9fdbeb5ae0%}
        ->setTargetUri('production/final.js')

        //{%assets_506859d439edc456b63250e6d21506ba%}
        ->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false)

        //{%assets_8483fe8dbc76cbc7cd4c561a9fb8e9d4%}
        ->addJs('common-functions.js')
        ->addJs('page-functions.js')

        //{%assets_bb21e08f5118d8e756e5931ad34a0cb4%}
        ->join(true)

        //{%assets_e7e2222b6c8fc52259a40f333221fd7c%}
        ->addFilter(new Phalcon\Assets\Filters\Jsmin())

        //{%assets_846d0f7848b284338b9f8cf2925e60ef%}
        ->addFilter(new MyApp\Assets\Filters\LicenseStamper());


%{assets_da38d11ae4639174732c3a3a7b3c539a}%

.. code-block:: php

    <?php

    //{%assets_24d37315fe2dd7cc09472c27e3f5f7f8%}
    $js = $manager->collection('jsFooter');


%{assets_86e4862e10edfdeada3c6627782eb1a1}%

.. code-block:: php

    <?php

    // {%assets_018bbed3aeeec02df927ee3f6c36fe33%}
    $js->addJs('code.jquery.com/jquery-1.10.0.min.js', true, false);

    // {%assets_8483fe8dbc76cbc7cd4c561a9fb8e9d4%}
    $js->addJs('common-functions.js');
    $js->addJs('page-functions.js');


%{assets_117e99e366d35d81ada7c3bf77dfcab1}%

.. code-block:: php

    <?php

    //{%assets_e7e2222b6c8fc52259a40f333221fd7c%}
    $js->addFilter(new Phalcon\Assets\Filters\Jsmin());

    //{%assets_846d0f7848b284338b9f8cf2925e60ef%}
    $js->addFilter(new MyApp\Assets\Filters\LicenseStamper());


%{assets_68e1c7c7c02b0c92d429361a93e217b4}%

.. code-block:: php

    <?php

    // {%assets_018bbed3aeeec02df927ee3f6c36fe33%}
    $js->join(true);

    //{%assets_a9e35114d8dbc115f304b3e8ec0db44f%}
    $js->setTargetPath('public/production/final.js');

    //{%assets_de1e687c95ee8b073172990876438f26%}
    $js->setTargetUri('production/final.js');


%{assets_a4bc709eadced84a672028c6471bad63}%

%{assets_4e6bcce78953fc4fab8ab028f9630b0e}%
^^^^^^^^^^^^^^^^
%{assets_b71d0d7b82df795a3f71bc36986017d6}%

+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Filter                            | Description                                                                                               |
+===================================+===========================================================================================================+
| Phalcon\\Assets\\Filters\\Jsmin   | Minifies Javascript removing unnecessary characters that are ignored by Javascript interpreters/compilers |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+
| Phalcon\\Assets\\Filters\\Cssmin  | Minifies CSS removing unnecessary characters that are already ignored by browsers                         |
+-----------------------------------+-----------------------------------------------------------------------------------------------------------+


%{assets_d1b2812923f7a6a1b2e2d1c556d842ce}%
^^^^^^^^^^^^^^
%{assets_29d376fce56b9b142527b0a8f433e827}%

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Filters CSS content using YUI
     *
     * @param string $contents
     * @return string
     */
    class CssYUICompressor implements FilterInterface
    {

        protected $_options;

        /**
         * CssYUICompressor constructor
         *
         * @param array $options
         */
        public function __construct($options)
        {
            $this->_options = $options;
        }

        /**
         * Do the filtering
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {

            //{%assets_5f64b35b08613f5d7f879a85b64466db%}
            file_put_contents('temp/my-temp-1.css', $contents);

            system(
                $this->_options['java-bin'] .
                ' -jar ' .
                $this->_options['yui'] .
                ' --type css '.
                'temp/my-temp-file-1.css ' .
                $this->_options['extra-options'] .
                ' -o temp/my-temp-file-2.css'
            );

            //{%assets_03bdedb550012cb6cd20dab6d7eb4edd%}
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }


%{assets_cd6b467ef5d856d72fe964ed65ffd28a}%

.. code-block:: php

    <?php

    //{%assets_c0ce9fe3866c4f3e96453e2d0c1cc01d%}
    $css = $this->assets->get('head');

    //{%assets_4a9cea3c8c1c8fc27161b32c96823eba%}
    $css->addFilter(new CssYUICompressor(array(
         'java-bin' => '/usr/local/bin/java',
         'yui' => '/some/path/yuicompressor-x.y.z.jar',
         'extra-options' => '--charset utf8'
    )));


%{assets_5360cfefe9d89ff1c2f947439de199a3}%
-------------
%{assets_6a556a51195344c6d4e6f145ea73b690}%

