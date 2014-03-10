%{intl_85d2bc52cf53e27ca20645a9431c6930}%

====================
%{intl_92aaa680cf30691651a1f728f7bbd0b1}%


%{intl_7225af6a7690ce43b3f118bf9235a8fa}%

%{intl_16faf9a6a387d16c7e9f1b7114966512}%

.. highlights::
   This guide is not intended to be a complete documentation of the intl_ extension. Please visit its the documentation_ of the extension for a reference.


%{intl_41d225fcbd85a9a62195821945d72707}%

------------------------------
%{intl_f05a8fa309000dd32507bbfee2a385f3}%


.. code-block:: php

    <?php

    $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);

    // {%intl_234654f0f0e9e33d203000dca2a8cd2a%}
    echo $locale;

%{intl_3ebdfbd89c1a413a2c4f3c0d948e52e5}%

* {%intl_8bcbd815ed88473e45dc3feb24f0f558%}
* {%intl_580e6a20e1580facdafdb33285d7766c%}
* {%intl_328cb63a9b73f3d5a3ee4bc5eee2afed%}

%{intl_5fcd413e9e2e372297f489fe24dbdce6}%

-----------------------------------
%{intl_2a2dc5fcf450c50a14b465a81d95b046}%


%{intl_178d127c9218637e406a7ca6e727d84d}%

.. code-block:: php

    <?php

    // {%intl_74788676640cf24873a5d31e48003c5d%}
    $formatter = new MessageFormatter("fr_FR", "€ {0, number, integer}");
    echo $formatter->format(array(4560));

    // {%intl_408b4ce049aa9e37589305879ea666fc%}
    $formatter = new MessageFormatter("en_US", "USD$ {0, number}");
    echo $formatter->format(array(4560.50));

    // {%intl_5b0f1aa2db82f39e46860db7cfb185e7%}
    $formatter = new MessageFormatter("es_AR", "ARS$ {0, number}");
    echo $formatter->format(array(1250.25));

%{intl_9422d3dc3121dcaa1b553f4157627efc}%

.. code-block:: php

    <?php

    //{%intl_0e63c14b25c7747f68277e26ccdb6bd4%}
    $time   = time();
    $values = array(7, $time, $time);

    // {%intl_461394b52a6120d8388b7b12bf86e854%}
    $pattern   = "At {1, time} on {1, date}, there was a disturbance on planet {0, number}.";
    $formatter = new MessageFormatter("en_US", $pattern);
    echo $formatter->format($values);

    // {%intl_01f6129f2b84e7ac8c111e93980535be%}
    $pattern   = "À {1, time} le {1, date}, il y avait une perturbation sur la planète {0, number}.";
    $formatter = new MessageFormatter("fr_FR", $pattern);
    echo $formatter->format($values);

%{intl_e68e6468f5553c619b4754175b53776d}%

---------------------------
%{intl_1b21ef2fc5095722b554a3e0ffa70435}%


.. code-block:: php

    <?php

    // {%intl_94a3195d410f44f5b576523a8764398d%}
    $collator = new Collator("es");

    // {%intl_774f2564a457cd5a559a81260a86c650%}
    $collator->setStrength(Collator::PRIMARY);
    var_dump($collator->compare("una canción", "una cancion"));

    // {%intl_594eac9635771cadbc71967a3d5e6ec5%}
    $collator->setStrength(Collator::DEFAULT_VALUE);
    var_dump($collator->compare("una canción", "una cancion"));

%{intl_86b69a9604c947e11ebd5d3a7ea33966}%

---------------
%{intl_7b5214c4dcab9dad7ea131785b8b50f9}%


