<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang tanaw">Naghihintay</a>
    </li>
    <li>
      <a href="$overview">Pagruruta</a> <ul>
        <li>
          <a href="$defining">Pagtukoy ng mga Ruta</a> <ul>
            <li>
              <a href="$defining-named-parameters">Mga Parameter na may mga Pangalan</a>
            </li>
            <li>
              <a href="$defining-short-syntax">Maikling Syntax</a>
            </li>
            <li>
              <a href="$defining-mixed-parameters">Paghahalo ng Array at Maikling Syntax</a>
            </li>
            <li>
              <a href="$defining-route-to-modules">Pagruruta ng mga Module</a>
            </li>
            <li>
              <a href="$defining-http-method-restrictions">Mga Paghihigpit na Paraan ng HTTP</a>
            </li>
            <li>
              <a href="$defining-using-conversors">Paggamit ng mga conversor</a>
            </li>
            <li>
              <a href="$defining-groups-of-routes">Grupo ng mga Ruta</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="$matching">Pagtutugma ng mga Ruta</a>
        </li>
        <li>
          <a href="$naming">Pagpapangalan ng mg Ruta</a>
        </li>
        <li>
          <a href="$usage">Ginagamit na mga Halimbawa</a>
        </li>
        <li>
          <a href="$default-behavior">Default na Pag-uugali</a>
        </li>
        <li>
          <a href="$default-route">I-set ang default na ruta</a>
        </li>
        <li>
          <a href="$not-found-paths">Hindi Makitang mga Daanan</a>
        </li>
        <li>
          <a href="$default-paths">I-set ang mga default na mga daanan</a>
        </li>
        <li>
          <a href="$extra-slashes">Pakikitungo kasama ang sobra/nagtrail na mga slash</a>
        </li>
        <li>
          <a href="$callbacks">Pagtutugma ng mga Muling Tumawag</a>
        </li>
        <li>
          <a href="$hostname-constraints">Pangalan ng Host na mga Humahadlang</a>
        </li>
        <li>
          <a href="$uri-sources">Mga Pinagkukunan ng URI</a>
        </li>
        <li>
          <a href="$testing">Pagsusubok sa mga ruta</a>
        </li>
        <li>
          <a href="$annotations">Mga Anotasyon ng mga Tagaruta</a>
        </li>
        <li>
          <a href="$registration">Halimbawang Pagrerehistro sa Tagaruta</a>
        </li>
        <li>
          <a href="$custom">Pagpapatupad ng iyong sariling Tagaruta</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Pagruruta

Ang bahagi ng tagaruta ay nagpapahintulot na bigyang kahulugan ang mga ruta na na mapa sa mga tagakontrol o mga dumadala na dapat tumanggap ng hiling. Ang tagaruta ay simpleng bumubukas ng isang URI upang malaman ang impormasyong ito. Ang tagaruta ay may dalawang mga mode: mode ng MVC at mode ng pagtutugma-lamang. Ang unang mode ay perpekto para sa pagtatrabaho kasama ang mga aplikasyon ng MVC.

<a name='defining'></a>

## Pagbibigay ng kahulugan sa mga Tagaruta

`Phalcon\Mvc\Router` nagbibigay ng maagang pagruruta na capabilidad. Sa mode ng MVC, pwede mong bigyang ng kahulugan ang mga ruta at i-mapa sila sa mga tagakontrol/mga aksyon na iyong kailangan. ang ruta ay binigyang ng kahulugan sa sumusunod:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

// Define a route
$router->add(
    '/admin/users/my-profile',
    [
        'controller' => 'users',
        'action'     => 'profile',
    ]
);

// Ibang Ruta
$router->add(
    '/admin/users/change-password',
    [
        'controller' => 'users',
        'action'     => 'changePassword',
    ]
);

$router->handle();
````

Ang unang parametro  ng `add()` na paraan ay ang palatandaan na gusto mong pagtugmain at, opsyonal na i-set ang parametro sa isang grupo ng mga daanan.
Sa kasong ito, kung ang URI ay `/admin/users/my-profile`, at ang `users` tagakontrol ng kanyang galaw `profile`ay magagawa na. Mahalagang tandaan na ang tagaruta ay hindi gumagawa ng tagakontrol at galaw, ito ay kumukuha lamang ng impormasyon upang ihatid sa wastong bahagi (i.e. `Phalcon\Mvc\Dispatcher`) na ito ay sang tagakontrol/galaw na dapat magawa.

Ang isang aplikasyon ay pwedeng magkaroon ng mga daanan at ang pagbibigay ng kahulugan isa-isa ay maaaring maging isang mapait na gawain. Sa kasong ito pwede tayong gumawa ng mas flexible na mga ruta:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

// Define a route
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
```

Sa halimbawa sa itaas, tayo ay gumagamit ng mga wilcards upang makagawa ng isang balidong ruta para sa maraming URIs, sa pagbukas ng mga sumusunod na URL (`/admin/users/a/delete/dave/301`) na makakagawa ng:

|  Tagakontrol  | Aksyon  | Parametro | Parametro |
|:-------------:|:-------:|:---------:|:---------:|
| mga gumagamit | burahin |   dave    |    301    |

Ang `lahat()` na paraan na tumanggap ng mga palatandaan na pwedeng opsyonal na magkaroon ng hindi pa nabibigyan ng kahulugan ng mga humahawak sa lugar at mga bumabago sa regular na ekspresyon. Lahat ng mga palatandaan ay dapt magsimula ng karakter na nasa unahang slash (`/`). Ang regular na ekspresyon syntax used sa parehong [PCRE regular expressions](http://www.php.net/manual/en/book.pcre.php). Tandaan, hindi kailangan na magdagdag ng regular na ekspresyon na tagalimit. Lahat ng ruta na palatandaan ay sensitibo sa kaso.

Ang pangalawang parametro na nagbibigay kahulugan sa magkatugmang bahagi ay dapat na nakatali sa tagakontrol/galaw/mga parametro. Ang magkatugmang mga bahagi ay tagahawak ng lugar o sangang palatandaan na nililimitahan ng panaklong(bilog na mga bracket). Sa halimbawang binigay sa itaas, ang unang sangang palatandaan na magkatugma (`:controller`) ay ang tagakontrol sa bahagi ng ruta. ang pangalawa na aksyon at marami pa.

Itong mga tagahawak ng lugar na tumutulong na sumulat ng regular na ekspresyon na mas mababasa para sa mga nagdedevelop at mas madaling maintindihan. Ang mga sumusunod na tagahawak ng lugar ay suportado:

| Tagahawak ng lugar    | Regular na Ekspresyon    | Ang Gamit                                                                                                                                     |
| --------------------- | ------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------- |
| `/:modyul`            | `/([a-zA-Z0-9\_\-]+)` | Pagtutugma ng isang balidong pangalan ng modyul na may letra-bilang na mga karakter lamang                                                    |
| `/:tagakontrol`       | `/([a-zA-Z0-9\_\-]+)` | Pagtutugma ng isang balidong pangalan ng tagakontrol na may letra-bilang na mga karakter lamang                                               |
| `/:aksyon`            | `/([a-zA-Z0-9_-]+)`      | Pagtutugma ng isang balidong pangalan ng aksyon na may letra-bilang na mga karakter lamang                                                    |
| `/:params`            | `(/.*)*`                 | Magkatugma sa listahan ng mga opsyonal na mga salita na hinihiwalay ng mga slash. Gumamit lamang nitong tagahawak ng lugar sa hulihan ng ruta |
| `/:pangalanngespasyo` | `/([a-zA-Z0-9\_\-]+)` | Tugma sa isang antas nga pangalan ng pangalan ng espasyo                                                                                      |
| `/:int`               | `/([0-9]+)`              | Tugma sa parametro ng integer                                                                                                                 |

Ang mga pangalan ng tagakontrol ay nakamelized na, na ang ibig sabihin na ang mga karakter (`-`) at (`_`) ay alisin ang ang susunod na karakter ay malaki ang mga titik. Halimbawa, some_controller ay nakonbert na saSomeController.

Dahil pwede kang magdagdag ng maraming mga ruta na kailangan gamit ang `add()` na paraan, ang pagkakasunod-sunod sa mga ruta na madadagdag na nagsasabi sa kanilang pagkakapareha, ang mga bagong ruta ay mas mara maraming pagkakapareha kaysa sa naunang nadagdag. Sa kalooban, sa lahat na nabigyan nga kahulugan ay nakatraverse sa baliktad na pagkakasunod hanggang`Phalcon\Mvc\Router` nakitang isang na magkatugma sa binigay na URI at mga proseso nito, habang binabaliwala ang natira.

<a name='defining-named-parameters'></a>

### Parametro kasama ang mga Pangalan

Ang halimbawa sa ibaba na nagpapakita kung paano bibigyan ng kahulugan ang pangalan upang maruta ang mga parametro:

```php
<?php

$router->add(
    '/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1, // ([0-9]{4})
        'month'      => 2, // ([0-9]{2})
        'day'        => 3, // ([0-9]{2})
        'params'     => 4, // :params
    ]
);
```

Sa itaas na halimbawa, ang ruta ay hindi nagbibigay ng isang `controller` o `action` na bahagi. Ang mga parteng ito ay napalitan na mga hindi nababagong mga halaga (`posts` at `show`). Ang gumagamit na hindi malalaman na ang tagakontrol ay talagang hindi na patch ng hiling. Sa loob ng tagakontrol, Iyong mga napangalanan na mga parametro ay pwedeng mabuksan sa mga sumusunod:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        // Get 'year' parameter
        $year = $this->dispatcher->getParam('year');

        // Get 'month' parameter
        $month = $this->dispatcher->getParam('month');

       // Get 'day' parameter
        $day = $this->dispatcher->getParam('day');

        // ...
    }
}
```

Tandaan na ang mga halaga na mga parametro ay nakuha galing sa mga tagadispatch. Nangyayari ito dahil ito ay bahagi na sa wakas na makipag-ugnay sa mga driver ng iyong aplikasyon. Sa karagdagan, walang ibang daan upang gumawa ng napangalang mga parametro bilang bahagi ng parte:

```php
<?php

$router->add(
    '/documentation/{chapter}/{name}.{type:[a-z]+}',
    [
        'controller' => 'documentation',
        'action'     => 'show',
    ]
);
```

Pwede mong buksan ang mga halaga nila sa parehong paraan gaya ng dati:

```php
<?php

use Phalcon\Mvc\Controller;

class DocumentationController extends Controller
{
    public function showAction()
    {
        // Get 'name' parameter
        $name = $this->dispatcher->getParam('name');

        // Get 'type' parameter
        $type = $this->dispatcher->getParam('type');

        // ...
    }
}
```

<a name='defining-short-syntax'></a>

### Maikling Syntax

Kung hindi mo gustong gumamit ng isang array upang bigyan ng kahulugan ang mga landas ng ruta, isang alternatibong syntax ay magagamit na din. Ang mga sumusunod na mga halimbawa ginagamit na nagawa sa parehong resulta:

```php
<?php

// Short form
$router->add(
    '/posts/{year:[0-9]+}/{title:[a-z\-]+}',
    'Posts::show'
);

// Array form
$router->add(
    '/posts/([0-9]+)/([a-z\-]+)',
    [
       'controller' => 'posts',
       'action'     => 'show',
       'year'       => 1,
       'title'      => 2,
    ]
);
```

<a name='defining-mixed-parameters'></a>

### Paghahalo ng Array at Maikling Syntax

Ang array at maikling syntax ay pwedeng bigyan ng kahulugan ng isang ruta, sa kasong ito tandaan na ang napanglang parametro na awtomatikong madagdag sa mga rutang landas ayon sa mga posisyon kung saan sila ay nabigyan ng kahulugan:

```php
<?php

// First position must be skipped because it is used for
// the named parameter 'country'
$router->add(
    '/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
    [
        'section' => 2, // Positions start with 2
        'article' => 3,
    ]
);
```

<a name='defining-route-to-modules'></a>

### Pagruruta sa mga Modyul

Pwede mong bigyan ng kahulugan iyong mga landas na isinama sa mga modyul. Ang mga ito ay espesyal na naangkop sa maramihang modyul na aplikasyon. Posible itong bigyan ng kahulugan amg mga default na ruta na nagsasabi na nagsasama ng isang modyul na wildcard:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router(false);

$router->add(
    '/:module/:controller/:action/:params',
    [
        'module'     => 1,
        'controller' => 2,
        'action'     => 3,
        'params'     => 4,
    ]
);
```

Sa kasong ito, amg ruta ay dapat palaging magkaroon ng pangalan ng modyul bilang bahagi ng URL. Halimbawa, ang mga sumusunod na URL: `/admin/users/edit/sonny`, ay maproproseso bilang:

|    Modyul    |  Tagakontrol  | Aksyon | Parametro |
|:------------:|:-------------:|:------:|:---------:|
| nangangasiwa | mga gumagamit | i-edit |   sonny   |

O pwede mong ibigkis ang tiyak na mga ruta sa tiyak na mga modyul:

```php
<?php

$router->add(
    '/login',
    [
        'module'     => 'backend',
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'module'     => 'frontend',
        'controller' => 'products',
        'action'     => 1,
    ]
);
```

O ibigkis sila sa tiyak na mga pangalan ng espasyo:

```php
<?php

$router->add(
    '/:namespace/login',
    [
        'namespace'  => 1,
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

Pangalan ng espasyo/klase na mga pangalan ay kailangan hiwalay na mapasa:

```php
<?php

$router->add(
    '/login',
    [
        'namespace'  => 'Backend\Controllers',
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

<a name='defining-http-method-restrictions'></a>

### Mga Paghihigpit ng Paraan ng HTTP

Kapag ikaw ay nagdagdag ng isang ruta gamit ang `add()`, ang ruta ay papaganahin sa kahit anong paraan ng HTTP. Minsan pwede nating higpitan ang isang ruta sa isang tiyak na paraan, ito ay espesyal na magagamit kapag gumagawa ng restful na mga aplikasyon:

```php
<?php

// This route only will be matched if the HTTP method is GET
$router->addGet(
    '/products/edit/{id}',
    'Products::edit'
);

// This route only will be matched if the HTTP method is POST
$router->addPost(
    '/products/save',
    'Products::save'
);

// This route will be matched if the HTTP method is POST or PUT
$router->add(
    '/products/update',
    'Products::update'
)->via(
    [
        'POST',
        'PUT',
    ]
);
```

<a name='defining-using-conversors'></a>

### Paggamit ng mga conversor

Ang mga Conversor ang nagpapahintulot sa iyo na malayang mag-iba ng anyo nga mga parametro ng ruta bago magpasa sa kanila sa mga tagadispatch. Ang mga sumusunod na mga halimbawa na ipapakita kung paano gamitin ito:

```php
<?php

// The action name allows dashes, an action can be: /products/new-ipod-nano-4-generation
$route = $router->add(
    '/products/{slug:[a-z\-]+}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'slug',
    function ($slug) {
        // Transform the slug removing the dashes
        return str_replace('-', '', $slug);
    }
);
```

Ibang gamit para sa mga conversor na nagtatali sa isang modelo sa isang ruta. Ito ay nagpapahintulot sa modelo na direktang mapasa sa aksyo na binigyang kahulugan:

```php
<?php

// This example works off the assumption that the ID is being used as parameter in the url: /products/4
$route = $router->add(
    '/products/{id}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'id',
    function ($id) {
        // Fetch the model
        return Product::findFirstById($id);
    }
);
```

<a name='defining-groups-of-routes'></a>

### Grupo ng mga Ruta

Kung ang isang grupo ng mga ruta ay mayroong landas na pwedeng mapabilang sa grupo upang madali silang mapanatili:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'index',
    ]
);

// All the routes start with /blog
$blog->setPrefix('/blog');

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// This route maps to a controller different than the default
$blog->add(
    '/blog',
    [
        'controller' => 'blog',
        'action'     => 'index',
    ]
);

// Add the group to the router
$router->mount($blog);
```

Pwede mong galawin ang mga grupo upang hiwalayin ang mga file upang maayos ang pag-unlad ng organisasyon at code na ginamit muli sa aplikasyon:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

class BlogRoutes extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            [
                'module'    => 'blog',
                'namespace' => 'Blog\Controllers',
            ]
        );

// All the routes start with /blog
        $this->setPrefix('/blog');

        // Add a route to the group
        $this->add(
            '/save',
            [
                'action' => 'save',
            ]
        );

        // Add another route to the group
        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

// This route maps to a controller different than the default
        $this->add(
            '/blog',
            [
                'controller' => 'blog',
                'action'     => 'index',
            ]
        );
    }
}
```

Pagkatapos i-mount sa grupo sa tagaruta:

```php
<?php

// Add the group to the router
$router->mount(
    new BlogRoutes()
);
```

<a name='matching'></a>

## Pagtutugma ng mga Ruta

Isang balidong URI ang dapat na ipasa sa Tagaruta para ito ay ma proseso at makahanap ng tugmang ruta. Sa default, ang pagruruta ng URI ay nakuha galing sa `$_GET['_url']` na varyabol na nagawa sa pagsulat muli ng makina ng modyul. Isang pares ng nasulat muli na mga alituntunin na gagana ng maayos kasama ang Phalcon ay:

```apacheconfig
RewriteEngine On
RewriteCond   %{REQUEST_FILENAME} !-d
RewriteCond   %{REQUEST_FILENAME} !-f
RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
```

Sa pagaayos na ito, kahit anong mga hiling sa mga file o mga folder na hindi umiiral ay mapapdala sa `index.php`. Ang mga sumusunod na halimbawa ay nagpapakita kung paano gamitin ang bahging ito sa isang mag-isang mode:

```php
<?php

use Phalcon\Mvc\Router;

// Creating a router
$router = new Router();

// Define routes here if any
// ...

// Taking URI from $_GET['_url']
$router->handle();

// Or Setting the URI value directly
$router->handle('/employees/edit/17');

// Getting the processed controller
echo $router->getControllerName();

// Getting the processed action
echo $router->getActionName();

// Get the matched route
$route = $router->getMatchedRoute();
 
Context | Edit Context;
```

<a name='naming'></a>

## Pagpapangalan ng mga Ruta

Sa isang ruta na madadagdag sa tagruta ay nanatili sa loob bilang `Phalcon\Mvc\Router\Route` na bagay. Ang klaseng ito nagpapakita ng kabuuan nga lahat ng detalye ng bawat isang ruta. Halimbawa, pwede tayong magbigay ng pangalan sa isang landas upng malaman natin naito ay nag-iisa at walang katulad na aplikasyon. Ito ay espesyal na magagamit kung gustu mong gumawa ng mga URLs galing dito.

```php
<?php

$route = $router->add(
    '/posts/{year}/{title}',
    'Posts::show'
);

$route->setName('show-posts');
```

Pagkatapos, gamit ang halimbawa ng bahagi ng `Phalcon\Mvc\Url` pwede tayong gumawa ng mga ruta galing sa kanyang pangalan:

```php
<?php

// Returns /posts/2012/phalcon-1-0-released
echo $url->get(
    [
        'for'   => 'show-posts',
        'year'  => '2012',
        'title' => 'phalcon-1-0-released',
    ]
);
```

<a name='usage'></a>

## Gingamit na mga Halimbawa

Ang mga sumusunod na mga halimbawa ay pinasadyang mga ruta:

```php
<?php

// Matches '/system/admin/a/edit/7001'
$router->add(
    '/system/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

// Matches '/es/news'
$router->add(
    '/([a-z]{2})/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
        'language'   => 1,
    ]
);

// Matches '/es/news'
$router->add(
    '/{language:[a-z]{2}}/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);

// Matches '/admin/posts/edit/100'
$router->add(
    '/admin/:controller/:action/:int',
    [
        'controller' => 1,
        'action'     => 2,
        'id'         => 3,
    ]
);

// Matches '/posts/2015/02/some-cool-content'
$router->add(
    '/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1,
        'month'      => 2,
        'title'      => 3,
    ]
);

// Matches '/manual/en/translate.adapter.html'
$router->add(
    '/manual/([a-z]{2})/([a-z\.]+)\.html',
    [
        'controller' => 'manual',
        'action'     => 'show',
        'language'   => 1,
        'file'       => 2,
    ]
);

// Matches /feed/fr/le-robots-hot-news.atom
$router->add(
    '/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}',
    'Feed::get'
);

// Matches /api/v1/users/peter.json
$router->add(
    '/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
    [
        'controller' => 'api',
        'version'    => 1,
        'format'     => 4,
    ]
);
```

<h5 class='alert alert-warning'>Mag-ingat sa mga karakter na pinahintulutan sa regular na ekspresyon para sa mga tagakontrol at mga espasyong pangpangalan. Na sila ay nagiging pangalan ng mga klase at sa pabalik sila ay napasa sa pamamagitan ng sistema ng file na magagamit nga mga aatake na babasa sa mga hindi pinapayagang bumukas sa mga file. Isang ligtas na ekspresyon ay <code>/([a-zA-Z0-9\_\-]+)</code> </h5>

<a name='default-behavior'></a>

## Default na Pag-uugali

`Phalcon\Mvc\Router` ay mayroong default na pag-uugali na nagbibigay na napakasimpleng pagruruta na palaging umaasa sa isang URI na tugma sa mga sumusunod na patter: `/:controller/:action/:params`

Para sa Halimbawa, para sa gamitong URL `http://phalconphp.com/documentation/show/about.html`, ang tagarutang ito ay magsasalin nito sa sumusunod:

|  Tagakontrol  | Aksyon  | Parametro  |
|:-------------:|:-------:|:----------:|
| dokumentasyon | ipakita | about.html |

Kung hindi mo gustong aang tagaruta na magkaroon ng ganitong pag-uugali kailangan mong gumawa pagpasa ng tagaruta `false` bilang unang parametro:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router without default routes
$router = new Router(false);
```

<a name='default-route'></a>

## I-set ang default na ruta

Kapag ang iyong aplikasyon ay binuksanna wlang ruta, ang '/' na ruta ay ginamit upang malaman ang landas na gagamitin upang maipakita ang mga simulang pahina sa iyong website/aplikasyon:

```php
<?php

$router->add(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

<a name='not-found-paths'></a>

## Hindi Makitang mga Daanan

Kung wala sa mga rutang natiyak sa tagaruta na tugma, pwede mong bigyan ng kahulugan ang isang grupo ng mga landas na ginamit sa pangyayaring ito:

```php
<?php

// Set 404 paths
$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'route404',
    ]
);
```

Ito ay kadalasa para sa Pagkakamaling 404 ng pahina.

<a name='default-paths'></a>

## I-set ang mga default na mga landas

Posibleng itong magbigay ng kahulugan sa mga default na mga halaga para sa modyul, tagkontrol, o aksyon. Kapag ang isang ruta ay nawawala na kahit anong mga landas nito sila ay awtomatikong pinupunan na tagruta:

```php
<?php

// Setting a specific default
$router->setDefaultModule('backend');
$router->setDefaultNamespace('Backend\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

// Using an array
$router->setDefaults(
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

<a name='extra-slashes'></a>

## Pakikitungo kasama ang sobra/nagtrail na mga slash

Minsan ang isang ruta ay pwedeng mabuksan ng sobra/nagtrail na mga slash. Iyong mga sobrang mga slash ay mangunguna na gumawa ng isang hindi makitang estado sa tagadispatch. Pwede mong i-set ang tagruta sa awtomatikong tumatanggal ng mga slash galing sa katapusang ng hinawakan na ruta:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// Remove trailing slashes automatically
$router->removeExtraSlashes(true);
```

O, pwede mong baguhin ang tiyak na mga ruta upang opsyonal na tanggapin ang mga nagtrail na mga slash:

```php
<?php

// The [/]{0,1} allows this route to have optionally have a trailing slash
$router->add(
    '/{language:[a-z]{2}}/:controller[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);
```

<a name='callbacks'></a>

## Match Callbacks

Minsan, ang mga ruta ay kailangan lamang na tugma kung sila nakatugon sa mga tiyak na mga kondisyon. Pwede kang magdagdag na mga arbitaryong mga kondisyon upang ang mga ruta gamit ang `beforeMatch()` pagtawag muli. Sa gamit na ito na bumalik `false`, ang ruta ay tratatuhin bilang isang hindi tugma:

```php
<?php

$route = $router->add('/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return false;
        }

        return true;
    }
);
```

Pwede mong gamitin muli ang mga sobrang kondisyon sa mga klase:

```php
<?php

class AjaxFilter
{
    public function check()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
```

At gamit ang klaseng ito sa halip ng isang hindi kilalang gamit:

```php
<?php

$route = $router->add(
    '/get/info/{id}',
    [
        'controller' => 'products',
        'action'     => 'info',
    ]
);

$route->beforeMatch(
    [
        new AjaxFilter(),
        'check'
    ]
);
```

Sa Phalcon 3, wala ng ibang daan para masuri ito:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        /**
         * @var string $uri
         * @var \Phalcon\Mvc\Router\Route $route
         * @var \Phalcon\DiInterface $this
         * @var \Phalcon\Http\Request $request
         */
        $request = $this->getShared('request');

        // Check if the request was made with Ajax
        return $request->isAjax();
    }
);
```

<a name='hostname-constraints'></a>

## Hostname Constraints

Ang tagaruta na iyong na-set ns mgs psnglsn ng host na humahadlang, ang ibig sabihin nito na ang tiyak na mga ruta o isang grupo na psedeng mapigilan upang matugma lamang kung ang isang ruta ay naktugon sa pangalan ng host na humahadlang:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

$route->setHostName('admin.company.com');
 
Context | Edit Context;
```

Ang pangalan ng host ay pwede mapasa bilang isang regular na ekspresyon:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

    $route->setHostName('([a-z]+).company.com');
```

Sa mga grupo na mga ruta pwede kang mag-set ng isang pangalan ng host na pwedeng maglagay para sa bawat isang ruta sa isang grupo:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'posts',
    ]
);

// Hostname restriction
$blog->setHostName('blog.mycompany.com');

// All the routes start with /blog
$blog->setPrefix('/blog');

// Default route
$blog->add(
    '/',
    [
        'action' => 'index',
    ]
);

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Add the group to the router
$router->mount($blog);
```

<a name='uri-sources'></a>

## URI Sources

Sa pamamagitan ng default ng URI na impormasyon na nakuha galing sa `$_GET['_url']` na varyabol, na napasa ng Pagsulat muli-Makina patungon sa Phalcon, pwede mo ring gamitin ang `$_SERVER['REQUEST_URI']` kung kinakailangan:

```php
<?php

use Phalcon\Mvc\Router;

// ...

// Use $_GET['_url'] (default)
$router->setUriSource(
    Router::URI_SOURCE_GET_URL
);

// Use $_SERVER['REQUEST_URI']
$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);
```

O pwede mong manu-manung ipasa ang isang URI sa `handle()` na paraan:

```php
<?php

$router->handle('/some/route/to/handle');
```

<h5 class='alert alert-danger'>Pakitandaan na ang paggamit sa <code>Router::URI_SOURCE_GET_URL</code> na awtomatikong nagdedecode ang Uri, dahil ito ay nakabase sa <code>$_REQUEST</code> pinakaglobal. Gayunpaman, pa sa ngayon, gamitin ang <code>Router::URI_SOURCE_SERVER_REQUEST_URI</code> ay hindi magdedecode ng awtomatiko sa Uri para sa iyo. Ito ay magbabago sa susunod na malaking pagbitaw.</h5>

<a name='testing'></a>

## Testing your routes

Dahil ang bahagi ay walang dinedependihan, pwede kang gumawa ng isang file na ipinakita upang masuri ang iyong mga ruta:

```php
<?php

use Phalcon\Mvc\Router;

// These routes simulate real URIs
$testRoutes = [
    '/',
    '/index',
    '/index/index',
    '/index/test',
    '/products',
    '/products/index/',
    '/products/show/101',
];

$router = new Router();

// Add here your custom routes
// ...

// Testing each route
foreach ($testRoutes as $testRoute) {
    // Handle the route
    $router->handle($testRoute);

    echo 'Testing ', $testRoute, '<br>';

    // Check if some route was matched
    if ($router->wasMatched()) {
        echo 'Controller: ', $router->getControllerName(), '<br>';
        echo 'Action: ', $router->getActionName(), '<br>';
    } else {
        echo "The route wasn't matched by any route<br>";
    }

    echo '<br>';
}
```

<a name='annotations'></a>

## Annotations Router

Ang bahaging ito ay nagbibigay ng isang magkaiba-iba na naisama sa [annotations](/[[language]]/[[version]]/annotations) na serbisyo. Gamit ang stratehiyang ito pwede kang sumulat nga mga ruta direkta sa mga tagakontrol sa halip na idagdagdag sila sa rehistrasyon ng serbisyo:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router. We're passing false as we don't want the router to add its default patterns
    $router = new RouterAnnotations(false);

    // Read the annotations from ProductsController if the URI starts with /api/products
    $router->addResource('Products', '/api/products');

    return $router;
};
```

Ang mga anotasyon ay pwedeng mabigyan ng kahulugan sa sumusunod na paraan:

```php
<?php

/**
 * @RoutePrefix('/api/products')
 */
class ProductsController
{
    /**
     * @Get(
     *     '/'
     * )
     */
    public function indexAction()
    {

    }

    /**
     * @Get(
     *     '/edit/{id:[0-9]+}',
     *     name='edit-robot'
     * )
     */
    public function editAction($id)
    {

    }

    /**
     * @Route(
     *     '/save',
     *     methods={'POST', 'PUT'},
     *     name='save-robot'
     * )
     */
    public function saveAction()
    {

    }

    /**
     * @Route(
     *     '/delete/{id:[0-9]+}',
     *     methods='DELETE',
     *     conversors={
     *         id='MyConversors::checkId'
     *     }
     * )
     */
    public function deleteAction($id)
    {

    }

    public function infoAction($id)
    {

    }
}
```

Iyong mga paraan na namarkahan lamanmna may balidong anotasyon na ginamit bilng mga ruta, Listahan ng mga anotasyon na suportado:

| Name        | Description                                                                                       | Usage                                  |
| ----------- | ------------------------------------------------------------------------------------------------- | -------------------------------------- |
| RoutePrefix | A prefix to be prepended to each route URI. This annotation must be placed at the class' docblock | `@RoutePrefix('/api/products')`        |
| Route       | This annotation marks a method as a route. This annotation must be placed in a method docblock    | `@Route('/api/products/show')`         |
| Get         | This annotation marks a method as a route restricting the HTTP method to `GET`                    | `@Get('/api/products/search')`         |
| Post        | This annotation marks a method as a route restricting the HTTP method to `POST`                   | `@Post('/api/products/save')`          |
| Put         | This annotation marks a method as a route restricting the HTTP method to `PUT`                    | `@Put('/api/products/save')`           |
| Delete      | This annotation marks a method as a route restricting the HTTP method to `DELETE`                 | `@Delete('/api/products/delete/{id}')` |
| Options     | This annotation marks a method as a route restricting the HTTP method to `OPTIONS`                | `@Option('/api/products/info')`        |

Para sa mga anotasyon na magdadagdag ng mga ruta, ang mga sumusunod na parametro ay suportado:

| Name       | Description                                                            | Usage                                                                |
| ---------- | ---------------------------------------------------------------------- | -------------------------------------------------------------------- |
| methods    | Define one or more HTTP method that route must meet with               | `@Route('/api/products', methods={'GET', 'POST'})`                   |
| name       | Define a name for the route                                            | `@Route('/api/products', name='get-products')`                       |
| paths      | An array of paths like the one passed to `Phalcon\Mvc\Router::add()` | `@Route('/posts/{id}/{slug}', paths={module='backend'})`             |
| conversors | A hash of conversors to be applied to the parameters                   | `@Route('/posts/{id}/{slug}', conversors={id='MyConversor::getId'})` |

Kung ikaw ay gumagamit ng mga modyul sa iyong aplikasyon, mas mabuti na gamitin ang `addModuleResource()` na paraan:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router
    $router = new RouterAnnotations(false);

    // Read the annotations from Backend\Controllers\ProductsController if the URI starts with /api/products
    $router->addModuleResource('backend', 'Products', '/api/products');

    return $router;
};
```

<a name='registration'></a>

## Registering Router instance

Pwede kang magrehistro ng tagaruta sa panahon ng pagrehistro ng serbisyo sa Phalcon ng malayang pagturok upang magamit sa loob ng tagakontrol.

Kailangan mong magdagdag ng code sa ibaba sa iyong bootstrap na file (para sa halimbawa `index.php` or `app/config/services.php`kung iyong gagamitin [Phalcon Developer Tools](http://phalconphp.com/en/download/tools).

```php
<?php

/**
 * Add routing capabilities
 */
$di->set(
    'router',
    function () {
        require __DIR__ . '/../app/config/routes.php';

        return $router;
    }
);
```

Kailangan mong gumawa ng `app/config/routes.php` at magdagdag ng tagaruta na nagsisimulang code, para sa halimbawa:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/login',
    [
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'controller' => 'products',
        'action'     => 1,
    ]
);

return $router;
```

<a name='custom'></a>

## Implementing your own Router

Ang `Phalcon\Mvc\RouterInterface` ng interface ay dapat na maipatupad upang gumawa ng iyong sariling tagaruta na pumupalit sa isang binigay ng Phalcon.