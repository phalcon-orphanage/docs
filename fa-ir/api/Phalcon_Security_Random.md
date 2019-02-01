---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Security\Random'
---
# Class **Phalcon\Security\Random**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/security/random.zep)

Secure random number generator class.

Provides secure random number generator which is suitable for generating session key in HTTP cookies, etc.

It supports following secure random number generators:

- random_bytes (PHP 7)
- libsodium
- openssl, libressl
- /dev/urandom

`Phalcon\Security\Random` could be mainly useful for:

- Key generation (e.g. generation of complicated keys)
- Generating random passwords for new user accounts
- Encryption systems

```php
<?php

$random = new \Phalcon\Security\Random();

// Random binary string
$bytes = $random->bytes();

// Random hex string
echo $random->hex(10); // a29f470508d5ccb8e289
echo $random->hex(10); // 533c2f08d5eee750e64a
echo $random->hex(11); // f362ef96cb9ffef150c9cd
echo $random->hex(12); // 95469d667475125208be45c4
echo $random->hex(13); // 05475e8af4a34f8f743ab48761

// Random base62 string
echo $random->base62(); // z0RkwHfh8ErDM1xw

// Random base64 string
echo $random->base64(12); // XfIN81jGGuKkcE1E
echo $random->base64(12); // 3rcq39QzGK9fUqh8
echo $random->base64();   // DRcfbngL/iOo9hGGvy1TcQ==
echo $random->base64(16); // SvdhPcIHDZFad838Bb0Swg==

// Random URL-safe base64 string
echo $random->base64Safe();           // PcV6jGbJ6vfVw7hfKIFDGA
echo $random->base64Safe();           // GD8JojhzSTrqX7Q8J6uug
echo $random->base64Safe(8);          // mGyy0evy3ok
echo $random->base64Safe(null, true); // DRrAgOFkS4rvRiVHFefcQ==

// Random UUID
echo $random->uuid(); // db082997-2572-4e2c-a046-5eefe97b1235
echo $random->uuid(); // da2aa0e2-b4d0-4e3c-99f5-f5ef62c57fe2
echo $random->uuid(); // 75e6b628-c562-4117-bb76-61c4153455a9
echo $random->uuid(); // dc446df1-0848-4d05-b501-4af3c220c13d

// Random number between 0 and $len
echo $random->number(256); // 84
echo $random->number(256); // 79
echo $random->number(100); // 29
echo $random->number(300); // 40

// Random base58 string
echo $random->base58();   // 4kUgL2pdQMSCQtjE
echo $random->base58();   // Umjxqf7ZPwh765yR
echo $random->base58(24); // qoXcgmw4A9dys26HaNEdCRj9
echo $random->base58(7);  // 774SJD3vgP

```

This class partially borrows SecureRandom library from Ruby

## روش ها

public **bytes** ([*mixed* $len])

Generates a random binary string The `Random::bytes` method returns a string and accepts as input an int representing the length in bytes to be returned. If $len is not specified, 16 is assumed. It may be larger in future. The result may contain any byte: "x00" - "xFF".

```php
<?php

$random = new \Phalcon\Security\Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"

```

public **hex** ([*mixed* $len])

Generates a random hex string If $len is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289

```

public **base58** ([*mixed* $len])

Generates a random base58 string If $len is not specified, 16 is assumed. It may be larger in future. The result may contain alphanumeric characters except 0, O, I and l. It is similar to `Phalcon\Security\Random:base64` but has been modified to avoid both non-alphanumeric characters and letters which might look ambiguous when printed.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE

```

public **base62** ([*mixed* $len])

Generates a random base62 string If $len is not specified, 16 is assumed. It may be larger in future. It is similar to `Phalcon\Security\Random:base58` but has been modified to provide the largest value that can safely be used in URLs without needing to take extra characters into consideration because it is [A-Za-z0-9].

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw

```

public **base64** ([*mixed* $len])

Generates a random base64 string If $len is not specified, 16 is assumed. It may be larger in future. The length of the result string is usually greater of $len. فرمول حجم (: 4 * ($len / 3 و این نیاز به چند تا از 4 گرد می شود.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8

```

public **base64Safe** ([*mixed* $len], [*mixed* $padding])

یک پایگاه 64 بیتی امن را ایجاد می کند اگر $len مشخص نشده است، فرض 16 است. It may be larger in future. The length of the result string is usually greater of $len. به طور پیش فرض، کلمات یا رکوردهای ساختگی ایجاد نمی شوند، زیرا "="ممکن است به عنوان یک حائل URL استفاده. نتایج ممکن است شامل A-Z، a-z، ۹-۰، و "-"باشند. اگر $padding صحیح باشد، "="نیز استفاده می شود. RFC 3548 برای تعریف پایگاه 64 آدرس ایمن را ببینید.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug

```

عمومی**uuid** ()

UUIDتصادفی v4را تولید می کند.( شناسه یگانه جهانی) نسخه ی 4 UUIDکاملا تصادفی است.( به جز نسخه). شامل این معنی نیست اطلاعات معنی دار مانند آدرس MAC ، زمان و غیره نمی شود. برای جزئیات UUIDبه RFC 4122مراجعه کنید. این الگوریتم شماره نسخه را (۴بیت) همانند ۲بیت رزرو شده تعیین می کند. تمام بیت های دیگر(۱۲۲بیت باقی مانده) با استفاده از یک منبع تصادفی یا شبه تصادفی تنظیم می شوند. نسخه UUID ۴ ها فرم xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx را دارند که X رقم مبنای ۱۶و Y یکی از ۸، ۹،A یا B است. (برای مثال: f47ac10b-58cc-4372-a567-0e02b2c3d479).

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22

```

عمومی **شماره** (*مخلوط* $len)

یک عدد تصادفی بین 0و $len تولید می کند و یک عدد صحیح باز می گرداند: 0 <= جواب <= $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->number(16); // 8

```

protected **base** (*mixed* $alphabet, *mixed* $base, [*mixed* $n])

Generates a random string based on the number ($base) of characters ($alphabet). If $n is not specified, 16 is assumed. It may be larger in future.