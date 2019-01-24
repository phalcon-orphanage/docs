---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Security\Random'
---
# Class **Phalcon\Security\Random**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/security/random.zep)

Kelas generator nomor acak yang aman.

Menyediakan generator bilangan acak aman yang mungkin sesuai untuk menghasilkan kunci sesi di cookie HTTP, dll.

Ini yang akan mendukung generator bilangan acak aman berikut:

- random_bytes (PHP 7)
- libsodium
- openssl, libressl
- /dev/urandom

`Phalcon\Security\Random` could be mainly useful for:

- Pembangkitan kunci (misal: pembuatan tombol rumit)
- Membangkitkan password yang acak untuk akun pengguna yang baru
- Sistem enkripsi

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

Kelas ini mungkin sebagian yang meminjam perpustakaan SecureRandom dari Ruby

## Metode

public **bytes** ([*mixed* $len])

Generates a random binary string The `Random::bytes` method returns a string and accepts as input an int representing the length in bytes to be returned. If $len is not specified, 16 is assumed. Mungkin akan lebih besar di masa depan. The result may contain any byte: "x00" - "xFF".

```php
<?php

$random = new \Phalcon\Security\Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"

```

public **hex** ([*mixed* $len])

Generates a random hex string If $len is not specified, 16 is assumed. Mungkin akan lebih besar di masa depan. The length of the result string is usually greater of $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289

```

public **base58** ([*mixed* $len])

Menghasilkan string base58 acak Jika $len tidak akan ditentukan, 16 diasumsikan. Mungkin akan lebih besar di masa depan. The result may contain alphanumeric characters except 0, O, I and l. It is similar to `Phalcon\Security\Random:base64` but has been modified to avoid both non-alphanumeric characters and letters which might look ambiguous when printed.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE

```

public **base62** ([*mixed* $len])

Menghasilkan string base62 yang acak Jika $len tidak akan ditentukan, 16 diasumsikan. Mungkin akan lebih besar di masa depan. It is similar to `Phalcon\Security\Random:base58` but has been modified to provide the largest value that can safely be used in URLs without needing to take extra characters into consideration because it is [A-Za-z0-9].

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw

```

public **base64** ([*mixed* $len])

Menghasilkan string base64 yang acak Jika $len tidak akan ditentukan, 16 diasumsikan. Mungkin akan lebih besar di masa depan. The length of the result string is usually greater of $len. Ukuran rumus: 4 * ($len/ 3) dan ini harus dibulatkan ke kelipatan dari 4.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8

```

public **base64Safe** ([*mixed* $len], [*mixed* $padding])

Generates a random URL-safe base64 string If $len is not specified, 16 is assumed. Mungkin akan lebih besar di masa depan. The length of the result string is usually greater of $len. Secara default, padding tidak dihasilkan karena “=” dapat digunakan sebagai URL delimiter. Hasil mungkin mengandung A-Z, a-z, 0-8, "-" dan "_". "=" Ini juga digunakan jika $padding adalah benar. Memahami RFC 3548 untuk definisi URL-safebase64.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug

```

public **uuid** ()

Menghasilkan UUID acak v4 (Universal Identity IDentifier) Versi 4 UUID murni acak (kecuali versinya). Ini tidak mengandung informasi yang berarti seperti alamat MAC, waktu, dll. See RFC 4122 for details of UUID. Algoritma ini menetapkan nomor versi (4 bit) serta dua bit reserved. Semua bit lainnya (sisa 122 bit) diatur menggunakan sumber data acak atau pseudorandom. Version 4 UUIDs have the form xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx where x is any hexadecimal digit and y is one of 8, 9, A, or B (e.g., f47ac10b-58cc-4372-a567-0e02b2c3d479).

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22

```

public **number** (*mixed* $len)

Menghasilkan nomor acak antara 0 dan $len Mengembalikan sebuah integer: 0 <= hasil <= $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->number(16); // 8

```

protected **base** (*mixed* $alphabet, *mixed* $base, [*mixed* $n])

Generates a random string based on the number ($base) of characters ($alphabet). If $n is not specified, 16 is assumed. Mungkin akan lebih besar di masa depan.