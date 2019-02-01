---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\MetaData\Xcache'
---
# Class **Phalcon\Mvc\Model\MetaData\Xcache**

*extends* abstract class [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

*implements* [Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/metadata/xcache.zep)

Stores model meta-data in the XCache cache. Data will erased if the web server is restarted

Secara default meta-data disimpan selama 48 jam (172800 detik)

Anda dapat meminta meta-data dengan mencetak xcache_get ('$PMM$') atau xcache_get ('$PMM$myapp-id')

```php
<?php

$metaData = new Phalcon\Mvc\Model\Metadata\Xcache(
    [
        "prefix"   => "my-app-id",
        "lifetime" => 86400,
    ]
);

```

## Constants

*bilangan bulat* **MODEL_ATRIBUT**

*bilangan bulat* **MODEL_UTAMA_KUNCI**

*bilangan bulat* **MODEL_TANPA_UTAMA_KUNCI**

*bilangan bulat* **MODEL_TIDAK_BATAL**

*bilangan bulat* **MODEL_JENIS_DATA**

*bilangan bulat* **MODEL_JENIS_DATA_NUMERIC**

*bilangan bulat* **MODEL_DI_TANGGAL**

*bilangan bulat* **MODEL_Di_TANGGAL**

*bilangan bulat* **MODEL_KOLOM_IDENTITAS**

*bilangan bulat* **MODEL_DATA_JENIS_MENGIKAT**

*bilangan bulat* **MODEL_AUTOMATIS_GAGAL_MEMASUKKAN**

*bilangan bulat* **MODEL_AUTOMATIS_GAGAL_MEMPERBARUI**

*bilangan bulat* **MODEL_KEGAGALAN_NILAI**

*bilangan bulat* **MODEL_RANGKAIAN_NILAI_KOSONG**

*bilangan bulat* **MODELS_PETUNJUK_KOLOM**

*bilangan bulat* **MODELS_MEMBALIKKAN_PETUNJUK_KOLOM**

## Metode

umum **__membangun** ([*array* $options])

Phalcon\Mvc\Model\MetaData\Xcache constructor

public *array* **read** (*string* $key)

Membaca metadata dari XCache

public **write** (*string* $key, *array* $data)

Menulis metadata ke XCache

final protected **_initialize** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Inisialisasi metadata untuk tabel tertentu

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Menetapkan kontainer Injector Ketergantungan

public **getDI** () inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan kontainer DependencyInjector

public **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Tetapkan strategi ekstraksi meta-data

public **getStrategy** () inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Kembalikan strategi untuk mendapatkan meta-data

final public **readMetaData** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Membaca meta-data lengkap untuk model tertentu

```php
<?php

Mencetak_r(
    $metaData->melihat MetaData(
        robot Baru()
    )
);

```

final public **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Membaca meta-data untuk model tertentu

```php
<?php

print_r(
    $metaData->membaca Petunjuk MetaData(
        robot Baru(),
        0
    )
);

```

final public **writeMetaDataIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index, *mixed* $data) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Menulis meta-data untuk model tertentu menggunakan MODEL_ * konstan

```php
<?php

print_r(
    $metaData->writeMetaDataIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP,
        [
            "leName" => "name",
        ]
    )
);

```

final public **readColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Membaca peta kolom yang dipesan / dibalik untuk model tertentu

```php
<?php

print_r(
    $metaData->membaca Kolom Peta(
        robot Baru()
    )
);

```

final public **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Membaca informasi peta kolom untuk model tertentu menggunakan MODEL_ * konstan

```php
<?php

print_r(
    $metaData->baca Indeks Peta Kolom(
        robot Baru(),
        MetaData::MODEL_PETUNJUK_MEMBALIKKAN_KOLOM
    )
);

```

public **getAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan tabel atribut nama (bidang)

```php
<?php

print_r(
    $metaData->mendapatkan Atribut(
        robot Baru()
    )
);

```

public **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan array bidang yang merupakan bagian dari primary key

```php
<?php

mencetak_r(
    $metaData->mendapatkan Kunci Atribut Utama(
        robot Baru()
    )
);

```

public **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan susunan bidang yang bukan bagian dari kunci utama

```php
<?php
mencetak_r(
    $metaData->mendapatkan Kunci Atribut Utama(
        robot Baru()
    )
);

```

public **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan array bukan atribut null

```php
<?php

mencetak_r(
    $metaData->batal Mendapatkan Atribut(
        robot Baru()
    )
);

```

public **getDataTypes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut dan tipe datanya

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Data(
        robot Baru()
    )
);

```

public **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut yang jenisnya numerik

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Data Numerik(
        robot Baru()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan nama bidang identitas (jika ada)

```php
<?php

print_r(
    $metaData->mendapatkan Bidang Identitas(
        robor Baru()
    )
);

```

public **getBindTypes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut dan tipe data bind mereka

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Pengikat(
        robot Baru()
    )
);

```

public **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut yang harus diabaikan dari INSERT SQL generation

```php
<?php

print_r(
    $metaData->dapatkan Atribut Buat Otomatis(
        robot Baru()
    )
);

```

public **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut yang harus diabaikan dari generasi UPDATE SQL

```php
<?php

mencetak_r(
    $metaData->mengatur Atribut Memperbarui Otomatis(
        robot Baru()
    )
);

```

public **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Tetapkan atribut yang harus diabaikan dari INSERT SQL generation

```php
<?php

$metaData->pengaturan Automatis Membuat Atribut(
    robot Baru(),
    [
        "di_diciptakan" => benar,
    ]
);

```

public **setAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Tetapkan atribut yang harus diabaikan dari generasi UPDATE SQL

```php
<?php

$metaData->pengaturan Atribut Memperbarui Automatis(
    robot Baru(),
    [
        "Di_ubah" => benar,
    ]
);

```

public **setEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Tetapkan atribut yang memungkinkan nilai string kosong

```php
<?php

$metaData->pengaturan Atribut Rangkaian Kosong(
    robot Baru(),
    [
        "nama" => benar,
    ]
);

```

public **getEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut memungkinkan string kosong

```php
<?php

mencetak_r(
    $metaData->mendapatkan Atribut Deretan Kosong(
        robot Baru()
    )
);

```

public **getDefaultValues** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengembalikan atribut (yang memiliki nilai default) dan nilai default nya

```php
<?php

mencetak_r(
    $metaData->mendapatkan Nilai Gagal(
        robot Baru()
    )
);

```

public **getColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Kembalikan peta kolom jika ada

```php
<?php

mencetak_r(
    $metaData->mendapatkan Kolom Peta(
        robot Baru()
    )
);

```

public **getReverseColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Kembalikan peta kolom terbalik jika ada

```php
<?php

mencetak_r(
    $metaData->mendapatkan Peta Kolom Balik(
        robot Baru()
    )
);

```

public **hasAttribute** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $attribute) inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Periksa apakah model memiliki atribut tertentu

```php
<?php

var_dump(
    $metaData->hasAttribute(
        new Robots(),
        "name"
    )
);

```

public **isEmpty** () inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Memeriksa apakah wadah meta-data internal kosong

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```

public **reset** () inherited from [Phalcon\Mvc\Model\MetaData](Phalcon_Mvc_Model_MetaData)

Mengatur ulang meta-data internal untuk menumbuhkannya kembali

```php
<?php

$metaData->reset();

```