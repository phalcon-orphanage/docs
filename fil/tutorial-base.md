<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangunahin">Tyutoryal - pangunahin</a> 
      <ul>
        <li>
          <a href="#balangaks ng mga talaan">Balangkas ng mga Talaan</a>
        </li>
        <li>
          <a href="#bootstrap">Bootstrap</a> 
          <ul>
            <li>
              <a href="#autoloaders">Autoloaders</a>
            </li>
            <li>
              <a href="#pamamahala ng Umaasa">Pamamahala ng Umaasa</a>
            </li>
            <li>
              <a href="#kahilingan">Pangangasiwa ng kahilingan na aplikasyon</a>
            </li>
            <li>
              <a href="#buong-halimbawa">Pagsama-samahin ang lahat</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#kontroler">Paggawa ng Kontroler</a>
        </li>
        <li>
          <a href="#view">Pagpapadala ng output sa pananaw</a>
        </li>
        <li>
          <a href="#signup-form">Pagdisenyo ng sign-up na uri</a>
        </li>
        <li>
          <a href="#modelo">Paggawa ng Modelo</a>
        </li>
        <li>
          <a href="#database-koneksiyon">Paglalagay ng Koneksyon sa Database</a>
        </li>
        <li>
          <a href="#pagiimpok-data">Pag-iimbak ng datos gamit ang mga modelo</a>
        </li>
        <li>
          <a href="#konklusyon">Konklusyon</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='basic'></a>

# Tyutoryal - pangunahin

Sa boong tyutoryal na ito, ipapakita namin sa iyo ng kompleto ang pagsasagawa ng isang aplikasyon kasama ang simpleng uri ng rehistrasyon. Ang sumusunod na gabay ay inilaan para ipakilala sa iyo ang mga aspeto ng desinyo ng balangkas ng Phalcon.

Kung nais mo lang magsimula maari mong laktawan ito at lumikha ng awtomatiko na proyekto ng Phalcon gamit ang [kasangkapan ng ilustrador](/[[language]]/[[version]]/devtools-usage). (Inimumungkahi na kung ikaw ay walang karanasan maaring bumalik ka dito kung ikaw ay natigil)

Ang pinakamahusay na paraan upang gamitin ang gabay na ito ay sumunod lang at subukang maglibang. Maari mong makuha ang kompleto na palahudyatan [dito](https://github.com/phalcon/tutorial). Kung ikaw ay natigil sa anumang bagay maaring bisitahin kami sa [salungatan](https://phalcon.link/discord) o sa aming [Forum](https://phalcon.link/forum)

<a name='file-structure'></a>

## Balangkas ng mga Talaan

Ang tampok na susi ng Phalcon ay ang **maluwag na paress**, maari kang magtayo ng isang Phalcon na proyekto gamit ang direktoryo na instrakture na madali para sa iyong partikular na aplikasyon. Sinasabi ng ilan na ang pagkakapareho ay nakakatulong kung makikipagtulungan sa iba, kaya ang tyutoryal na ito ay gagamit ng "standard" na istruktura kung saan ikaw ay magiging matiwasay kung ikaw ay nakapagtrabaho na kasama ang ibang MVC's noon.   


```text
┗ tyutoryal
   ┣ app
   ┇ ┣ mga kontrolers
   ┇ ┣ IndexController.php
   ┇ ┇ ┗ SignupController.php
   ┇ ┣ modelo
   ┇ ┇ ┗ Users.php
   ┇ ┗ views
   ┗ publiko
      ┣ css
      ┣ img
      ┣ js
      ┗ index.php
```

Paalala: Hindi mo makikita ang **vendor** na direktoryo dahil ang lahat ng ubod ng mga umaasa ay nakalagay sa memorya gamit ang Phalcon ekstensiyon na iyong dapat na na-install. Kung hindi mo na-install ang Phalcon ekstensiyon [Mangyaring bumalik](/[[language]]/[[version]]/installation) at tapusin and pag-install bago magpatuloy.

Kung ang lahat ay bago ito ay iminumungkahi na i-install and [Phalcon Devtools](/[[language]]/[[version]]/devtools-installation) dahil ito ay kumakapit sa PHP's na built-in server para ang inyong app ay gumagana kahit ng hindi nagkukumpirma ng isang web browse sa pagdagdag nito [.hrouter](https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php) sa ugat ng iyong proyekto.

Kung gusto mong gamitin ang Nginx andito ang mga karagdagang setup [dito](/[[language]]/[[version]]/webserver-setup#nginx)

Ang Apache ay maari ring gamitin sa mga karagdagan na mga setup na ito [dito](/[[language]]/[[version]]/webserver-setup#apache)

Panghuli, kung ang iyong panglasa ay Cherokee gamitin ang setup [dito](/[[language]]/[[version]]/webserver-setup#cherokee)

<a name='bootstrap'></a>

## Bootstrap

Ang unang file na iyong kailangang gawin ay ang bootstrap file. Ang file na ito ay gumaganap bilang isang punto ng pagpasok at pagsasaayos ng iyong aplikasyon. Sa file na ito, maari mong ipatupad ang inisyalisasyon ng mga bahagi pati na ang gawi ng aplikasyon.

Ang file na ito ay naghahawak ng 3 bagay: -Rehistrasyon ng mga bahagi ng autoloaders. -Pagsasaayos ng **Serbisyo** at pagrehistro sa kanila gamit ang **Dependence Injection** na konteksto. -Paglutas ng kahilingan ng aplikasyon ng HTTP.

<a name='autoloaders'></a>

### Autoloaders

Ang Autoloader ay naghahawak ng [PSR-4](http://www.php-fig.org/psr/psr-4/) masunurin na file loader na gumagana gamit ang Phalcon C ekstensyon. Mga karaniwnag bagay na dapat idagdag sa Autoloadrr ay ang iyong mga **Kontrolers** at **Mga Modelo**. Maaring i-rehistro ang **mga direktoryo** kung saan ito ay maghahanap nga mga files sa loob ng namespace ng aplikasyon. (Kung gusto mong magbasa ng ibang mga paraan na pwedeng gamitin ang Autoloders pumunta [dito](/[[language]]/[[version]]/loader#overview))

Upang magsimula, i-rehistro ang **kontrolers** at **mga modelo** ng apps sa direktoryo. Huwag kalimutang isama ang loader mula sa `Phalcon\Loader`.

  
**public/index.php**

```php
<?php

gamiting ang Phalcon\Loader;

// Liwanaging ang buong gawa para makatulong sa paghanap ng mga kailangang bagay
liwanagin (BASE_PATH',dirname(__DIR__));
liwanagin ('APP_PATH',BASE_PATH . '/app');
// ...

$loader = bagong Loader();

$loader->registerDirs(
    [
        APP_PATH. '/controllers/'',
        APP_PATH . '/models/',
    ]
);

$loader->register();
```

  

<a name='dependency-management'></a>

### Pamamahala ng Umaasa

Dahil ang Phalcon ay **maluwag na pares** na serbisyo ito ay nakarehistro sa balangkas ng Dependency Manager kaya ito ay maaring automatikong maipapasok sa mga bahagi at serbisyo na nakalagay sa **loC** na lagayan. Madalas kang makakatagpo ng kataga na **DI** na ang ibig sabihin ay Dependency Injection. Ang Dependency Injection at Inversion of Control (IoC) ay maaring komplikado na katangian ngunit sa Phalcon ang gamit nito ay napakasimple at praktikal. Ang lagayan ng Phalcon IoC ay binubuo ng mga sumusunod na konsepto: -Lagayan ng Serbisyo: isang 'supot' kung saan dito pangkalahatang nilalagay ang mga serbisyo na kailangan ng ating aplikasyon para gumana. -Serbisyo o Mga Bahagi: Ang mga bagay para sa pagproseso ng data na ilalagay sa mga bahagi

Kung ikaw ay interesado sa mga detalye maaring tingnan ang artikulo na ito ayun kay [Martin Fowler](https://martinfowler.com/articles/injection.html)

Kung ang balangkas ay nangangailangan ng isang sangap o serbisyo, hihilingin nito ang lagayan gamit ang nasang-ayunan na pangalan para sa serbisyo. Wag kalimutang isali ang `Phalcon\Di` sa pag set-up ng lagayan ng serbisyo.

Ang mga serbisyo ay maaring i-rehistro sa maraming paraan, pero sa ating tyutoryal tayo ay gagamit ng [dikilala na kabisa](http://php.net/manual/en/functions.anonymous.php):

### Default na Pabrika

`Phalcon\Di\FactoryDefault` ay isang klase ng `Phalcon\Di`. Upang maging madali, ito ay awtomatikong magrerehistro ng mga sangkap na kasama sa Phalcon. Iminumungkahi namin na i-rehistro ang iyong mga serbisyo ng mano-mano ngnuit ito kay kasali na para makatulong maiwasan ang mga hadlang sa pagpasok ng paggamit ng Dependcy Managrment. Kalaunan, maaring palaging tukuyinang mga bagay kung ikaw ay komportable na sa konsepto.

  
**public/index.php**

```php
<?php

gamitin ang Phalcon\Di\FactoryDefault;

// ...

// Create a Di
$di = new FactoryDefault();
```

  


Sa susunod na parte, i-rehistro natin ang "view" na serbisyo na magpapahiwatig sa direktoryo kung saan ang makikita ng balangkas ang mga views files. Kung ang mga views ay hindi tumugon sa mga klase, ito ay hindi puwedeng i-karga ng autoloader.

  
**public/index.php**

```php
<?php

gamitin ang Phalcon\Mvc\Vuew;

// ...

// I-setup ang mga bahagi ng view
$di->set(
    'view',
    function () {
        $view = new View ();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);
```

  


Susunod, i -rehistro ang pangunahing URL upang ang lahat na URL na nilikha ng Phalcon ay maisama ang "tyutoryal" na folder na i-setup kanina. Ito ay magiging importante kalaunan sa tyutoryal na ito kung gagamitin natin ang klase na `Phalcon\Tag` para lumikha ng hyperlink.

  
**public/index.php**

```php
<?php

gamitin ang Phalcon\Mvc\Url bilang UrlProvider;

// ...

// Mag Setup ng pangunahin na URl upang ang lahat na nalikha na URl kasama ang "tyutoryal" na folder.
$di->set(
    'url'
    function () {
        $url= bagong UrlProvider();
        $url->setBaseUri('/);
        bumalik $url;
    }
);
```

  

<a name='request'></a>

### Paghawak ng kahilingan ng aplikasyon

Sa huling bahagi ng file na ito, makikita natin ang `Phalcon\Mvc\Application`. Ang layunin nito ay simulan ang kaligiran na kahilingan, bigyang daan ang kahilingan, at ibahagi ang mga nadiskubre na mga aksiyon; ito ay magtitipon ng mga sagot at magbabalik nito kung kompleto na ang proseso.

  
**public/index.php**

```php
<?php

gamiting ang Phalcon\Mvc\Application

// ...

$application = bagong Aplikasyon ($di);
$response = $application->handle();
$response->send();
```

  

<a name='full-example'></a>

### Pagsama-samahin ang lahat

Ang `tutorial/public/index.php` file ay ganito dapat ang hitsura:

  
**public/index.php**

```php
<?php

gamitin ang Phalcon\Loader;
gamitin ang Phalcon\Mvc\view;
gamitin ang Phalcon\Mvc\Application;
gamitin ang Phalcon\Di\FactoryDefault;
gamitin ang Phalcon\Mvc\Url bilang UrlProvider;
gamitin ang Phalcon\Db\Adapter\Pdo\Mysql bilang DbAdapter;

// Bigyang kahulugan ang ibang ganap na mga lagian upang makatulong sa paghanap ng mga pagaaring bagay
define(BASE_PATH', dirname(__DIR__));
define(APP_PATH', BASE_PATH . '/app');

// Magrehistro ng autoloader
$loader = bagong Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/'
        APP_PATH . '/models/',
    ]
);


$loader->register();

// gumawa ng DI
$di = bagong FactoryDefault();

// I-setup ang bahagi ng view
$di->set(
    'view',
    function () {
        $view = baong View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);


// I-Setup ang pangunahin na URL para ang lahat na naisali na URl malagay sa "tyutoryal" na folder
$di->set(
    'url',
    function () {
        $url = bagong UrlProvider();
        $url->setBaseUri('/');
        Ibalik $url;
    }
);

$application = bagong aplikasyon($di);

subukan {
    // Hawakan ang hiling
    $response = $application->handle();

    $response->send()
} kunin (\Exception $e) {
    echo 'Exception:', $e->getMessage();
}
```

  
Kagaya ng makikita mo, ang bootstrap file ay napaikli at hindi na kailangang isali ang kahit na anong karagdagan na mga files. **Congratulations** ikaw ay papunta na sa pagkakaroon ng isang makunat na MVC na aplikasyon sa loob lamang ng 30 na linya ng palahudyatan.

<a name='controller'></a>

## Paggawa ng Kontroler

Ayun sa default ang Phalcon ay maghahanap ng isang kontroler na nagngangalang **IndexController**. Ito ang simula na kung saan walang kontroler o aksyon ang naidagdag sa kahilingan. (eg. http://localhost:8000/) Ang **IndexController** at ang **IndexAction** ay dapat magkahawig sa sumusunod na halimbawa:

  
**app/controllers/indexController.php**

```php
<?php

gamitin ang Phalcon\Mvc\Controller
{
    public function indexaction()
    {
        echo '<h1>Hello!</h1>';
    }
}
```

Ang mga klase ng kontroler ay dapat mayroong hulapi na "Kontroller" at anf mga aksyon ng kontroler ay dapat mayroong hulapi na "Aksyon". Kung papasok ka sa aplikasyon gamit ang iyong browser, dapat makita mo ang bagay na katulad nito:

  
![](/images/content/tutorial-basic-1.png)

  
Binabati kita, ikaw ay phlying kasama ang Phalcon!

<a name='view'></a>

## Magpapadala ng output sa pananaw

Ang pagpapadala ng output sa eskrin galing sa kontroler ay minsan kinakailangan pero hindi nais tulad ng karamihan ng mga purists sa kuminidad ng MVC ang magpapatunay nito. Lahat ay dapat ipasa sa view na responsable sa pag-output ng data sa eskrin. Ang Phalcon ay maghahanap ng view na may parehas na pangalan katulad ng aksyon na huling ginawa sa loob ng isang direktoryo na nakapangalan na pinakahuling kontroler na nagawa. Sa kaso na ito (`app/views/index/index.phtml`):

  
**app/views/index/index.phtml**

```php
<?php echo "<h1>Hello!</h1>";
```

  


Ang aming kontroler (`app/controllers/indexControllers.php`) ngayon ay mayroong walang laman na kahulugan na aksyon:

  
**app/controllers/indexController.php**

```php
<?php

gamiting ang Phalcon\Mvc\Controller;

klase ng IndexControler nagpapahaba ng Kontroler
{
    public function indexAction()
    {

    }
}
```

  


Ang output ng browser ay dapat manatiling pareho. Ang `Phalcon\Mvc\Viee` estatik na bahagi ay awtomatikong malilikha kapag tapos ng nagawa ang aksyon. Para mas matutunan ito `ipakita ang paggamit dito<views>`.

<a name='signup-form'></a>

## Pagdisenyo ng isang sign-up form

Ngayon babaguhin natin ang `index.phtml` view file, para magdagdag ng isang link sa isang bagong kontroler na nagngangalang "signup". Ang layunin ay hayaan ang mga gagamit na mag sign up gamit amg aming aplikasyon.

  
**app/views/index.phtml**

```php
<?php

echo "<h1>Hello!</h1>";

echo PHP _EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
    "signup",
    "Mag sign Up Dito!"
);
```

  


Amg nakuha na HTML code ay magpapakita ng angkla ("a") HTML na tag na mag-uugnay nito sa isang bagong kontroler:

  
**app/views/index/index.phtml Rendered**

```html
<h1>Hello!</h1>

<a href="/signup">Mag sign up Dito!</a>
```

  


Para makuha ang tag gagamitin nating ang klase na `Phalcon\Tag`. Ito ay isang utility na klase na nagpapahintulot na gumawa ng HTML tags na mayroong balangkas ng kapulungan sa isipan. Ang klase din na ito ay isang serbisyo na nakarehistro sa DI at ginagamit namin ang `$this->tag` upang mapasok ito.

Isang detalyadong artikulo tungkol sa HTML na henerasyon ay makikita [dito<tags>](/[[language]]/[[version]]/tag).

  
![](/images/content/tutorial-basic-2.png)

  
Narito ang Signup Kontroler (`app/controllers/SignupController.php`):

  
**app/controllers/SignupController.php**

```php
<?php

gamitin ang Phalcon\Mvc\Controller;

klase ng SignupController ay nagpapahaba ng Kontroler
{
   public function IndexAction()
    {

    }
}
```

  


Ang walang laman na index aksyon ay nagbibigay ng malinis na daan sa pananaw kasama ang kahulugan ng porma (`app\views/signup/index phtml`):

  
**app/views/signup/index.phtml**

```php
<h2>Mag sign-up gamit ang porma na ito</h2>

<?php echo $this->tag->form("signup/register"); ?>

    <p>
        <label for="name">Pangalan</label>
        <?php echo $this->tag->textField("pangalan"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <?php echo $this->tag->submitButton("Rehistro"); ?>
    </p>

</form>
```

  


Kapag titingnan ang porma sa inyong browser makikita ang isang bagay na katulad nito:

  
![](/images/content/tutorial-basic-3.png)

  
`Phalcon\Tag` ay nagbibigay din nga mga nakakatulong na mga paraan upang bumuo ng elemento ng anyo.

Ang :code:`Phalcon\Tag::form()` na paraan ay tumatanggap lamang ng isang sadyansukat halimbawa, ang kapareha na URl ng kontroler/action sa aplikasyon.

Sa pamamagitan ng pag pindot ng "Send" button, mapapansin mo ang isang taliwas na tinapon galing sa balangkas, nag nagpapahiwatig na nawawala ang "register" na aksyon sa kontroller ng "signup". Ang ating `public/index.php` na file ay magtatapon ng nabubukod na ito:

```bash
Nabubukod: Aksyon "register" ay hindi natagpuan sa tagahawak ng "signup"
```

Ang pagpapatupad ng paraan na yan ay magtatanggal sa nabubukod:

  
**app/controllers/SignupController.php**

```php
<?php

gamitin ang Phalcon\Mvc\Controller

klase na SignupController nagpapahaba ng Kontroler
{
    publiko na aksyon IndexAction()
    {

    }

    publiko na tungkulin registerAction()
    {

    }
}
```

  


Kung iyong i-klik and "send" na butones ulit, makakakita ka ng isang blangko na pahina. Ang pangalan at email input na ibinigay ng gumagamit ay dapat naka impok sa isang database. Ayon sa MVC na mga tuntunin, ang interaksyon ng mga database ay dapat gawin sa mga modelo para matiyak ang malinis na object-oriented code.

<a name='model'></a>

## Paggawa ng Modelo

Ang Phalcon ay magdadala ng kauna-unahang ORM para sa PHP na kabuoang nakasulat sa C-wika. Sa halip na pataasin ang pagiging komplikado ng pagsulong, pinapasimple nito ito.

Bago nilikha ang ating unang modelo, kailangan nating lumikha ng database na talaan sa labas ng Phalcon para ma-mapa ito. Ang simple na talaan kung saan i-impok ang mga nakarehistro na tagagamit ay puweding gawin katulad nito:

  
**create_users_table.sql**

```sql
GUMAWA NG TALAAN `tagagamit` (
    `id`   int(110)    unsigned      WALANG HALAGA AUTO_INCREMENT,
    `pangalan`  varchar(70)     WALANG HALAGA,
    `email` varchar(70)             WALANG HALAGA,

    PANGUNAHING SUSI (`id`)
);
```

  


Ang isang modelo ay dapat makikita sa `app/models` na direktoryo (`app/models/Users.php`). Ang modelo na mapa para sa "tagagamit" na talaan:

  
**app/models/Users.php**

```php
<?php

gamiting ang Phalcon\Mvc\Modelo;

klase ng Tagagamit ay pinapahaba ang Modelo
{
    publiko $id;
    publiko $name;
    publiko $email;
}
```

  

<a name='database-connection'></a>

## Paglalagay ng Koneksyon ng Database

Upang magamit ang isang koneksyon ng database at sunod-sunod na pag-abot ng mga data gamit ang mga modelo, kailangan nating i-uriin ito sa ating bootstrap na proseso. Ang database na koneksyon ay isang uri ng serbisyo na mayroon ang ating aplikasyon na puwedeng gamitin sa maraming bahagi:

  
**public/index.php**

```php
<?php

gamitin ang Phalcon\Db\Adapter|Pdo|Mysql bilang DbAdapter;

// I-setup ang serbisyo ng database
$di->set(
    `db'
    function () {
        ibalik ang bagong DbAdapter(
            [
                'host'   =>'127.0.0.1',
                'username' +>'root'',
                'password' =>'secret'
                'dbname'  =>'tutorial1',
            ]
        );
    }
);
```

  


Kasama ang mga tamang database na sadyansukat, ang ating mga modelo ay handa ng gumana at makisalamuha sa iba pang mga aplikasyon.

<a name='storing-data'></a>

## Pag-iimbak ng mga data gaming ang mga modelo

  
**app/controllers/SignupController.php**

```php
<?php

gamiting ang Phalcon\Mvc\Controller;

klase SignupController nagpapahaba ng Kontroler
{
    publiko na function IndexAction()
    {

    }

    }

    publiko na function registerAction()
    {
        $user = bagong Users();

        // Imbak at suriin ang mga mali
        $success = $user->save(
            $this->request->getPost(),
            [
                "pangalan",
                "email",
            ]
        );

        kung ($success) {
            echo "Salamat sa pagrehistro!";
        } iba {
            echo 'Patawad, ang mga sumusunod na mga problema ay nalikha: "; 

            $messages = $user->getMessage (); 

            foreach ($messages bilang $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
```

  


Sa simula ng **registerAction** tayo ay gagawa ng isang walang laman na bagay ng tagagamit galing sa klase ng Tagagamit, kung saan ito ay namamahal ng mga talaan ng Tagagamit. Ang klase ng publiko na mga katangian ng mapa sa paligid ng `users` na talaan ay nasa ating database. Pagtatakda ng mga importante na mga mahalang bagay sa bagong talaan at tinatawag na `save()` ay mag-iimbak ng data sa database para sa talaan,. Ang `save()` na paraan ay magbabalik ng boolean na halaga na nagpapahiwatig kung ang pag-iimbak ng data ay matagumpay o hindi.

Ang ORM ay awtomatikong nag-aalis ng input na pumipigil sa SQL injections kaya kailangan lang natin ipasa ang hiling sa `save()` na paraan.

Mga karagdagang pagpapatunay ay awtomatikong mangyayari sa paligid na nangangahulugang ito ay hindi null (kinakailangan). Kung hindi nating ipapasok ang mga kailangan na paligid sa sign-up na form ang ating eskrin ay magaging ganito:

  
![](/images/content/tutorial-basic4.png)

  
<a name='conclusion'></a>

## Konklusyon

Tulad ng nakikita mo, madaling mag umpisang gumawa ng aplikasyon gamit ang Phalcon. Ang katunayan na ang Phalcon ay nagpapatakbo galing sa isang ekstinsyon ay makabuluhang nagbabawas ng mga bakas ng proyekto pati na rin ang pagbibigay ng mahalagang tulong sa pagganap nito.

Kung ikaw ay handa nang matuto ng marami pa siyasatin ang [Natitirang Tutorial](/[[language]]/[[version]]/tutorial-rest) sa susunod.