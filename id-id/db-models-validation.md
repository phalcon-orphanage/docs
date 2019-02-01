---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Memvalidasi Model

<a name='data-integrity'></a>

## Memvalidasi Integritas Data

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides several events to validate data and implement business rules. Khusus `validasi` acara ini memungkinkan kita untuk memanggil built-in validator selama merekam. Phalcon memaparkan beberapa validator bawaan yang dapat digunakan pada tahap validasi ini.

Contoh berikut menunjukkan bagaimana cara menggunakannya:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'type',
            new InclusionIn(
                [
                    'domain' => [
                        'Mechanical',
                        'Virtual',
                    ]
                ]
            )
        );

        $validator->add(
            'name',
            new Uniqueness(
                [
                    'message' => 'The robot name must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

The above example performs a validation using the built-in validator 'InclusionIn'. It checks the value of the field `type` in a domain list. If the value is not included in the method then the validator will fail and return false.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a></h5>

The idea of creating validators is make them reusable between several models. A validator can also be as simple as:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Robots extends Model
{
    public function validation()
    {
        if ($this->type === 'Old') {
            $message = new Message(
                'Sorry, old robots are not allowed anymore',
                'type',
                'MyType'
            );

            $this->appendMessage($message);

            return false;
        }

        return true;
    }
}
```

<a name='messages'></a>

## Pesan validasi

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message is an instance of [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message) and the set of messages generated can be retrieved with the `getMessages()` method. Setiap pesan memberikan informasi tambahan seperti nama field yang menghasilkan pesan atau jenis pesan:

```php
<?php

if ($robot->save() === false) {
    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage();
        echo 'Field: ', $message->getField();
        echo 'Type: ', $message->getType();
    }
}
```

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can generate the following types of validation messages:

| Mengetik                     | Deskripsi                                                                                                                                             |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Kehadiran dari`             | Dihasilkan saat field dengan atribut non-null pada database sedang mencoba memasukkan/update nilai null                                               |
| `Pelanggaran Kendala`        | Dihasilkan ketika sebuah bagian lapangan dari kunci asing virtual mencoba memasukkan/memperbarui nilai yang tidak ada dalam model yang direferensikan |
| `Nilai tidak valid`          | Dihasilkan saat validator gagal karena nilai yang tidak valid                                                                                         |
| `Percobaan Buat Tidak Valid` | Diproduksi saat sebuah rekaman dicoba diciptakan tapi sudah ada                                                                                       |
| `InvalidUpdateAttempt`       | Diproduksi saat sebuah rekaman dicoba diperbaharui namun tidak ada                                                                                    |

The `getMessages()` method can be overridden in a model to replace/translate the default messages generated automatically by the ORM:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case 'InvalidCreateAttempt':
                    $messages[] = 'The record cannot be created because it already exists';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "The record cannot be updated because it doesn't exist";
                    break;

                case 'PresenceOf':
                    $messages[] = 'The field ' . $message->getField() . ' is mandatory';
                    break;
            }
        }

        return $messages;
    }
}
```

<a name='failed-events'></a>

## Validasi Gagal

Another type of events are available when the data validation process finds any inconsistency:

| Operasi                       | Nama                  | Penjelasan                                                             |
| ----------------------------- | --------------------- | ---------------------------------------------------------------------- |
| Sisipkan atau Perbarui        | `tidak disimpan`      | Triggered when the `INSERT` or `UPDATE` operation fails for any reason |
| Sisipkan, Hapus atau Perbarui | `padaPengesahanGagal` | Dipicu saat operasi manipulasi data gagal                              |