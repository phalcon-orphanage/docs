# Class **Phalcon\\Security\\Random**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/security/random.zep" class="btn btn-default btn-sm">Fuente en GitHub</a>

Asegure la clase de generador de números aleatorios.

Proporciona un generador seguro de números aleatorios que es adecuado para generar clave de sesión en cookies HTTP, etc.

Es compatible con siguientes generadores de números aleatorios seguros:

- random_bytes (PHP 7)
- libsodium
- openssl, libressl
- /dev/urandom

`Phalcon\\Security\\Random` could be mainly useful for:

- Generación de claves (por ejemplo, generación de claves complicadas)
- Generando contraseñas aleatorias para nuevas cuentas de usuario
- Sistemas de cifrado

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

Esta clase toma en préstamo parcialmente la librería SecureRandom de Ruby

## Métodos

public **bytes** ([*mixed* $len])

Genera una cadena binaria aleatoria El método `Random::bytes` devuelve una cadena y acepta como entrada una int representando la longitud en bytes a devolver. Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. El resultado puede contener cualquier byte: "x00" - "xFF".

```php
<?php

$random = new \Phalcon\Security\Random();

$bytes = $random->bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"

```

public **hex** ([*mixed* $len])

Genera una cadena hexagonal aleatoria Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->hex(10); // a29f470508d5ccb8e289

```

public **base58** ([*mixed* $len])

Genera una cadena base58 al azar Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. El resultado puede contener caracteres alfanuméricos excepto 0, O, I y l. Es similar a `Phalcon\\Security\\Random:base64` pero se ha modificado para evitar tanto los no alfanuméricos caracteres y letras que pueden parecer ambiguos cuando se imprimen.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base58(); // 4kUgL2pdQMSCQtjE

```

public **base62** ([*mixed* $len])

Genera una cadena base62 aleatoria Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. Es similar a `Phalcon\\Security\\Random:base58` pero se ha modificado para proporcionar el mayor valor que puede se puede utilizar de forma segura en las URL sin tener que tener en cuenta los caracteres adicionales porque es [A-Za-z0-9].

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base62(); // z0RkwHfh8ErDM1xw

```

public **base64** ([*mixed* $len])

Genera una cadena base64 aleatoria Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len. Size formula: 4 * ($len / 3) and this need to be rounded up to a multiple of 4.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64(12); // 3rcq39QzGK9fUqh8

```

public **base64Safe** ([*mixed* $len], [*mixed* $padding])

Genera una cadena base64 aleatoria segura para URL Si $len no se especifica, se asume 16. Puede ser más grande en el futuro. La longitud de la cadena resultante suele ser mayor de $len. Por defecto, el relleno no se genera porque "=" se puede usar como un delimitador de URL. El resultado puede contener A-Z, a-z, 0-9, "-" y "_". "=" también se usa si $padding es verdadero. Consulte RFC 3548 para la definición de base64 segura para URL.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->base64Safe(); // GD8JojhzSTrqX7Q8J6uug

```

public **uuid** ()

Genera un UUID aleatorio v4 (identificador único universal) La versión 4 UUID es puramente aleatoria (excepto la versión). No contiene significado información como dirección MAC, hora, etc. Ver RFC 4122 para detalles del UUID. Este algoritmo establece el número de versión (4 bits) y dos bits reservados. Todos los demás bits (los 122 bits restantes) se establecen utilizando una fuente de datos aleatoria o pseudoaleatoria. Los UUID de versión 4 tienen la forma xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx donde x es cualquier dígito hexadecimal e y es uno de 8, 9, A o B (p. ej., f47ac10b-58cc-4372-a567-0e02b2c3d479).

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22

```

public **number** (*mixed* $len)

Generates a random number between 0 and $len Returns an integer: 0 <= result <= $len.

```php
<?php

$random = new \Phalcon\Security\Random();

echo $random->number(16); // 8

```

protected **base** (*mixed* $alphabet, *mixed* $base, [*mixed* $n])

Genera una cadena aleatoria basada en el número ($base) de caracteres ($alphabet). Si $n no se especifica, se supone 16. Puede ser más grande en el futuro.