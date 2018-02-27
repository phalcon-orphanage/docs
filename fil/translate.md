<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Multi-lingual Support</a> 
      <ul>
        <li>
          <a href="#adapters">Adapters</a>
        </li>
        <li>
          <a href="#usage">Component Usage</a>
        </li>
        <li>
          <a href="#custom">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Multi-lingual Support

The component `Phalcon\Translate` aids in creating multilingual applications. Applications using this component, display content in different languages, based on the user's chosen language supported by the application.

<a name='adapters'></a>

## Adapters

This component makes use of adapters to read translation messages from different sources in a unified way.

| Adapter                                    | Description                                                                             |
| ------------------------------------------ | --------------------------------------------------------------------------------------- |
| `Phalcon\Translate\Adapter\NativeArray` | Uses PHP arrays to store the messages. This is the best option in terms of performance. |

<a name='adapters-factory'></a>

### Factory

Loads Translate Adapter class using `adapter` option

```php
<?php

use Phalcon\Translate\Factory;

$options = [
    'locale'        => 'de_DE.UTF-8',
    'defaultDomain' => 'translations',
    'directory'     => '/path/to/application/locales',
    'category'      => LC_MESSAGES,
    'adapter'       => 'gettext',
];

$translate = Factory::load($options);
```

<a name='usage'></a>

## Component Usage

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

Pagpapatupad ng mekanismo ng pagsasalin sa iyong aplikasyon ay pangkaraniwan ngunit ito ay naka depende kung paano mo gusto ipatupad ito. You can use an automatic detection of the language from the user's browser or you can provide a settings page where the user can select their language.

Ang simpleng paraan ng pagtutukoy ng wika ng tagagamit ay ihiwalay ang `$_SERVER['HTTP_ACCEPT_LANGUAGE']` na nilalaman, o kung gusto mo na ipasok ito ng direkta sa pamamagitan ng pagtawag ng `$this->request->getBestLanguage()` galing sa aksyon/kontroler:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class UserController extends Controller
{
    protected function getTranslation()
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();
        $messages = [];

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

```php
<!-- welcome -->
<!-- String: hi => 'Hello' -->
<p><?php echo $t->_('hi'), ' ', $name; ?></p>
```

Ang `_()` na paraan ay ibinabalik ang nasalin na string base sa index na naipasa. Ang ibang strings ay kailangan ilakip ang placeholders para kuwentahin ang data i.e. `Hello %name%`. Ang mga placeholders na ito ay maaring palitan sa naipasa na talaan sa `_()` na paraan. Ang naipasa na mga talaan ay nasa porma ng susi/halaga na array, kung saan ang susi ay katulad sa placeholder na pangalangan at ang halaga ay ang aktwal na data na papalitan:

```php
<!-- welcome -->
<!-- String: hi-name => 'Hello %name%' -->
<p><?php echo $t->_(hi-name', ['pangalan' => $name]); ?></p>
```

Ang ibang aplikasyon ay nagpapatupad ng multilingual sa URL katulad ng `http://www.mozilla.org/**es-ES**/firefox/`. Phalcon can implement this by using a [Router](/[[language]]/[[version]]/routing).

The implementation above is helpful but it requires a base controller to implement the `_getTranslation()` and return the `Phalcon\Translate\Adapter\NativeArray` component. Additionaly the component needs to be set in the view as seen above in the `$t` variable.

You can always wrap this functionality in its own class and register that class in the DI container:

```php
<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Component
{
    public function getTranslator()
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();

        /**
         * We are using JSON based files for storing translations. 
         * You will need to check if the file exists! 
         */
        $translations = json_decode(
            file_get_contents('app/messages/' . $language . '.json'),
            true
        );

        // Return a translation object $messages comes from the require
        // statement above
        return new NativeArray(
            [
                'content' => $translations,
            ]
        );
    }
}
```

This way you can use the component in controllers:

```php
<?php

use Phalcon\Mvc\Controller;

class MyController extends Controller
{
    public function indexAction()
    {
        $name = 'Mike';
        $text = $this->locale->_('hi-name', ['name' => $name]);

        $this->view->text = $text;
    }
}
```

or in a view directly

```php
<?php echo $locale->_('hi-name', ['name' => 'Mike']);
```

<a name='custom'></a>

## Implementing your own adapters

Ang `Phalcon\Translate\AdapterInterface` interface ay dapat maipatupad para makalikha ng sarili mong mga adaptor sa pagsasalin o palawigin ang mga kasulukuyang nakasali:

```php
<?php

use Phalcon\Translate\AdapterInterface;

class MyTranslateAdapter implements AdapterInterface
{
    /**
     * Adapter constructor
     *
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param  string     $translateKey
     * @param  array|null $placeholders
     * @return string
     */
    public function t($translateKey, $placeholders = null);

    /**
     * Returns the translation string of the given key
     *
     * @param   string $translateKey
     * @param   array $placeholders
     * @return  string
     */
    public function _(string $translateKey, $placeholders = null): string;

    /**
     * Returns the translation related to the given key
     *
     * @param   string $index
     * @param   array $placeholders
     * @return  string
     */
    public function query(string $index, $placeholders = null): string;

    /**
     * Check whether is defined a translation key in the internal array
     *
     * @param   string $index
     * @return  bool
     */
    public function exists(string $index): bool;
}
```

Mayroong marami na mga adaptor na magagamit para sa bahagi na ito sa [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Translate/Adapter)