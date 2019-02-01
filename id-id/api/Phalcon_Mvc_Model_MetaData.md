---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\MetaData'
---
# Abstract class **Phalcon\Mvc\Model\MetaData**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/metadata.zep)

Because Phalcon\Mvc\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\Mvc\Model. Phalcon\Mvc\Model\MetaData can also use adapters to store temporarily or permanently the meta-data.

A standard Phalcon\Mvc\Model\MetaData can be used to query model attributes:

```php
<?php

$metaData = new \Phalcon\Mvc\Model\MetaData\Ingatan();

$attributes = $metaData->dapatkan Atribut(
    robot Baru()
);
mencetak($attributes);

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

final protected **_initialize** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema)

Inisialisasi metadata untuk tabel tertentu

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy)

Tetapkan strategi ekstraksi meta-data

publik **mendapatkan Strategi** ()

Kembalikan strategi untuk mendapatkan meta-data

final public **readMetaData** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Membaca meta-data lengkap untuk model tertentu

```php
<?php

Mencetak_r(
    $metaData->melihat MetaData(
        robot Baru()
    )
);

```

final public **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index)

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

final public **writeMetaDataIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index, *mixed* $data)

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

final public **readColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Membaca peta kolom yang dipesan / dibalik untuk model tertentu

```php
<?php

print_r(
    $metaData->membaca Kolom Peta(
        robot Baru()
    )
);

```

final public **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $index)

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

public **getAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan tabel atribut nama (bidang)

```php
<?php

print_r(
    $metaData->mendapatkan Atribut(
        robot Baru()
    )
);

```

public **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan array bidang yang merupakan bagian dari primary key

```php
<?php

mencetak_r(
    $metaData->mendapatkan Kunci Atribut Utama(
        robot Baru()
    )
);

```

public **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan susunan bidang yang bukan bagian dari kunci utama

```php
<?php
mencetak_r(
    $metaData->mendapatkan Kunci Atribut Utama(
        robot Baru()
    )
);

```

public **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan array bukan atribut null

```php
<?php

mencetak_r(
    $metaData->batal Mendapatkan Atribut(
        robot Baru()
    )
);

```

public **getDataTypes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut dan tipe datanya

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Data(
        robot Baru()
    )
);

```

public **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut yang jenisnya numerik

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Data Numerik(
        robot Baru()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan nama bidang identitas (jika ada)

```php
<?php

print_r(
    $metaData->mendapatkan Bidang Identitas(
        robor Baru()
    )
);

```

public **getBindTypes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut dan tipe data bind mereka

```php
<?php

mencetak_r(
    $metaData->mendapatkan Tipe Pengikat(
        robot Baru()
    )
);

```

public **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut yang harus diabaikan dari INSERT SQL generation

```php
<?php

print_r(
    $metaData->dapatkan Atribut Buat Otomatis(
        robot Baru()
    )
);

```

public **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut yang harus diabaikan dari generasi UPDATE SQL

```php
<?php

mencetak_r(
    $metaData->mengatur Atribut Memperbarui Otomatis(
        robot Baru()
    )
);

```

public **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **setAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **setEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **getEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut memungkinkan string kosong

```php
<?php

mencetak_r(
    $metaData->mendapatkan Atribut Deretan Kosong(
        robot Baru()
    )
);

```

public **getDefaultValues** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan atribut (yang memiliki nilai default) dan nilai default nya

```php
<?php

mencetak_r(
    $metaData->mendapatkan Nilai Gagal(
        robot Baru()
    )
);

```

public **getColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Kembalikan peta kolom jika ada

```php
<?php

mencetak_r(
    $metaData->mendapatkan Kolom Peta(
        robot Baru()
    )
);

```

public **getReverseColumnMap** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Kembalikan peta kolom terbalik jika ada

```php
<?php

mencetak_r(
    $metaData->mendapatkan Peta Kolom Balik(
        robot Baru()
    )
);

```

public **hasAttribute** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $attribute)

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

public **isEmpty** ()

Memeriksa apakah wadah meta-data internal kosong

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```

umum **reset** ()

Mengatur ulang meta-data internal untuk menumbuhkannya kembali

```php
<?php

$metaData->reset();

```

abstract public **read** (*mixed* $key) inherited from [Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface)

...

abstract public **write** (*mixed* $key, *mixed* $data) inherited from [Phalcon\Mvc\Model\MetaDataInterface](Phalcon_Mvc_Model_MetaDataInterface)

...