---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model'
---
# Abstract class **Phalcon\Mvc\Model**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface), [Phalcon\Mvc\Model\ResultInterface](Phalcon_Mvc_Model_ResultInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Serializable](https://php.net/manual/en/class.serializable.php), [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model.zep)

Phalcon\Mvc\Model connects business objects and database tables to create a persistable domain model where logic and data are presented in one wrapping. It's an implementation of the object-relational mapping (ORM).

Sebuah model mewakili informasi (data) aplikasi dan aturan untuk memanipulasi data tersebut. Model terutama digunakan untuk mengelola aturan interaksi dengan tabel database yang sesuai. Dalam kebanyakan kasus, setiap tabel dalam database anda akan sesuai dengan satu model dalam aplikasi anda. Sebagian besar logika bisnis aplikasi anda akan terkonsentrasi pada model.

Phalcon\Mvc\Model is the first ORM written in Zephir/C languages for PHP, giving to developers high performance when interacting with databases while is also easy to use.

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We cannot store robots: ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

## Constants

*bilangan bulat* **OP_NONE**

*bilangan bulat* **OP_CREATE**

*bilangan bulat* **OP_UPDATE**

*bilangan bulat* **OP_DELETE**

*bilangan bulat* **DIRTY_STATE_PERSISTENT**

*bilangan bulat* **DIRTY_STATE_TRANSIENT**

*bilangan bulat* **DIRTY_STATE_DETACHED**

## Metode

final public **__construct** ([*mixed* $data], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $modelsManager])

Phalcon\Mvc\Model constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan ketergantungan injeksi wadah

publik **mendapatkanDI** ()

Kembali wadah injeksi ketergantungan

protected **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Set manajer acara kustom

dilindungi (**getEventsManager**)

Kembali manajer acara kustom

publik **getModelsMetaData** ()

Mengembalikan model layanan meta-data yang terkait dengan contoh kesatuan

publik **getModelsManager** ()

Kembali pengelola model yang berkaitan dengan contoh entitas

public **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

Mengatur sebuah transaksi yang berkaitan dengan contoh model

```php
<?php

menggunakan Phalcon\Mvc\Model\Transaction\Manager sebagai TxManager;
menggunakan Phalcon\Mvc\Model\Transaction\Failed sebagai TxFailed;

mencoba {
    $txManager = baru TxManager();

    $transaction = $txManager->get();

    $robot = Robot baru();

    $robot->setTransaksi($transaction);

    $robot->nama       = "DINDING·E";
    $robot->dibuat di = tanggal("Y-m-d");

    if ($robot->menyimpan() === salah) {
        $transaction->rollback("Tidak bisa selamatkan robot");
    }

    $robotPart = RobotParts baru();

    $robotPart->setTransaksi($transaction);

    $robotPart->jenis = "head";

    if ($robotPart->menyimpan() === salah) {
        $transaction->rollback("Robot bagian tidak bisa diselamatkan");
    }

    $transaction->commit();
} catch (TxFailed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

dilindungi **setSource** (*campuran* $source)

Menetapkan nama tabel yang modelnya harus dipetakan

publik **mendapatkan Sumber** ()

Mengembalikan nama tabel yang dipetakan kedalam model

terlindung **atur Skema** (*dicampur* $schema)

Mengatur nama skema dimana lokasi tabel dipetakan

publik **mendapatkan Skema** ()

Mengembalikan nama skema dimana lokasi tabel dipetakan

umum **setConnectionService** (*campuran* $connectionService)

Menetapkan nama layanan sambungan DependencyInjection

publik **setReadConnectionService** (*campuran* $connectionService)

Menetapkan nama layanan sambungan DependencyInjection yang digunakan untuk menyambung data

publik **setWriteConnectionService** (*campuran* $connectionService)

Menetapkan nama layanan sambungan DependencyInjection yang digunakan untuk menulis data

publik **getReadConnectionService** ()

Mengembalikan nama layanan koneksi DependencyInjection yang digunakan untuk membaca data yang berhubungan dengan model

publik **getWriteConnectionService** ()

Mengembalikan nama layanan koneksi DependencyInjection yang digunakan untuk menulis data yang terkait dengan model

public **setDirtyState** (*mixed* $dirtyState)

Sets the dirty state of the object using one of the `DIRTY_STATE_*` constants

public **getDirtyState** ()

Returns one of the `DIRTY_STATE_*` constants telling if the record exists in the database or not

publi **dapatkan Sambungan Baca** ()

Mendapatkan koneksi yang digunakan untuk membaca data untuk model

publik **dapatkan Koneksi Tulis** ()

Mendapatkan koneksi yang digunakan untuk mencatat data untuk model

public [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **assign** (*array* $data, [*mixed* $dataColumnMap], [*array* $whiteList])

Menetapkan nilai untuk model dari sebuah susunan

```php
<?php

$robot->menetapkan(
    [
        "jenis" => "mekanis",
        "nama" => "Astro Boy",
        "tahun" => 1952,
    ]
);

// Tetapkan dengan baris db, peta kolom diperlukan
$robot->menetapkan(
    $dbRow,
    [
        "db_jenis" => "jenis",
        "db_nama" => "nama",
        "db_tahun" => "tahun",
    ]
);

// Izinkan hanya menetapkan nama dan tahun
$robot->menetapkan(
    $_POST,
    batal,
    [
        "nama",
        "tahun",
    ]
);

// Secara default metode penetapan akan menggunakan setters jika ada, Anda bisa menonaktifkannya dengan menggunakan ini_set untuk langsung menggunakan properti

ini_set("phalcon.orm.disable_assign_setters", benar);

$robot->menetapkan(
    $_POST,
    batal,
    [
        "nama",
        "tahun",
    ]
);

```

public static **cloneResultMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\Model\Row](Phalcon_Mvc_Model_Row) $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Menatapkan nilai untuk sebuah model dari sebuah susunan, mengembalikan model baru.

```php
<?php

$robot = \Phalcon\Mvc\Model::cloneResultMap(
    Robot baru(),
    [
        "jenis" => "mekanikal",
        "nama" => "Astro Boy",
        "tahun" => 1952,
    ]
);

```

statis umum *campuran* **cloneResultMapHydrate** (*array* $data, *array* $columnMap, *int* $hydrationMode)

Mengembalikan hasil yang terhidrasi berdasarkan data dan peta kolom

public static [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **cloneResult** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $base, *array* $data, [*int* $dirtyState])

Menetapkan nilai dari sebuah model dari susunan mengembalikan model baru

```php
<?php

$robot = Phalcon\Mvc\Model::cloneResult(
    Robot baru(),
    [
        "jenis" => "mekanikal",
        "nama" => "Astro Boy",
        "tahun" => 1952,
    ]
);

```

statis umum **menemukan** ([*campuran* $parameters])

Permintaan untuk satu set catatan yang mungkin sesuai dengan hal kondisi yang ditentukan

```php
<?php

// How many robots are there?
$robots = Robots::find(); echo "Ada", count($robots), "\n"; Robot mekanis berapa banyak Apakah ada?
$robots = Robot::temukan(
    "tipe = 'mekanis'"
);

echo "Ada ", menghitung($robots), "\n";

// Dapatkan dan cetak robot virtual yang dipesan berdasarkan namanya
$robots = Robot::temukan(
    [
        "tipe = 'virtual'",
        "memesan" => "nama",
    ]
);

untuk setiap ($robots as $robot) {
 echo $robot->name, "\n";
}

// Dapatkan 100 robot virtual pertama yang dipesan berdasarkan namanya
$robots = Robot::temukan(
    [
        "tipe = 'virtual'",
        "memesan" => "nama",
        "batas" => 100,
    ]
);

untuk setiap ($robots as $robot) {
 echo $robot->nama, "\n";
}

```

status publik *statis* **Pertama temukan** ([*tali* | *array* $parameters])

Permintaan rekaman pertama yang sesuai dengan kondisi yang ditentukan

```php
<?php

// Apa robot pertama di meja robot?
$robot = Robots::findFirst();

echo "Nama robot adalah ", $robot->nama;

// Apa robot mekanis pertama di meja robot?
$robot = Robot::Pertama temukan(
    "tipe = 'mekanis'"
);

echo "Nama robot mekanis pertama adalah ", $robot->nama;

// Dapatkan robot virtual pertama yang dipesan berdasarkan namanya
$robot = Robot::Pertama temukan(
    [
        "tipe = 'virtual'",
        "memesan" => "nama",
    ]
);

echo "Nama robot virtual pertama adalah ", $robot->name;

```

public static **query** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Buat sebuah kriteria untuk model tertentu

protected *boolean* **_exists** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [*string* | *array* $table])

Periksa apakah catatan baru-baru ini sudah ada

protected static [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **_groupResult** (*mixed* $functionName, *string* $alias, *array* $parameters)

Menghasilkan pernyataan PHQL PILIH untuk sebuah agregat

statis publik *dicampur* **menghitung** ([*array* $parameters])

Menghaitung berapa banyak rekaman yang sesuai dengan kondisi yang ditentukan

```php
<?php

// How many robots are there?
$number = Robots::count();

echo "Ada ", $number, "\n";

// Berapa banyak robot mekanis yang ada?
$number = Robots::count("type = 'mechanical'");

echo "Ada ", $number, " robot mekanis\n";

```

statis publik *dicampur* **jumlah** ([*array* $parameters])

Menghitung jumlah pada kolom untuk kumpulan baris hasil yang sesuai dengan kondisi yang ditentukan

```php
<?php

// Berapa banyak semua robot?
$sum = Robot::jumlah(
    [
        "kolom" => "harga",
    ]
);

echo "Harga total robot adalah ", $sum, "\n";

// Berapa robot mekanisnya?
$sum = Robot::jumlah(
    [
        "tipe = 'mekanis'",
        "kolom" => "harga",
    ]
);

echo "Harga total robot mekanis adalah", $sum, "\n";

```

statis publik *dicampur* **maksimum** ([*array* $parameters])

Mengembalikan nilai maksimum kolom untuk kumpulan baris hasil yang sesuai dengan kondisi yang telah ditentukan

```php
<?php

// Apa itu id robot maksimal?
$id = Robot::maksimum(
    [
        "kolom" => "id",
    ]
);

echo "Id robot maksimal adalah: ", $id, "\n";

// Apa itu maksimum id dari robot mekanis?
$sum = Robot::maksimum(
    [
        "tipe = 'mekanis'",
        "kolom" => "id",
    ]
);

echo "Robot id maksimum dari robot mekanis adalah ", $id, "\n";

```

statis publik *dicampur* **minimum** ([*array* $parameters])

Mengembalikan nilai maksimal kolom untuk kumpulan baris hasil yang sesuai dengan kondisi yang telah ditentukan

```php
<?php

// Apa itu id robot minimum?
$id = Robot::minimum(
    [
        "kolom" => "id",
    ]
);

echo "Id robot minimum adalah: ", $id;

// Apa itu minimum id dari robot mekanis?
$sum = Robot::minimum(
    [
        "tipe = 'mekanis'",
        "kolom" => "id",
    ]
);

echo "Id robot minimum dari robot mekanis adalah ", $id;

```

statis publik *ganda* **rata-rata** ([*array* $parameters])

Mengembalikan nilai rata-rata pada kolom untuk kumpulan baris hasil yang sesuai dengan kondisi yang telah di tentukan

```php
<?php

// Berapa harga rata-rata robot?
$average = Robot::rata-rata(
    [
        "kolom" => "harga",
    ]
);

echo "Harga rata-rata adalah ", $average, "\n";

// Berapa harga rata-rata robot mekanis?
$average = Robot::rata-rata(
    [
        "tipe = 'mekanis'",
        "kolom" => "harga",
    ]
);

echo "Harga rata-rata dari robot mekanis ini ", $average, "\n";

```

public **fireEvent** (*mixed* $eventName)

Membakar sebuah acara, secara implisit dapat memanggil prilaku dan pendengar di pengelola acara yang diberitau

public **fireEventCancel** (*mixed* $eventName)

Membakar sebuah acara, secara implisit dapat memanggil prilaku dan pendengar di pengelola acara diberitau motode ini berhenti jika salah satu callbaks/pendengar mengembalikan boolean false

terlindung **_Batalkan operasi** ()

Batalkan operasi saat ini

public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface) $message)

Menambahkan pesan yang disesuaikan pada proses validasi

```php
<?php

Kelas robot model meluas
{
    fungsi publik sebelum Menyimpan()
    {
        if ($this->nama === "Peter") {
            $message = Pesan baru(
                "Maaf, Tapi robot tidak bisa diberi nama Peter"
            );

            $this->appendMessage($message);
        }
    }
}

```

protected **validate** ([Phalcon\ValidationInterface](Phalcon_ValidationInterface) $validator)

Jalankan validator pada setiap panggilan validasi

```php
<?php

gunakan Phalcon\Mvc\Model;
gunakan Phalcon\Validasi;
gunakan Phalcon\Validasi\Validator\pengecualianIn;

kelas Langganan Model meluas
{
    validasi fungsi publik()
    {
        $validator = Validasi baru();

        $validator->add(
            "status",
            Pengecualian baruIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        mengembalikan $this->validasi($validator);
    }
}

```

public **validationHasFailed** ()

Periksa apakah proses validasi telah menghasilkan pesan apa pun

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscribers extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->validate(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

publik **getMessages** ([*campuran* $filter])

Mengembalikan array pesan validasi

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

akhir dilindungi **_checkForeignKeysRestrict** ()

Baca "belongs to" relasi dan periksa kunci asing virtual saat memasukkan atau memperbarui catatan untuk memverifikasi yang disisipkan/diperbarui ada pada entitas terkait

akhir dilindungi **_checkForeignKeysReverseCascade** ()

Baca keduanya "hasMany" dan "hasOne" relasi dan cek kunci asing virtual (riam) saat menghapus catatan

akhir dilindungi **_Periksa kunci asing batasi pembalikan** ()

Baca kedua hubungan "memiliki Banyak" dan "Memiliki Satu" dan memeriksa kunci virtual asing (membatasi) saat menghapus catatan

protected **_preSave** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, *mixed* $exists, *mixed* $identityField)

Jalankan kait internal sebelum menyimpan catatan

terlindung **_Menyimpan postingan** (*dicampur* $success, *dicampur* $exists)

Jalankan peristiwa internal setelah menyimpan catatan

protected *boolean* **_doLowInsert** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table, *boolean* | *string* $identityField)

Mengirimkan pernyataan SQL build-build awal ke sistem database relasional

protected *boolean* **_doLowUpdate** ([Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface) $metaData, [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, *string* | *array* $table)

Mengirimkan pra-membangun UPDATE statement SQL untuk database relasional sistem

protected *boolean* **_preSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $related)

Menghemat terkait catatan yang harus disimpan sebelumnya untuk menyimpan catatan guru

protected *boolean* **_postSaveRelatedRecords** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $related)

Menyimpan catatan yang terkait ditugaskan dalam-satu/punya-banyak hubungan

publik *boolean* **menyimpan** ([*array* $data], [*array* $whiteList])

Inserts or updates a model instance. Returning true on success or false otherwise.

```php
<?php

// Membut robot baru
$robot = Robot baru();

$robot->tipe = "mekanis";
$robot->nama = "Astro Boy";
$robot->tahun = 1952;

$robot->menyimpan();

// Memperbarui nama robot
$robot = Robot::temukan dulu("id = 100");

$robot->nama = "Biomass";

$robot->menyimpan();

```

publik **membuat** ([*dicampur* $data], [*dicampur* $whiteList])

Inserts a model instance. If the instance already exists in the persistence it will throw an exception Returning true on success or false otherwise.

```php
<?php

// Membuat robot baru
$robot = Robot baru();

$robot->tipe = "mekanis";
$robot->nama = "Astro Boy";
$robot->tahun = 1952;

$robot->membuat();

// Melewati sebuah array untuk dibuat
$robot = Robot baru();

$robot->membuat(
    [
        "tipe" => "mekanis",
        "nama" => "Astro Boy",
        "tahun" => 1952,
    ]
);

```

publik **memperbarui** ([*dicampur* $data], [*dicampur* $whiteList])

Updates a model instance. If the instance doesn't exist in the persistence it will throw an exception Returning true on success or false otherwise.

```php
<?php

// Memperbarui nama robot
$robot = Robot::temukan dulu("id = 100");

$robot->nama = "Biomass";

$robot->memperbarui();

```

public **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

```php
<?php

$robot = Robot::temukan dulu("id=100");

$robot->menghapus();

$robots = Robot::menemukan("tipe = 'mekanis'");

untuk setiap ($robots as $robot) {
    $robot->menghapus();
}

```

publik **mendapatkan pembuatan operasi** ()

Mengembalikan jenis operasi terbaru yang dilakukan oleh ORM Mengembalikan salah satu konstanta kelas OP_ *

publik **menyegarkan** ()

Menyegarkan atribut model untuk melakukan query ulang dari database

public **skipOperation** (*mixed* $skip)

Melompati operasi saat ini yang memaksa negara sukses

publik **baca Atribut** (*dicampur* $attribute)

Membaca nilai atribut dengan nama

```php
<? php echo $robot -> readAttribute("name");

```

publik **Tulis Atribut** (*dicampur* $attribute, *dicampur* $value)

Menulis nilai atribut dengan nama

```php
<? php $robot -> writeAttribute ("nama", "Rosey");

```

terlindung **Lewati Atribut** (*array* $attributes)

Menetapkan daftar atribut yang harus dilewati dari dihasilkan pernyataan INSERT / UPDATE

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
    fungsi publik diinisialisasi()
    {
        $this->skipAttributes(
            [
                "harga",
            ]
        );
    }
}

```

terlindung **Lewati Atribut pada pembuatan** (*array* $attributes)

Menetapkan daftar atribut yang harus dilewati dari dihasilkan pernyataan INSERT

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
   fungsi publik diinisialisasi()
    {
        $this->Lewati Atribut pada pembuatan(
            [
                "dibuat_di",
            ]
        );
    }
}

```

terlindung **Lewati Atribut pada pembaruan** (*array* $attributes)

Menetapkan daftar atribut yang harus dilewati dari dihasilkan UPDATE pernyataan

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
    fungsi publik diinisialisasi()
    {
        $this->skipAttributesOnUpdate(
            [
                "dimodifikasi_dalam",
            ]
        );
    }
}

```

terlindung **Izinkan nilai tali kosong** (*array* $attributes)

Menetapkan daftar atribut yang harus dilewati dari dihasilkan UPDATE pernyataan

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
    fungsi publik diinisialisasi()
    {
        $this->Izinkan nilai tali kosong(
            [
                "nama",
            ]
        );
    }
}

```

terlindung **punya satu** (*dicampur* $fields, *dicampur* $referenceModel, *dicampur* $referencedFields, [*dicampur* $options])

Setup hubungan 1-1 antara dua model

```php
<?php

kelas robot meluas \Phalcon\Mvc\Model
{
    fungsi publik diinisialisasi()
    {
        $this->punya satu("id", "Deskripsi robot", "robots_id");
    }
}

```

Using more than one field:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(["id", "type"], "RobotParts", ["robots_id", "robots_type"]);
    }
}

```

Using options:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(
            "id", 
            "RobotParts", 
            "robots_id",
            [
                "reusable" => true,    // cache the results of this relationship
                "alias"    => "parts", // Alias of the relationship
            ]
        );
    }
}

```

Using conditionals:

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(
            "id", 
            "RobotParts", 
            "robots_id",
            [
                "reusable" => true,           // cache the results of this relationship
                "alias"    => "partsTypeOne", // Alias of the relationship
                "params"   => [               // Acts like a filter
                    "conditions" => "type = :type:",
                    "bind"       => [
                        "type" => 1,
                    ],
                ],
            ]
        );
    }
}

```

terlindung **Milik** (*dicampur* $fields, *dicampur* $referenceModel, *dicampur* $referencedFields, [*dicampur* $options])

Atur hubungan terbalik 1-1 atau n-1 antara dua model

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
    fungsi publik diinisialisasi()
    {
        $this->Milik("robot_id", "Robot", "id");
    }
}

```

terlindung **Punya banyak** (*dicampur* $fields, *dicampur* $referenceModel, *dicampur* $referencedFields, [*dicampur* $options])

Setup hubungan 1-n antara dua model

```php
<?php

Kelas robot meluas \Phalcon\Mvc\Model
{
    funsi publik diinisialisasi()
    {
        $this->Punya banyak("id", "Bagian robot", "robot_id");
    }
}

```

protected [Phalcon\Mvc\Model\Relation](Phalcon_Mvc_Model_Relation) **hasManyToMany** (*string* | *array* $fields, *string* $intermediateModel, *string* | *array* $intermediateFields, *string* | *array* $intermediateReferencedFields, *mixed* $referenceModel, *string* | *array* $referencedFields, [*array* $options])

Menyiapkan hubungan n-n antara dua model, melalui hubungan perantara

```php
<?php

class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        // Setup a many-to-many relation to Parts through RobotsParts
        $this->hasManyToMany(
            "id",
            "RobotsParts",
            "robots_id",
            "parts_id",
            "Parts",
            "id"
        );
    }
}

```

public **addBehavior** ([Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface) $behavior)

Mengatur perilaku dalam model

```php
<?php

gunakan Phalcon\Mvc\Model;
gunakan Phalcon\Mvc\Model\Perilaku\Waktu Tampable;

Model kelas Robot meluas
{
    fungsi publik diinisialisasi()
    {
        $this->tambahkan perilaku(
            Waktu tampable baru(
               [
                   "di Buat" => [
                        "bidang"  => "dibuat_di",
                        "format" => "Y-m-d",
                       ],
                ]
            )
        );
    }
}

```

protected **keepSnapshots** (*mixed* $keepSnapshot)

Menetapkan apakah model harus menyimpan cuplikan rekaman asli di memori

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}

```

public **setSnapshotData** (*array* $data, [*array* $columnMap])

Sets the record's snapshot data. This method is used internally to set snapshot data when the model was set up to keep snapshot data

public **hasSnapshotData** ()

Memeriksa apakah objek memiliki data snapshot internal

public **getSnapshotData** ()

Mengembalikan data snapshot internal

public **getOldSnapshotData** ()

Mengembalikan data snapshot lama internal

public **hasChanged** ([*string* | *array* $fieldName], [*boolean* $allFields])

Periksa apakah atribut tertentu telah berubah Ini hanya bekerja jika modelnya menyimpan data snapshot

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();
$robot->type = "hydraulic";
$hasChanged = $robot->hasChanged("type"); // returns true
$hasChanged = $robot->hasChanged(["type", "name"]); // returns true
$hasChanged = $robot->hasChanged(["type", "name", true]); // returns false

```

public **hasUpdated** ([*string* | *array* $fieldName], [*mixed* $allFields])

Periksa apakah atribut tertentu telah diperbarui Ini hanya bekerja jika modelnya menyimpan data snapshot

public **getChangedFields** ()

Mengembalikan daftar nilai yang berubah.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]

```

public **getUpdatedFields** ()

Mengembalikan daftar nilai yang diperbarui.

```php
<?php

$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]
$robots->save();
print_r($robots->getChangedFields()); // []
print_r($robots->getUpdatedFields()); // ["deleted"]

```

protected **useDynamicUpdate** (*mixed* $dynamicUpdate)

Menyetel jika model harus menggunakan pembaruan dinamis dan bukan pembaruan semua bidang

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}

```

public [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **getRelated** (*string* $alias, [*array* $arguments])

Mengembalikan catatan terkait berdasarkan hubungan yang didefinisikan

```php
<?php

// Gets the relationship data named "parts"
$parts = $robot->getRelated('parts');

// Gets the relationship data named "parts" sorted descending by name
$parts = $robot->getRelated('parts', ['order' => 'name DESC']);

// Gets the relationship data named "parts" filtered
$parts = $robot->getRelated('parts', ['conditions' => 'type = 1']);

$parts = $robot->getRelated(
    'parts', 
    [
        'conditions' => 'type = :type:',
        'bind'       => [
            'type' => 1,
        ]
    ]
);

```

protected *mixed* **_getRelatedRecords** (*string* $modelName, *string* $method, *array* $arguments)

Mengembalikan catatan terkait mendefinisikan relasi tergantung pada nama metode

final protected static [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) | *boolean* **_invokeFinder** (*string* $method, *array* $arguments)

Cobalah untuk memeriksa apakah query harus memanggil finder

publik *campuran* **__memanggil** (*tali* $method, *array* $arguments)

Menangani pemanggilan metode saat metode tidak diterapkan

public static *mixed* **__callStatic** (*string* $method, *array* $arguments)

Menangani pemanggilan metode saat metode statis tidak diterapkan

public **__set** (*string* $property, *mixed* $value)

Metode sihir untuk memberi nilai pada model

final protected *string* **_possibleSetter** (*string* $property, *mixed* $value)

Periksa, dan coba gunakan, setter mungkin.

public [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset) | [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **__get** (*string* $property)

Magic method to get related records using the relation alias as a property

public **__isset** (*mixed* $property)

Metode Magic untuk mengecek apakah sebuah property adalah relasi yang valid

publik **getName** ()

Serializes objek mengabaikan koneksi, layanan, objek terkait atau sifat statis

public ** beforeStore ** ( * mixed * $data)

Unserializes objek dari string serial

public **dump** ()

Mengembalikan representasi sederhana objek yang bisa digunakan dengan var_dump

```php
<?php

var_dump(
    $robot->dump()
);

```

public *array* **toArray** ([*array* $columns])

Mengembalikan instance sebagai representasi array

```php
<?php

print_r(
    $robot->toArray()
);

```

public *array* **jsonSerialize** ()

Serializes the object for json_encode

```php
<?php

echo json_encode($robot);

```

public static **pengaturan** (*array* $pilihan)

Mengaktifkan / menonaktifkan pilihan di ORM

umum **reset** ()

Setel ulang contoh data model