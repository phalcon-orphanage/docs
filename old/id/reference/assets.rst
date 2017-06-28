Pengelolaan Aset
================

:code:`Phalcon\Assets` adalah komponen yang memungkinkan anda mengelola resource statik
seperti CSS stylesheet atau pustaka JavaScript dalam sebuah aplikasi web.

:doc:`Phalcon\\Assets\\Manager <../api/Phalcon_Assets_Manager>` tersedia dalam service
container, sehingga anda dapat menambahkan resource dari sembarang bagian aplikasi di mana container
tersedia.

Menambah Resource
-----------------
Asset mendukung dua jenis resource bawaan: CSS dan JavaScript. Anda dapat menciptakan
resource lain jika dibutuhkan. Pengelola asset secara internal menyimpan dua kumpulan
resource bawaan - satu untuk JavaScript dan untuk CSS.

Anda dapat menambah resource ke kumpulan seperti berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function index()
        {
            // Tambahkan beberapa CSS lokal
            $this->assets->addCss("css/style.css");
            $this->assets->addCss("css/index.css");

            // Tambahkan beberapa Javascript
            $this->assets->addJs("js/jquery.js");
            $this->assets->addJs("js/bootstrap.min.js");
        }
    }

di sebuah view, resource ini lalu dapat dicetak:

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>

            <?php $this->assets->outputCss(); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs(); ?>
        </body>
    <html>

Sintaks Volt:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>

            {{ assets.outputCss() }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs() }}
        </body>
    <html>

Untuk performa pageload yang lebih baik, disarankan untuk menempatkan JavaScript diakhir HTML daripada di :code:`<head>`.

Resource Local/Remote
---------------------
Resource lokal adalah resource yang disediakan oleh aplikasi yang sama dan terletak di document root
aplikasi. URL resource lokal dibuat menggunakan 'url' service, biasanya
:doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`.

Resource remote adalah resource seperti pustaka umum seperti jQuery, Bootstrap, dan lain-lain. yang disediakan  oleh sebuah CDN.

Parameter kedua :code:`addCss()` dan :code:`addJs()` menyatakan apakah resource adalah lokal atau tidak (:code:`true` berarti lokal, :code:`false` berarti remote). Defaultnya, pengelola asset akan mengasumsikan resource adalah lokal:

.. code-block:: php

    <?php

    public function indexAction()
    {
        // Tambahkan resource CSS local
        $this->assets->addCss("//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css", false);
        $this->assets->addCss("css/style.css", true);
        $this->assets->addCss("css/extra.css");
    }

Koleksi
-------
Koleksi mengelompokkan resource berjenis sama. Pengelola asset secara implisit menciptakan dua koleksi: :code:`css` dan :code:`js`.
Anda dapat menciptakan koleksi tambahah untuk mengelompokkan resource tertentu agar mudah menempatkan resource tersebut di view:

.. code-block:: php

    <?php

    // Javascripts di header
    $headerCollection = $this->assets->collection("header");

    $headerCollection->addJs("js/jquery.js");
    $headerCollection->addJs("js/bootstrap.min.js");

    // Javascripts di footer
    $footerCollection = $this->assets->collection("footer");

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

dalam view:

.. code-block:: html+php

    <html>
        <head>
            <title>Some amazing website</title>

            <?php $this->assets->outputJs("header"); ?>
        </head>

        <body>
            <!-- ... -->

            <?php $this->assets->outputJs("footer"); ?>
        </body>
    <html>

Sintaks Volt:

.. code-block:: html+jinja

    <html>
        <head>
            <title>Some amazing website</title>

            {{ assets.outputCss("header") }}
        </head>

        <body>
            <!-- ... -->

            {{ assets.outputJs("footer") }}
        </body>
    <html>

Prefix URL
----------
Koleksi dapat diberi prefix URL, memungkinkan anda mengubah satu server ke lainnya pada tiap saat:

.. code-block:: php

    <?php

    $footerCollection = $this->assets->collection("footer");

    if ($config->environment === "development") {
        $footerCollection->setPrefix("/");
    } else {
        $footerCollection->setPrefix("http:://cdn.example.com/");
    }

    $footerCollection->addJs("js/jquery.js");
    $footerCollection->addJs("js/bootstrap.min.js");

Sintaks berantai tersedia pula:

.. code-block:: php

    <?php

    $scripts = $assets
        ->collection("header")
        ->setPrefix("http://cdn.example.com/")
        ->setLocal(false)
        ->addJs("js/jquery.js")
        ->addJs("js/bootstrap.min.js");

Penyaringan dan Minifikasi
--------------------------
:code:`Phalcon\Assets` menyediakan minfikasi resource JavaScript dan CSS bawaan. Anda dapat menciptakan koleksi resource yang
memerintahkan pengelola asset mana harus disaring dan mana yang harus dibiarkan apa adanya.
Tambahan diatas, Jsmin oleh Douglas Crockford adalah bagian ektensi inti yang menawarkan minifikasi file JavaScript
untuk performa maksimum. Di ranah CSS, CSSMin oleh Ryan Day juga tersedia untuk meminimalkan file CSS:

Contoh berikut menunjukkan bagaimana melakukan minifikasi pada koleksi resource:

.. code-block:: php

    <?php

    $manager

        // JavaScript berikut terletak di bawah
        ->collection("jsFooter")

        // Nama file akhir
        ->setTargetPath("final.js")

        // Script tag dibuat dengan URI ini
        ->setTargetUri("production/final.js")

        // INi adalah resource remote yang tidak perlu difilter
        ->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false)

        // Ini adalah resource lokal yang harus difilter
        ->addJs("common-functions.js")
        ->addJs("page-functions.js")

        // Gabung semuanya menjadi satu file
        ->join(true)

        // menggunakan filter bawaan Jsmin
        ->addFilter(
            new Phalcon\Assets\Filters\Jsmin()
        )

        // Menggunakan filter kustom
        ->addFilter(
            new MyApp\Assets\Filters\LicenseStamper()
        );

Sebuah koleksi dapat berisi resource JavaScript atau CSS
namun tidak keduanya. Beberapa resource mungkin remote, yakni, mereka diperoleh melalui HTTP dari sumber remote
untuk difilter lebih lanjut. Di sarankan untuk mengubah resource external menjadi lokal untuk performa lebih baik.

Seperti yang terlihat di atas, metode :code:`addJs()` digunakan untuk menambah resource ke koleksi, parameter kedua menentukan
apakah resource adalah ekternal atau tidak dan parameter ketiga menentukan apakah resource harus difilter atau
dibiarkan apa adanya:

.. code-block:: php

    <?php

    // JavaScript ini terletak di bagian bawah halaman
    $jsFooterCollection = $manager->collection("jsFooter");

    // resource remote berikut tidak perlu difilter
    $jsFooterCollection->addJs("code.jquery.com/jquery-1.10.0.min.js", false, false);

    // Resource lokal ini harus difilter
    $jsFooterCollection->addJs("common-functions.js");
    $jsFooterCollection->addJs("page-functions.js");

Filter didaftarkan di koleksi, filter lebih dari satu diizinkan, konten resource difilter
dengan urutan sama seperti urutan registrasi filter:

.. code-block:: php

    <?php

    // gunakan filter Jsmin bawaan
    $jsFooterCollection->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    );

    // Gunakan filter custom
    $jsFooterCollection->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );

Kedua filter bawaan dan kustom dapat diterapkan secara transparan pada koleksi.
Langkah terakhir adalah menentukan apakah semua resource dalam koleksi harus digabung menjadi file tunggal or masing-masing
terpisah. Untuk memberitahu koleksi bawah semua resource harus digabung anda dapat menggunakan metode :code:`join()`.

Jika resource akan digabung, kita perlu menentukan file yang digunakan untuk menyimpan resource
dan URI mana yang akan digunakan menampilkannya. Pengaturan ini diset dengan :code:`setTargetPath()` dan :code:`setTargetUri()`:

.. code-block:: php

    <?php

    $jsFooterCollection->join(true);

    // Nama file akhir
    $jsFooterCollection->setTargetPath("public/production/final.js");

    // script HTML tag dibuat dengan URI ini
    $jsFooterCollection->setTargetUri("production/final.js");

Filter Bawaan
^^^^^^^^^^^^^
Phalcon menyediakan 2 filter bawaan untuk minifikasi JavaScript dan CSS, C-backendnya menghasilkan
overhead terendah untuk menjalankan tugas ini:

+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+
| Filter                                                                          | Keterangan                                                                                                   |
+=================================================================================+==============================================================================================================+
| :doc:`Phalcon\\Assets\\Filters\\Jsmin <../api/Phalcon_Assets_Filters_Jsmin>`    | Mengecilkan JavaScript dengan menghapus karakter yang diabaikan oleh interpreter/kompiler Javascript         |
+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Assets\\Filters\\Cssmin <../api/Phalcon_Assets_Filters_Cssmin>`  | Mengecilkan CSS dengan menghapus karakter yang diabaikan oleh  browsers                                      |
+---------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------+

Filter Kustom
^^^^^^^^^^^^^
Sebagai tambahan filter bawaan, anda dapat menciptakan filter anda sendiri. Filter ini dapat memanfaatkan
tool yang sudah dan lebih canggih seperti YUI_, Sass_, Closure_, dan lain-lain.:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Filter konten CSS dengan YUI
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
        public function __construct(array $options)
        {
            $this->_options = $options;
        }

        /**
         * Lakukan filtering
         *
         * @param string $contents
         *
         * @return string
         */
        public function filter($contents)
        {
            // Tulis konten string ke file sementara
            file_put_contents("temp/my-temp-1.css", $contents);

            system(
                $this->_options["java-bin"] .
                " -jar " .
                $this->_options["yui"] .
                " --type css " .
                "temp/my-temp-file-1.css " .
                $this->_options["extra-options"] .
                " -o temp/my-temp-file-2.css"
            );

            // Kembalikan isi file sementara
            return file_get_contents("temp/my-temp-file-2.css");
        }
    }

Penggunaan:

.. code-block:: php

    <?php

    // Ambil koleksi CSS
    $css = $this->assets->get("head");

    // Tambahkan filter kompresor YUI ke koleksi
    $css->addFilter(
        new CssYUICompressor(
            [
                "java-bin"      => "/usr/local/bin/java",
                "yui"           => "/some/path/yuicompressor-x.y.z.jar",
                "extra-options" => "--charset utf8",
            ]
        )
    );

di contoh sebelumnya, kita menggunakan filter kustom bernama :code:`LicenseStamper`:

.. code-block:: php

    <?php

    use Phalcon\Assets\FilterInterface;

    /**
     * Tambahkan pesan lisensi di awal file
     *
     * @param string $contents
     *
     * @return string
     */
    class LicenseStamper implements FilterInterface
    {
        /**
         * Lakukan filtering
         *
         * @param string $contents
         * @return string
         */
        public function filter($contents)
        {
            $license = "/* (c) 2015 Your Name Here */";

            return $license . PHP_EOL . PHP_EOL . $contents;
        }
    }

Output Kustom
-------------
Metode :code:`outputJs()` dan :code:`outputCss()` tersedia untuk menghasilkan kode HTML yang diperlukan tergantung jenis masing-masing resource.
Anda dapat mengubah metode ini atau mencetak resource secara manual dengan cara berikut:

.. code-block:: php

    <?php

    use Phalcon\Tag;

    $jsCollection = $this->assets->collection("js");

    foreach ($jsCollection as $resource) {
        echo Tag::javascriptInclude(
            $resource->getPath()
        );
    }

.. _YUI: http://yui.github.io/yuicompressor/
.. _Closure: https://developers.google.com/closure/compiler/?hl=fr
.. _Sass: http://sass-lang.com/
