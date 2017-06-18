Instalacja na serwerach Cherokee
================================

Cherokee_ jest wysoce wydajnym serwerem WWW. Jest bardzo szybki, elastyczny i prosty w konfiguracji.

Configuring Cherokee for Phalcon
--------------------------------
Cherokee oferuje przyjazny interfejs graficzny, aby skonfigurować niemal każde ustawienie dostępne w serwerze WWW.
Uruchom administratora cherokee wykonując polecenie /ściezka-do-cherokee/sbin/cherokee-admin jako root:

.. figure:: ../_static/img/cherokee-1.jpg
    :align: center

Stwórz nowy serwer wirtualny klikając na 'vServers', następnie dodaj nowy serwer wirtualny:

.. figure:: ../_static/img/cherokee-2.jpg
    :align: center

Ostatnio dodany wirtualny serwer musi pojawić się na lewym pasku ekranu. W zakładce 'Behaviors'
zobaczysz zestaw domyślnych zachowań dla tego serwera wirtualnego. Kliknij na przycisk 'Rule Management'.
Usuń te oznaczone jako 'Directory /cherokee_themes' i 'Directory /icons':

.. figure:: ../_static/img/cherokee-3.jpg
    :align: center

Dodaj zachowanie 'PHP Language' używając kreatora. To pozwoli ci uruchamiać aplikacje PHP:

.. figure:: ../_static/img/cherokee-4.jpg
    :align: center

Normalnie to zachowanie nie wymaga dodatkowych ustawień. Dodaj kolejne zachowanie,
tym razem w sekcji 'Manual Configuration'. W 'Rule Type' wybierz 'File Exists',
następnie upewnij się że opcja 'Match any file' jest włączona:

.. figure:: ../_static/img/cherokee-55.jpg
    :align: center

W zakładce 'Handler' wybierz 'List & Send' jako handler:

.. figure:: ../_static/img/cherokee-7.jpg
    :align: center

Edytuj zachowanie 'Default' w celu włączenia przepisywania linków. Zmień handler na 'Redirection',
następnie dodaj do silnika następujące wyrażenie regularne ^(.*)$:

.. figure:: ../_static/img/cherokee-6.jpg
    :align: center

Na koniec, upewnij się, że zachowania mają następującą kolejność:

.. figure:: ../_static/img/cherokee-8.jpg
    :align: center

Uruchom aplikację w przeglądarce:

.. figure:: ../_static/img/cherokee-9.jpg
    :align: center

.. _Cherokee: http://www.cherokee-project.com/
