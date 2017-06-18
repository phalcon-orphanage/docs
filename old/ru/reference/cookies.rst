Управление Куками
=================

`Куки`_ очень полезный способ хранения маленьких фрагментов данных на стороне клиента, которые могут быть получены, даже
если пользователь закроет свой браузер. :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`
выступает в качестве глобального "мешка" (bag) для Кук. Куки хранятся в таком "мешке" (bag) во время выполнения запроса
и отправляются автоматически по его окончанию.

Базовое использование
---------------------
Вы можете установить или извлечь Куки простым обращением к сервису 'cookies' из любого места в приложении:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            // Проверяем была ли установлена Кука ранее
            if ($this->cookies->has("remember-me")) {
                // Извлекаем Куку
                $rememberMeCookie = $this->cookies->get("remember-me");

                // Извлекаем значение из Куки
                $value = $rememberMeCookie->getValue();
            }
        }

        public function startAction()
        {
            $this->cookies->set(
                "remember-me",
                "некоторое значение",
                time() + 15 * 86400
            );
        }

        public function logoutAction()
        {
            $rememberMeCookie = $this->cookies->get("remember-me");

            // Delete the cookie
            $rememberMeCookie->delete();
        }
    }

Шифрование/дешифрование Кук
---------------------------
По умолчанию Куки автоматически шифруются перед отправкой клиенту и расшифровываются при получении.
Такая защита не позволяет неавторизированным пользователям видеть содержимое Кук на стороне клиента (в браузере),
но несмотря на это, хранить в них конфиденциальные (персональные) данные не следует.

Вы можете отключить шифрование следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Http\Response\Cookies;

    $di->set(
        "cookies",
        function () {
            $cookies = new Cookies();

            $cookies->useEncryption(false);

            return $cookies;
        }
    );

При использовании шифрования должен быть установлен глобальный ключ в сервисе 'crypt':

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        "crypt",
        function () {
            $crypt = new Crypt();

            $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // Используйте свой собственный ключ!

            return $crypt;
        }
    );

.. highlights::

    Отправка клиентам в куки без шифрования объектов со сложной структурой, наборы результатов,
    служебную информацию и другую подобную информацию, может раскрыть детали реализации приложения,
    которыми могут воспользоваться злоумышленники для взлома вашего приложения. Если вы не хотите использовать
    шифрование, мы настоятельно рекомендуем вам отправлять только очень простые данные, такие как числа и небольшие
    строки.

.. _Куки: http://ru.wikipedia.org/wiki/HTTP_cookie
