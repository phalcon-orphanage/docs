---
layout: default
language: 'ru-ru'
version: '4.0'
title: 'Security'
keywords: 'security, hashing, passwords'
---

# Security

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Введение

> **NOTE**: Requires PHP's [openssl](https://php.net/manual/en/book.openssl.php) extension to be present in the system
{: .alert .alert-info }

[Phalcon\Security](api/phalcon_security#security) is a component that helps developers with common security related tasks, such as password hashing and Cross-Site Request Forgery protection ([CSRF](https://en.wikipedia.org/wiki/Cross-site_request_forgery)).

## Password Hashing

Storing passwords in plain text is a bad security practice. Anyone with access to the database will immediately have access to all user accounts thus being able to engage in unauthorized activities. To combat that, many applications use popular one way hashing methods [md5](https://php.net/manual/en/function.md5.php) and [sha1](https://php.net/manual/en/function.sha1.php). However, hardware evolves on a daily basis and as processors become faster, these algorithms are becoming vulnerable to brute force attacks. These attacks are also known as [rainbow tables](https://en.wikipedia.org/wiki/Rainbow_table).

The security component uses [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) as the hashing algorithm. Thanks to the [Eksblowfish](https://en.wikipedia.org/wiki/Bcrypt#Algorithm) key setup algorithm, we can make the password encryption as `slow` as we want. Slow algorithms minimize the impact of brute force attacks.

[Bcrypt](https://en.wikipedia.org/wiki/Bcrypt), is an adaptive hash function based on the Blowfish symmetric block cipher cryptographic algorithm. It also introduces a security or work factor, which determines how slow the hash function will be to generate the hash. This effectively negates the use of FPGA or GPU hashing techniques.

Should hardware becomes faster in the future, we can increase the work factor to mitigate this. The salt is generated using pseudo-random bytes with the PHP's function [openssl_random_pseudo_bytes](https://php.net/manual/en/function.openssl-random-pseudo-bytes.php).

This component offers a simple interface to use the algorithm:

```php
<?php

use Phalcon\Security;

$security = new Security();

echo $security->hash('Phalcon'); 
// $2y$08$ZUFGUUk5c3VpcHFoVUFXeOYoA4NPFEP4G9gcm6rdo3jFPaNFdR2/O
```

The hash that was created used the default work factor which is set to `10`. Using a higher work factor will take a bit more time to calculate the hash.

We can now check if a value sent to us by a user through the UI of our application, is identical to our hashed string:

```php
<?php

use Phalcon\Security;

$password = $_POST['password'] ?? '';

$security = new Security();
$hashed = $security->hash('Phalcon');

echo $security->checkHash($password, $hashed); // true / false
```

The above example simply shows how the `checkHash()` can be used. In production applications we will definitely need to sanitize input and also we need to store the hashed password in a data store such as a database. Using controllers, the above example can be shown as:

```php
<?php

use MyApp\Models\Users;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Security;

/**
 * @property Request  $request
 * @property Security $security
 */
class SessionController extends Controller
{
    /**
     * Login
     */
    public function loginAction()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $user = Users::findFirst(
            [
                'conditions' => 'login = :login:',
                'bind'       => [
                    'login' => $login,
                ],
            ]
        );

        if (false !== $user) {
            $check = $this
                ->security
                ->checkHash($password, $user->password);

            if (true === $check) {
                // OK
            }
        } else {
            $this->security->hash(rand());
        }

        // ERROR
    }

    /**
     * Register
     */
    public function registerAction()
    {
        $login    = $this->request->getPost('login', 'string');
        $password = $this->request->getPost('password', 'string');

        $user = new Users();

        $user->login    = $login;
        $user->password = $this->security->hash($password);

        $user->save();
    }

}
```

> **NOTE** The code snippet above is incomplete and **must not be used as is for production applications**
{: .alert .alert-danger }

The `registerAction()` above accepts posted data from the UI. It sanitizes it with the `string` filter and then creates a new `User` model object. It then assigns the passed data to the relevant properties before saving it. Notice that for the password, we use the `hash()` method of the [Phalcon\Security](api/phalcon_security#security) component so that we do not save it as plain text in our database.

The `loginAction()` accepts posted data from the UI and then tries to find the user in the database based on the `login` field. If the user does exist, it will use the `checkHash()` method of the [Phacon\Security](api/phalcon_security#security) component, to assess whether the supplied password hashed is the same as the one stored in the database.

> **NOTE**: You do not need to hash the supplied password (first parameter) when using `checkHash()` - the component will do that for you.
{: .alert .alert-info }

If the password is not correct, you can then inform the user that something is wrong with the credentials. It is always a good idea not to provide specific information about your users to people that want to hack your site. So for instance our example above can produce two messages:

* User not found in the database
* Password is incorrect

Separating the error messages is not a good idea. If a hacker that is using brute force attack detects the second message, they can stop trying to guess the `login` and concentrate on the password, thus increasing their chances of gaining access. A more appropriate message for both potential error conditions could be

`Invalid Login/Password combination`

Finally you will notice in the example that when the user is not found, we call:

```php
$this->security->hash(rand());
```

This is done to protect against timing attacks. Irrespective of whether a user exists or not, the script will take roughly the same amount of time to execute, since it is computing a hash again, even though we will never use that result.

## Exceptions

Any exceptions thrown in the Security component will be of type [Phalcon\Security\Exception](api/phalcon_security#security-exception). You can use this exception to selectively catch exceptions thrown only from this component. Exceptions can be raised if the hashing algorithm is unknown, if the `session` service is not present in the Di container etc.

```php
<?php

use Phalcon\Security\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->security->hash('123');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## CSRF Protection

Cross-Site Request Forgery (CSRF) is another common attack against web sites and applications. Forms designed to perform tasks such as user registration or adding comments are vulnerable to this attack.

The idea is to prevent the form values from being sent outside our application. To fix this, we generate a [random nonce](https://en.wikipedia.org/wiki/Cryptographic_nonce) (token) in each form, add the token in the session and then validate the token once the form posts data back to our application by comparing the stored token in the session to the one submitted by the form:

```php
<form method='post' action='session/login'>

    <!-- Login and password inputs ... -->

    <input type='hidden' name='<?php echo $this->security->getTokenKey() ?>'
        value='<?php echo $this->security->getToken() ?>'/>

</form>
```

Then in the controller's action you can check if the CSRF token is valid:

```php
<?php

use Phalcon\Mvc\Controller;

/**
 * @property Request  $request
 * @property Security $security
 */
class SessionController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
                // OK
            }
        }
    }
}
```

> **NOTE**: It is important to remember that you will need to have a valid `session` service registered in your Dependency Injection container. Otherwise the `checkToken()` will not work.
{: .alert .alert-warning }

Adding a [captcha](https://en.wikipedia.org/wiki/ReCAPTCHA) to the form is also recommended to completely avoid the risks of this attack.

## Functionality

### Hash

**getDefaultHash() / setDefaultHash()**

Getter and setter for the default hash that the component will use. By default the hash is set to `CRYPT_DEFAULT` (`0`). The available options are:

* `CRYPT_BLOWFISH_A`
* `CRYPT_BLOWFISH_X`
* `CRYPT_BLOWFISH_Y`
* `CRYPT_MD5`
* `CRYPT_SHA256`
* `CRYPT_SHA512`
* `CRYPT_DEFAULT`

**hash()**

Hashes as string or password and returns the hashed string back. The second parameter is optional, and allows you to set temporarily a specific `workFactor` or passes which overrides the default one.

**checkHash()**

Accepts a string (usually the password), an already hashed string (the hashed password) and an optional minimum password length. It checks them both and returns `true` if they are identical and `false` otherwise.

**isLegacyHash()**

Returns `true` if the passed hashed string is a valid [bcrypt](https://en.wikipedia.org/wiki/Bcrypt) hash.

### HMAC

**computeHmac()**

Generates a keyed hash value using the HMAC method. It uses PHP's [`hash_hmac`](https://www.php.net/manual/en/function.hash-hmac.php) method internally, therefore all the parameters it accepts are the same as the [`hash_hmac`](https://www.php.net/manual/en/function.hash-hmac.php).

### Random

**`getRandom()`**

Returns a [Phalcon\Security\Random](api/phalcon_security#security-random) object, which is secure random number generator instance. The component is explained in detail below.

**`getRandomBytes()` / `setRandomBytes()`**

Getter and setter methods to specify he number of bytes to be generated by the openssl pseudo random generator. It defaults to `16`.

**`getSaltBytes()`**

Generates a pseudo random string to be used as a salt for passwords. It uses the `getRandomBytes()` value for the length of the string. It can however be overridden by the passed numeric parameter.

### Token

**`getToken()`**

Generates a pseudo random token value to be used as input's value in a CSRF check.

**`getTokenKey()`**

Generates a pseudo random token key to be used as input's name in a CSRF check.

**`getRequestToken()`**

Returns the value of the CSRF token for the current request.

**`checkToken()`**

Check if the CSRF token sent in the request is the same that the current in session. The first parameter is the token key and the second one the token value. It also accepts a third boolean parameter `destroyIfValid` which if set to `true` will destroy the token if the method returns `true`.

**`getSessionToken()`**

Returns the value of the CSRF token in session

**`destroyToken()`**

Removes the value of the CSRF token and key from session

## Random

The [Phalcon\Security\Random](api/phalcon_security#security-random) class makes it really easy to generate lots of types of random data to be used in salts, new user passwords, session keys, complicated keys, encryption systems etc. This class partially borrows [SecureRandom](https://ruby-doc.org/stdlib-2.2.2/libdoc/securerandom/rdoc/SecureRandom.html) library from Ruby.

It supports following secure random number generators: * random_bytes * libsodium * openssl, libressl * /dev/urandom

To utilize the above you will need to ensure that the generators are available in your system. For instance to use `openssl` your PHP installation needs to support it.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->hex(10);       // a29f470508d5ccb8e289
echo $random->base62();      // z0RkwHfh8ErDM1xw
echo $random->base64(16);    // SvdhPcIHDZFad838Bb0Swg==
echo $random->base64Safe();  // PcV6jGbJ6vfVw7hfKIFDGA
echo $random->uuid();        // db082997-2572-4e2c-a046-5eefe97b1235
echo $random->number(256);   // 84
echo $random->base58();      // 4kUgL2pdQMSCQtjE
```

**`base58()`**

Generates a random `base58` string. If the `$len` parameter is not specified, `16` is assumed. It may be larger in future. The result may contain alphanumeric characters except `0` (zero), `O` (capital `o`), `I` (capital `i`) and `l` (lower case `L`).

It is similar to `base64()` but has been modified to avoid both non-alphanumeric characters and letters which might look ambiguous when printed.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE
```

**`base62()`**

Generates a random `base62` string. If the `$len` parameter is not specified, `16` is assumed. It may be larger in future. It is similar to `base58()` but has been modified to provide the largest value that can safely be used in URLs without needing to take extra characters into consideration because it is `[A-Za-z0-9]`

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw
```

**`base64()`**

Generates a random `base64` string. If the `$len` parameter is not specified, `16` is assumed. It may be larger in future. The length of the result string is usually greater of `$len`. The size formula is:

`4 * ($len / 3)` rounded up to a multiple of 4.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8
```

**`base64Safe()`**

Generates a URL safe random `base64` string. If the `$len` parameter is not specified, `16` is assumed. It may be larger in future. The length of the result string is usually greater of `$len`.

By default, padding is not generated because `=` may be used as a URL delimiter. The result may contain `A-Z`, `a-z`, `0-9`, `-` and `_`. `=` is also used if `$padding` is `true`. See [RFC 3548](https://www.ietf.org/rfc/rfc3548.txt) for the definition of URL-safe `base64`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug
```

**`bytes()`**

Generates a random binary string and accepts as input an integer representing the length in bytes to be returned. If `$len` is not specified, `16` is assumed. It may be larger in future. The result may contain any byte: `x00` - `xFF`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"
```

**`hex()`**

Generates a random hex string. If `$len` is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of `$len`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->hex(10); // a29f470508d5ccb8e289
```

**`number()`**

Generates a random number between `0` and `$len`. Returns an integer: `0 <= result <= $len`.

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->number(16); // 8
```

**`uuid()`**

Generates a v4 random UUID (Universally Unique IDentifier). The version 4 UUID is purely random (except the version). It doesn't contain meaningful information such as MAC address, time, etc. See [RFC 4122](https://www.ietf.org/rfc/rfc4122.txt) for details of UUID.

This algorithm sets the version number (4 bits) as well as two reserved bits. All other bits (the remaining 122 bits) are set using a random or pseudorandom data source. Version 4 UUIDs have the form `xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx` where x is any hexadecimal digit and `y` is one of `8`, `9`, `A`, or `B` (e.g., `f47ac10b-58cc-4372-a567-0e02b2c3d479`). *

```php
<?php

use Phalcon\Security\Random;

$random = new Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22
```

## Dependency Injection

If you use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the [Phalcon\Security](api/phalcon_security#security) is already registered for you. However you might want to override the default registration in order to set your own `workFactor()`. Alternatively if you are not using the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) and instead are using the [Phalcon\Di](di) the registration is the same. By doing so, you will be able to access your configuration object from controllers, models, views and any component that implements `Injectable`.

An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Security;

// Create a container
$container = new FactoryDefault();

$container->set(
    'security',
    function () {
        $security = new Security();

        $security->setWorkFactor(12);

        return $security;
    },
    true
);
```

In the above example, the `setWorkFactor()` sets the password hashing factor to 12 rounds.

The component is now available in your controllers using the `security` key

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security;

/**
 * @property Security $security
 */
class MyController extends Controller
{
    private function getHash(string $password): string
    {
        return $this->security->hash($password);
    }
}
```

Also in your views (Volt syntax)

```twig
{% raw %}{{ security.getToken() }}{% endraw %}
```