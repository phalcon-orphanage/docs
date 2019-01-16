* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Flash\Direct'

* * *

# Class **Phalcon\Flash\Direct**

*extends* abstract class [Phalcon\Flash](Phalcon_Flash)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\FlashInterface](Phalcon_FlashInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/flash/direct.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is a variant of the Phalcon\Flash that immediately outputs any message passed to it

## Metody

public **message** (*mixed* $type, *mixed* $message)

Outputs a message

public **output** ([*mixed* $remove])

Prints the messages accumulated in the flasher

public **__construct** ([*mixed* $cssClasses]) inherited from [Phalcon\Flash](Phalcon_Flash)

Phalcon\Flash constructor

public **getAutoescape** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the autoescape mode in generated html

public **setAutoescape** (*mixed* $autoescape) inherited from [Phalcon\Flash](Phalcon_Flash)

Set the autoescape mode in generated html

public **getEscaperService** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the Escaper Service

public **setEscaperService** ([Phalcon\EscaperInterface](Phalcon_EscaperInterface) $escaperService) inherited from [Phalcon\Flash](Phalcon_Flash)

Sets the Escaper Service

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Flash](Phalcon_Flash)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Flash](Phalcon_Flash)

Returns the internal dependency injector

public **setImplicitFlush** (*mixed* $implicitFlush) inherited from [Phalcon\Flash](Phalcon_Flash)

Set whether the output must be implicitly flushed to the output or returned as string

public **setAutomaticHtml** (*mixed* $automaticHtml) inherited from [Phalcon\Flash](Phalcon_Flash)

Set if the output must be implicitly formatted with HTML

public **setCssClasses** (*array* $cssClasses) inherited from [Phalcon\Flash](Phalcon_Flash)

Set an array with CSS classes to format the messages

public **error** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML error message

```php
<?php

$flash->error("This is an error");

```

public **notice** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML notice/information message

```php
<?php

$flash->notice("This is an information");

```

public **success** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML success message

```php
<?php

$flash->success("The process was finished successfully");

```

public **warning** (*mixed* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Shows a HTML warning message

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message) inherited from [Phalcon\Flash](Phalcon_Flash)

Outputs a message formatting it with HTML

```php
<?php

$flash->outputMessage("error", $message);

```

public **clear** () inherited from [Phalcon\Flash](Phalcon_Flash)

Clears accumulated messages when implicit flush is disabled