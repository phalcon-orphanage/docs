<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">加密/解密</a> <ul>
        <li>
          <a href="#usage">Basic Usage</a>
        </li>
        <li>
          <a href="#options">加密选项</a>
        </li>
        <li>
          <a href="#base64">Base64 支持</a>
        </li>
        <li>
          <a href="#service">设置加密服务</a>
        </li>
        <li>
          <a href="#links">链接</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 加密/解密

Phalcon提供加密设施通过 `Phalcon\Crypt` 组件。 此类提供 [openssl](http://www.php.net/manual/en/book.openssl.php) PHP 加密库简单的面向对象的封装器。

默认情况下，此组件提供安全的加密使用 AES-256-CFB.。

The cipher AES-256 is used among other places in SSL/TLS across the Internet. It's considered among the top ciphers. In theory it's not crackable since the combinations of keys are massive. Although NSA has categorized this in [Suite B](https://en.wikipedia.org/wiki/NSA_Suite_B_Cryptography), they have also recommended using higher than 128-bit keys for encryption.

<div class="alert alert-warning">
    <p>
        您必须使用对应于当前的算法密钥长度。默认情况下使用的算法为 32 个字节。
    </p>
</div>

<a name='usage'></a>

## 基本用法

此组件被旨在提供一种非常简单的用法：

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

/**
 * Set the cipher algorithm.
 *
 * The `aes-256-gcm' is the preferable cipher, but it is not usable until the
 * openssl library is upgraded, which is available in PHP 7.1.
 *
 * The `aes-256-ctr' is arguably the best choice for cipher
 * algorithm in these days.
 */
$crypt->setCipher('aes-256-ctr');

/**
 * Set the encryption key.
 *
 * The `$key' should have been previously generated in a cryptographically safe way.
 *
 * Bad key:
 * "le password"
 *
 * Better (but still unsafe):
 * "#1dj8$=dp?.ak//j1V$~%*0X"
 *
 * Good key:
 * "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
 *
 * Use your own key. Do not copy and paste this example key.
 */
$key = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";

$text = 'This is the text that you want to encrypt.';

$encrypted = $crypt->encrypt($text, $key);

echo $crypt->decrypt($encrypted, $key);
```

你可以使用相同的实例以加密解密几次：

```php
<?php

use Phalcon\Crypt;

$crypt->setCipher('aes-256-ctr');

// Create an instance
$crypt = new Crypt();

// Use your own keys!
$texts = [
    "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c" => 'This is a secret text',
    "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3" => 'This is a very secret',
];

foreach ($texts as $key => $text) {
    // Perform the encryption
    $encrypted = $crypt->encrypt($text, $key);

    // Now decrypt
    echo $crypt->decrypt($encrypted, $key);
}
```

<a name='options'></a>

## 加密选项

以下选项可以用来更改加密行为：

| Name   | Description                                                                                                                                                          |
| ------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Cipher | The cipher is one of the encryption algorithms supported by openssl. You can see a list [here](http://www.php.net/manual/en/function.openssl-get-cipher-methods.php) |

Example:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use blowfish
$crypt->setCipher('bf-cbc');

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

echo $crypt->encrypt($text, $key);
```

<a name='base64'></a>

## Base64 Support

In order for encryption to be properly transmitted (emails) or displayed (browsers) [base64](http://www.php.net/manual/en/function.base64-encode.php) encoding is usually applied to encrypted texts:

```php
<?php

use Phalcon\Crypt;

// Create an instance
$crypt = new Crypt();

// Use your own key!
$key  = "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3";
$text = 'This is a secret text';

$encrypt = $crypt->encryptBase64($text, $key);

echo $crypt->decryptBase64($encrypt, $key);
```

<a name='service'></a>

## Setting up an Encryption service

You can set up the encryption component in the services container in order to use it from any part of the application:

```php
<?php

use Phalcon\Crypt;

$di->set(
    'crypt',
    function () {
        $crypt = new Crypt();

        // Set a global encryption key
        $crypt->setKey(
            "T4\xb1\x8d\xa9\x98\x05\\\x8c\xbe\x1d\x07&[\x99\x18\xa4~Lc1\xbeW\xb3"
        );

        return $crypt;
    },
    true
);
```

Then, for example, in a controller you can use it as follows:

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
                'Secret was successfully created!'
            );
        }
    }
}
```

<a name='links'></a>

## Links

* [Advanced Encryption Standard (AES)](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard)
* [What is block cipher](https://en.wikipedia.org/wiki/Block_cipher)
* [Introduction to Blowfish](http://www.splashdata.com/splashid/blowfish.htm)
* [CTR-Mode Encryption](http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.79.1353&rep=rep1&type=pdf)
* [Recommendation for Block Cipher Modes of Operation: Methods and Techniques](https://csrc.nist.gov/publications/detail/sp/800-38a/final)
* [Counter (CTR) mode](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)