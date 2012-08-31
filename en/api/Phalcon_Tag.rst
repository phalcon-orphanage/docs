Class **Phalcon\\Tag**
======================

Phalcon\\Tag   Phalcon\\Tag is designed to simplify building of HTML tags.  It provides a set of helpers to generate HTML in a dynamic way.  This component is an abstract class that you can extend to add more helpers.

Methods
---------

**setDI** (*unknown* **$dependencyInjector**)

:doc:`Phalcon\\DI <Phalcon_DI>` **getDI** ()

:doc:`Phalcon\\Mvc\\Url <Phalcon_Mvc_Url>` **getUrlService** ()

:doc:`Phalcon\\Mvc\\Dispatcher <Phalcon_Mvc_Dispatcher>` **getDispatcherService** ()

**setDefault** (*string* **$id**, *string* **$value**)

**displayTo** (*string* **$id**, *string* **$value**)

*mixed* **getValue** (*string* **$name**)

**resetInput** ()

*string* **linkTo** (*array* **$parameters**, *unknown* **$text**)

*string* **_inputField** ()

*string* **textField** (*array* **$parameters**)

*string* **passwordField** (*array* **$parameters**)

*string* **hiddenField** (*array* **$parameters**)

*string* **fileField** (*array* **$parameters**)

*string* **checkField** (*array* **$parameters**)

*string* **submitButton** (*unknown* **$parameters**)

*string* **selectStatic** (*array* **$parameters**, *unknown* **$data**)

*string* **select** (*unknown* **$parameters**, *unknown* **$data**)

*string* **textArea** (*array* **$parameters**)

*string* **form** (*array* **$parameters**)

*string* **endForm** ()

**setTitle** (*string* **$title**)

**appendTitle** (*string* **$title**)

**prependTitle** (*string* **$title**)

*string* **getTitle** ()

*string* **stylesheetLink** (*array* **$parameters**, *boolean* **$local**)

*string* **javascriptInclude** (*array* **$parameters**, *boolean* **$local**)

*string* **image** (*array* **$parameters**)

