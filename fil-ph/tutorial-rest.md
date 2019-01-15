<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang-ideya">Tutoryal: Paggawa ng isang Simpleng REST API</a> <ul>
        <li>
          <a href="#kahulugan">Pagtukoy sa API</a>
        </li>
        <li>
          <a href="#pagpapatupad">Paggawa ng Aplikasyon</a>
        </li>
        <li>
          <a href="#modelo">Paggawa ng Modelo</a>
        </li>
        <li>
          <a href="#pagkuha ng datos">Pagkahuha ng Datos</a>
        </li>
        <li>
          <a href="#pagpasok ng datos">Pagpasok ng Datos</a>
        </li>
        <li>
          <a href="#pagupdate ng datos">Pag-update ng Datos</a>
        </li>
        <li>
          <a href="#pagbura ng datos">Pagbura ng Datos</a>
        </li>
        <li>
          <a href="#pagsuri">Pagsusuri sa ating Aplikasyon</a>
        </li>
        <li>
          <a href="#konklusyon">Konklusyon</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tyutoryal: Paggawa ng Simpleng REST API

Sa tyutoryal na ito, aming ipapaliwanag kung paano gumawa ng simpleng aplikasyon na magbibigay ng [REStful](http://en.wikipedia.org/wiki/Representational_state_transfer) API gamit ang mga iba't-ibang HTTP na paraan:

- `KUHA` upang makuha at mahanap ang datos
- `POST` para magdagdag ng datos
- `ILAGAY` para ma-update ang datos
- `BURAHIN` para matanggal ang datos

<a name='definitions'></a>

## Pagbigay ng kahulugan ng API

Ang API ay binubuo ng mga sumusunod na paraan:

| Paraan    | URL                      | Aksyon                                                           |
| --------- | ------------------------ | ---------------------------------------------------------------- |
| `KUMUHA`  | /api//robots             | Kumukuha ng lahat ng mga robot                                   |
| `KUMUHA`  | /api/robots/search/Astro | Naghahanap ng mga robots na may 'Astro" sa kanilang mga pangalan |
| `KUMUHA`  | /api/robots/2            | Kinukuha ang mga robots base sa pangunahin na susi               |
| `I-POST`  | /api/robots              | Magdadagdag ng bagong robot                                      |
| `ILAGAY`  | /api/robots/2            | Mag-uupdate ng mga robot base sa pangunahin na susi              |
| `BURAHIN` | /api/robots/2            | Buburahin ang mga robot basin sa pangunahin na susi              |

<a name='implementation'></a>

## Paggawa ng Aplikasyon

Dahil ang aplikasyon ay napakasimple, hindi namin ipapatupad ang anumang buong paligid ng MVC para mapaunlad ito. Sa kasong ito, gagamitin natin ang [micro aplikasyon](/[[language]]/[[version]]/application-micro) para makamtan ang ating hangarin.

Ang sumusunod na file na istraktura ay sapat na:

```php
my-rest-api/
    mgamodelo/
        Robots.php
    index.php
    .htaccess
```

Una, kailangan nating ang `.htaccess` na file na naglalaman ng lahat ng mga utos kung paano isulat muli ang mga URl sa `index.php` na file, yan ang ating aplikasyon:

```apacheconfig
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

Ang bulto ng aming kodigo ay ilalagay sa `index.php`. Ang file ay ginawa katulad nito:

```php
<?php

gamitin ang Phalcon\Mvc\Micro;

$app = new Micro();

// Bigyang kahulugan ang mga daan dito

$app->handle();
```

Ngayon tayo ay gagawa ng mga daanan sa pagbibigay ng kahulugan ng nasa taas:

```php
<?php

gamitin ang Phalcon\Mvc\Micro;

$app = bagong Micro();

// Kukuha ng lahat ng mga robot
$app->get(
    '/api/robots',
    function () {

    }
);

// Maghahanap ng mga robot na may $name sa kanilang pangalan
$app->get(
    '/api/robots/search/{name}',
    function ($name) {

    }
);

// Kinukuha ang mga robot base sa pangunahin na susi
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) {

    }
);

// Magdadagdag ng bagong robot
$app->post(
    '/api/robots',
    function () {

    }
);

// Mag-update ng mga robot base sa pangunahin na susi
$app->put(
    '/api/robots/{id:[0-9]+}',
    function () {

    }
);

// Buburahin ang mga robot base sa pangunahin na susi
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function () {

    }
);

$app->handle();
```

Ang bawat daanan ay may kahulugan na paraan na may kaparehang pangalan bilang HTTP na paraan, bilang unang parameter malalampasan nating ang anyo ng ruta, sinusundan ng tagahawak. Sa kasong ito, ang tagahawak ay paraan na hindi nakikilala. Ang sumusunod na ruta: `/api/robots/{id:[0-9]+}`, halimbawa, nagtatakda ito na ang `id` na parameter ay kailangan mayroong numerik na format.

Kung ang nabigyang kahulugan na ruta ay nagkatugma sa hiniling na URl ang aplikasyon ay magpapatupad ng kaukulang tagahawak.

<a name='models'></a>

## Paggawa ng Modelo

Ang aming API ay nagbibigay ng mga impormasyon tungkol sa `robots`, ang mga datos na ito ay nakaimbak sa isang database. Ang sumusuno na modelo ay nagbibigay-daan para makuha ang talaan sa pamamagitan ng object-oriented na paraan. Naisagawa namin ang mga panuntunan sa negosyo gamit ang naka built-in na mga nagpapatunay at mga simple na mga pagpapatunay. Ang paggawa nito ay magbibigay sa amin ng kapayapaan sa isipan na ang naka impok na datos ay maitagpo ang mga pangangailangan para sa aming aplikasyon. Ang file ng modelo na ito ay dapat ilagay sa iyong `Models` na folder.

```php
<?php

namespace Store\Toys;

gamitin ang Phalcon\Mvc\Model;
gamitin ang Phalcon\Mvc\Model\Message;
gamitin ang Phalcon\Mvc\Model\Validator\Uniqueness;
gamitin ang Phalcon\Mvc\Model\Validator\InclusionIn;

ang klase ng mga robots ay nagpapahaba ng Modelo

{
    public function validation ()
    {
        // Ang tipo ay dapat na: droid, mekanikal o birtuwal
        $this->validate(
            new InclusionIn(
                [
                    'field' => 'type'.
                    'domain' => [
                        'droid',
                        'mechanical',
                        'virtual',
                    ],
                ]
            )
        );

        // Ang pangalan ng robot ay dapat kakaiba
        $this->validate(
            new Uniqueness(
                [
                    'field'   =>'name'
                    'mensahe' => 'Ang pangalan ng robot ay dapat kakaiba',
                ]
            )
        );

        // Ang taon ay dapat hindi bababa sa zero
        kung ($this->taon < 0) {
            $this->appendMessage(
                bagong Mensahe('Ang taon ay hindi dapat bababa sa zero')
            );
        }

        // Suriin kung ang mga mensahe ay naibigay
        kung ($this->validasyonayNabigo() ===totoo) {
            balik sa hindi totoo;
        }
    }
}
```

Ngayon, kailangan nating mag set-up ng koneksiyon na gagamitin ng model na ito at i-load ito sa loob ng ating app [File: `index.php`]:

```php
<?php

gamitin ang Phalcon\Loader;
gamitin ang Phalcon\Mvc\Micro;
gamitin ang Phalcon\Di\FactoryDefault;
gamitin ang Phalcon\Db\Adapter\Pdo\Mysql bilang PdoMysql;

// Gamiting ang Loader() para ma autoload ang modelo
$loader = bagong Loader();

$loader->registerNamespaces(
    [
        'Store\Toys' => __DIR__. '/mgamodelo/',
    ]
);

$loader->rehistro();

$di = bagong FactoryDefault();

// I-set up ang serbisyo ng database
$di->set(
    'db',
    function () {
        ibalik ang bagong PdoMysql(
            [
                'host'     =>; 'localhost',
                'username' =>; 'asimov',
                'password' =>; 'zeroth',
                'dbname'   =>; 'robotics',
            ]
        );
    }
);

// Gumawa at isama ang DI sa aplikasyon
$app = bagong MIcro($di);
```

<a name='retrieving-data'></a>

## Pagkuha ng Datos

Ang unang `tagahawak` na aming ipapatupad ay sa pamamagitan ng GET na magbabalik sa lahat ng mapapakinabangan na mga robot. Ating gamitin ang PHQL para maisagawa ang simpleng query pabalik sa resulta bilang jSON. [File: `index.php`]

```php
<?php

// Magkukuha ng lahat ng mga robot
$app->get(
    '/api/robots',
    function () use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Robots isunod bilang pangalan';

        $robots = $app->modelsManager->executeQuery($phql);

        $data = [];

        foreach ($robots as $robot) {
            $data[] = [
                'id'   => $robot->id,
                'name' => $robot->name,
            ];
        }

        echo json_encode($data);
    }
);
```

Ang [PHQL](/[[language]]/[[version]]/db-phql), ay nahihintulot sa atin na magsulat ng queries gamit ang isang matas na klase, object-oriented na SQL na wika na nagsasalin sa tamang SQL nga mga estamento depende sa sistema ng database na ating ginagamit. Ang sugnay na `gamitin` sa hindi nakikilalang paraan ay nagtutulot sa atin na ipasa ang ibang mga aligin galing sa global na saklaw papunta sa lokal sa madaling paraan.

Ang paghahanap ng pangalan na tagahawal ay magmukukhang `index.php`]:

```php
<?php

// Maghanap ng mga robot na may $name sa kanilang pangalan
$app->get(
    '/api/robots/search/{name}',
    function ($name) use ($app) {
        $phql = 'PILIIN * FROM Store\Toys\Robots WHERE name LIKE :name: ORDER BY name';

        $robots = $app->modelsManager->executeQuery(
            $phql,
            [
                'name' => '%' . $name . '%'
            ]
        );

        $data = [];

        foreach ($robots as $robot) {
            $data[] = [
                'id'   => $robot->id,
                'name' => $robot->name,
            ];
        }

        echo json_encode($data);
    }
);
```

Sa paghahanap sa paligid ng `id` ay magkapareha lamang, sa kaso na ito, tayo ay nagpapahayag kung ang robot ay nahanap o hindi [File: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Nagkukuha ng mga robot base sa pangunahin na susi
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * FROM Store\Toys\Robots WHERE id = :id:';

        $robot = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        )->getFirst();




        // Lumikha ng sagot
        $response = bagong sagot();

        if ($robot === false) {
            $response->setJsonContent(
                [
                    'status' => 'HINDI_NAHANAP'
                ]
            );
        } else {
            $response->setJsonContent(
                [
                    'status' => 'NAHANAP',
                    'data'   => [
                        'id'   => $robot->id,
                        'name' => $robot->name
                    ]
                ]
            );
        }

        return $response;
    }
);
```

<a name='inserting-data'></a>

## Pagpasok ng Datos

Pagkuha ng datos bilang JSON na string ay ipapasok sa katawan ng hiling, tayo ay gagamit din ng PHQL para sa pagpasok ng [File: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// Magdagdag ng bagong robot
$app->post(
    '/api/robots',
    function () use ($app) {
        $robot = $app->request->getJsonRawBody();

        $phql = 'IPASOK SA Store\Toys\Robots (name, type, year) VALUES (:name:, :type:, :year:)';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        // Lumikha ng sagot
        $response = bagong sagot();

        // Suriin kung matagumapy na naipasok
        if ($status->success() === true) {
            // Ibahin ang HTTP status
            $response->setStatusCode(201, 'Created');

            $robot->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $robot,
                ]
            );
        } else {
            // Ibahin ang HTTP status
            $response->setStatusCode(409, 'Conflict');

            // Ipasa ang mga mali sa kliyente
            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);
```

<a name='updating-data'></a>

## Pag-update ng Datos

Ang pag-update ng datos ay katulad sa pagpasok. Ang `id` na naipasa bilang parameter ay naghuhugyat kung anong robot ang dapat na ma update [File: `index.php`]:

```php
<?php

use Phalcon\Http\Response;

// I-update ang mga robot base sa pangunahing susi
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $robot = $app->request->getJsonRawBody();

        $phql = 'UPDATE Store\Toys\Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id'   => $id,
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        // Lumikha ng sagot
        $response = bagong sagot();

        // suriin kung matagumpay na naipasok
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Ibahin ang HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        bumalik $response;
    }
);
```

<a name='deleting-data'></a>

## Pagbura ng Datos

Ang pagbura ng datos ay katulad ng sa pag-update. Ang `id` naipasa bilang parameter ay nagtutukoy kung anong robot ang dapat na burahin [File: `index.php`]:

```php
<?php

gamitin ang Phalcon\Http\Response;

// Buburahin ang mga robot base sa pangunahin na susi
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE FROM Store\Toys\Robots WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        );

        // Lumikha ng sagot
        $response = bagong sagot();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Ibahin ang HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        bumalik $response;
    }
);
```

<a name='testing'></a>

## Pagsusuri sa ating Aplikasyon

Gamiting ang [curl](http://en.wikipedia.org/wiki/CURL) ating susubukin ang bawat ruta sa ating aplikasyon para malaman ang tamang operasyon.

Kunin ang lahat ng mga robot:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots

HTTP/1.1 200 OK
Petsa: Tue, 21 Jul 2015 07:05:13 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 117
Content-Type: text/html; charset=UTF-8

[{"id":"1","name":"Robotina"},{"id":"2","name":"Astro Boy"},{"id":"3","name":"Terminator"}]
```

Hanapin ang robot sa pangalan nito:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots/search/Astro

HTTP/1.1 200 OK
Petsa: Tue, 21 Jul 2015 07:09:23 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 31
Content-Type: text/html; charset=UTF-8

[{"id":"2","name":"Astro Boy"}]
```

Hanapin ang robot sa id nito:

```bash
curl -i -X GET http://localhost/my-rest-api/api/robots/3

HTTP/1.1 200 OK
Petsa: Tue, 21 Jul 2015 07:12:18 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 56
Content-Type: text/html; charset=UTF-8

{"status":"FOUND","data":{"id":"3","name":"Termin
```

Ipasok ang bagong robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
    http://localhost/my-rest-api/api/robots

HTTP/1.1 201 Created
Petsa: Tue, 21 Jul 2015 07:15:09 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 75
Content-Type: text/html; charset=UTF-8

{"status":"OK","data":{"name":"C-3PO","type":"droid","year":1977,"id":"4"}}
```

Subukan magpasok ng bagong robot gamit ang pangalan ng robot:

```bash
curl -i -X POST -d '{"name":"C-3PO","type":"droid","year":1977}'
    http://localhost/my-rest-api/api/robots

HTTP/1.1 409 Conflict
Petsa: Tue, 21 Jul 2015 07:18:28 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 63
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["Ang pangalan ng robot ay dapat kakaiba"]}
```

O i-update ang robot sa hindi alam na klase:

```bash
curl -i -X PUT -d '{"name":"ASIMO","type":"humanoid","year":2000}'
    http://localhost/my-rest-api/api/robots/4

HTTP/1.1 409 Conflict
Petsa: Tue, 21 Jul 2015 08:48:01 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 104
Content-Type: text/html; charset=UTF-8

{"status":"ERROR","messages":["Value of field 'type' must be part of
    list: droid, mechanical, virtual"]}
```

Sa katapusan, magbura ng robot:

```bash
curl -i -X BURAHIN http://localhost/my-rest-api/api/robots/4

HTTP/1.1 200 OK
PETSA: Tue, 21 Jul 2015 08:49:29 GMT
Server: Apache/2.2.22 (Unix) DAV/2
Content-Length: 15
Content-Type: text/html; charset=UTF-8

{"status":"OK"}
```

<a name='conclusion'></a>

## Konklusyon

Sa nakita natin, ang pagsagawa ng [Restful](http://en.wikipedia.org/wiki/Representational_state_transfer) na API gamit ang Phalcon ay madali gamit ang [micro na mga aplikasyon](/[[language]]/[[version]]/application-micro) at [PHQL](/[[language]]/[[version]]/db-phql).