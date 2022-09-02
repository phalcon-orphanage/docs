---
layout: default
language: 'de-de'
version: '4.0'
title: 'Static Analysis'
keywords: 'static analysis, static analyzer, vimeo, psalm, phalcon'
---

# Static Analysis
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-intermediate.svg)

## Overview

Using a static analysis tool in your project can dramatically increase your code quality and highlight potential bugs before they are exposed.

## Integrating Psalm with Phalcon

```bash
composer require --dev vimeo/psalm:^3.11
```

or by manually adding it to `composer.json`:

```json
{
    "require-dev": {
        "vimeo/psalm": "^3.11"
    }
}
```

### Phalcon IDE Stubs

Phalcon provides a stub library that provides support for most IDEs. Psalm requires these stubs in order to properly analyze the codebase. These files exist in the [Phalcon IDE Stubs](https://github.com/phalcon/ide-stubs) repository.

You can use the IDE Stubs library by adding it as a dependency:

```bash
composer require --dev phalcon/ide-stubs:^v4.0
```

or by manually adding it to `composer.json`:

```json
{
    "require-dev": {
        "phalcon/ide-stubs": ",^v4.0"
    }
}
```

## Initializing Psalm

Run the command `vendor/bin/psalm --init` in the root of your project to initialize Psalm. Psalm will create a default project configuration file called `psalm.xml` at the root of your project.

### Sample Configuration with Phalcon Stubs

The configuration file below serves as a good base to use in your project. Replace the contents in `psalm.xml` with the contents below and update any parameters applicable to your project settings.

If you find that you need to stub additional Phalcon components, add them to the stub section of the configuration with the full path to their location in the `ide-stubs` package.

```xml
<?xml version="1.0"?>
<psalm
    name="Phalcon - Psalm Config"
    totallyTyped="true"
    errorLevel="3"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
>
    <stubs>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Di/Injectable.php" />
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Di/AbstractInjectionAware.php"/>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Mvc/Controller.php"/>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Mvc/Model.php"/>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Validation.php"/>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Http/Response.php"/>
        <file name="vendor/phalcon/ide-stubs/src/Phalcon/Http/Request.php"/>
    </stubs>
    <projectFiles>
        <directory name="app" />
        <directory name="src" />
        <ignoreFiles>
            <directory name="vendor" />
            <directory name="public" />
        </ignoreFiles>
    </projectFiles>
    <issueHandlers>
        <PropertyNotSetInConstructor>
            <errorLevel type="suppress">
                <directory name="src"/>
            </errorLevel>
        </PropertyNotSetInConstructor>
        <MissingConstructor>
            <errorLevel type="suppress">
                <directory name="src/Controller"/>
            </errorLevel>
        </MissingConstructor>
    </issueHandlers>
</psalm>
```

### Running Psalm

When you execute `vendor/bin/psalm` in your command-line, you will a get similar output depending on your errors:

```bash
Scanning files...
Analyzing files...

░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░ 60 / 95 (63%)
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
------------------------------
No errors found!
------------------------------

Checks took 0.80 seconds and used 214.993MB of memory
Psalm was able to infer types for 92.9630% of the codebase
```

Fix your errors, and re-run Psalm!

## Resources
- [Psalm Documentation](https://psalm.dev/docs/)
- [Static Analysis with Psalm PHP](https://www.twilio.com/blog/static-analysis-with-psalm-php)
- [What Is Static Code Analysis?](https://www.perforce.com/blog/sca/what-static-analysis)
