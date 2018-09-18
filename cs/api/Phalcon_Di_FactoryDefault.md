<h1>Class <strong>Phalcon\\Di\\FactoryDefault</strong></h1>

<p><em>extends</em> class <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p><em>implements</em> <a href="http://php.net/manual/en/class.arrayaccess.php">ArrayAccess</a>, <a href="/[[language]]/[[version]]/api/Phalcon_DiInterface">Phalcon\DiInterface</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/factorydefault.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<p>This is a variant of the standard Phalcon\\Di. By default it automatically
registers all the services provided by the framework. Thanks to this, the developer does not need
to register each service individually providing a full stack framework</p>

<h2>Methods</h2>

<p>public  <strong>__construct</strong> ()</p>

<p>Phalcon\\Di\\FactoryDefault constructor</p>

<p>public  <strong>setInternalEventsManager</strong> (<a href="/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface">Phalcon\Events\ManagerInterface</a> $eventsManager) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Sets the internal event manager</p>

<p>public  <strong>getInternalEventsManager</strong> () inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Returns the internal event manager</p>

<p>public  <strong>set</strong> (<em>mixed</em> $name, <em>mixed</em> $definition, [<em>mixed</em> $shared]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Registers a service in the services container</p>

<p>public  <strong>setShared</strong> (<em>mixed</em> $name, <em>mixed</em> $definition) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Registers an "always shared" service in the services container</p>

<p>public  <strong>remove</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Removes a service in the services container
It also removes any shared instance created for the service</p>

<p>public  <strong>attempt</strong> (<em>mixed</em> $name, <em>mixed</em> $definition, [<em>mixed</em> $shared]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Attempts to register a service in the services container
Only is successful if a service hasn't been registered previously
with the same name</p>

<p>public  <strong>setRaw</strong> (<em>mixed</em> $name, <a href="/[[language]]/[[version]]/api/Phalcon_Di_ServiceInterface">Phalcon\Di\ServiceInterface</a> $rawDefinition) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Sets a service using a raw Phalcon\\Di\\Service definition</p>

<p>public  <strong>getRaw</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Returns a service definition without resolving</p>

<p>public  <strong>getService</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Returns a Phalcon\\Di\\Service instance</p>

<p>public  <strong>get</strong> (<em>mixed</em> $name, [<em>mixed</em> $parameters]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Resolves the service based on its configuration</p>

<p>public <em>mixed</em> <strong>getShared</strong> (<em>string</em> $name, [<em>array</em> $parameters]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Resolves a service, the resolved service is stored in the DI, subsequent
requests for this service will return the same instance</p>

<p>public  <strong>has</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Check whether the DI contains a service by a name</p>

<p>public  <strong>wasFreshInstance</strong> () inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Check whether the last service obtained via getShared produced a fresh instance or an existing one</p>

<p>public  <strong>getServices</strong> () inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Return the services registered in the DI</p>

<p>public  <strong>offsetExists</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Check if a service is registered using the array syntax</p>

<p>public  <strong>offsetSet</strong> (<em>mixed</em> $name, <em>mixed</em> $definition) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Allows to register a shared service using the array syntax</p>

<pre><code class="php">&lt;?php

$di["request"] = new \Phalcon\Http\Request();

</code></pre>

<p>public  <strong>offsetGet</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Allows to obtain a shared service using the array syntax</p>

<pre><code class="php">&lt;?php

var_dump($di["request"]);

</code></pre>

<p>public  <strong>offsetUnset</strong> (<em>mixed</em> $name) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Removes a service from the services container using the array syntax</p>

<p>public  <strong>__call</strong> (<em>mixed</em> $method, [<em>mixed</em> $arguments]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Magic method to get or set services using setters/getters</p>

<p>public  <strong>register</strong> (<a href="/[[language]]/[[version]]/api/Phalcon_Di_ServiceProviderInterface">Phalcon\Di\ServiceProviderInterface</a> $provider) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Registers a service provider.</p>

<pre><code class="php">&lt;?php

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di-&gt;setShared('service', function () {
            // ...
        });
    }
}

</code></pre>

<p>public static  <strong>setDefault</strong> (<a href="/[[language]]/[[version]]/api/Phalcon_DiInterface">Phalcon\DiInterface</a> $dependencyInjector) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Set a default dependency injection container to be obtained into static methods</p>

<p>public static  <strong>getDefault</strong> () inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Return the latest DI created</p>

<p>public static  <strong>reset</strong> () inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Resets the internal default DI</p>

<p>public  <strong>loadFromYaml</strong> (<em>mixed</em> $filePath, [<em>array</em> $callbacks]) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Loads services from a yaml file.</p>

<pre><code class="php">&lt;?php

$di-&gt;loadFromYaml(
    "path/services.yaml",
    [
        "!approot" =&gt; function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);

</code></pre>

<p>And the services can be specified in the file as:</p>

<pre><code class="php">&lt;?php

myComponent:
    className: \Acme\Components\MyComponent
    shared: true

group:
    className: \Acme\Group
    arguments:

        - type: service
          name: myComponent

user:
   className: \Acme\User

</code></pre>

<p>public  <strong>loadFromPhp</strong> (<em>mixed</em> $filePath) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Loads services from a php config file.</p>

<pre><code class="php">&lt;?php

$di-&gt;loadFromPhp("path/services.php");

</code></pre>

<p>And the services can be specified in the file as:</p>

<pre><code class="php">&lt;?php

return [
     'myComponent' =&gt; [
         'className' =&gt; '\Acme\Components\MyComponent',
         'shared' =&gt; true,
     ],
     'group' =&gt; [
         'className' =&gt; '\Acme\Group',
         'arguments' =&gt; [
             [
                 'type' =&gt; 'service',
                 'service' =&gt; 'myComponent',
             ],
         ],
     ],
     'user' =&gt; [
         'className' =&gt; '\Acme\User',
     ],
];

</code></pre>

<p>protected  <strong>loadFromConfig</strong> (<a href="/[[language]]/[[version]]/api/Phalcon_Config">Phalcon\Config</a> $config) inherited from <a href="/[[language]]/[[version]]/api/Phalcon_Di">Phalcon\Di</a></p>

<p>Loads services from a Config object.</p>
