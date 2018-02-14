# Abstract class **Phalcon\\Flash**

*implements* [Phalcon\FlashInterface](/en/3.1.2/api/Phalcon_FlashInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/flash.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Shows HTML notifications related to different circumstances. Classes can be stylized using CSS

```php
<?php

$flash->success("The record was successfully deleted");
$flash->error("Cannot open the file");

```

## Methods
public  **__construct** ([*mixed* $cssClasses])

Phalcon\\Flash constructor

public  **getAutoescape** ()

Returns the autoescape mode in generated html

public  **setAutoescape** (*mixed* $autoescape)

Set the autoescape mode in generated html

public  **getEscaperService** ()

Returns the Escaper Service

public  **setEscaperService** ([Phalcon\EscaperInterface](/en/3.1.2/api/Phalcon_EscaperInterface) $escaperService)

Sets the Escaper Service

public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public  **getDI** ()

Returns the internal dependency injector

public  **setImplicitFlush** (*mixed* $implicitFlush)

Set whether the output must be implicitly flushed to the output or returned as string

public  **setAutomaticHtml** (*mixed* $automaticHtml)

Set if the output must be implicitly formatted with HTML

public  **setCssClasses** (*array* $cssClasses)

Set an array with CSS classes to format the messages

public  **error** (*mixed* $message)

Shows a HTML error message

```php
<?php

$flash->error("This is an error");

```

public  **notice** (*mixed* $message)

Shows a HTML notice/information message

```php
<?php

$flash->notice("This is an information");

```

public  **success** (*mixed* $message)

Shows a HTML success message

```php
<?php

$flash->success("The process was finished successfully");

```

public  **warning** (*mixed* $message)

Shows a HTML warning message

```php
<?php

$flash->warning("Hey, this is important");

```

public *string* | *void* **outputMessage** (*mixed* $type, *string* | *array* $message)

Outputs a message formatting it with HTML

```php
<?php

$flash->outputMessage("error", $message);

```

public  **clear** ()

Clears accumulated messages when implicit flush is disabled

abstract public  **message** (*mixed* $type, *mixed* $message) inherited from [Phalcon\FlashInterface](/en/3.1.2/api/Phalcon_FlashInterface)

...

