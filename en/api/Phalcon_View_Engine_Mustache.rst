Class **Phalcon_View_Engine_Mustache**
======================================

Adapter to use Mustache library as templating engine

Methods
---------

**__construct** (Phalcon_View $view, array $options)

Phalcon_View_Engine_Mustache constructor

**render** (string $path, array $params)

Renders a view using the template engine

**boolean** **__isset** (unknown $property)

Checks if a view variable exists

**string** **__get** (unknown $property)

Returns a variable by its name

**__call** (string $method, array $arguments)

Passes unknow calls to the internal mustache object

