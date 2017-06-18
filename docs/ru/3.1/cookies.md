<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Управление куками</a> <ul>
        <li>
          <a href="#usage">Базовое использование</a>
        </li>
        <li>
          <a href="#encryption-decryption">Шифрование/дешифрование кук</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Cookies Management

[Куки](http://en.wikipedia.org/wiki/HTTP_cookie)очень полезный способ хранения маленьких фрагментов данных на стороне клиента, которые могут быть получены, даже если пользователь закроет свой браузер. `Phalcon\Http\Response\Cookies` выступает в качестве глобального хранилища для кук. Куки хранятся в таком хранилище во время выполнения запроса и отправляются автоматически по его окончанию.

<a name='usage'></a>

## Basic Usage

Вы можете установить или извлечь куки простым обращением к сервису `cookies` из любого места в приложении:

```php
<?php

use Phalcon\Mvc\Controller;

class SessionController extends Controller
{
    public function loginAction()
    {
        // Проверяем была ли установлена кука ранее
        if ($this->cookies->has('remember-me')) {
            // Извлекаем куку
            $rememberMeCookie = $this->cookies->get('remember-me');

            // Извлекаем значение из куки
            $value = $rememberMeCookie->getValue();
        }
    }

    public function startAction()
    {
        $this->cookies->set(
            'remember-me',
            'некоторое значение',
            time() + 15 * 86400
        );
    }

    public function logoutAction()
    {
        $rememberMeCookie = $this->cookies->get('remember-me');

        // Удаляем куку
        $rememberMeCookie->delete();
    }
}
```

<a name='encryption-decryption'></a>

## Encryption/Decryption of Cookies

По умолчанию Куки автоматически шифруются перед отправкой клиенту и расшифровываются при получении. Такая защита не позволяет неавторизированным пользователям видеть содержимое кук на стороне клиента (в браузере). Но несмотря на это, хранить в них конфиденциальные (персональные) данные не следует.

Вы можете отключить шифрование следующим образом:

```php
<?php

use Phalcon\Http\Response\Cookies;

$di->set(
    'cookies',
    function () {
        $cookies = new Cookies();

        $cookies->useEncryption(false);

        return $cookies;
    }
);
```

При использовании шифрования должен быть установлен глобальный ключ в сервисе [crypt](/[[language]]/[[version]]/crypt):

```php
    <?php

    use Phalcon\Crypt;

    $di->set(
        'crypt',
        function () {
            $crypt = new Crypt();
            // Используйте свой собственный ключ!
            $crypt->setKey('#1dj8$=dp?.ak//j1V$');

            return $crypt;
        }
    );
```

<h5 class='alert alert-danger'>Отправка клиентам в куки без шифрования объектов со сложной структурой, наборы результатов, служебную информацию и другую подобную информацию, может раскрыть детали реализации приложения, которыми могут воспользоваться злоумышленники для взлома вашего приложения. Если вы не хотите использовать шифрование, мы настоятельно рекомендуем вам отправлять только очень простые данные, такие как числа и небольшие строки.</h5>