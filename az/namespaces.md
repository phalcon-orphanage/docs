<div class='article-menu' mark="crwd-mark">

<ul>
<li><a href="#overview">Working with Namespaces</a>

<ul>
<li><a href="#setting-up">Setting up the framework</a></li>
<li><a href="#controllers">Controllers in Namespaces</a></li>
<li><a href="#models">Models in Namespaces</a></li>
</ul></li>
</ul>

</div>

<p><a name='overview' mark="crwd-mark"></a></p>

<h1>Working with Namespaces</h1>

<p><a href="http://php.net/manual/en/language.namespaces.php">Namespaces</a> can be used to avoid class name collisions; this means that if you have two controllers in an application with the same name, a namespace can be used to differentiate them. Namespaces are also useful for creating bundles or modules.</p>

<p><a name='setting-up' mark="crwd-mark"></a></p>

<h2>Setting up the framework</h2>

<p>Using namespaces has some implications when loading the appropriate controller. To adjust the framework behavior to namespaces is necessary to perform one or all of the following tasks:</p>

<p>Use an autoload strategy that takes into account the namespaces, for example with <code>Phalcon\Loader</code>:</p>

<pre><code class="php">&lt;?php

$loader-&gt;registerNamespaces(
    [
       'Store\Admin\Controllers' =&gt; '../bundles/admin/controllers/',
       'Store\Admin\Models'      =&gt; '../bundles/admin/models/',
    ]
);
</code></pre>

<p>Specify it in the routes as a separate parameter in the route's paths:</p>

<pre><code class="php">&lt;?php

$router-&gt;add(
    '/admin/users/my-profile',
    [
        'namespace'  =&gt; 'Store\Admin',
        'controller' =&gt; 'Users',
        'action'     =&gt; 'profile',
    ]
);
</code></pre>

<p>Passing it as part of the route:</p>

<pre><code class="php">&lt;?php

$router-&gt;add(
    '/:namespace/admin/users/my-profile',
    [
        'namespace'  =&gt; 1,
        'controller' =&gt; 'Users',
        'action'     =&gt; 'profile',
    ]
);
</code></pre>

<p>If you are only working with the same namespace for every controller in your application, then you can define a default namespace in the <a href="/[[language]]/[[version]]/dispatcher">Dispatcher</a>, by doing this, you don't need to specify a full class name in the router path:</p>

<pre><code class="php">&lt;?php

use Phalcon\Mvc\Dispatcher;

// Registering a dispatcher
$di-&gt;set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher-&gt;setDefaultNamespace(
            'Store\Admin\Controllers'
        );

        return $dispatcher;
    }
);
</code></pre>

<p><a name='controllers' mark="crwd-mark"></a></p>

<h2>Controllers in Namespaces</h2>

<p>The following example shows how to implement a controller that use namespaces:</p>

<pre><code class="php">&lt;?php

namespace Store\Admin\Controllers;

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function profileAction()
    {

    }
}
</code></pre>

<p><a name='models' mark="crwd-mark"></a></p>

<h2>Models in Namespaces</h2>

<p>Take the following into consideration when using models in namespaces:</p>

<pre><code class="php">&lt;?php

namespace Store\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{

}
</code></pre>

<p>If models have relationships they must include the namespace too:</p>

<pre><code class="php">&lt;?php

namespace Store\Models;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this-&gt;hasMany(
            'id',
            'Store\Models\Parts',
            'robots_id',
            [
                'alias' =&gt; 'parts',
            ]
        );
    }
}
</code></pre>

<p>In PHQL you must write the statements including namespaces:</p>

<pre><code class="php">&lt;?php

$phql = 'SELECT r.* FROM Store\Models\Robots r JOIN Store\Models\Parts p';
</code></pre>
