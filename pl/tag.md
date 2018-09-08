<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">View Helpers (Tags)</a> 
      <ul>
        <li>
          <a href="#document-type">Document Type of Content</a>
        </li>
        <li>
          <a href="#generating-links">Generating Links</a>
        </li>        
        <li>
          <a href="#creating-forms">Creating Forms</a>
        </li>
        <li>
          <a href="#helpers-for-form-elements">Helpers to Generate Form Elements</a>
        </li>
        <li>
          <a href="#select-boxes">Making Select Boxes</a>
        </li>
        <li>
          <a href="#html-attributes">Assigning HTML attributes</a>
        </li>
        <li>
          <a href="#helper-values">Setting Helper Values</a> 
          <ul>
            <li>
              <a href="#helper-values-form-controllers">From Controllers</a>
            </li>
            <li>
              <a href="#helper-values-from-request">From the Request</a>
            </li>
            <li>
              <a href="#helper-values-directly">Specifying values directly</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#changing-document-title-dynamically">Changing dynamically the Document Title</a>
        </li>
        <li>
          <a href="#static-content-helpers">Static Content Helpers</a> 
          <ul>
            <li>
              <a href="#static-content-helpers-images">Obrazki</a>
            </li>
            <li>
              <a href="#static-content-helpers-stylesheets">Stylesheets</a>
            </li>
            <li>
              <a href="#static-content-helpers-javascript">Javascript</a>
            </li>
            <li>
              <a href="#static-content-helpers-html5">HTML5 elements - generic HTML helper</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#tag-helpers">Tag Service</a>
        </li>
        <li>
          <a href="#custom-helpers">Creating your own helpers</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# View Helpers (Tags)

Writing and maintaining HTML markup can quickly become a tedious task because of the naming conventions and numerous attributes that have to be taken into consideration. Phalcon deals with this complexity by offering the `Phalcon\Tag` component which in turn offers view helpers to generate HTML markup.

This component can be used in a plain HTML+PHP view or in a [Volt](/[[language]]/[[version]]/volt) template.

<div class="alert alert-warning">
    <p>
        This guide is not intended to be a complete documentation of available helpers and their arguments. Please visit the <a href="/[[language]]/[[version]]/api/Phalcon_Tag">Phalcon\Tag</a> page in the API for a complete reference.
    </p>
</div>

<a name='document-type'></a>

## Document Type of Content

Phalcon offers the `Phalcon\Tag::setDoctype()` helper to set document type of the content. The document type setting may affect HTML output produced by other tag helpers. For example, if you set XHTML document type family, helpers that return or output HTML tags will produce self-closing tags to follow valid XHTML standard.

Available document type constants in `Phalcon\Tag` namespace are:

| Constant             | Document type          |
| -------------------- | ---------------------- |
| HTML32               | HTML 3.2               |
| HTML401_STRICT       | HTML 4.01 Strict       |
| HTML401_TRANSITIONAL | HTML 4.01 Transitional |
| HTML401_FRAMESET     | HTML 4.01 Frameset     |
| HTML5                | HTML 5                 |
| XHTML10_STRICT       | XHTML 1.0 Strict       |
| XHTML10_TRANSITIONAL | XHTML 1.0 Transitional |
| XHTML10_FRAMESET     | XHTML 1.0 Frameset     |
| XHTML11              | XHTML 1.1              |
| XHTML20              | XHTML 2.0              |
| HTML5                | XHTML 5                |

Setting document type.

```php
<?php

use Phalcon\Tag;

$this->tag->setDoctype(Tag::HTML401_STRICT);
```

Getting document type.

```php
<?= $this->tag->getDoctype() ?>
<html>
<!-- your HTML code -->
</html>
```

The following HTML will be produced.

```html
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'
        'http://www.w3.org/TR/html4/strict.dtd'>
<html>
<!-- your HTML code -->
</html>
```

Volt syntax:

```twig
{{ get_doctype() }}
<html>
<!-- your HTML code -->
</html>
```

<a name='generating-links'></a>

## Generating Links

A real common task in any web application or website is to produce links that allow us to navigate from one page to another. When they are internal URLs we can create them in the following manner:

```php
<!-- for the default route -->
<?= $this->tag->linkTo('products/search', 'Search') ?>

<!-- with CSS attributes -->
<?= $this->tag->linkTo(['products/edit/10', 'Edit', 'class' => 'edit-btn']) ?>

<!-- for a named route -->
<?= $this->tag->linkTo([['for' => 'show-product', 'title' => 123, 'name' => 'carrots'], 'Show']) ?>
```

Actually, all produced URLs are generated by the component `Phalcon\Mvc\Url`. The same links can be generated with Volt:

```twig
<!-- for the default route -->
{{ link_to('products/search', 'Search') }}

<!-- for a named route -->
{{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Show') }}

<!-- for a named route with a HTML class -->
{{ link_to(['for': 'show-product', 'id': 123, 'name': 'carrots'], 'Show', 'class': 'edit-btn') }}
```

<a name='creating-forms'></a>

## Creating Forms

Forms in web applications play an essential part in retrieving user input. The following example shows how to implement a simple search form using view helpers:

```php
<!-- Sending the form by method POST -->
<?= $this->tag->form('products/search') ?>
    <label for='q'>Search:</label>

    <?= $this->tag->textField('q') ?>

    <?= $this->tag->submitButton('Search') ?>
<?= $this->tag->endForm() ?>

<!-- Specifying another method or attributes for the FORM tag -->
<?= $this->tag->form(['products/search', 'method' => 'get']); ?>
    <label for='q'>Search:</label>

    <?= $this->tag->textField('q'); ?>

    <?= $this->tag->submitButton('Search'); ?>
<?= $this->tag->endForm() ?>
```

This last code will generate the following HTML:

```html
<form action='/store/products/search/' method='get'>
    <label for='q'>Search:</label>

    <input type='text' id='q' value='' name='q' />

    <input type='submit' value='Search' />
</form>
```

Same form generated in Volt:

```twig
<!-- Specifying another method or attributes for the FORM tag -->
{{ form('products/search', 'method': 'get') }}
    <label for='q'>Search:</label>

    {{ text_field('q') }}

    {{ submit_button('Search') }}
{{ endForm() }}
```

Phalcon also provides a [form builder](/[[language]]/[[version]]/forms) to create forms in an object-oriented manner.

<a name='helpers-for-form-elements'></a>

## Helpers to Generate Form Elements

Phalcon provides a series of helpers to generate form elements such as text fields, buttons and more. The first parameter of each helper is always the name of the element to be generated. When the form is submitted, the name will be passed along with the form data. In a controller you can get these values using the same name by using the `getPost()` and `getQuery()` methods on the request object (`$this->request`).

```php
<?php echo $this->tag->textField('username') ?>

<?php echo $this->tag->textArea(
    [
        'comment',
        'This is the content of the text-area',
        'cols' => '6',
        'rows' => 20,
    ]
) ?>

<?php echo $this->tag->passwordField(
    [
        'password',
        'size' => 30,
    ]
) ?>

<?php echo $this->tag->hiddenField(
    [
        'parent_id',
        'value' => '5',
    ]
) ?>
```

Volt syntax:

```twig
{{ text_field('username') }}

{{ text_area('comment', 'This is the content', 'cols': '6', 'rows': 20) }}

{{ password_field('password', 'size': 30) }}

{{ hidden_field('parent_id', 'value': '5') }}
```

<a name='select-boxes'></a>

## Making Select Boxes

Generating select boxes (select box) is easy, especially if the related data is stored in PHP associative arrays. The helpers for select elements are `Phalcon\Tag::select()` and `Phalcon\Tag::selectStatic()`. `Phalcon\Tag::select()` has been was specifically designed to work with the Phalcon [Models](/[[language]]/[[version]]/db-models) (`Phalcon\Mvc\Model`), while `Phalcon\Tag::selectStatic()` can with PHP arrays.

```php
<?php

$products = Products::find("type = 'vegetables'");

// Using data from a resultset
echo $this->tag->select(
    [
        'productId',
        $products,
        'using' => [
            'id',
            'name',
        ]
    ]
);

// Using data from an array
echo $this->tag->selectStatic(
    [
        'status',
        [
            'A' => 'Active',
            'I' => 'Inactive',
        ]
    ]
);
```

The following HTML will generated:

```html
    <select id='productId' name='productId'>
        <option value='101'>Tomato</option>
        <option value='102'>Lettuce</option>
        <option value='103'>Beans</option>
    </select>

    <select id='status' name='status'>
        <option value='A'>Active</option>
        <option value='I'>Inactive</option>
    </select>
```

You can add an `empty` option to the generated HTML:

```php
    <?php

    $products = Products::find("type = 'vegetables'");

    // Creating a Select Tag with an empty option
    echo $this->tag->select(
        [
            'productId',
            $products,
            'using'    => [
                'id',
                'name',
            ],
            'useEmpty' => true,
        ]
    );
```

Produces this HTML:

```html
<select id='productId' name='productId'>
    <option value=''>Choose..</option>
    <option value='101'>Tomato</option>
    <option value='102'>Lettuce</option>
    <option value='103'>Beans</option>
</select>
```

```php
<?php

$products = Products::find("type = 'vegetables'");

// Creating a Select Tag with an empty option with default text
echo $this->tag->select(
    [
        'productId',
        $products,
        'using'      => [
            'id',
            'name',
        ],
        'useEmpty'   => true,
        'emptyText'  => 'Please, choose one...',
        'emptyValue' => '@',
    ]
);
```

```html
<select id='productId' name='productId'>
    <option value='@'>Please, choose one..</option>
    <option value='101'>Tomato</option>
    <option value='102'>Lettuce</option>
    <option value='103'>Beans</option>
</select>
```

Volt syntax for above example:

```twig
    {# Creating a Select Tag with an empty option with default text #}
    {{ select('productId', products, 'using': ['id', 'name'],
        'useEmpty': true, 'emptyText': 'Please, choose one...', 'emptyValue': '@') }}
```

<a name='html-attributes'></a>

## Assigning HTML attributes

All the helpers accept an array as their first parameter which can contain additional HTML attributes for the element generated.

```php
<?php $this->tag->textField(
    [
        'price',
        'size'        => 20,
        'maxlength'   => 30,
        'placeholder' => 'Enter a price',
    ]
) ?>
```

or using Volt:

```twig
{{ text_field('price', 'size': 20, 'maxlength': 30, 'placeholder': 'Enter a price') }}
```

The following HTML is generated:

```html
<input type='text' name='price' id='price' size='20' maxlength='30'
       placeholder='Enter a price' />
```

<a name='helper-values'></a>

## Setting Helper Values

<a name='helper-values-form-controllers'></a>

### From Controllers

It is a good programming principle for MVC frameworks to set specific values for form elements in the view. You can set those values directly from the controller using `Phalcon\Tag::setDefault()`. This helper preloads a value for any helpers present in the view. If any helper in the view has a name that matches the preloaded value, it will use it, unless a value is directly assigned on the helper in the view.

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {
        $this->tag->setDefault('color', 'Blue');
    }
}
```

At the view, a selectStatic helper matches the same index used to preset the value. In this case `color`:

```php
<?php

echo $this->tag->selectStatic(
    [
        'color',
        [
            'Yellow' => 'Yellow',
            'Blue'   => 'Blue',
            'Red'    => 'Red',
        ]
    ]
);
```

This will generate the following select tag with the value 'Blue' selected:

```html
<select id='color' name='color'>
    <option value='Yellow'>Yellow</option>
    <option value='Blue' selected='selected'>Blue</option>
    <option value='Red'>Red</option>
</select>
```

<a name='helper-values-from-request'></a>

### From the Request

A special feature that the `Phalcon\Tag` helpers have is that they keep the values of form helpers between requests. This way you can easily show validation messages without losing entered data.

<a name='helper-values-directly'></a>

### Specifying values directly

Every form helper supports the parameter 'value'. With it you can specify a value for the helper directly. When this parameter is present, any preset value using setDefault() or via request will be ignored.

<a name='changing-document-title-dynamically'></a>

## Changing dynamically the Document Title

`Phalcon\Tag` offers helpers to change dynamically the document title from the controller. The following example demonstrates just that:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('Your Website');
    }

    public function indexAction()
    {
        $this->tag->prependTitle('Index of Posts - ');
    }
}
```

```php
<html>
    <head>
        <?php echo $this->tag->getTitle(); ?>
    </head>

    <body>

    </body>
</html>
```

The following HTML will generated:

```php
<html>
    <head>
        <title>Index of Posts - Your Website</title>
    </head>

    <body>

    </body>
</html>
```

<a name='static-content-helpers'></a>

## Static Content Helpers

`Phalcon\Tag` also provide helpers to generate tags such as script, link or img. They aid in quick and easy generation of the static resources of your application

<a name='static-content-helpers-images'></a>

### Obrazki

```php
<?php

// Generate <img src='/your-app/img/hello.gif'>
echo $this->tag->image('img/hello.gif');

// Generate <img alt='alternative text' src='/your-app/img/hello.gif'>
echo $this->tag->image(
    [
       'img/hello.gif',
       'alt' => 'alternative text',
    ]
);
```

Volt syntax:

```twig
{# Generate <img src='/your-app/img/hello.gif'> #}
{{ image('img/hello.gif') }}

{# Generate <img alt='alternative text' src='/your-app/img/hello.gif'> #}
{{ image('img/hello.gif', 'alt': 'alternative text') }}
```

<a name='static-content-helpers-stylesheets'></a>

### Stylesheets

```php
<?php

// Generate <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Rosario' type='text/css'>
echo $this->tag->stylesheetLink('http://fonts.googleapis.com/css?family=Rosario', false);

// Generate <link rel='stylesheet' href='/your-app/css/styles.css' type='text/css'>
echo $this->tag->stylesheetLink('css/styles.css');
```

Volt syntax:

```twig
{# Generate <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Rosario' type='text/css'> #}
{{ stylesheet_link('http://fonts.googleapis.com/css?family=Rosario', false) }}

{# Generate <link rel='stylesheet' href='/your-app/css/styles.css' type='text/css'> #}
{{ stylesheet_link('css/styles.css') }}
```

<a name='static-content-helpers-javascript'></a>

### Javascript

```php
<?php

// Generate <script src='http://localhost/javascript/jquery.min.js' type='text/javascript'></script>
echo $this->tag->javascriptInclude('http://localhost/javascript/jquery.min.js', false);

// Generate <script src='/your-app/javascript/jquery.min.js' type='text/javascript'></script>
echo $this->tag->javascriptInclude('javascript/jquery.min.js');
```

Volt syntax:

```twig
{# Generate <script src='http://localhost/javascript/jquery.min.js' type='text/javascript'></script> #}
{{ javascript_include('http://localhost/javascript/jquery.min.js', false) }}

{# Generate <script src='/your-app/javascript/jquery.min.js' type='text/javascript'></script> #}
{{ javascript_include('javascript/jquery.min.js') }}
```

<a name='static-content-helpers-html5'></a>

### HTML5 elements - generic HTML helper

Phalcon offers a generic HTML helper that allows the generation of any kind of HTML element. It is up to the developer to produce a valid HTML element name to the helper.

```php
<?php

// Generate
// <canvas id='canvas1' width='300' class='cnvclass'>
// This is my canvas
// </canvas>
echo $this->tag->tagHtml(
    'canvas', 
    [
        'id'    => 'canvas1', 
        'width' => '300', 
        'class' => 'cnvclass',
    ], 
    false, 
    true, 
    true
);
echo 'This is my canvas';
echo $this->tag->tagHtmlClose('canvas');
```

Volt syntax:

```php
{# Generate
<canvas id='canvas1' width='300' class='cnvclass'>
This is my canvas
</canvas> #}
{{ tag_html('canvas', ['id': 'canvas1', width': '300', 'class': 'cnvclass'], false, true, true) }}
    This is my canvas
{{ tag_html_close('canvas') }}
```

<a name='tag-helpers'></a>

## Tag Service

`Phalcon\Tag` is available via the [tag](/[[language]]/[[version]]/tag) service, this means you can access it from any part of the application where the services container is located:

```php
<?php echo $this->tag->linkTo('pages/about', 'About') ?>
```

You can easily add new helpers to a custom component replacing the service 'tag' in the services container:

```php
<?php

use Phalcon\Tag;

class MyTags extends Tag
{
    // ...

    // Create a new helper
    public static function myAmazingHelper($parameters)
    {
        // ...
    }

    // Override an existing method
    public static function textField($parameters)
    {
        // ...
    }
}
```

Then change the definition of the service [tag](/[[language]]/[[version]]/tag):

```php
<?php

$di['tag'] = function () {
    return new MyTags();
};
```

<a name='custom-helpers'></a>

## Creating your own helpers

You can easily create your own helpers. First, start by creating a new folder within the same directory as your controllers and models. Give it a title that is relative to what you are creating. For our example here, we can call it 'customhelpers'. Next we will create a new file titled `MyTags.php` within this new directory. At this point, we have a structure that looks similar to : `/app/customhelpers/MyTags.php`. In `MyTags.php`, we will extend the `Phalcon\Tag` and implement your own helper. Below is a simple example of a custom helper:

```php
<?php

use Phalcon\Tag;

class MyTags extends Tag
{
    /**
     * Generates a widget to show a HTML5 audio tag
     *
     * @param array
     * @return string
     */
    public static function audioField($parameters)
    {
        // Converting parameters to array if it is not
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Determining attributes 'id' and 'name'
        if (!isset($parameters[0])) {
            $parameters[0] = $parameters['id'];
        }

        $id = $parameters[0];

        if (!isset($parameters['name'])) {
            $parameters['name'] = $id;
        } else {
            if (!$parameters['name']) {
                $parameters['name'] = $id;
            }
        }

        // Determining widget value,
        // \Phalcon\Tag::setDefault() allows to set the widget value
        if (isset($parameters['value'])) {
            $value = $parameters['value'];

            unset($parameters['value']);
        } else {
            $value = self::getValue($id);
        }

        // Generate the tag code
        $code = '<audio id="' . $id . '" value="' . $value . '" ';

        foreach ($parameters as $key => $attributeValue) {
            if (!is_integer($key)) {
                $code.= $key . '="' . $attributeValue . '" ';
            }
        }

        $code.=' />';

        return $code;
    }
}
```

After creating our custom helper, we will autoload the new directory that contains our helper class from our `index.php` located in the public directory.

```php
<?php

use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault();
use Phalcon\Exception as PhalconException;

try {
    $loader = new Loader();

    $loader->registerDirs(
        [
            '../app/controllers',
            '../app/models',
            '../app/customhelpers', // Add the new helpers folder
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Assign our new tag a definition so we can call it
    $di->set(
        'MyTags',
        function () {
            return new MyTags();
        }
    );

    $application = new Application($di);

    $response = $application->handle();

    $response->send();
} catch (PhalconException $e) {
    echo 'PhalconException: ', $e->getMessage();
}
```

Now you are ready to use your new helper within your views:

```php
<body>

    <?php

    echo MyTags::audioField(
        [
            'name' => 'test',
            'id'   => 'audio_test',
            'src'  => '/path/to/audio.mp3',
        ]
    );

    ?>

</body>
```

You can also check out [Volt](/[[language]]/[[version]]/volt) a faster template engine for PHP, where you can use a more developer friendly syntax for helpers provided by `Phalcon\Tag`.