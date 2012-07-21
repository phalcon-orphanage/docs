Internationalization
====================
Phalcon is written in C as an extension for PHP. There is a PECL_ extension that offers internationalization functions to PHP applications called intl_. Its documentation can be found in the pages of the official `PHP manual`_. 

Phalcon does not offer this functionality, since creating such a component would be replicating existing code.

In the examples below, we will show you how to implement the intl_ extension's functionality into Phalcon powered applications. 

.. highlights::
   This guide is not intended to be a complete documentation of the intl_ extension. Please visit its the documentation_ of the extension for a reference.

Find out best available Locale
------------------------------
There are several ways to find out the best available locale using intl_. One of them is to check the HTTP "Accept-Language" header: 

.. code-block:: php

    <?php

    $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    
    // Locale could be something like "en_GB" or "en"
    echo $locale;

Below method returns a locale identified. It is used to get language, culture, or regionally-specific behavior from the Locale API. Examples of identifiers include:

* en-US (English, United States)
* zh-Hant-TW (Chinese, Traditional Script, Taiwan)
* fr-CA, fr-FR (French for Canada and France respectively)

Formatting messages based on Locale
-----------------------------------
Part of creating a localized application is to produce concatenated, language-neutral messages. The MessageFormatter_ allows for the production of those messages. 

Printing numbers formatted based on some locale:

.. code-block:: php

    <?php

    // Prints € 4 560
    $formatter = new MessageFormatter("fr_FR", "€ {0, number, integer}");
    echo $formatter->format(array(4560));

    // Prints USD$ 4,560.5
    $formatter = new MessageFormatter("en_US", "USD$ {0, number}");
    echo $formatter->format(array(4560.50));

    // Prints ARS$ 1.250,25
    $formatter = new MessageFormatter("es_AR", "ARS$ {0, number}");
    echo $formatter->format(array(1250.25));

Message formatting using time and date patterns:

.. code-block:: php

    <?php

    //Setting parameters
    $time   = time();
    $values = array(7, $time, $time);

    // Prints "At 3:50:31 PM on Apr 19, 2012, there was a disturbance on planet 7."
    $pattern   = "At {1, time} on {1, date}, there was a disturbance on planet {0, number}.";
    $formatter = new MessageFormatter("en_US", $pattern);
    echo $formatter->format($values);

    // Prints "À 15:53:01 le 19 avr. 2012, il y avait une perturbation sur la planète 7."
    $pattern   = "À {1, time} le {1, date}, il y avait une perturbation sur la planète {0, number}.";
    $formatter = new MessageFormatter("fr_FR", $pattern);
    echo $formatter->format($values);

Locale-Sensitive comparison
---------------------------
The Collator_ class provides string comparison capability with support for appropriate locale-sensitive sort orderings. Check the examples below on the usage of this class: 

.. code-block:: php

    <?php

    // Create a collator using Spanish locale
    $collator = new Collator("es");

    // Returns that the strings are equal, in spite of the emphasis on the "o"
    $collator->setStrength(Collator::PRIMARY);
    $collator->compare("una canción", "una cancion");

    // Returns that the strings are not equal
    $collator->setStrength(Collator::DEFAULT);
    $collator->compare("una canción", "una cancion");


.. _PECL: http://pecl.php.net/package/intl
.. _intl: http://pecl.php.net/package/intl
.. _PHP manual: http://www.php.net/manual/en/intro.intl.php
.. _documentation: http://www.php.net/manual/en/book.intl.php
.. _MessageFormatter: http://www.php.net/manual/en/class.messageformatter.php
.. _Collator: http://www.php.net/manual/en/class.collator.php