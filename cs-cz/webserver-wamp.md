* * *

layout: default language: 'en' version: '4.0'

* * *

<a name='overview'></a>

# Instalace: WAMP

[WampServer](http://www.wampserver.com/en/) je vývojové prostředí pro web pro Windows. Umožňuje vám vytvářet webové aplikace běžící na Apache2, PHP a MySQL databázi. Níže jsou podrobné informace jak nainstalovat Phalcon framework na WampServer pro Windows. Použití nejnovější verze WampServeru je vysoce doporučeno.

<a name='phalcon'></a>

## Download the right version of Phalcon

WAMP podporuje jak 32bitové tak 64bitové verze. Ze sekce "Stažení" můžete stáhnout DLL knihovnu Phalcon frameworku která vyhovuje Vaší WAMP instalaci.

Po stažení knihovny Phalcon frameworku budete mít ZIP soubor podobný ukázanému níže:

![](/assets/images/content/webserver-xampp-1.png)

Extrahujte knihovnu z archivu a budete mít Phalcon framework jako DLL soubor:

![](/assets/images/content/webserver-xampp-2.png)

Zkopírujte soubor `php_phalcon.dll` do adresáře kde máte rozšíření pro PHP. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php5.5.12\ext` (assuming your WAMP installation installed PHP 5.5.12).

![](/assets/images/content/webserver-wamp-1.png)

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php5.5.12\php.ini`. Soubor může být upraven v libovolném textovém editoru. My doporučujeme použít Notepad++ pro předejití problémů s konci řádků a kódováním. Přidejte následující řádek na konec souboru:

extension=php_phalcon.dll

    <br />a uložte soubor.
    
    ![](/assets/images/content/webserver-wamp-2.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Přidejte následující řádek na konec souboru: 
    
    extension=php_phalcon.dll 
    

and save it.

Restartuje webserver Apache. Jednou klikněte na ikonu WampServer v systémové liště. Vyberte `Restartovat všechny služby` (angl.: Restart All Services) z menu které se ukázalo. Zkontrolujte že ikonka v systémové liště bude opět zelená.

![](/assets/images/content/webserver-wamp-3.png)

Otevřete internetový prohlížeč a zadejte do řadku s adresou: http://localhost. Ukáže se Vám uvítací stránka WAMP serveru. Zkontrolujte sekci `načtené rozšíření` (angl.: extensions loaded) pro zjištění že Phalcon framework je načten.

![](/assets/images/content/webserver-wamp-4.png)

Gratulujeme! Nyní je Phalcon framework připraven.

<a name='related'></a>

## Související průvodci

* [General Installation](/3.4/en/installation)
* [Instalace: XAMPP](/3.4/en/webserver-xampp)