---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Filteronderdeel

* * *

- [Filteren & Zuiveren](filter-overview)
- [Ingebouwde Sanitizers](filter-sanitizers)
- [Opschonen van gegevens](filter-sanitizing)
- [Opschonen van Controllers](filter-sanitizing-from-controllers)
- [Schoonmaken van de Parameters van de actie](filter-sanitizing-action-parameters)
- [Data filteren](filter-sanitizing-data)
- [Het combineren van Sanitizers](filter-combining-sanitizers)
- [Complex Sanitizing and Filtering](filter-complex-sanitization-filtering)
- [Implementing your own Sanitizer](filter-custom)

* * *

## Filteren & Zuiveren

Opschonen van gebruikersinvoer is een cruciaal onderdeel van softwareontwikkeling. Vertrouwen of niet zuiveren van de gebruikersinvoer kan leiden tot niet-geautoriseerde toegang tot de inhoud van de aanvraag, voornamelijk gebruikersgegevens, of zelfs de server waar uw toepassing op wordt gehost.

![](/assets/images/content/filter-sql.png)

[Volledige afbeelding op XKCD](https://xkcd.com/327)

Filteren van inhoud kan worden bereikt met de [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) en [Phalcon\Filter\FilterLocatorFactory](api/Phalcon_Filter_FilterLocatorFactory) klassen.

## FilterLocatorFactory

Dit component maakt een nieuwe locator waar vooraf gedefinieerde filters aan verbonden zijn. Elk filter word pas bij aanroep geïnitialiseerd(lazy) voor maximale prestaties. Instantiëren van de fabriek en het ophalen van de [Phalcon\Filter\FilterLocator](api/Phalcon_Filter_FilterLocator) met de vooraf ingestelde sanitizers gebeurt door het aanroepen van `newInstance()`

```php
<?php

use Phalcon\Filter\FilterLocatorFactory;

$factory = new FilterLocatorFactory();
$locator = $factory->newInstance();
```

Je kunt nu de locator gebruiken waar je deze nodig hebt en zuiveren van de inhoud volgens de behoeften van de toepassing.

## FilterLocator

De filter-locator kan ook worden gebruikt als een stand-alone-component, zonder de ingebouwde filters te initialiseren.

```php
<?php

use MyApp\Sanitizers\HelloSanitizer;
use Phalcon\Filter\FilterLocator;

$services = [
    'hello' => HelloSanitizer::class,
];
$locator = new FilterLocator($services);
$text    = $locator->hello('World');
```

> De `Phalcon\Di` container heeft al een `Phalcon\Filter\FilterLocator` -object geladen met de vooraf gedefinieerde sanitizers. Het onderdeel kan worden gebruikt met behulp van de `filter` naam. {: .alert .alert-info }