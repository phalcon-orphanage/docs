<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang-ideya">Multi-lingual na Suporta</a> <ul>
        <li>
          <a href="#mga adaptor">Mga adapter</a>
        </li>
        <li>
          <a href="#paggamit">Paggamit ng mga bahagi</a>
        </li>
        <li>
          <a href="#kaugalian">Pagsasagawa ng sariling mga adaptor</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Multi-lingual na Suporta

Ang bahagi na `Phalcon\\Translate` ay nakakatulong sa paggawa ng mga multilingual na aplikasyon. Mga aplikasyon na gumagamit ng mga bahagi na ito, nagpapakita ng mga laman sa iba''t-ibang wika, batay sa napiling wika ng tagagamit na sinusuportahan ng aplikasyon.

<a name='adapters'></a>

## Mga Adaptor

Ang bahagi na ito ay gagamit ng mga adaptor para mabasa ang mga pagsasalin ng mga mensahe galing sa iba't-ibang pinagmulan sa isang uniporme na paraan,.

| Adaptor                                     | Deskripsyon                                                                                                   |
| ------------------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Pagsasalin\Adapter\NativeArray` | Ginagamit ang PHP arrays para i-impok ang mga mensahe. Ito ay pinakamahusay na opsiyon pagdating sa pagganap. |

<a name='usage'></a>

## Paggamit ng mga bahagi

Ang mga strings sa pagsasalin ay naka-imbak sa mga file. Ang istraktura ng mga file na ito ay maaring mag-iba depende sa uri ng adaptor na ginamit. Ang Phalcon ay nagbibigay sayo ng kalayaan para isaayos ang iyong mga strings sa pagsasalin. Ang isang simple na istraktura ay maaring:

```bash
app/messages/en.php
app/messages/es.php
app/messages/fr.php
app/messages/zh.php
```

Ang bawat file ay naglalaman ng iba't-ibang pagsasalin sa isang susi/halaga na paraan,. Sa bawat pagsasalin na file, ang mga susi ay kakaiba. Ang parehong ayos ay ginagamit sa iba't-ibang mga file, kung saan ang mga susi ay nananatiling magkapareho at ang mga value ay naglalaman ng mga naisalin na mga strings depende sa bawat wika.

```php
<?php

// app/messages/en.php
$messages = [
    'hi'      =>'Hello',
    'bye'    =>"Paalam',
    'hi-pangalan' =>'Hello %name%',
    'kanta'      =>'Ang kanta na ito ay %song%',
];
```

```php
<?php

// app/messages/fr.php
$messages = [
    'hi'     =>'Bonjour',
    'bye'   =>'Au revoir',
    'hi-pangalan' =>'Bonjour %name%',
    'kanta'    =>La chanson est %song%',
];
```

Pagpapatupad ng mekanismo ng pagsasalin sa iyong aplikasyon ay pangkaraniwan ngunit ito ay naka depende kung paano mo gusto ipatupad ito. Maari kang gumamit ng awtomatikong nagtutukoy ng wika mula sa browser ng tagagamit o maari kang magbigay ng pahina ng settings kung saan ang tagagamit ay makakapili ng kanilang wika.

Ang simpleng paraan ng pagtutukoy ng wika ng tagagamit ay ihiwalay ang `$_SERVER['HTTP_ACCEPT_LANGUAGE']` na nilalaman, o kung gusto mo na ipasok ito ng direkta sa pamamagitan ng pagtawag ng `$this->request->getBestLanguage()` galing sa aksyon/kontroler:

```php
<?php

gamiting ang Phalcon\Mvc\Kontroler;
gamitin ang Phalcon\Translate\Adapter\NativeArray;

klase UserController nagpapahaba ng Kontroler
{
    nakaprotekta na paraan getTranslation()
    {
        //Tanungin ang browser kung ano ang pinakamabuting wika
        $language = $this->request->getBestLanguage();

        $translationFile = 'app/messages/' . $language . '.php';

        // Suriin kung mayroon tayong file ng pagsasalin para sa wika na yan
         kung (file_exists($translationFile)) {
            kailangan $translationFile;
        } iba {
            // Bumalik sa ibang default
            kailangan 'app/messages/en.php';
        }

        // Ibalik ang bagay ng pagsasalin $messages galing sa kinakailangan
        // pahayag sa taas
        ibalik ang bagong NativeArray(
            [
                'content' =>$messages,
            ]
        );
    }

    publiko na paraan indexAction()
    {
        $this->view->pangalan = 'Mike';
        $this->view->   = $this->getTranslation();
    }
}
```

Ang `_getTranslation()` na paraan ay magagamit sa lahat ng aksyon na nangangailangan ng pagsasalin. Ang `$t` na aligin ay ipinapasa sa mga views, at kasama nito, makakapagsalin tayo ng strings sa ganyan na patong:

.. code-block:: html+php

    <!-- welcome -->
    <-- String: hi => 'Hello' -->
    <p><?php echo $t->_('hi'),'', $name; ?></p>
    

Ang `_()` na paraan ay ibinabalik ang nasalin na string base sa index na naipasa. Ang ibang strings ay kailangan ilakip ang placeholders para kuwentahin ang data i.e. `Hello %name%`. Ang mga placeholders na ito ay maaring palitan sa naipasa na talaan sa `_()` na paraan. Ang naipasa na mga talaan ay nasa porma ng susi/halaga na array, kung saan ang susi ay katulad sa placeholder na pangalangan at ang halaga ay ang aktwal na data na papalitan:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_(hi-name', ['pangalan' => $name]); ?></p>
```

Ang ibang aplikasyon ay nagpapatupad ng multilingual sa URL katulad ng `http://www.mozilla.org/**es-ES**/firefox/`. Ang Phalcon ay maaring magpatupad nito sa pamamagitan ng paggamit ng isang [Tagaruta](/[[language]]/[[version]]/routing).

<a name='custom'></a>

## Pagsasagawa ng sarili mong mga adaptor

Ang `Phalcon\Translate\AdapterInterface` interface ay dapat maipatupad para makalikha ng sarili mong mga adaptor sa pagsasalin o palawigin ang mga kasulukuyang nakasali:

```php
<?php

gamitin ang Phalcon\Translate|AdapterInterface;

klase MyTranslateAdapter nagsasagawa ng AdapterInterface
{
    /**
     * Tagagawa ng adaptor
     *
     * @param array $options
     */
    publiko function _construct(array $options);

    /**
     * Ibabalik ang string ng nasalin sa naibigay na susi
     *
     * @param   string $translateKey
     * @param    array $placeholders
     * @return    string
     */
    publiko function _(string $translateKey, $placeholders = null); string:

    /**
     * Ibabalik ang naisalin ayun sa naibigay na susi
     *
     * @param    string $index
     * @param    array $placeholders
     * @return    string
     */
    publiko function query(string $index, $placeholders = null): string:

    /**
     * Suriin kung ang naisalin na susi ay nasa loob ng array
     *
     * @param   string $index
     *@return   bool
     */
     publiko na tungkulin ay umiiral(string $index): bool;
}
```

Mayroong marami na mga adaptor na magagamit para sa bahagi na ito sa [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)