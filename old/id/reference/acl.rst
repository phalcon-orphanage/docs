Access Control Lists (ACL)
==========================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` menghadirkan pengelolaan ACL yang mudah termasuk izin yang melekat padanya. `Access Control Lists`_ (ACL) memungkinkan sebuah aplikasi mengendalikan akses ke area aplikasi dan objek di dalamnya melalui request. Anda disarankan membaca lebih jauh tentang metodologi ACL agar familiar dengan konsepnya.

Singkatnya, ACL memiliki role dan resource. Resource adalah objek yang mematuhi izin yang didefinisikan terhadapnya oleh ACL. Role adalah objek yang meminta akses ke resource dan dapat diberi atau ditolak oleh mekanisme ACL.

Menciptakan sebuah ACL
----------------------
Komponen ini dirancang awalnya bekerja di memori. Hal ini memberikan kemudahan pakai dan kecepatan akses ke semua aspek di daftar. Konstruktor :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` parameter pertama mengharapkan sebuah adapter yang digunakan untuk mengambil informasi terkait control list. Contoh menggunakan adapter memori adalah sebagai berikut:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

Defaultnya :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` mengizinkan akses ke aksi pada resource yang belum didefinisi. Untuk meningkatkan level keamanan access list, kita dapat mendefinisikan level "deny" sebagai level akses default.

.. code-block:: php

    <?php

    use Phalcon\Acl;

    // Aksi default adalah deny access
    $acl->setDefaultAction(
        Acl::DENY
    );

Menambahkan Role ke ACL
-----------------------
Sebuah role adalah objek yang bisa atau tidak bisa mengakses resource tertentu dalam access list. Sebagai contoh, kita akan mendefinisikan role sebagai sebuah grup orang dalam sebuah organisasi. Kelas :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>` tersedia untuk menciptakan role dengan cara yang lebih terstruktur. Mari kita tambahkan beberapa role ke dalam list yang baru kita ciptakan:

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // Tambahkan beberapa role.
    // Parameter pertama adalah nama dan parameter kedua adalah deskripsi tidak wajib.
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // Tambahkan "Guests" role ke ACL
    $acl->addRole($roleGuests);

    // Tambahkan "Designers" role ke ACL tanpa menggunakan Phalcon\Acl\Role
    $acl->addRole("Designers");

Seperti yang bisa Anda lihat, role didefinisi langsung tanpa menggunakan instance.

Menambah Resource
-----------------
Resource adalah objeck-objek yang aksesnya terkontrol. Normalnya dalam aplikasi MVC resource mengacu pada kontroler. Meski tidak wajib, kelas :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` dapat digunakan untuk mendefinisikan resource. Hal penting adalah menambahkan aksi atau operasi terkait ke resource sehingga ACL dapat mengerti apa yang harus dikendalikan.

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // Definisikan resource "Customers"
    $customersResource = new Resource("Customers");

    // Tambahkan resource "customers" dengan beberapa operasi

    $acl->addResource(
        $customersResource,
        "search"
    );

    $acl->addResource(
        $customersResource,
        [
            "create",
            "update",
        ]
    );

Menentukan Kontrol Akses
------------------------
Sekarang kita punya role dan resource, saatnya untuk mendefinisikan ACL (yaitu role yang dapat mengakses resource). Bagian ini sangat penting terutama menentukan default level akses "allow" atau "deny".

.. code-block:: php

    <?php

    // Set level akses role ke resource

    $acl->allow("Guests", "Customers", "search");

    $acl->allow("Guests", "Customers", "create");

    $acl->deny("Guests", "Customers", "update");

Metode :code:`allow()` memberikan role tersebut akses ke resource tertentu. Metode :code:`deny()` melakukan sebaliknya.

Meminta ACL
-----------
Setelah daftar sudah terdefinisi. Kita dapat bertanya untuk menguji apakah sebuah role punya izin atau tidak.

.. code-block:: php

    <?php

    // Uji apakah role punya akses ke operasi

    // Mengembalikan 0
    $acl->isAllowed("Guests", "Customers", "edit");

    // Mengembalikan 1
    $acl->isAllowed("Guests", "Customers", "search");

    // Mengembalikan 1
    $acl->isAllowed("Guests", "Customers", "create");

Akses berbasis Fungsi
---------------------
Anda dapat juga menambahkan parameter ke-4 berupa fungsi kustom yang mengembalikan nilai boolean. Fungsi tersebut akan dipanggil ketika menggunakan metode :code:`isAllowed()`. Anda dapat melewatkan parameter sebagai array asosiatif ke metode :code:`isAllowed()` sebagai argumen ke-4 dimana key adalah nama parameter difungsi yang kita definisi.

.. code-block:: php

    <?php
    // Set level akses role ke resource menggunakan fungsi kustom
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Uji apakah role punya akses ke operasi menggunakan fungsi kustom

    // Mengembalikan true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // Mengembalikan false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

Jika anda tidak menyediakan parameter di metode :code:`isAllowed()` maka perilaku defaultnya adalah :code:`Acl::ALLOW`. Anda dapat mengubahnya dengan menggunakan :code:`setNoArgumentsDefaultAction()`.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // Set level akses role ke resource engan fungsi kustom
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Uji apakah role punya akses ke operasi menggunakan fungsi kustom

    // Mengembalikan true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // Ubah aksi default tanpa argumen
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // Mengembalikan false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

Objek sebagai nama role dan nama resource
-----------------------------------------
Anda dapat melewatkan objek sebagai :code:`roleName` and :code:`resourceName`. Kelas anda harus membuat implementasi :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` untuk :code:`roleName` dan :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` untuk :code:`resourceName`.

Kelas :code:`UserRole` kita

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    // Buat kelas yang akan digunakan sebagai roleName
    class UserRole implements RoleAware
    {
        protected $id;

        protected $roleName;

        public function __construct($id, $roleName)
        {
            $this->id       = $id;
            $this->roleName = $roleName;
        }

        public function getId()
        {
            return $this->id;
        }

        // Implementasi fungsi dari RoleAware Interface
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

dan kelas :code:`ModelResource`

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // Buat kelas yang akan digunakan sebagai resourceName
    class ModelResource implements ResourceAware
    {
        protected $id;

        protected $resourceName;

        protected $userId;

        public function __construct($id, $resourceName, $userId)
        {
            $this->id           = $id;
            $this->resourceName = $resourceName;
            $this->userId       = $userId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        // Implementasi fungsi ResourceAware Interface
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

Selanjutnya anda dapat menggunakannya dalam metode :code:`isAllowed()`.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set level akses role ke resource
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // Buat objek yang menyediakan roleName dan resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Uji apakah objek user memiliki akses ke operasi pada objek model

    // Mengembalikan false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Mengembalikan true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Mengembalikan true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Anda dapt mengakses objektersebut dalam fungsi kustom Anda di :code:`allow()` atau :code:`deny()`. Mereka otomatis akan diikat ke parameter menggunakan tipe dalam fungsi.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set level akses role ke resource dengan fungsi kustom
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function (UserRole $user, ModelResource $model) { // Kelas User dan Model wajib
            return $user->getId == $model->getUserId();
        }
    );

    $acl->allow(
        "Guests",
        "Customers",
        "create"
    );

    $acl->deny(
        "Guests",
        "Customers",
        "update"
    );

    // Buat objek yang menyediakan roleName and resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Uji apakah objek user memiliki akses ke operasi pada objek model

    // Mengembalikan false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Mengembalikan true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Mengembalikan false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Anda dapat menambah parameter kustom ke fungsi dan melewatkan array asosiatif dalam metode :code:`isAllowed()`. Urutannya juga tidak penting.

Penurunan Role
--------------
Anda dapat membangun struktur role kompleks menggunakan inheritansi yang disediakan :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`. Role dapat diturunkan dari role lain, sehingga memungkinan akses ke himpunan resource yang lebih luas atau lebih sempit. Untuk menggunakan penurunan role, anda perlu melewatkan role turunan sebagai parameter kedua pada pemanggilan metode, ketika menambah role ke daftar.

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // Buat beberapa role

    $roleAdmins = new Role("Administrators", "Super-User role");

    $roleGuests = new Role("Guests");

    // Tambahkan role "Guests" ke ACL
    $acl->addRole($roleGuests);

    // Tambahkan role "Administrators" yang diturunkan dari "Guests"
    $acl->addRole($roleAdmins, $roleGuests);

Serialisasi Daftar ACL
----------------------
Untuk meningkatkan performa instance :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` dapat diserialisasi dan disimpan dalam APC, session, file text atau tabel database sehingga mereka dapat dimuat sesukanya tanpa perlu mendefinisi ulang seluruh daftar. Anda dapat melakukannya sebagai berikut:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // Uji apakah data ACL sudah ada
    if (!is_file("app/security/acl.data")) {
        $acl = new AclList();

        // ... Definisi role, resource, akses, dan lain-lain

        // Simpan daftar terserialisasi ke plain file
        file_put_contents(
            "app/security/acl.data",
            serialize($acl)
        );
    } else {
        // Restore ACL object dari serialized file
        $acl = unserialize(
            file_get_contents("app/security/acl.data")
        );
    }

    // Gunakan ACL list seperlunya
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Access granted!";
    } else {
        echo "Access denied :(";
    }

Sangat disarankan menggunakan adapter Memory selama pengembangan dan menggunakan salah satu adapter lain diproduksi.

Event ACL
---------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` dapat mengirim event ke :doc:`EventsManager <events>` jika ada. Event dipicu menggunakan tipe "acl". Beberapa event ketika mengembalikan nilai boolean false dapat menghentikan operasi yang aktif. Event berikut ini didukung:

+-------------------+---------------------------------------------------------+---------------------+
| Nama Event        | Dipicu                                                  | Bisa stop operasi?  |
+===================+=========================================================+=====================+
| beforeCheckAccess | Dipicu sebelum menguji apakah role punya akses          | Yes                 |
+-------------------+---------------------------------------------------------+---------------------+
| afterCheckAccess  | Dipicu sesudah menguji apakah role punya akses          | No                  |
+-------------------+---------------------------------------------------------+---------------------+

Contoh berikut menunjukkan bagaimana memasang listener ke komponen ini:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // Buat event manager
    $eventsManager = new EventsManager();

    // Pasangkan listener tipe "acl"
    $eventsManager->attach(
        "acl:beforeCheckAccess",
        function (Event $event, $acl) {
            echo $acl->getActiveRole();

            echo $acl->getActiveResource();

            echo $acl->getActiveAccess();
        }
    );

    $acl = new AclList();

    // Setup $acl
    // ...

    // Ikat eventsManager ke komponen ACL
    $acl->setEventsManager($eventsManager);

Implementasi adapter Anda sendiri
---------------------------------
Interface :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>` harus diimplementasi untuk menciptakan adapter ACL anda sendiri atau mengubah yang sudah ada.

.. _Access Control Lists: http://en.wikipedia.org/wiki/Access_control_list
