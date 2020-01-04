---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Forms'
keywords: 'forms, render html, validation, elements'
---

# Forms

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble

Phalcon offers a components under the `Phalcon\Forms` namespace that help developers create and maintain forms that can be used to render HTML elements on screen but also perform validations on the input from those elements.

```php
<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

$form = new Form();

$form->add(
    new Text(
        'nameLast'
    )
);

$form->add(
    new Text(
        'nameFirst'
    )
);

$form->add(
    new Select(
        'phoneType',
        [
            1 => 'Home',
            2 => 'Work',
            3 => 'Mobile',
        ]
    )
);
```

In the template:

```php
<h1>
    Contacts
</h1>

<form method='post'>

    <p>
        <label>
            Last Name
        </label>

        <?php echo $form->render('nameLast'); ?>
    </p>

    <p>
        <label>
            First Name
        </label>

        <?php echo $form->render('nameFirst'); ?>
    </p>

    <p>
        <label>
            Gender
        </label>

        <?php echo $form->render('phoneType'); ?>
    </p>

    <p>
        <input type='submit' value='Save' />
    </p>

</form>
```

Each element in the form can be rendered as required by the developer. Internally, [Phalcon\Tag](tag) is used to produce the correct HTML for each element and you can pass additional HTML attributes as the second parameter of `render()`:

```php
<p>
    <label>
        Name
    </label>

    <?php 
        echo $form->render(
            'nameFirst', 
            [
                'maxlength'   => 30, 
                'placeholder' => 'First Name',
            ]
        ); ?>
</p>
```

HTML attributes also can be set in the element's definition:

```php
<?php

use Phalcon\Forms\Form;

$form = new Form();

$form->add(
    new Text(
        'nameFirst',
        [
            'maxlength'   => 30, 
            'placeholder' => 'First Name',
        ]
    )
);
```

## Méthodes

[Phalcon\Forms\Form](api/phalcon_forms#forms-form) exposes a number of methods that help with setting up a form with the necessary elements so that it can be used for validation, rendering elements etc.

```php
public function __construct(
    mixed $entity = null, 
    array $userOptions = []
)
```

Constructor. Accepts optionally an `entity` object which will be read internally. If the properties of the object contain properties that match the names of the elements defined in the form, those elements will be populated with the values of the corresponding properties of the entity. The entity can be an object such as a [Phalcon\Mvc\Model](db-models) or even a `\stdClass`. The second parameter is `userOptions` an optional array with user defined data.

> **NOTE**: If the form has the `initialize` method present, the constructor will call it automatically with the same parameters
{: .alert .alert-info }

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;

$form = new Form(
    null,
    [
        'phoneTypes' => [
            1 => 'Home',
            2 => 'Work',
            3 => 'Mobile',
        ],
    ]
);

$form->add(
    new Text(
        'nameLast'
    )
);

$form->add(
    new Text(
        'nameFirst'
    )
);

$options    = $this->getUserOptions();
$phoneTypes = $options['phoneTypes'] ?? [];
$form->add(
    new Select(
        'phoneType',
        $phoneTypes
    )
);
```

If the `entity` is passed and it is not an object, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function add(
    ElementInterface $element, 
    string $position = null, 
    bool $type = null
): Form
```

Adds an element to the form. The first parameter is an `ElementInterface` object. The second parameter `position` (if defined) is the name of the existing element we are targeting. The third boolean parameter `type` if set to `true` the new element will be added before the element defined in `position`. If not set or set to `null`/`false`, the new element will be added after the one defined by the `position` parameter.

```php
public function bind(
    array $data, 
    mixed $entity, 
    array $whitelist = []
): Form
```

Binds data to the entity. The first parameter `data` is an array of key/values. This usually is the `$_POST` array. The second parameter `entity` is an entity object. If the properties of the entity object contain properties that match the names of the `data`elements defined in the form, those elements will be populated with the values of the corresponding properties of the entity. The entity can be an object such as a [Phalcon\Mvc\Model](db-models) or even a `\stdClass`. The third parameter `whitelist` is an array of whitelisted elements. Any element in the `whitelist` array that has the same name as an element in the `data` array will be ignored.

The `bind` method takes the first array (e.g `$_POST`) and an entity object (e.g. `Invoices`). It loops through the array and if it finds an array key that exists in the form, it applies the necessary filters (defined in the form) to the value of the array. After that, it checks the entity object (`Invoices`) and assigns this value to any property that matches the array key. If a method exists as a setter with the same name as an array key, it will be called first (i.e. `name` -> `setName()`). This method allows us to quickly filter input and assign this input to the passed entity object.

```php
<?php

$form->bind($_POST, $customer);

if (true === $form->isValid()) {
    $customer->save();
}
```

If there are no elements in the form, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function clear(mixed $fields = null): Form
```

Clears every element in the form to its default value. If the passed parameter `fields` is a string, only that field will will be cleared. If an array is passed, all elements in the array will be cleared. Finally, if nothing is passed, all fields will be cleared.

```php
public function count(): int
```

Returns the number of elements in the form

```php
public function current(): ElementInterface | bool
```

Returns the current element in the iterator

```php
public function get(string $name): ElementInterface
```

Returns an element added to the form by its name. If the element is not found in the form, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function getAction(): string
```

Returns the form's action

```php
public function getAttributes(): Attributes
```

Returns the form's attributes collection. The object returned is [Phalcon\Html\Attributes](api/phalcon_html#html-attributes).

```php
public function getElements(): ElementInterface[]
```

Returns the form elements added to the form

```php
public function getEntity()
```

Returns the entity related to the model

```php
public function getLabel(string $name): string
```

Returns a label for an element. If the element is not found in the form, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function getMessages(): Messages | array
```

Returns the messages generated in the validation.

```php
if (false === $form->isValid($_POST)) {
    $messages = $form->getMessages();
    foreach ($messages as $message) {
        echo $message, "<br>";
    }
}
```

```php
public function getMessagesFor(string $name): Messages
```

Returns the messages generated for a specific element

```php
public function getValidation(): ValidationInterface
```

Returns the validator object registered in the form

```php
public function getUserOption(
    string option, 
    mixed defaultValue = null
): mixed
```

Returns the value of an option if present. If the option is not present the `defaultValue` will be returned.

```php
public function getUserOptions(): array
```

Returns the options for the element

```php
public function getValue(string $name): mixed | null
```

Gets a value from the internal related entity or from the default value

```php
public function has(string $name): bool
```

Check if the form contains an element

```php
public function hasMessagesFor(string $name): bool
```

Check if messages were generated for a specific element

```php
public function isValid(
    array $data = null, 
    object $entity = null
): bool
```

Validates the form. The first element is the data that has been provided by the user. This is usually the `$_POST` array. There is an optional `entity` parameter, which, if passed, will be populated by the user input after all validations and filtering have been completed.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

if (true === $form->isValid($_POST, $customer)) {
    $customer->save();
}
```

```php
public function key(): int
```

Returns the current position/key in the iterator

```php
public function label(
    string $name, 
    array $attributes = null
): string
```

Generate the label of an element added to the form including HTML. The first parameter is the name of the element while the second one is an array with optional parameters that need to be added to the `<label>` HTML tag. Such parameter can be CSS classes for instance. If the element is not found in the form, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function next(): void
```

Moves the internal iteration pointer to the next position

```php
public function render(
    string $name, 
    array attributes = []
): string
```

Renders a specific item in the form. The optional `attributes` array parameter can be used to pass additional parameters for the element to be rendered. If the element is not found in the form, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

```php
public function remove(string $name): bool
```

Removes an element from the form

```php
public function rewind(): void
```

Rewinds the internal iterator

```php
public function setAction(string $action): Form
```

Sets the form's action

```php
public function setEntity(object $entity): Form
```

Sets the entity related to the model

```php
public function setAttributes(
    Attributes> $attributes
): AttributesInterface
```

Set form attributes collection

```php
public function setValidation(
    ValidationInterface $validation
);
```

Sets the validation object in the form.

```php
public function setUserOption(
    string $option, 
    mixed $value
): Form
```

Sets a user defined option for the form

```php
public function setUserOptions(array $options): Form
```

Sets user defined options for the form

```php
public function valid(): bool
```

Returns if the current element in the iterator is valid or not

## Initialization

Forms can be initialized outside the form class by adding elements to it. However you can reuse code or organize your form classes by implementing forms in their own classes:

```php
<?php

use MyApp\Models\PhoneTypes;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class CustomersForm extends Form
{
    public function initialize()
    {
        $this->add(
            new Text(
                'nameLast'
            )
        );

        $this->add(
            new Text(
                'nameFirst'
            )
        );

        $this->add(
            new Select(
                'phoneType',
                PhoneTypes::find(),
                [
                    'emptyText'  => 'Select one...',
                    'emptyValue' => '',
                    'useEmpty'   => true,
                    'using'      => [
                        'typ_id',
                        'typ_name',
                    ],
                ]
            )
        );
    }
}
```

We can also pass an array of user defined options in the constructor, that will offer more functionality.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class CustomersForm extends Form
{
    public function initialize(
        Customers $customer,
        array $options
    ) {
        $mode = $options['mode'] ?? 'view';
        if ('edit' === $mode) {
            $this->add(
                new Hidden(
                    'id'
                )
            );
        }

        $this->add(
            new Text(
                'nameLast'
            )
        );

        $this->add(
            new Text(
                'nameFirst'
            )
        );
    }
}
```

In the form's instantiation you will use:

```php
<?php

use MyApp\Models\Customers;

$form = new CustomersForm(
    new Customers(),
    [
        'mode' => 'edit',
    ]
);
```

The code above will check the `options` array during the `initialize` method. The code will check for the `mode` element in the array and if not present it will default to `view`. If the `mode` is `edit`, we are going to add a [Phalcon\Forms\Element\Hidden](api/phalcon_forms#forms-element-hidden) element with the entity's ID in the form. By using the `options` array we can create reusable forms and also pass in our form additional data that could be required.

## Entities

An entity such as a [Phalcon\Mvc\Model](db-models), a PHP class or even a `\stdClass` object can be passed to the form in order to set default values, or to assign the values from the form to the object.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

$form->add(
    new Text(
        'nameFirst'
    )
);

$form->add(
    new Text(
        'nameLast'
    )
);
```

Once the form is rendered if there are no default values assigned to the elements it will use the ones provided by the entity:

```php
<?php echo $form->render('nameLast'); ?>
```

You can also validate the form and assign the values from the user input to the entity as follows:

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Forms\Form;

$customer = Customers::findFirst();
$form = new Form($customer);

$form->bind($_POST, $customer);

if (true === $form->isValid()) {
    $customer->save();
}
```

In the above example, we get the first `Customer` record. We pass that object in our form to populate it with initial values. Following that we call the `bind` method with the entity and the `$_POST` array. The form will automatically filter input from the `$_POST` and assign the input to the entity object (`Customers`). We can then save the object if the form has passed validation.

We can also use a PHP class as an entity:

```php
<?php

class Preferences
{
    public $timezone = 'Europe/Amsterdam';

    public $receiveEmails = 'No';
}
```

Using this class as entity, allows the form to take the default values from it:

```php
<?php

$form = new Form(
    new Preferences()
);

$form->add(
    new Select(
        'timezone',
        [
            'America/New_York'  => 'New York',
            'Europe/Amsterdam'  => 'Amsterdam',
            'America/Sao_Paulo' => 'Sao Paulo',
            'Asia/Tokyo'        => 'Tokyo',
        ]
    )
);

$form->add(
    new Select(
        'receiveEmails',
        [
            'Yes' => 'Yes, please!',
            'No'  => 'No, thanks',
        ]
    )
);
```

Entities can implement getters, which have a higher precedence than public properties. These methods offer more flexibility to generate values:

```php
<?php

class Preferences
{
    public $timezone;

    public $receiveEmails;

    public function getTimezone()
    {
        return 'Europe/Amsterdam';
    }

    public function getReceiveEmails()
    {
        return 'No';
    }
}
```

For the above entity class, the `getReceiveEmails` and `getTimezone` methods will be used instead of the `receiveEmails` and `timezone` properties.

## Elements

Phalcon provides a set of built-in elements to use in your forms, all these elements are located in the `Phalcon\Forms\Element` namespace:

| Name                                                                          | Description                                 |
| ----------------------------------------------------------------------------- | ------------------------------------------- |
| [Phalcon\Forms\Element\Check](api/phalcon_forms#forms-element-check)       | Generate `input[type=check]` elements       |
| [Phalcon\Forms\Element\Date](api/phalcon_forms#forms-element-date)         | Generate `input[type=date]` elements        |
| [Phalcon\Forms\Element\Email](api/phalcon_forms#forms-element-email)       | Generate `input[type=dateemail]` elements   |
| [Phalcon\Forms\Element\File](api/phalcon_forms#forms-element-file)         | Generate `input[type=file]` elements        |
| [Phalcon\Forms\Element\Hidden](api/phalcon_forms#forms-element-hidden)     | Generate `input[type=hidden]` elements      |
| [Phalcon\Forms\Element\Numeric](api/phalcon_forms#forms-element-numeric)   | Generate `input[type=number]` elements      |
| [Phalcon\Forms\Element\Password](api/phalcon_forms#forms-element-password) | Generate `input[type=password]` elements    |
| [Phalcon\Forms\Element\Radio](api/phalcon_forms#forms-element-radio)       | Generate `radio` elements                   |
| [Phalcon\Forms\Element\Select](api/phalcon_forms#forms-element-select)     | Generate `select` elements based on choices |
| [Phalcon\Forms\Element\Submit](api/phalcon_forms#forms-element-submit)     | Generate `input[type=submit]` elements      |
| [Phalcon\Forms\Element\Text](api/phalcon_forms#forms-element-text)         | Generate `input[type=text]` elements        |
| [Phalcon\Forms\Element\TextArea](api/phalcon_forms#forms-element-textarea) | Generate `textarea` elements                |

These elements use the [Phalcon\Tag](tag) component transparently.

> **NOTE**: For more information regarding HTML elements, you can check our [Tag document](tag)
{: .alert .alert-info }

The [Phalcon\Forms\Element\Select](api/phalcon_forms#forms-element-select) supports the `useEmpty` option to enable the use of a blank element within the list of available options. The options `emptyText` and`emptyValue` are optional, which allow you to customize, respectively, the text and the value of the empty element

You can also create your own elements by extending the [Phalcon\Forms\Element\ElementInterface](api/phalcon_forms#forms-element-elementinterface) interface.

```php
<?php

use Phalcon\Forms\Element;

class MyElement extends Element
{
    public function render($attributes = null)
    {
        $html = '';// HTML

        return $html;
    }
}
```

## Filtering

A form is also able to filter data before it is validated. You can set filters in each element:

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

$form = new Form();

$name = new Text('nameLast');
$name->setFilters(
    [
        'string',
        'trim',
    ]
);
$form->add($name);

$email = new Text('email');
$email->setFilters(
    'email'
);
$form->add($email);
```

> **NOTE**: For more information regarding filters, you can check our [Filter document](filters)
{: .alert .alert-info }

## Validation

Phalcon forms are integrated with the <validation> component to offer instant validation. Built-in or custom validators could be set to each element:

```php
<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

$name = new Text(
    'nameLast'
);

$name->addValidator(
    new PresenceOf(
        [
            'message' => 'The name is required',
        ]
    )
);

$name->addValidator(
    new StringLength(
        [
            'min'            => 10,
            'messageMinimum' => 'The name is too short',
        ]
    )
);

$form->add($name);
```

Then you can validate the form according to the input entered by the user:

```php
<?php

if (false === $form->isValid($_POST)) {
    $messages = $form->getMessages();

    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

Validators are executed in the same order as they were registered.

By default messages generated by all the elements in the form are joined so they can be traversed using a single `foreach`. You can also get specific messages for an element:

```php
<?php

$messages = $form->getMessagesFor('nameLast');

foreach ($messages as $message) {
    echo $message, '<br>';
}
```

## Rendering

You can render the form with total flexibility, the following example shows how to render each element using a standard procedure:

```php
<form method='post'>
    <?php

        // Traverse the form
        foreach ($form as $element) {
            // Get any generated messages for the current element
            $messages = $form->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Print each element
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $message;
                }

                echo '</div>';
            }

            echo '<p>';
            echo '<label for="' . 
                    $element->getName() .
                 '">' .
                 $element->getLabel() .
                 '</label>' 
             ;

            echo $element;
            echo '</p>';
        }
    ?>

    <input type='submit' value='Send' />
</form>
```

Or reuse the logic in your form class:

```php
<?php

use Phalcon\Forms\Form;

class ContactForm extends Form
{
    public function initialize()
    {
        // ...
    }

    public function renderDecorated($name)
    {
        $element  = $this->get($name);
        $messages = $this->getMessagesFor(
            $element->getName()
        );

        if (count($messages)) {
            echo "<div class='messages'>";

            foreach ($messages as $message) {
                echo $this->flash->error($message);
            }

            echo '</div>';
        }

        echo '<p>';
        echo '<label for="' .
                $element->getName() .
             '">' .
             $element->getLabel() .
             '</label>';

        echo $element;
        echo '</p>';
    }
}
```

In the view:

```php
<?php

echo $element->renderDecorated('nameLast');
echo $element->renderDecorated('nameFirst');
```

## Events

Whenever forms are implemented as classes, the callbacks: `beforeValidation()` and `afterValidation()` methods can be implemented in the form's class to perform pre-validations and post-validations:

```php
<?php

use Phalcon\Forms\Form;

class ContactForm extends Form
{
    public function beforeValidation()
    {

    }
}
```

## Manager

This component provides the [Phalcon\Forms\Manager](api/phalcon_forms#forms-manager) that can be used by the developer to register forms and access them via the service locator:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Forms\Manager;

$container = new FactoryDefault();
$container->set(
    'forms',
    function () {
        return new Manager();
    }
);
```

Forms are added to the forms manager and referenced by a unique name:

```php
<?php

$this
    ->forms
    ->set(
        'login',
        new LoginForm()
    )
;
```

Using the unique name, forms can be accessed in any part of the application:

```php
<?php

$loginForm = $this->forms->get('login');

echo $loginForm->render();
```

If a form is not found in the manager, a [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception) will be thrown.

## Exceptions

Any exceptions thrown in the `Phalcon\Forms` namespace will be [Phalcon\Forms\Exception](api/phalcon_forms#forms-exception). You can use these exceptions to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Forms\Exception;
use Phalcon\Forms\Manager;
use Phalcon\Mvc\Controller;

/**
 * @property Manager $forms
 */
class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->forms->get('unknown-form');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Dependency Injection

[Phalcon\Forms\Form](api/phalcon_forms#forms-form) extends [Phalcon\Di\Injectable](api/phalcon_di#di-injectable) so you have access to the application services if needed:

```php
<?php

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Security;

/**
 * @property Security $security
 */
class ContactForm extends Form
{
    public function initialize()
    {
        // Set the same form as entity
        $this->setEntity($this);

        // Add a text element to capture the 'email'
        $this->add(
            new Text(
                'email'
            )
        );

        // Add a text element to put a hidden CSRF
        $this->add(
            new Hidden(
                'csrf'
            )
        );
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}
```

## Additional Resources

* [Vökuró](https://github.com/phalcon/vokuro), is a sample application that uses the forms builder to create and manage forms, [[GitHub](https://github.com/phalcon/vokuro)]