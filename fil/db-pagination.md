<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Ang Pagination</a> 
      <ul>
        <li>
          <a href="#data-adapters">Mga Adapter ng datos</a>
        </li>
        <li>
          <a href="#examples">Examples</a>
        </li>
        <li>
          <a href="#using-adapters">Using Adapters</a>
        </li>
        <li>
          <a href="#page-attributes">Page Attributes</a>
        </li>
        <li>
          <a href="#custom">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Ang Pagination

Ang proseso ng pagination ay mangyayari kapag kailangan naming magpakita ng mga malalaking grupo ng arbitrary na datos nang paunti-unti. `Phalcon\Paginator` nag-aalok ng mabilis at madaling paraan para hatiin ang mga hanay ng datos na ito sa mga na-browse na pahina.

<a name='data-adapters'></a>

## Mga Adapter ng datos

Gumagamit ang komponent na ito ng mga adapter para i-encapsulate ang iba't ibang pinagkukunan ng datos:

| Adapter                                     | Description                                                                                                                                                                                                                                       |
| ------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Paginator\Adapter\NativeArray`  | Gamitin ang PHP na array bilang batayan ng datos                                                                                                                                                                                                  |
| `Phalcon\Paginator\Adapter\Model`        | Gumamit ng `Phalcon\Mvc\Model\Resultset` bagay bilang pinagmulan ng datos. Sapagka't hindi sinusuportahan ng PDO ang mga scrollable na cursor ang adapter na ito ay hindi dapat gamitin para i-paginate ng isang malaking bilang ng mga rekord |
| `Phalcon\Paginator\Adapter\QueryBuilder` | Gumamit ng isang `Phalcon\Mvc\Model\Query\Builder` bagay bilang pinagmulan ng datos                                                                                                                                                           |

<a name='factory'></a>

## Pabrika

Naglo-load ng klase ng Paginator Adapter gamit ang `adapter` na opsyon

```php
<?php

use Phalcon\Paginator\Factory;

$builder = $this->modelsManager->createBuilder()
                ->columns('id, name')
                ->from('Robots')
                ->orderBy('name');

$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
    'adapter' => 'queryBuilder',
];

$paginator = Factory::load($options);

```

<a name='examples'></a>

## Mga halimbawa

Sa halimbawa sa ibaba, gagamitin ng paginator ang resulta ng isang query mula sa isang modelo bilang pinagmulan ng datos nito, at nililimitahan ang ipinapakitang datos sa sampung mga rekord sa bawat pahina:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

// Kasalukuyang pahina na ipapakita
// Sa isang controller/component ito ay maaaring:
// $this->request->getQuery('page', 'int'); // GET
// $this->request->getPost('page', 'int'); // POST
$currentPage = (int) $_GET['page'];

// Ang set ng datos para i-paginate
$robots = Robots::find();

// Gumawa ng isang Modelo na paginator, magpakita ng sampung hanay sa pamamagitan ng pahina na nagsisimula mula sa $currentPage
$paginator = new PaginatorModel(
    [
        'data'  => $robots,
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Kunin ang mga resulta ng na-paginate
$page = $paginator->getPaginate();
```

Ang `$currentPage` na variable ay kinokontrol ang pahina na idi-display. Ang `$paginator->getPaginate()` ibinabalik ang isang `$page` na bagay na naglalaman ng na-paginate na datos. Maaari itong magamit para sa paglikha ng pagination:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Type</th>
    </tr>
    <?php foreach ($page->items as $item) { ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->type; ?></td>
    </tr>
    <?php } ?>
</table>
```

Ang `$page` bagay ay naglalaman din ng datos ng nabigasyon:

```php
<a href='/robots/search'>First</a>
<a href='/robots/search?page=<?= $page->before; ?>'>Previous</a>
<a href='/robots/search?page=<?= $page->next; ?>'>Next</a>
<a href='/robots/search?page=<?= $page->last; ?>'>Last</a>

<?php echo 'You are in page ', $page->current, ' of ', $page->total_pages; ?>
```

<a name='using-adapters'></a>

## Gamit ang mga Adapter

Isang halimbawa ng pinagmulan ng datos na dapat gamitin para sa bawat adapter:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

// Pagpasa ng isang resultet bilang datos
$paginator = new PaginatorModel(
    [
        'data'  => Products::find(),
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Pagpasa ng isang array bilang datos
$paginator = new PaginatorArray(
    [
        'data'  => [
            ['id' => 1, 'name' => 'Artichoke'],
            ['id' => 2, 'name' => 'Carrots'],
            ['id' => 3, 'name' => 'Beet'],
            ['id' => 4, 'name' => 'Lettuce'],
            ['id' => 5, 'name' => ''],
        ],
        'limit' => 2,
        'page'  => $currentPage,
    ]
);

// Pagpasa ng isang QueryBuilder bilang datos

$builder = $this->modelsManager->createBuilder()
    ->columns('id, name')
    ->from('Robots')
    ->orderBy('name');

$paginator = new PaginatorQueryBuilder(
    [
        'builder' => $builder,
        'limit'   => 20,
        'page'    => 1,
    ]
);
```

<a name='page-attributes'></a>

## Mga Attribute ng Pahina

Ang `$page` bagay ay may sumusunod na mga attribute:

| Katangian     | Deskripsyon                                                 |
| ------------- | ----------------------------------------------------------- |
| `items`       | Ang hanay ng mga rekord na ipapakita sa kasalukuyang pahina |
| `current`     | Ang kasalukuyang pahina                                     |
| `before`      | Ang nakaraang pahina para sa kasalukuyan                    |
| `next`        | Ang susunod na pahina sa kasalukuyan                        |
| `last`        | Ang huling pahina sa hanay ng mga rekord                    |
| `total_pages` | Ang bilang ng mga pahina                                    |
| `total_items` | Ang bilang ng mga aytem sa pinagmulan ng datos              |

<a name='custom'></a>

## Pagpapatupad ng iyong sariling mga adapter

Ang `Phalcon\Paginator\AdapterInterface` na interface ay dapat na ipatupad para makalikha ng iyong sariling adapter ng paginator o palawigin ang mga umiiral na:

```php
<?php

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

class MyPaginator implements PaginatorInterface
{
    /**
     * Adapter constructor
     *
     * @param array $config
     */
    public function __construct($config);

    /**
     * Itakda ang kasalukuyang numero ng pahina
     *
     * @param int $page
     */
    public function setCurrentPage($page);

    /**
     * Binabalik ang isang slice ng resultet para maipakita sa pagbilang ng pahina
     *
     * @return stdClass
     */
    public function getPaginate();
}
```