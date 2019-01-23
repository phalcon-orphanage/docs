---
layout: article
language: 'nl-nl'
version: '4.0'
---


<a name='overview'></a>

# Toegangscontrolelijst (ACL)

[Phalcon\Acl](api/Phalcon_Acl) biedt een eenvoudige en lichtgewicht beheer van toegangscontrole en machtigingen. [Toegangscontrolelijsten](https://en.wikipedia.org/wiki/Access_control_list) (ACL) geven een applicatie toegang tot de gebieden en de onderliggende objecten van aanvragen.

Kortom, ACL's heeft twee objecten: Het object dat toegang nodig heeft, en het object we toegang tot willen. In de programmering wereld, worden deze meestal aangeduid als Operations en Subjects (operaties en onderwerpen). In Phalcon gebruiken we deze terminologie ook [ Operation](api/Phalcon_Acl_Operation) en [ Subject ](api/Phalcon_Acl_Subject).

> **Voorbeeld**
> 
> Een boekhoudkundige toepassing moet verschillende groepen gebruikers toegang geven tot verschillende gebieden van de toepassing.
> 
> ** Operation** - beheerder toegang - boekhoudafdeling toegang - manager Toegang - gasten toegang
> 
> **Subject** - Login pagina - Beheerder pagina - facturatie pagina - rapporten pagina {:.alert .alert-info}

Zoals hierboven is te zien in het voorbeeld, een [Operation](api/Phalcon_Acl_Operation) wordt gedefinieerd als iets het nodig heeft voor toegang tot een bepaald [Subject](api/Phalcon_Acl_Subject) oftewel en gebied van de toepassing. Een [Subject](api/Phalcon_Acl_Subject) wordt gedefinieerd als het gebied van de toepassing die moet worden geopend.

Met behulp van het component [Phalcon\Acl](api/Phalcon_Acl), kunnen wij die twee verbinden, en gebruiken voor het beveiligen van onze applicatie, zodat alleen bepaalde bewerkingen kunnen worden gebonden aan specifieke onderwerpen.

<a name='setup'></a>

## Een ACL maken

[Phalcon\Acl](api/Phalcon_Acl) gebruikt een adapters om operations en subjects op te slaan en ermee te werken. De enige beschikbare adapter op dit moment is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Een memory adapter zorg voor een aanzienlijke verhoging in de snelheid wanneer de ACL wordt benaderd, maar heeft ook nadelen. Het grootste nadeel is dat het geheugen niet persistent is, dus de ontwikkelaar moet een opslagstrategie voor de ACL-gegevens implementeren, zodat de ACL niet op elk verzoek wordt gegenereerd. Dit kan gemakkelijk leiden tot vertragingen en onnodige verwerking, vooral als de ACL vrij groot en/of opgeslagen is in een database of bestand systeem.

Phalcon biedt ook een gemakkelijke manier voor ontwikkelaars om hun eigen adapters te bouwen door de [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface te implementeren.

### In actie

De [Phalcon\Acl](api/Phalcon_Acl) constructor neemt als eerste parameter een adapter die wordt gebruikt om de gegevens op te halen die nodig zijn voor de toegangscontrolelijst.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

Er zijn twee voor zichzelf sprekende acties die de [Phalcon\Acl](api/Phalcon_Acl) heeft: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

**`Phalcon\Acl::DENY`** Is de standaardactie voor elke [operatie](api/Phalcon_Acl_Operation) of [onderwerp](api/Phalcon_Acl_Subject). Dit is met opzet om ervoor te zorgen dat alleen de ontwikkelaar of de toepassing toegang tot specifieke onderwerpen verleent en niet in het de ACL-component zelf.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Standaard actie is geen toegang

// Verander de standaard naar toegang/allow
$acl->setDefaultAction(Acl::ALLOW);
```

<a name='adding-operations'></a>

## Operations toevoegen

As mentioned above, a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) is an object that can or cannot access a set of [Subject](api/Phalcon_Acl_Subject) in the access list.

There are two ways of adding operations to our list. * by using a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) object or * using a string, representing the name of the operation

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) objects in our list:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create some Operations.
 * 
 * The first parameter is the name of the operation, 
 * the second is an optional description
 */

$operationAdmins     = new Operation('admins', 'Administrator Access');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 

/**
 * Add these operations in the list 
 */
$acl->addOperation($operationAdmins);
$acl->addOperation($operationAccounting);

/**
 * Add operations without creating an object first 
 */
$acl->addOperation('manager');
$acl->addOperation('guest');
```

<a name='adding-subjects'></a>

## Adding Subjects

A [Subject](api/Phalcon_Acl_Subject) is the area of the application where access is controlled. In a MVC application, this would be a Controller. Although not mandatory, the [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) class can be used to define subjects in the application. Also it is important to add related actions to a subject so that the ACL can understand what it should control.

There are two ways of adding subjects to our list. * by using a [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) object or * using a string, representing the name of the operation

Similar to the `addOperation`, `addSubject` requires a name for the subject and an optional description.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Create some Subjects and add their respective actions in the ACL
 */
$admin   = new Subject('admin', 'Administration Pages');
$reports = new Subject('reports', 'Reports Pages');

/**
 * Add the subjects to the ACL and attach them to relevant actions 
 */
$acl->addSubject($admin, ['dashboard', 'users']);
$acl->addSubject($reports, ['list', 'add']);

/**
 * Add subjects without creating an object first 
 */
$acl->addSubject('admin', ['dashboard', 'users']);
$acl->addSubject('reports', ['list', 'add']);
```

<a name='access-controls'></a>

## Defining Access Controls

After both the `Operations` and `Subjects` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the operation since a small mistake here can allow access to operations for subjects that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl](api/Phalcon_Acl) is `Acl::DENY`, following the [whitelist](https://en.wikipedia.org/wiki/Whitelisting) approach.

To tie `Operations` and `Subjects` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory) class.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Add the operations
 */
$acl->addOperation('manager');
$acl->addOperation('accounting');
$acl->addOperation('guest');


/**
 * Add the Subjects
 */
$acl->addSubject('admin', ['dashboard', 'users', 'view']);
$acl->addSubject('reports', ['list', 'add', 'view']);
$acl->addSubject('session', ['login', 'logout']);

/**
 * Now tie them all together 
 */
$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');
```

What the above lines tell us:

```php
$acl->allow('manager', 'admin', 'users');
```

For the `manager` operation, allow access to the `admin` subject and `users` action. To bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `admin` controller and `users` action.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

You can also pass an array as the `action` parameter when invoking the `allow()` command. The above means that for the `manager` operation, allow access to the `reports` subject and `list` and `add` actions. Again to bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `reports` controller and `list` and `add` actions.

```php
$acl->allow('*', 'session', '*');
```

Wildcards can also be used to do mass matching for operations, subjects or actions. In the above example, we allow every operation to access every action in the `session` subject. This command will give access to the `manager`, `accounting` and `guest` operations, access to the `session` subject and to the `login` and `logout` actions.

```php
$acl->allow('*', '*', 'view');
```

Similarly the above gives access to any operation, any subject that has the `view` action. In a MVC application, the above is the equivalent of allowing any group to access any controller that exposes a `viewAction`.

> Please be **VERY** careful when using the `*` wildcard. It is very easy to make a mistake and the wildcard, although it seems convenient, it may allow users to access areas of your application that they are not supposed to. The best way to be 100% sure is to write tests specifically to test the permissions and the ACL. These can be done in the `unit` test suite by instantiating the component and then checking the `isAllowed()` if it is `true` or `false`.
> 
> [Codeception](https://codeception.com) is the chosen testing framework for Phalcon and there are plenty of tests in our github repository (`tests` folder) to offer guidance and ideas. {:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

For the `guest` operation, we deny access to all subjects with the `view` action. Despite the fact that the default access level is `Acl::DENY` in our example above, we specifically allowed the `view` action to all operations and subjects. This includes the `guest` operation. We want to allow the `guest` operation access only to the `session` subject and the `login` and `logout` actions, since `guests` are not logged into our application.

```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` operation to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```

<a name='querying'></a>

## Querying an ACL

Once the list has been defined, we can query it to check if a particular operation has access to a particular subject and action. To do so, we need to use the `isAllowed()` method.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addOperation('accounting');                   
$acl->addOperation('guest');                       


$acl->addSubject('admin', ['dashboard', 'users', 'view']);
$acl->addSubject('reports', ['list', 'add', 'view']);
$acl->addSubject('session', ['login', 'logout']);

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');

// ....


// true - defined explicitly
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - defiled with wildcard
$acl->isAllowed('manager', 'session', 'login');

// true - defined with wildcard
$acl->isAllowed('accounting', 'reports', 'view');

// false - defined explicitly
$acl->isAllowed('guest', 'reports', 'view');

// false - default access level
$acl->isAllowed('guest', 'reports', 'add');
```

<a name='function-based-access'></a>

## Function based access

Depending on the needs of your application, you might need another layer of calculations to allow or deny access to users through the ACL. The method `isAllowed()` accepts a 4th parameter which is a callable such as an anonymous function.

To take advantage of this functionality, you will need to define your function when calling the `allow()` method for the operation and subject you need. Assume that we need to allow access to all `manager` operations to the `admin` subject except if their name is 'Bob' (Poor Bob!). To achieve this we will register an anonymous function that will check this condition.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addSubject('admin', ['dashboard', 'users', 'view']);

// Set access level for operation into subjects with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

Now that the callable is defined in the ACL, we will need to call the `isAllowed()` method with an array as the fourth parameter:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addSubject('admin', ['dashboard', 'users', 'view']);

// Set access level for operation into subjects with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns true
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// Returns false
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> The fourth parameter must be an array. Each array element represents a parameter that your anonymous function accepts. The key of the element is the name of the parameter, while the value is what will be passed as the value of that the parameter of to the function. {:.alert .alert-info}

You can also omit to pass the fourth parameter to `isAllowed()` if you wish. The default action for a call to `isAllowed()` without the last parameter is `Acl::DENY`. To change this behavior, you can make a call to `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addSubject('admin', ['dashboard', 'users', 'view']);

// Set access level for operation into subjects with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns false
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(Acl::ALLOW);

// Returns true
$acl->isAllowed('manager', 'admin', 'dashboard');
```

<a name='objects'></a>

## Objects as operation name and subject name

Phalcon allows developers to define their own operation and subject objects. These objects must implement the supplied interfaces:

* [Phalcon\Acl\OperationAware](api/Phalcon_Acl_OperationAware) for Operation
* [Phalcon\Acl\SubjectAware](api/Phalcon_Acl_SubjectAware) for Subject

### Operation

We can implement the [Phalcon\Acl\OperationAware](api/Phalcon_Acl_OperationAware) in our custom class with its own logic. The example below shows a new operation object called `ManagerOperation`:

```php
<?php

use Phalcon\Acl\OperationAware;

// Create our class which will be used as operationName
class ManagerOperation implements OperationAware
{
    protected $id;

    protected $operationName;

    public function __construct($id, $operationName)
    {
        $this->id       = $id;
        $this->operationName = $operationName;
    }

    public function getId()
    {
        return $this->id;
    }

    // Implemented function from OperationAware Interface
    public function getOperationName()
    {
        return $this->operationName;
    }
}
```

### Subject

We can implement the [Phalcon\Acl\SubjectAware](api/Phalcon_Acl_SubjectAware) in our custom class with its own logic. The example below shows a new operation object called `ReportsSubject`:

```php
<?php

use Phalcon\Acl\SubjectAware;

// Create our class which will be used as subjectName
class ReportsSubject implements SubjectAware
{
    protected $id;

    protected $subjectName;

    protected $userId;

    public function __construct($id, $subjectName, $userId)
    {
        $this->id          = $id;
        $this->subjectName = $subjectName;
        $this->userId      = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // Implemented function from SubjectAware Interface
    public function getSubjectName()
    {
        return $this->subjectName;
    }
}
```

### ACL

These objects can now be used in our ACL.

```php
<?php

use ManagerOperation;
use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;
use ReportsSubject;

$acl = new AclList();

/**
 * Add the operations
 */
$acl->addOperation('manager');

/**
 * Add the Subjects
 */
$acl->addSubject('reports', ['list', 'add', 'view']);

/**
 * Now tie them all together with a custom function. The ManagerOperation and
 * ModelSbject parameters are necessary for the custom function to work 
 */
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerOperation $manager, ModelSubject $model) {
        return $manager->getId() === $model->getUserId();
    }
);

// Create the custom objects
$levelOne = new ManagerOperation(1, 'manager-1');
$levelTwo = new ManagerOperation(2, 'manager');
$admin    = new ManagerOperation(3, 'manager');

// id - name - userId
$reports  = new ModelSubject(2, 'reports', 2);

// Check whether our user objects have access 
// Returns false
$acl->isAllowed($levelOne, $reports, 'list');

// Returns true
$acl->isAllowed($levelTwo, $reports, 'list');

// Returns false
$acl->isAllowed($admin, $reports, 'list');
````

The second call for `$levelTwo` evaluates `true` since the `getUserId()` returns `2` which in turn is evaluated in our custom function. Also note that in the custom function for `allow()` the objects are automatically bound, providing all the data necessary for the custom function to work. The custom function can accept any number of additional parameters. The order of the parameters defined in the `function()` constructor does not matter, because the objects will be automatically discovered and bound.

<a name='operations-inheritance'></a>
## Operations Inheritance
To remove duplication and increase efficiency in your application, the ACL offers inheritance in operations. This means that you can define one [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) as a base and after that inherit from it offering access to supersets or subsets of subjects. To use operation inheritance, you need, you need to pass the inherited operation as the second parameter of the method call, when adding that operation in the list.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create the operations
 */
$manager    = new Operation('Managers');
$accounting = new Operation('Accounting Department');
$guest      = new Operation('Guests');

/**
 * Add the `guest` operation to the ACL 
 */
$acl->addOperation($guest);

/**
 * Add the `accounting` inheriting from `guest` 
 */
$acl->addOperation($accounting, $guest);
/**
 * Add the `manager` inheriting from `accounting` 
 */

$acl->addOperation($manager, $accounting);
```

Whatever access `guests` have will be propagated to `accounting` and in turn `accounting` will be propagated to `manager`

### Setup relationships after adding operations

Based on the application design, you might prefer to add first all the operations and then define the relationship between them.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create the operations
 */
$manager    = new Operation('Managers');
$accounting = new Operation('Accounting Department');
$guest      = new Operation('Guests');

/**
 * Add all the operations
 */
$acl->addOperation($manager);
$acl->addOperation($accounting);
$acl->addOperation($guest);

/**
 * Add the inheritance 
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```

<a name='serialization'></a>

## Serializing ACL lists

[Phalcon\Acl](api/Phalcon_Acl) can be serialized and stored in a cache system to improve efficiency. You can store the serialized object in APC, session, file system, database, Redis etc. This way you can retrieve the ACL quickly without having to read the underlying data that create the ACL nor will you have to compute the ACL in every request.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$aclFile = 'app/security/acl.cache';
// Check whether ACL data already exist
if (true !== is_file($aclFile)) {

    // The ACL does not exist - build it
    $acl = new AclList();

    // ... Define operations, subjects, access, etc

    // Store serialized list into plain file
    file_put_contents($aclFile, serialize($acl));
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(file_get_contents($aclFile));
}

// Use ACL list as needed
if (true === $acl->isAllowed('manager', 'admin', 'dashboard');) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

It is a good practice to not use serialization of the ACL during development, to ensure that your ACL is built in every request, while other adapters or means of serializing and storing the ACL in production.

<a name='events'></a>

## Events

[Phalcon\Acl](api/Phalcon_Acl) can work in conjunction with the [EventsManager](events) if present, to fire events to your application. Events are triggered using the type `acl`. Events that return `false` can stop the active operation. The following events are available:

| Event Name          | Triggered                                                   | Can stop operation? |
| ------------------- | ----------------------------------------------------------- |:-------------------:|
| `afterCheckAccess`  | Triggered after checking if a operation/subject has access  |         No          |
| `beforeCheckAccess` | Triggered before checking if a operation/subject has access |         Yes         |

The following example demonstrates how to attach listeners to the ACL:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Create an event manager
$eventsManager = new EventsManager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveOperation() . PHP_EOL;

        echo $acl->getActiveSubject() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new AclList();

// Setup the $acl
// ...

// Bind the eventsManager to the ACL component
$acl->setEventsManager($eventsManager);
```

<a name='custom-adapters'></a>

## Implementing your own adapters

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.