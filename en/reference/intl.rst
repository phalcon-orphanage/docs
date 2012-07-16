

Internationalization
====================
As well you should know Phalcon is a framework written as a C extension for PHP. Currently, PHP has a magnificent extension to create internationalized applications. You can find it in the `PECL <http://pecl.php.net/package/intl>`_ repository and its well documented at the official `PHP manual <http://www.php.net/manual/en/intro.intl.php>`_. 

So basically for us is not worth it, to re-implement another internationalization extension for PHP. In this part of the documentation, we'll show you how to implement the functionality of this extension into Phalcon applications. 

.. highlights::
   This guide is not intended to be a complete documentation of the intl extension.Please visit its  `documentation <http://www.php.net/manual/en/book.intl.php>`_ for a complete reference.

Find out best available Locale
------------------------------
There are several ways to find out the best available locale using intl. One of them is to check the HTTP "Accept-Language" header: 

.. code-block:: php

    <?php

    $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    //Locale could be something like "en_GB" or "en"
    echo $locale;

Below method returns a locale identified. It is used to get language, culture, or regionally-specific behavior from the Locale API. Examples of identifiers include:

* en-US (English, United States)
* zh-Hant-TW (Chinese, Traditional Script, Taiwan)
* fr-CA, fr-FR (French for Canada and France respectively)

Formatting messages based on Locale
-----------------------------------
Part of creating a localized application is to produce concatenated, language-neutral messages. The  `MessageFormatter <http://www.php.net/manual/en/class.messageformatter.php>`_ enables to produce those outputs.Printing numbers formatted based on some locale:

.. code-block:: php

    <?php

    //Prints â¬ 4 560
    $formatter = new MessageFormatter("fr_FR", "â¬ {0,number,integer}");
    echo $formatter->format(array(4560));
    
    //Prints USD$ 4,560.5
    $formatter = new MessageFormatter("en_US", "USD$ {0,number}");
    echo $formatter->format(array(4560.50));
    
    //Prints ARS$ 1.250,25
    $formatter = new MessageFormatter("es_AR", "ARS$ {0,number}");
    echo $formatter->format(array(1250.25));

Message formatting using time and date patterns:

.. code-block:: php

    <?php

    //Setting parameters
    $time = time();
    $values = array(7, $time, $time);
    
    //Prints "At 3:50:31 PM on Apr 19, 2012, there was a disturbance on planet 7."
    $pattern = "At {1,time} on {1,date}, there was a disturbance on planet {0,number}.";
    $formatter = new MessageFormatter("en_US", $pattern);
    echo $formatter->format($values);
    
    //Prints "Ã 15:53:01 le 19 avr. 2012, il y avait une perturbation sur la planÃ¨te 7."
    $pattern = "Ã {1,time} le {1,date}, il y avait une perturbation sur la planÃ¨te {0,number}.";
    $formatter = new MessageFormatter("fr_FR", $pattern);
    echo $formatter->format($values);



Locale-Sensitive comparison
---------------------------
The `Collator <http://www.php.net/manual/en/class.collator.php>`_ class provides string comparison capability with support for appropriate locale-sensitive sort orderings. Check the examples below to figure out how this class works: 

.. code-block:: php

    <?php

    //Create a collator using Spanish locale
    $collator = new Collator("es");
    
    //Returns that the strings are equal, in spite of the emphasis on the "o"
    $collator->setStrength(Collator::PRIMARY);
    $collator->compare("una canciÃ³n", "una cancion");
    
    //Returns that the strings are not equal
    $collator->setStrength(Collator::DEFAULT);
    $collator->compare("una canciÃ³n", "una cancion");

