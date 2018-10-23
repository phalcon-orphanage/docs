<div class='article-menu' mark="crwd-mark">
  <ul>
    <li>
      <a href="#overview">Generating URLs and Paths</a> 
      <ul>
        <li>
          <a href="#base-uri">Setting a base URI</a>
        </li>
        <li>
          <a href="#generating-uri">Generating URIs</a>
        </li>
        <li>
          <a href="#urls-without-mod-rewrite">Producing URLs without mod_rewrite</a>
        </li>
        <li>
          <a href="#urls-from-volt">Producing URLs from Volt</a>
        </li>
        <li>
          <a href="#static-vs-dynamic-uri">Static vs. Dynamic URIs</a>
        </li>
        <li>
          <a href="#custom-url">Implementing your own URL Generator</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<p><a name='overview' mark="crwd-mark"></a></p>

<h1>Generating URLs and Paths</h1>

<p><code>Phalcon\Mvc\Url</code> is the component responsible of generate URLs in a Phalcon application. It's capable of produce independent URLs based on routes.</p>

<p><a name='base-uri' mark="crwd-mark"></a></p>

<h2>Setting a base URI</h2>

<p>Depending of which directory of your document root your application is installed, it may have a base URI or not.</p>

<p>For example, if your document root is <code>/var/www/htdocs</code> and your application is installed in <code>/var/www/htdocs/invo</code> then your baseUri will be <code>/invo/</code>. If you are using a VirtualHost or your application is installed on the document root, then your baseUri is <code>/</code>. Execute the following code to know the base URI detected by Phalcon:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$url = new Url();

echo $url-&gt;getBaseUri();
</code></pre>

<p>By default, Phalcon automatically may detect your baseUri, but if you want to increase the performance of your application is recommended setting up it manually:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$url = new Url();

// Setting a relative base URI
$url-&gt;setBaseUri('/invo/');

// Setting a full domain as base URI
$url-&gt;setBaseUri('//my.domain.com/');

// Setting a full domain as base URI
$url-&gt;setBaseUri('http://my.domain.com/my-app/');
</code></pre>

<p>Usually, this component must be registered in the Dependency Injector container, so you can set up it there:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$di-&gt;set(
    'url',
    function () {
        $url = new Url();

        $url-&gt;setBaseUri('/invo/');

        return $url;
    }
);
</code></pre>

<p><a name='generating-uri' mark="crwd-mark"></a></p>

<h2>Generating URIs</h2>

<p>If you are using the <a href="/[[language]]/[[version]]/routing">Router</a> with its default behavior, your application is able to match routes based on the following pattern:</p>

<div class="alert alert-info" mark="crwd-mark">
    <p>
        /:controller/:action/:params
    </p>
</div>

<p>Accordingly it is easy to create routes that satisfy that pattern (or any other pattern defined in the router) passing a string to the method <code>get</code>:</p>

<pre><code class="php">&lt;?php echo $url-&gt;get('products/save'); ?&gt;
</code></pre>

<p>Note that isn't necessary to prepend the base URI. If you have named routes you can easily change it creating it dynamically. For Example if you have the following route:</p>

<pre><code class="php">&lt;?php

$router
    -&gt;add(
        '/blog/{year}/{month}/{title}',
        [
            'controller' =&gt; 'posts',
            'action'     =&gt; 'show',
        ]
    )
    -&gt;setName('show-post');
</code></pre>

<p>A URL can be generated in the following way:</p>

<pre><code class="php">&lt;?php

// This produces: /blog/2015/01/some-blog-post
$url-&gt;get(
    [
        'for'   =&gt; 'show-post',
        'year'  =&gt; '2015',
        'month' =&gt; '01',
        'title' =&gt; 'some-blog-post',
    ]
);
</code></pre>

<p><a name='urls-without-mod-rewrite' mark="crwd-mark"></a></p>

<h2>Producing URLs without mod_rewrite</h2>

<p>You can use this component also to create URLs without mod_rewrite:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$url = new Url();

// Pass the URI in $_GET['_url']
$url-&gt;setBaseUri('/invo/index.php?_url=/');

// This produce: /invo/index.php?_url=/products/save
echo $url-&gt;get('products/save');
</code></pre>

<p>You can also use <code>$_SERVER['REQUEST_URI']</code>:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$url = new Url();

// Pass the URI in $_GET['_url']
$url-&gt;setBaseUri('/invo/index.php?_url=/');

// Pass the URI using $_SERVER['REQUEST_URI']
$url-&gt;setBaseUri('/invo/index.php/');
</code></pre>

<p>In this case, it's necessary to manually handle the required URI in the Router:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Router;

$router = new Router();

// ... Define routes

$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

$router-&gt;handle($uri);
</code></pre>

<p>The produced routes would look like:</p>

<pre><code class="php">&lt;?php

// This produce: /invo/index.php/products/save
echo $url-&gt;get('products/save');
</code></pre>

<p><a name='urls-from-volt' mark="crwd-mark"></a></p>

<h2>Producing URLs from Volt</h2>

<p>The function <code>url</code> is available in volt to generate URLs using this component:</p>

<pre><code class="twig">&lt;a href='{{ url('posts/edit/1002') }}' mark="crwd-mark"&gt;Edit&lt;/a&gt;
</code></pre>

<p>Generate static routes:</p>

<pre><code class="twig">&lt;link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' /&gt;
</code></pre>

<p><a name='static-vs-dynamic-uri' mark="crwd-mark"></a></p>

<h2>Static vs. Dynamic URIs</h2>

<p>This component allow you to set up a different base URI for static resources in the application:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Url;

$url = new Url();

// Dynamic URIs are
$url-&gt;setBaseUri('/');

// Static resources go through a CDN
$url-&gt;setStaticBaseUri('http://static.mywebsite.com/');
</code></pre>

<p><code>Phalcon\Tag</code> will request both dynamic and static URIs using this component.</p>

<p><a name='custom-url' mark="crwd-mark"></a></p>

<h2>Implementing your own URL Generator</h2>

<p>The <code>Phalcon\Mvc\UrlInterface</code> interface must be implemented to create your own URL generator replacing the one provided by Phalcon.</p>
