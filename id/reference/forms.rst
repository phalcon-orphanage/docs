Forms
=====

:code:`Phalcon\Forms` adalah sebuah komponen yang membantumu dalam menciptakan dan mengelola form dalam aplikasi web.

Contoh berikut menunjukkan penggunaan dasarnya:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    $form = new Form();

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "telephone"
        )
    );

    $form->add(
        new Select(
            "telephoneType",
            [
                "H" => "Home",
                "C" => "Cell",
            ]
        )
    );

Form dapat dirender berdasarkan definisi form:

.. code-block:: html+php

    <h1>
        Contacts
    </h1>

    <form method="post">

        <p>
            <label>
                Name
            </label>

            <?php echo $form->render("name"); ?>
        </p>

        <p>
            <label>
                Telephone
            </label>

            <?php echo $form->render("telephone"); ?>
        </p>

        <p>
            <label>
                Type
            </label>

            <?php echo $form->render("telephoneType"); ?>
        </p>



        <p>
            <input type="submit" value="Save" />
        </p>

    </form>

Tiap elemen dalam form dapat di render seperlunya oleh developer. Secara internal,
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` digunakan untuk menghasilkan HTML yang benar untuk tiap elemen dan anda dapat melewatkan atribut HTML tambahan di parameter kedua :code:`render()`:

.. code-block:: html+php

    <p>
        <label>
            Name
        </label>

        <?php echo $form->render("name", ["maxlength" => 30, "placeholder" => "Type your name"]); ?>
    </p>

Atribut HTML dapat juga di set dalam definisi elemen:

.. code-block:: php

    <?php

    $form->add(
        new Text(
            "name",
            [
                "maxlength"   => 30,
                "placeholder" => "Type your name",
            ]
        )
    );

Inisialisasi forms
------------------
Seperti terlihat sebelumnya, form dapat diinisialisasi diluar kelas form dengan menambahkan elemen ke dalamnya. Anda dapat menggunakan ulang code atau mengorganisasi kelas form anda
dengam membuat implementasi form dalam file terpisah:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    class ContactForm extends Form
    {
        public function initialize()
        {
            $this->add(
                new Text(
                    "name"
                )
            );

            $this->add(
                new Text(
                    "telephone"
                )
            );

            $this->add(
                new Select(
                    "telephoneType",
                    TelephoneTypes::find(),
                    [
                        "using" => [
                            "id",
                            "name",
                        ]
                    ]
                )
            );
        }
    }

:doc:`Phalcon\\Forms\\Form <../api/Phalcon_Forms_Form>` diturunkan dari :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`
sehingga anda punya akses ke service aplikasi bila diperlukan:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class ContactForm extends Form
    {
        /**
         * This method returns the default value for field 'csrf'
         */
        public function getCsrf()
        {
            return $this->security->getToken();
        }

        public function initialize()
        {
            // Set the same form as entity
            $this->setEntity($this);

            // Add a text element to capture the 'email'
            $this->add(
                new Text(
                    "email"
                )
            );

            // Add a text element to put a hidden CSRF
            $this->add(
                new Hidden(
                    "csrf"
                )
            );
        }
    }

Entitas terkait yang ditambahkan ke form dalam inisialisasi dan opsi kustom pengguna dilewatkan kedalam konstruktor form:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class UsersForm extends Form
    {
        /**
         * Forms initializer
         *
         * @param Users $user
         * @param array $options
         */
        public function initialize(Users $user, array $options)
        {
            if ($options["edit"]) {
                $this->add(
                    new Hidden(
                        "id"
                    )
                );
            } else {
                $this->add(
                    new Text(
                        "id"
                    )
                );
            }

            $this->add(
                new Text(
                    "name"
                )
            );
        }
    }

Dalam penciptaan form anda harus menggunakan:

.. code-block:: php

    <?php

    $form = new UsersForm(
        new Users(),
        [
            "edit" => true,
        ]
    );

Validasi
--------
Form Phalcon terintegrasi dengan kompoenen :doc:`validation <validation>` untuk menyediakan validasi seketika. Validator bawaan atau kustom
dapat diatur di tiap elemen:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;
    use Phalcon\Validation\Validator\PresenceOf;
    use Phalcon\Validation\Validator\StringLength;

    $name = new Text(
        "name"
    );

    $name->addValidator(
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $name->addValidator(
        new StringLength(
            [
                "min"            => 10,
                "messageMinimum" => "The name is too short",
            ]
        )
    );

    $form->add($name);

sehingga anda dapat memvalidasi form sesuai input yang dimasukkan pengguna:

.. code-block:: php

    <?php

    if (!$form->isValid($_POST)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Validator dieksekusi dengan urutan sama seperti urutan mereka didaftarkan.

Secara default pesan yang dihasilkan semua elemen dalam form digabung sehingga mereka dapat dijelajahi dengan sebuah foreach,
anda dapat mengubah perilaku ini untuk mendapatkan pesan dipisah berdasarkan field:

.. code-block:: php

    <?php

    foreach ($form->getMessages(false) as $attribute => $messages) {
        echo "Messages generated by ", $attribute, ":", "\n";

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

atau mendapatkan pesan tertentu untuk sebuah elemen:

.. code-block:: php

    <?php

    $messages = $form->getMessagesFor("name");

    foreach ($messages as $message) {
        echo $message, "<br>";
    }

Penyaringan
-----------
Sebuah form dapat juga menyaring data sebelum divalidasi. Anda dapat mengatur filter di tiap elemen:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;

    $name = new Text(
        "name"
    );

    // Set multiple filters
    $name->setFilters(
        [
            "string",
            "trim",
        ]
    );

    $form->add($name);



    $email = new Text(
        "email"
    );

    // Set one filter
    $email->setFilters(
        "email"
    );

    $form->add($email);

.. highlights::

    Pelajari lebih jauh tentang penyaringan dalam Phalcon dengan membaca :doc:`dokumentasi Filter <filter>`.

Form + Entitas
--------------
Sebuah entitas seperti sebuah model/koleksi/atau instance biasa atau sekedar kelas PHP biasa dapat dikaitkan ke form untuk mengatur nilai defaultnya
dalam elemen form atau menyalin nilai dari form ke entitas secara mudah:

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    $form = new Form($robot);

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "year"
        )
    );

Ketika form di render jika tidak ada default value diset ke elemen, ia akan menggunakan yang disediakan entitas:

.. code-block:: html+php

    <?php echo $form->render("name"); ?>

Anda dapat memvalidasi form dan menyalin nilai dari input user dengan cara berikut:

.. code-block:: php

    <?php

    $form->bind($_POST, $robot);

    // Check if the form is valid
    if ($form->isValid()) {
        // Save the entity
        $robot->save();
    }

Mengatur kelas biasa sebagai entitas juga dimungkinkan:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone = "Europe/Amsterdam";

        public $receiveEmails = "No";
    }

Menggunakan kelas ini sebagai entitas, memungkinkan form mengambil nilai default darinya:

.. code-block:: php

    <?php

    $form = new Form(
        new Preferences()
    );

    $form->add(
        new Select(
            "timezone",
            [
                "America/New_York"  => "New York",
                "Europe/Amsterdam"  => "Amsterdam",
                "America/Sao_Paulo" => "Sao Paulo",
                "Asia/Tokyo"        => "Tokyo",
            ]
        )
    );

    $form->add(
        new Select(
            "receiveEmails",
            [
                "Yes" => "Yes, please!",
                "No"  => "No, thanks",
            ]
        )
    );

Entitas dapat mengimplementasi getter, yang memiliki presedensi lebih tinggi dibanding properti publik. Metode ini
memberikan kebebasan lebih untuk menghasilkan nilai:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone;

        public $receiveEmails;



        public function getTimezone()
        {
            return "Europe/Amsterdam";
        }

        public function getReceiveEmails()
        {
            return "No";
        }
    }

Elemen Form
-----------
Phalcon menyedikana sejumlah elemen bawaanuntuk digunakan dalam form, semua elemen ini terletak di namespace :doc:`Phalcon\\Forms\\Element <../api/Phalcon_Forms_Element>`:

+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| Nama                                                                             | Keterangan                                                    |
+==================================================================================+===============================================================+
| :doc:`Phalcon\\Forms\\Element\\Text <../api/Phalcon_Forms_Element_Text>`         | Menghasilkan elemen INPUT[type=text]                          |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Password <../api/Phalcon_Forms_Element_Password>` | Menghasilkan elemen INPUT[type=password]                      |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Select <../api/Phalcon_Forms_Element_Select>`     | Menghasilkan elemen tag SELECT (combo lists) berdasar pilihan |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Check <../api/Phalcon_Forms_Element_Check>`       | Menghasilkan elemen INPUT[type=check]                         |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\TextArea <../api/Phalcon_Forms_Element_TextArea>` | Menghasilkan elemen TEXTAREA                                  |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Hidden <../api/Phalcon_Forms_Element_Hidden>`     | Menghasilkan elemen INPUT[type=hidden]                        |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\File <../api/Phalcon_Forms_Element_File>`         | Menghasilkan elemen INPUT[type=file]                          |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Date <../api/Phalcon_Forms_Element_Date>`         | Menghasilkan elemen INPUT[type=date]                          |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Numeric <../api/Phalcon_Forms_Element_Numeric>`   | Menghasilkan elemen INPUT[type=number]                        |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Submit <../api/Phalcon_Forms_Element_Submit>`     | Menghasilkan elemen INPUT[type=submit]                        |
+----------------------------------------------------------------------------------+---------------------------------------------------------------+

Callback Event
--------------
Tiap kali form diimplementasi sebagai kelas, callback: :code:`beforeValidation()` dan :code:`afterValidation()` dapat diimplementasi
dalam kelas form untuk melakukan sesuatu sebelum dan sesudah validasi:

.. code-block:: html+php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function beforeValidation()
        {

        }
    }

Merender Form
-------------
Anda dapat merender form dengan fleksibilitas penuh, contoh berikut menunjukkan bagaimana merender tiap elemen menggunakan prosedur standar:

.. code-block:: html+php

    <?php

    <form method="post">
        <?php

            // Traverse the form
            foreach ($form as $element) {
                // Get any generated messages for the current element
                $messages = $form->getMessagesFor(
                    $element->getName()
                );

                if (count($messages)) {
                    // Print each element
                    echo '<div class="messages">';

                    foreach ($messages as $message) {
                        echo $message;
                    }

                    echo "</div>";
                }

                echo "<p>";

                echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

                echo $element;

                echo "</p>";
            }

        ?>

        <input type="submit" value="Send" />
    </form>

atau menggunakan ulang logika dalam kelas form:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function initialize()
        {
            // ...
        }

        public function renderDecorated($name)
        {
            $element  = $this->get($name);

            // Get any generated messages for the current element
            $messages = $this->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Print each element
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $this->flash->error($message);
                }

                echo "</div>";
            }

            echo "<p>";

            echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

            echo $element;

            echo "</p>";
        }
    }

dalam view:

.. code-block:: php

    <?php

    echo $element->renderDecorated("name");

    echo $element->renderDecorated("telephone");

Menciptakan Elemen Form
-----------------------
Sebagai tambahan elemen yang disediakan Phalcon, anda dapat menciptakan elemen kustom anda sendiri:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element;

    class MyElement extends Element
    {
        public function render($attributes = null)
        {
            $html = // ... Produce some HTML

            return $html;
        }
    }

Pengelola Form
--------------
Komponen ini menyediakan pengelola form yang dapat digunakan developer untuk mendaftarkan form dan mengaksesnya melalui service locator:

.. code-block:: php

    <?php

    use Phalcon\Forms\Manager as FormsManager;

    $di["forms"] = function () {
        return new FormsManager();
    };

Form ditambahkan ke pengelola form dan diacu dengan sebuah nama unik:

.. code-block:: php

    <?php

    $this->forms->set(
        "login",
        new LoginForm()
    );

Menggunakan nama unik, form dapat diakses dari semua bagian aplikasi:

.. code-block:: php

    <?php

    $loginForm = $this->forms->get("login");

    echo $loginForm->render();

Resource Eksternal
------------------
* `Vökuró <http://vokuro.phalconphp.com>`_, adalah aplikasi contoh yang menggunakan form builder untuk menciptakan dan mengelola form, [`Github <https://github.com/phalcon/vokuro>`_]
