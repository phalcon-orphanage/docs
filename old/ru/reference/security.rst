Security
========

Этот компонент помогает разработчику в общих задачах обеспечения безопасности, таких как хеширование паролей и защите от атак вида Cross-Site Request Forgery (CSRF).

Хеширование паролей
-------------------
Хранение паролей в открытом виде является плохой практикой. Любой, кто имеет доступ к базе данных, мгновенно получит доступ ко всем пользовательским
аккаунтам и, таким образом, получает возможность производить неавторизованные действия. Для противостояния этому, многие приложения используют знакомые методы
одностороннего хеширования вроде "md5_" и "sha1_". Однако аппаратное обеспечение развивается с каждым днем, становится быстрее, и эти алгоритмы становятся уязвимы
к атакам методом перебора. Данные атаки также известны как "радужные таблицы" (`rainbow tables`_).

Для решения этой проблемы, мы можем использовать такие алгоритмы хеширования, как bcrypt_. Почему bcrypt? Благодаря алгоритму установки ключа “Eksblowfish_”
мы можем сделать шифрование пароля настолько "медленным", насколько мы этого захотим. Медленные алгоритмы делают процесс вычисления настоящего
пароля, скрытого за хешем, крайне сложным, если не невозможным. Это защитит вас на долгое время от возможных атак с использованием радужных таблиц.

Этот компонент дает вам возможность простым способом использовать данный алгоритм:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function registerAction()
        {
            $user = new Users();

            $login    = $this->request->getPost("login");
            $password = $this->request->getPost("password");

            $user->login = $login;

            // Сохраняем пароль хешированным
            $user->password = $this->security->hash($password);

            $user->save();
        }
    }

Мы сохранили пароль хешированным с коэффициентом хеширования по-умолчанию. Более высокий коэффициент хеширования сделает пароль менее уязвимым, так как
его шифрование будет медленным. Мы можем проверить правильность пароля следующим способом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            $login    = $this->request->getPost("login");
            $password = $this->request->getPost("password");

            $user = Users::findFirstByLogin($login);
            if ($user) {
                if ($this->security->checkHash($password, $user->password)) {
                    // Пароль верный
                }
            } else {
                // To protect against timing attacks. Regardless of whether a user exists or not, the script will take roughly the same amount as it will always be computing a hash.
                $this->security->hash(rand());
            }

            // неудачная проверка
        }
    }

Соль генерируется с использованием псевдослучайных байтов функции PHP openssl_random_pseudo_bytes_, поэтому необходимо, чтобы расширение openssl_ было загружено.

Защита от Cross-Site Request Forgery (CSRF)
-------------------------------------------
Это один из других видов атак на веб-сайты и приложения. Формы, созданные для выполнения таких задач, как регистрация или добавление комментариев,
уязвимы для этих атак.

Основной идеей является предотвращение отправления значений формы куда-либо вне нашего приложения. Чтобы это сделать, мы генерируем токен (`nonce`_)
для каждой формы, добавляем этот токен в сессию, а после, как только форма возвращает данные нашему приложению, проверяем токен, сравнивая присланный формой
токен с его сохраненным значением в сессии:

.. code-block:: html+php

    <?php echo Tag::form('session/login') ?>

        <!-- поля логина и пароля ... -->

        <input type="hidden" name="<?php echo $this->security->getTokenKey() ?>"
            value="<?php echo $this->security->getToken() ?>"/>

    </form>

После этого, в действии контроллера вы можете проверить CSRF-токен на правильность:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            if ($this->request->isPost()) {
                if ($this->security->checkToken()) {
                    // Токен верный
                }
            }
        }
    }

Remember to add a session adapter to your Dependency Injector, otherwise the token check won't work:

.. code-block:: php

    <?php

    $di->setShared(
        "session",
        function () {
            $session = new \Phalcon\Session\Adapter\Files();

            $session->start();

            return $session;
        }
    );

Также рекомендуется добавление каптчи (captcha_) в форму, чтобы полностью избежать рисков от этого типа атак.

Настройка компонента
--------------------
Компонент автоматически регистрируется в контейнере сервисов под названием 'security', вы можете его перерегистрировать
для настройки параметров:

.. code-block:: php

    <?php

    use Phalcon\Security;

    $di->set(
        "security",
        function () {
            $security = new Security();

            // Устанавливаем фактор хеширования в 12 раундов
            $security->setWorkFactor(12);

            return $security;
        },
        true
    );

Random
------
The :doc:`Phalcon\\Security\\Random <../api/Phalcon_Security_Random>` class makes it really easy to generate lots of types of random data.

.. code-block:: php

    <?php

    use Phalcon\Security\Random;

    $random = new Random();

    // ...
    $bytes      = $random->bytes();

    // Generate a random hex string of length $len.
    $hex        = $random->hex($len);

    // Generate a random base64 string of length $len.
    $base64     = $random->base64($len);

    // Generate a random URL-safe base64 string of length $len.
    $base64Safe = $random->base64Safe($len);

    // Generate a UUID (version 4). See https://en.wikipedia.org/wiki/Universally_unique_identifier
    $uuid       = $random->uuid();

    // Generate a random integer between 0 and $n.
    $number     = $random->number($n);

Внешние источники
-----------------
* `Vökuró <http://vokuro.phalconphp.com>`_, пример приложения с использованием Security для избежание CSRF и хешированием паролей [`Github <https://github.com/phalcon/vokuro>`_]

.. _sha1: http://php.net/manual/ru/function.sha1.php
.. _md5: http://php.net/manual/ru/function.md5.php
.. _openssl_random_pseudo_bytes: http://php.net/manual/ru/function.openssl-random-pseudo-bytes.php
.. _openssl: http://php.net/manual/ru/book.openssl.php
.. _captcha: http://www.google.com/recaptcha
.. _`nonce`: http://ru.wikipedia.org/wiki/Nonce
.. _bcrypt: http://ru.wikipedia.org/wiki/Bcrypt
.. _Eksblowfish: http://ru.wikipedia.org/wiki/Bcrypt#.D0.90.D0.BB.D0.B3.D0.BE.D1.80.D0.B8.D1.82.D0.BC
.. _`rainbow tables`: http://ru.wikipedia.org/wiki/Rainbow_table
