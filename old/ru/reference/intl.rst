Интернационализация
===================

Phalcon является расширением для PHP, написанным на языке C. Существует PECL_-расширение intl_, которое предоставляет функции, обеспечивающие
поддержку интернационализации в PHP.
Начиная с PHP 5.4/5.5, это расширение поставляется вместе с PHP. Документация по нему может быть найдена на страницах официального `Руководства по PHP`_.

Phalcon не предоставляет функциональности этого расширения, так как создание такого компонента являлось бы повторением существующего кода.

В примере ниже мы покажем вам как воспользоваться функциональностью расширения intl_ в приложениях, написанных с использованием Phalcon.

.. highlights::
   Данное руководство не ставит перед собой цель подробно документировать расширение intl_. Для справок, пожалуйста, обратитесь к `документации`_ этого расширения.

Выяснение наиболее подходящей локали
------------------------------------
Существует несколько способов для выяснения наиболее подходящей локали с помощью intl_. Одним из них является проверка HTTP-заголовка "Accept-Language":

.. code-block:: php

    <?php

    $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);

    // Локалью может быть что-то вроде "ru_RU" или "ru"
    echo $locale;

Метод выше возвращает идентифицированную локаль. Она используется для получения языковых, культурных или региональных особенностей поведения с использованием
API класса Locale.

Примерами идентификаторов локали являются:

* en-US (Английский, США)
* ru-RU (Русский, Россиия)
* zh-Hant-TW (Китай, Традиционный китайский, Тайвань)
* fr-CA, fr-FR (Французский для Канады и Франции соответственно)

Форматирование сообщений на основании локали
--------------------------------------------
Неотъемлемой частью разработки локализованного приложения является создание объединенных, независимых от языка сообщений. MessageFormatter_ позволяет
создавать такие сообщения.

Печать форматированных чисел на основе разных локалей:

.. code-block:: php

    <?php

    // Выведет € 4 560
    $formatter = new MessageFormatter("fr_FR", "€ {0, number, integer}");
    echo $formatter->format([4560]);

    // Выведет USD$ 4,560.5
    $formatter = new MessageFormatter("en_US", "USD$ {0, number}");
    echo $formatter->format([4560.50]);

    // Выведет ARS$ 1.250,25
    $formatter = new MessageFormatter("es_AR", "ARS$ {0, number}");
    echo $formatter->format([1250.25]);

Форматирование сообщений, используя шаблоны времени и даты:

.. code-block:: php

    <?php

    // Устанавливаем параметры
    $time   = time();
    $values = [7, $time, $time];

    // Выведет "At 3:50:31 PM on Apr 19, 2015, there was a disturbance on planet 7."
    $pattern   = "At {1, time} on {1, date}, there was a disturbance on planet {0, number}.";
    $formatter = new MessageFormatter("en_US", $pattern);
    echo $formatter->format($values);

    // Выведет "À 15:53:01 le 19 avr. 2015, il y avait une perturbation sur la planète 7."
    $pattern   = "À {1, time} le {1, date}, il y avait une perturbation sur la planète {0, number}.";
    $formatter = new MessageFormatter("fr_FR", $pattern);
    echo $formatter->format($values);

Сравнение строк с учетом локали
-------------------------------
Класс Collator_ предоставляет возможности по сравнению строк, чувствительных к локали, с поддержкой соответствующих правил сравнений. Ниже приведены
примеры, демонстрирующие использование этого класса:

.. code-block:: php

    <?php

    // Создаем коллатор, использующий испанскую локаль
    $collator = new Collator("es");

    // Результат сравнения будет положительный, несмотря на ударение над "о"
    $collator->setStrength(Collator::PRIMARY);
    var_dump($collator->compare("una canción", "una cancion"));

    // Результат сравнения будет отрицательный
    $collator->setStrength(Collator::DEFAULT_VALUE);
    var_dump($collator->compare("una canción", "una cancion"));

Транслитерация
--------------
Компонент Transliterator_ добавляет возможность транслитерации строк:

.. code-block:: php

    <?php

    $id = "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();";
    $transliterator = Transliterator::create($id);

    $string = "garçon-étudiant-où-L'école";
    echo $transliterator->transliterate($string); // garconetudiantoulecole

.. _PECL: http://pecl.php.net/package/intl
.. _intl: http://pecl.php.net/package/intl
.. _`Руководства по PHP`: http://www.php.net/manual/ru/intro.intl.php
.. _документации: http://www.php.net/manual/ru/book.intl.php
.. _MessageFormatter: http://www.php.net/manual/ru/class.messageformatter.php
.. _Collator: http://www.php.net/manual/ru/class.collator.php
.. _Transliterator: http://www.php.net/manual/en/class.transliterator.php
