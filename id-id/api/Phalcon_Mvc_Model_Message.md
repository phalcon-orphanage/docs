---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Message'
---
# Class **Phalcon\Mvc\Model\Message**

*implements* [Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/message.zep)

Encapsulates info pengesahan yang dihasilkan sebelum simpan/menghapus catan gagal

```php
<?php

gunakan Phalcon\Mvc\Model\Pesan sebagai Pesan;

memperluas Kelas robot \Phalcon\Mvc\Model
{
    fungsi umum sebelum Menyimpan()
    {
        if ($this->nama === "Peter") {
            $text  = "Robot tidak boleh dinamakan Peter";
            $field = "nama";
            $type  = "Nilai tidak Sah";

            $message = pesan Baru($text, $field, $type);

            $this->tambahkan Pesan($message);
        }
    }
}

```

## Metode

public **__construct** (*string* $message, [*string* | *array* $field], [*string* $type], [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model], [*int* | *null* $code])

Phalcon\Mvc\Model\Message constructor

publik **perangkat Tipe** (*dicampur* $type)

Menetapkan jenis pesan

publik **berhenti** ()

Mengembalikan jenis pesan

publik **perangkat Pesan** (*campur* $message)

Mengatur pesan verbose   Teks paragraf

public **getMessage** ()

Mengembalikan pesan verbose

publik **setelan Bidang** (*campur* $field)

Menetapkan nama bidang yang terkait dengan pesan

publik **mendapatkan Bidang** ()

Mengembalikan nama bidang yang terkait dengan pesan

public **setModel** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Tetapkan model yang menghasilkan pesan

publik **mengatur Kode** (*campur* $code)

Menetapkan kode untuk pesan

publik **mendapatkan Model** ()

Mengembalikan model yang menghasilkan pesan

publik **mendapatkan Kode** ()

Mengembalikan kode pesan

publik **__keString** ()

Metode Magic __toString mengembalikan pesan verbose

statik publik **__menyetel_negara** (*aturan* $message)

Magic __set_state membantu membangun kembali variabel pesan yang diekspor