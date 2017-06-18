Internacionalização
====================

Phalcon é escrito em C como uma extensão para o PHP. Há uma extensão PECL_ que oferece funções de internacionalização de aplicações PHP chamada intl_.
A partir do PHP 5.4 / 5.5 esta extensão é fornecido com PHP. Sua documentação pode ser encontrada na pagina oficial do `PHP manual`_.

Phalcon não oferece essa funcionalidade, uma vez que a criação de um tal componente seria replicar código existente.

Nos exemplos a seguir, vamos mostrar-lhe como implementar a funcionalidade de extensão intl_ em aplicações Phalcon alimentados.

.. highlights::
   Este guia não se destina a ser uma documentação completa da extensão intl_. Por favor, visite a documentation_ da extensão para uma referência.

Find out best available Locale
------------------------------
Existem várias maneiras de descobrir o melhor local disponível usando intl_. Um deles é verificar o HTTP "Accept-Language" no cabeçalho:

.. code-block:: php

    <?php

    $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);

    // Locale could be something like "en_GB" or "en"
    echo $locale;

O método abaixo retorna uma localidade identificada. Ele é usado para obter idioma, cultura ou comportamento específico-regional da API Locale.

Os exemplos de identificadores incluem:

* en-US (English, United States)
* ru-RU (Russian, Russia)
* zh-Hant-TW (Chinese, Traditional Script, Taiwan)
* fr-CA, fr-FR (French for Canada and France respectively)

A formatação de mensagens com base na localidade
------------------------------------------------
Parte da criação de uma aplicação localizada é produzir mensagens concatenadas, de idioma neutro. O MessageFormatter_ permite a
produção dessas mensagens.

Imprimir números formatados com base em alguma localidade:

.. code-block:: php

    <?php

    // Prints € 4 560
    $formatter = new MessageFormatter("fr_FR", "€ {0, number, integer}");
    echo $formatter->format([4560]);

    // Prints USD$ 4,560.5
    $formatter = new MessageFormatter("en_US", "USD$ {0, number}");
    echo $formatter->format([4560.50]);

    // Prints ARS$ 1.250,25
    $formatter = new MessageFormatter("es_AR", "ARS$ {0, number}");
    echo $formatter->format([1250.25]);

Formatação de uma mensagem usando padrões de data e hora:

.. code-block:: php

    <?php

    // Setting parameters
    $time   = time();
    $values = [7, $time, $time];

    // Prints "At 3:50:31 PM on Apr 19, 2015, there was a disturbance on planet 7."
    $pattern   = "At {1, time} on {1, date}, there was a disturbance on planet {0, number}.";
    $formatter = new MessageFormatter("en_US", $pattern);
    echo $formatter->format($values);

    // Prints "À 15:53:01 le 19 avr. 2015, il y avait une perturbation sur la planète 7."
    $pattern   = "À {1, time} le {1, date}, il y avait une perturbation sur la planète {0, number}.";
    $formatter = new MessageFormatter("fr_FR", $pattern);
    echo $formatter->format($values);

Locale-Sensitive comparison
---------------------------
A classe Collator_ fornece capacidade de comparação de string com suporte para orderings classificar sensíveis à localidade apropriadas. Verifique um exemplo abaixo sobre o uso desta classe:

.. code-block:: php

    <?php

    // Create a collator using Spanish locale
    $collator = new Collator("es");

    // Returns that the strings are equal, in spite of the emphasis on the "o"
    $collator->setStrength(Collator::PRIMARY);
    var_dump($collator->compare("una canción", "una cancion"));

    // Returns that the strings are not equal
    $collator->setStrength(Collator::DEFAULT_VALUE);
    var_dump($collator->compare("una canción", "una cancion"));

Transliteration
---------------
Transliterator_ provides transliteration of strings:

.. code-block:: php

    <?php

    $id = "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();";
    $transliterator = Transliterator::create($id);

    $string = "garçon-étudiant-où-L'école";
    echo $transliterator->transliterate($string); // garconetudiantoulecole

.. _PECL: http://pecl.php.net/package/intl
.. _intl: http://pecl.php.net/package/intl
.. _PHP manual: http://www.php.net/manual/en/intro.intl.php
.. _documentation: http://www.php.net/manual/en/book.intl.php
.. _MessageFormatter: http://www.php.net/manual/en/class.messageformatter.php
.. _Collator: http://www.php.net/manual/en/class.collator.php
.. _Transliterator: http://www.php.net/manual/en/class.transliterator.php
