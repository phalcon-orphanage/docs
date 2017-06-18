Instalacja na WAMP
==================

WampServer_ to darmowy, zintegrowany pakiet webowy, z pomocą którego łatwo uruchomimy na swoim komputerze własny serwer WWW. Z powodzeniem posłużyć ono może do testowania skryptów PHP, jak również hostowania niewielkich stron internetowych oraz aplikacji webowych. Poniżej przedstawiamy szczegółową instrukcję instalacji Phalcona na WampServer. Korzystanie z najnowszej wersji WampServer jest wysoce zalecane.

Pobierz właściwą wersję Phalcona
--------------------------------
WAMP ma zarówno wersje 32 jak i 64 bitowe. Z sekcji Download możesz wybrać wersje Phalcona odpowiednią dla swojej architektury.

Po pobraniu biblioteki Phalcon, będziesz miał plik zip jak na obrazku poniżej:

.. figure:: ../_static/img/xampp-1.png
    :align: center

Wypakuj bibliotekę z archiwum, aby otrzymać Phalcon DLL:

.. figure:: ../_static/img/xampp-2.png
    :align: center

Skopiuj plik php_phalcon.dll do folderu rozszerzeń PHP. Jeżeli zainstalowałeś XAMPP w folderze C:\\wamp, rozszerzenie musi być w C:\\wamp\\bin\\php\\php5.5.12\\ext

.. figure:: ../_static/img/wamp-1.png
    :align: center

Edytuj plik php.ini, jest zlokalizowany w C:\\wamp\\bin\\php\\php5.5.12\\php.ini. Możesz go edytować Notatnikiem lub innym, podobnym programem. Polecamy Nodepad++, aby uniknąć problemów z zakończeniami linii. Dodaj na końcu pliku: extension=php_phalcon.dll i zapisz go.

.. figure:: ../_static/img/wamp-2.png
    :align: center

Edytuj jeszcze jeden plik php.ini, który zlokalizowany jest w C:\\wamp\\bin\\apache\\apache2.4.9\\bin\\php.ini. Dodaj na końcu pliku: extension=php_phalcon.dll i zapisz go.

Zrestartuj serwer Apache. Kliknij pojedyńczo na ikonie WampServer w prawym dolnym rogu paska zadań. Z menu podręcznego wybierz "Restart All Services". Ikona na pasku zadań będzie znowu zielona.

.. figure:: ../_static/img/wamp-3.png
    :align: center

Otwórz swoją przeglądarkę i przejdź do http://localhost. Pojawi się strona powitalna WAMP. Spójrz na sekcję "extensions loaded", aby sprawdzić czy phalcon został załadowany.

.. figure:: ../_static/img/wamp-4.png
    :align: center

Gratulacje!, Teraz latasz z Phalconem.

Powiązane przewodniki
---------------------
* :doc:`General Installation </reference/install>`
* :doc:`Detailed Installation on XAMPP for Windows </reference/xampp>`

.. _WampServer: http://www.wampserver.com/en/
