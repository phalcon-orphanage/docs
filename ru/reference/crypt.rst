Зашифрование и расшифрование
============================
Phalcon предоставляет средства шифрования с помощью компонента :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`.
Этот класс предоставляет простые объектно-ориентированные обертки к php библиотеке mcrypt_.

По умолчанию данный компонент использует надежный алгоритм шифрования AES-256 (rijndael-256-cbc).

Базовое использование
---------------------
Данный компонент разработан так, чтобы быть максимально простым в использовании:

.. code-block:: php

    <?php

    // Создание экземпляра
    $crypt = new Phalcon\Crypt();

    $key = 'это пароль';
    $text = 'Это секретный текст';

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);

Вы можете использовать тот же экземпляр для многократного зашифрования или расшифрования:

.. code-block:: php

    <?php

    // Создание экземпляра
    $crypt = new Phalcon\Crypt();

    $texts = array(
        'my-key' => 'Это секретный текст',
        'other-key' => 'Это очень секретно'
    );

    foreach ($texts as $key => $text) {

        // Зашифровываем
        $encrypted = $crypt->encrypt($text, $key);

        // Теперь расшифровываем
        echo $crypt->decrypt($encrypted, $key);
    }

Атрибуты шифрования
-------------------
Для изменения в поведении шифрования доступны следующие атрибуты:

+------------+---------------------------------------------------------------------------------------------------+
| Атрибут    | Описание                                                                                          |
+============+===================================================================================================+
| Cipher     | Один из алгоритмов шифрования поддерживаемый libmcrypt. Посмотреть список Вы можете `здесь`_      |
+------------+---------------------------------------------------------------------------------------------------+
| Mode       | Один из режимов шифрования поддерживаемый libmcrypt (ecb, cbc, cfb, ofb)                          |
+------------+---------------------------------------------------------------------------------------------------+

Пример:

.. code-block:: php

    <?php

    // Создаем экземпляр
    $crypt = new Phalcon\Crypt();

    // Используем алгоритм blowfish
    $crypt->setCipher('blowfish');

    $key = 'это пароль';
    $text = 'Это секретный текст';

    echo $crypt->encrypt($text, $key);

Поддержка Base64
----------------
Для того, чтобы зашифрованный текст должным образом передать (по электронной почте) или отобразить (в браузере) очень часто
применяется кодирование base64_.

.. code-block:: php

    <?php

    // Создаем экземпляр
    $crypt = new Phalcon\Crypt();

    $key = 'это пароль';
    $text = 'Это секретный текст';

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($text, $key);

Настройка сервиса
-----------------
Чтобы использовать компонент шифрования из любой точки приложения, Вы можете поместить его в контейнер сервисов:

.. code-block:: php

    <?php

    $di->set('crypt', function() {

        $crypt = new Phalcon\Crypt();

        // Устанавливаем глобальный ключ шифрования
        $crypt->setKey('%31.1e$i86e$f!8jz');

        return $crypt;
    }, true);

Затем, как пример, Вы можете использовать его в контроллере следующим образом:

.. code-block:: php

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
                $this->flash->success('Секрет успешно создан!');
            }

        }

    }

.. _mcrypt: http://www.php.net/manual/en/book.mcrypt.php
.. _здесь: http://www.php.net/manual/en/mcrypt.ciphers.php
.. _base64: http://www.php.net/manual/en/function.base64-encode.php
