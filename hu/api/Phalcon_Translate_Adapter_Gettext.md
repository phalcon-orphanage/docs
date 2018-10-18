<h1>Class <strong>Phalcon\\Translate\\Adapter\\Gettext</strong></h1>

<p><em>extends</em> abstract class <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p><em>implements</em> <a href="/en/3.2/api/Phalcon_Translate_AdapterInterface">Phalcon\Translate\AdapterInterface</a>, <a href="http://php.net/manual/en/class.arrayaccess.php">ArrayAccess</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/translate/adapter/gettext.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<pre><code class="php">&lt;?php

use Phalcon\Translate\Adapter\Gettext;

$adapter = new Gettext(
    [
        "locale"        =&gt; "de_DE.UTF-8",
        "defaultDomain" =&gt; "translations",
        "directory"     =&gt; "/path/to/application/locales",
        "category"      =&gt; LC_MESSAGES,
    ]
);

</code></pre>

<p>Allows translate using gettext</p>

<h2>Methods</h2>

<p>public  <strong>getDirectory</strong> ()</p>

<p>public  <strong>getDefaultDomain</strong> ()</p>

<p>public  <strong>getLocale</strong> ()</p>

<p>public  <strong>getCategory</strong> ()</p>

<p>public  <strong>__construct</strong> (<em>array</em> $options)</p>

<p>Phalcon\\Translate\\Adapter\\Gettext constructor</p>

<p>public  <strong>query</strong> (<em>mixed</em> $index, [<em>mixed</em> $placeholders])</p>

<p>Returns the translation related to the given key.</p>

<pre><code class="php">&lt;?php

$translator-&gt;query("你好 %name%！", ["name" =&gt; "Phalcon"]);

</code></pre>

<p>public  <strong>exists</strong> (<em>mixed</em> $index)</p>

<p>Check whether is defined a translation key in the internal array</p>

<p>public  <strong>nquery</strong> (<em>mixed</em> $msgid1, <em>mixed</em> $msgid2, <em>mixed</em> $count, [<em>mixed</em> $placeholders], [<em>mixed</em> $domain])</p>

<p>The plural version of gettext().
Some languages have more than one form for plural messages dependent on the count.</p>

<p>public  <strong>setDomain</strong> (<em>mixed</em> $domain)</p>

<p>Changes the current domain (i.e. the translation file)</p>

<p>public  <strong>resetDomain</strong> ()</p>

<p>Sets the default domain</p>

<p>public  <strong>setDefaultDomain</strong> (<em>mixed</em> $domain)</p>

<p>Sets the domain default to search within when calls are made to gettext()</p>

<p>public  <strong>setDirectory</strong> (<em>mixed</em> $directory)</p>

<p>Sets the path for a domain</p>

<pre><code class="php">&lt;?php

// Set the directory path
$gettext-&gt;setDirectory("/path/to/the/messages");

// Set the domains and directories path
$gettext-&gt;setDirectory(
    [
        "messages" =&gt; "/path/to/the/messages",
        "another"  =&gt; "/path/to/the/another",
    ]
);

</code></pre>

<p>public  <strong>setLocale</strong> (<em>mixed</em> $category, <em>mixed</em> $locale)</p>

<p>Sets locale information</p>

<pre><code class="php">&lt;?php

// Set locale to Dutch
$gettext-&gt;setLocale(LC_ALL, "nl_NL");

// Try different possible locale names for german
$gettext-&gt;setLocale(LC_ALL, "de_DE@euro", "de_DE", "de", "ge");

</code></pre>

<p>protected  <strong>prepareOptions</strong> (<em>array</em> $options)</p>

<p>Validator for constructor</p>

<p>protected  <strong>getOptionsDefault</strong> ()</p>

<p>Gets default options</p>

<p>public  <strong>setInterpolator</strong> (<a href="/en/3.2/api/Phalcon_Translate_InterpolatorInterface">Phalcon\Translate\InterpolatorInterface</a> $interpolator) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>...</p>

<p>public <em>string</em> <strong>t</strong> (<em>string</em> $translateKey, [<em>array</em> $placeholders]) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Returns the translation string of the given key</p>

<p>public <em>string</em> <strong>_</strong> (*string* $translateKey, [*array* $placeholders]) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Returns the translation string of the given key (alias of method 't')</p>

<p>public  <strong>offsetSet</strong> (<em>string</em> $offset, <em>string</em> $value) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Sets a translation value</p>

<p>public  <strong>offsetExists</strong> (<em>mixed</em> $translateKey) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Check whether a translation key exists</p>

<p>public  <strong>offsetUnset</strong> (<em>string</em> $offset) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Unsets a translation from the dictionary</p>

<p>public <em>string</em> <strong>offsetGet</strong> (<em>string</em> $translateKey) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Returns the translation related to the given key</p>

<p>protected  <strong>replacePlaceholders</strong> (<em>mixed</em> $translation, [<em>mixed</em> $placeholders]) inherited from <a href="/en/3.2/api/Phalcon_Translate_Adapter">Phalcon\Translate\Adapter</a></p>

<p>Replaces placeholders by the values passed</p>
