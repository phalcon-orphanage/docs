<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Шифрование и расшифровка</a> <ul>
        <li>
          <a href="#usage">Basic Usage</a>
        </li>
        <li>
          <a href="#options">Настройки шифрования</a>
        </li>
        <li>
          <a href="#base64">Поддержка base64</a>
        </li>
        <li>
          <a href="#service">Настройка сервиса шифрования</a>
        </li>
        <li>
          <a href="#links">Ссылки</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Encryption/Decryption

Phalcon предоставляет средства шифрования с помощью компонента `Phalcon\Crypt`. Этот класс предоставляет простые объектно-ориентированные обертки к PHP библиотеке [openssl](http://www.php.net/manual/en/book.openssl.php).

По умолчанию данный компонент использует надежный алгоритм шифрования AES-256-CFB.

<h5 class='alert alert-warning'>Вы должны использовать длину ключа, соответствующую текущему алгоритму. Для алгоритма по-умолчанию она составляет 32 байта.</h5>

<a name='usage'></a>

## Basic Usage

Данный компонент разработан так, чтобы быть максимально простым в использовании:

```php
<?php

use Phalcon\Crypt;

// Создаём экземпляр
$crypt = new Crypt();

$key  = 'Это секретный ключ (32 байта).';
$text = 'Это секретное сообщение, которое мы хотим зашифровать.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

Вы можете использовать тот же экземпляр для многократного шифрования или расшифровывания:

```php
<?php

use Phalcon\Crypt;

// Создаём экземпляр
$crypt = new Crypt();

$texts = [
    'my-key'    => 'Это секретное сообщение',
    'other-key' => 'Это ещё одно секретное сообщение',
];

foreach ($texts as $key => $text) {
    // Выполнение шифрования
    $encrypted = $crypt->encrypt($text, $key);

    // Расшифровка
    echo $crypt->decrypt($encrypted, $key);
}
```

<a name='options'></a>

## Encryption Options

Для изменения поведения шифрования доступны следующие параметры:

| Название | Description                                                                                                                                                      |
| -------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Шифр     | Один из алгоритмов шифрования, поддерживаемый openssl. Посмотреть список вы можете [здесь](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Пример:

```php
<?php

use Phalcon\Crypt;

// Создаём экземпляр
$crypt = new Crypt();

// Используем алгоритм blowfish
$crypt->setCipher('bf-cbc');

$key  = 'некоторый-ключ';
$text = 'Это секретная фраза';

echo $crypt->encrypt($text, $key);
```

<a name='base64'></a>

## Base64 Support

Для того, чтобы зашифрованный текст должным образом передать (по электронной почте) или отобразить (в браузере) очень часто применяется кодирование [base64](http://www.php.net/manual/en/function.base64-encode.php):

```php
<?php

use Phalcon\Crypt;

// Создаём экземпляр
$crypt = new Crypt();

$key  = 'Наш секретный ключ';
$text = 'Это секретное сообщение';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Setting up an Encryption service

Чтобы использовать компонент шифрования из любой точки приложения, вы можете поместить его в контейнер сервисов:

```php
<?php

use Phalcon\Crypt;

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // Устанавливаем глобальный ключ шифрования
        $crypt->setKey(
            '%31.1e$i86e$f!8jz'
        );

        return $crypt;
    },
    true
);
```

Затем, например, вы можете использовать его в контроллере следующим образом:

```php
<?php

use Phalcon\Mvc\Controller;

class SecretsController extends Controller
{
    public function saveAction()
    {
        $secret = new Secrets();

        $text = $this->request->getPost('text');

        $secret->content = $this->crypt->encrypt($text);

        if ($secret->save()) {
            $this->flash->success(
                'Секрет успешно создан!'
            );
        }
    }
}
```

<a name='links'></a>

## Links

- [Advanced Encryption Standard (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
- [Что такое блочный шифр](https://en.wikipedia.org/wiki/Block_cipher)
- [Введение в Blowfish](http://www.splashdata.com/splashid/blowfish.htm)