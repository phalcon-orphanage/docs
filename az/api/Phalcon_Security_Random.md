<h1>Class <strong>Phalcon\\Security\\Random</strong></h1>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/security/random.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>Secure random number generator class.</p>

<p>Provides secure random number generator which is suitable for generating
session key in HTTP cookies, etc.</p>

<p>It supports following secure random number generators:</p>

<ul>
<li>random_bytes (PHP 7)</li>
<li>libsodium</li>
<li>openssl, libressl</li>
<li>/dev/urandom</li>
</ul>

<p><code>Phalcon\\Security\\Random</code> could be mainly useful for:</p>

<ul>
<li>Key generation (e.g. generation of complicated keys)</li>
<li>Generating random passwords for new user accounts</li>
<li>Encryption systems</li>
</ul>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

// Random binary string
$bytes = $random-&gt;bytes();

// Random hex string
echo $random-&gt;hex(10); // a29f470508d5ccb8e289
echo $random-&gt;hex(10); // 533c2f08d5eee750e64a
echo $random-&gt;hex(11); // f362ef96cb9ffef150c9cd
echo $random-&gt;hex(12); // 95469d667475125208be45c4
echo $random-&gt;hex(13); // 05475e8af4a34f8f743ab48761

// Random base62 string
echo $random-&gt;base62(); // z0RkwHfh8ErDM1xw

// Random base64 string
echo $random-&gt;base64(12); // XfIN81jGGuKkcE1E
echo $random-&gt;base64(12); // 3rcq39QzGK9fUqh8
echo $random-&gt;base64();   // DRcfbngL/iOo9hGGvy1TcQ==
echo $random-&gt;base64(16); // SvdhPcIHDZFad838Bb0Swg==

// Random URL-safe base64 string
echo $random-&gt;base64Safe();           // PcV6jGbJ6vfVw7hfKIFDGA
echo $random-&gt;base64Safe();           // GD8JojhzSTrqX7Q8J6uug
echo $random-&gt;base64Safe(8);          // mGyy0evy3ok
echo $random-&gt;base64Safe(null, true); // DRrAgOFkS4rvRiVHFefcQ==

// Random UUID
echo $random-&gt;uuid(); // db082997-2572-4e2c-a046-5eefe97b1235
echo $random-&gt;uuid(); // da2aa0e2-b4d0-4e3c-99f5-f5ef62c57fe2
echo $random-&gt;uuid(); // 75e6b628-c562-4117-bb76-61c4153455a9
echo $random-&gt;uuid(); // dc446df1-0848-4d05-b501-4af3c220c13d

// Random number between 0 and $len
echo $random-&gt;number(256); // 84
echo $random-&gt;number(256); // 79
echo $random-&gt;number(100); // 29
echo $random-&gt;number(300); // 40

// Random base58 string
echo $random-&gt;base58();   // 4kUgL2pdQMSCQtjE
echo $random-&gt;base58();   // Umjxqf7ZPwh765yR
echo $random-&gt;base58(24); // qoXcgmw4A9dys26HaNEdCRj9
echo $random-&gt;base58(7);  // 774SJD3vgP

</code></pre>

<p>This class partially borrows SecureRandom library from Ruby</p>

<h2>Methods</h2>

<p>public  <strong>bytes</strong> ([<em>mixed</em> $len])</p>

<p>Generates a random binary string
The <code>Random::bytes</code> method returns a string and accepts as input an int
representing the length in bytes to be returned.
If $len is not specified, 16 is assumed. It may be larger in future.
The result may contain any byte: "x00" - "xFF".</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

$bytes = $random-&gt;bytes();
var_dump(bin2hex($bytes));
// Possible output: string(32) "00f6c04b144b41fad6a59111c126e1ee"

</code></pre>

<p>public  <strong>hex</strong> ([<em>mixed</em> $len])</p>

<p>Generates a random hex string
If $len is not specified, 16 is assumed. It may be larger in future.
The length of the result string is usually greater of $len.</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;hex(10); // a29f470508d5ccb8e289

</code></pre>

<p>public  <strong>base58</strong> ([<em>mixed</em> $len])</p>

<p>Generates a random base58 string
If $len is not specified, 16 is assumed. It may be larger in future.
The result may contain alphanumeric characters except 0, O, I and l.
It is similar to <code>Phalcon\\Security\\Random:base64</code> but has been modified to avoid both non-alphanumeric
characters and letters which might look ambiguous when printed.</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;base58(); // 4kUgL2pdQMSCQtjE

</code></pre>

<p>public  <strong>base62</strong> ([<em>mixed</em> $len])</p>

<p>Generates a random base62 string
If $len is not specified, 16 is assumed. It may be larger in future.
It is similar to <code>Phalcon\\Security\\Random:base58</code> but has been modified to provide the largest value that can
safely be used in URLs without needing to take extra characters into consideration because it is [A-Za-z0-9].</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;base62(); // z0RkwHfh8ErDM1xw

</code></pre>

<p>public  <strong>base64</strong> ([<em>mixed</em> $len])</p>

<p>Generates a random base64 string
If $len is not specified, 16 is assumed. It may be larger in future.
The length of the result string is usually greater of $len.
Size formula: 4 * ($len / 3) and this need to be rounded up to a multiple of 4.</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;base64(12); // 3rcq39QzGK9fUqh8

</code></pre>

<p>public  <strong>base64Safe</strong> ([<em>mixed</em> $len], [<em>mixed</em> $padding])</p>

<p>Generates a random URL-safe base64 string
If $len is not specified, 16 is assumed. It may be larger in future.
The length of the result string is usually greater of $len.
By default, padding is not generated because "=" may be used as a URL delimiter.
The result may contain A-Z, a-z, 0-9, "-" and "_". "=" is also used if $padding is true.
See RFC 3548 for the definition of URL-safe base64.</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;base64Safe(); // GD8JojhzSTrqX7Q8J6uug

</code></pre>

<p>public  <strong>uuid</strong> ()</p>

<p>Generates a v4 random UUID (Universally Unique IDentifier)
The version 4 UUID is purely random (except the version). It doesn't contain meaningful
information such as MAC address, time, etc. See RFC 4122 for details of UUID.
This algorithm sets the version number (4 bits) as well as two reserved bits.
All other bits (the remaining 122 bits) are set using a random or pseudorandom data source.
Version 4 UUIDs have the form xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx where x is any hexadecimal
digit and y is one of 8, 9, A, or B (e.g., f47ac10b-58cc-4372-a567-0e02b2c3d479).</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;uuid(); // 1378c906-64bb-4f81-a8d6-4ae1bfcdec22

</code></pre>

<p>public  <strong>number</strong> (<em>mixed</em> $len)</p>

<p>Generates a random number between 0 and $len
Returns an integer: 0 <= result <= $len.</p>

<pre><code class="php">&lt;?php

$random = new \Phalcon\Security\Random();

echo $random-&gt;number(16); // 8

</code></pre>

<p>protected  <strong>base</strong> (<em>mixed</em> $alphabet, <em>mixed</em> $base, [<em>mixed</em> $n])</p>

<p>Generates a random string based on the number ($base) of characters ($alphabet).
If $n is not specified, 16 is assumed. It may be larger in future.</p>
