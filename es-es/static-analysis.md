---
layout: default
language: 'es-es'
version: '4.0'
title: 'Análisis Estático'
keywords: 'análisis estático, analizador estático, vimeo, psalm, phalcon'
---

# Análisis Estático
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg) ![](/assets/images/level-intermediate.svg)

## Resumen

Usar una herramienta de análisis estático en su proyecto puede incrementar dramáticamente su calidad de código y resaltar posibles errores que estén expuestos.

## Integrar Psalm con Phalcon

```bash
composer require --dev vimeo/psalm:^3.11
```

o agregando manualmente al archivo `composer.json`:

```json
{
    "require-dev": {
        "vimeo/psalm": "^3.11"
    }
}
```

### Stubs IDE Phalcon

Phalcon proporciona una librería *stub* que proporciona soporte para la mayoría de IDEs. Psalm requiere estos *stubs* para poder analizar correctamente el código base. Estos ficheros existen en el repositorio [Phalcon IDE Stubs](https://github.com/phalcon/ide-stubs).

Puede usar la librería *IDE Stubs* añadiéndola como dependencia:

```bash
composer require --dev phalcon/ide-stubs:^v4.0
```

o agregando manualmente al archivo `composer.json`:

```json
{
    "require-dev": {
        "phalcon/ide-stubs": ",^v4.0"
    }
}
```

## Inicializar Psalm

Ejecuta el comando `vendor/bin/psalm --init` en la raíz de su proyecto para inicializar Psalm. Psalm creará un fichero de configuración de proyecto predeterminado llamado `psalm.xml` en la raíz de su proyecto.

### Configuración de ejemplo con *Phalcon Stubs*

El siguiente fichero de configuración sirve como una buena base para usar en su proyecto. Sustituya los contenidos de `psalm.xml` con los contenidos de abajo y actualice cualquier parámetro aplicable a los ajustes de su proyecto.

Si encuentra que necesita *stubs* de componentes Phalcon adicionales, añádalos a la sección *stub* de la configuración con la ruta completa de su localización en el paquete `ide-stubs`.

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

### Ejecutar Psalm

Cuando ejecute `vendor/bin/psalm` en su línea de comandos, obtendrá una salida similar dependiendo de sus errores:

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

¡Corrija sus errores y vuelva a ejecutar Psalm!

## Recursos
- [Documentación Psalm](https://psalm.dev/docs/)
- [Análisis Estático con Psalm PHP](https://www.twilio.com/blog/static-analysis-with-psalm-php)
- [¿Qué es el Análisis Estático de Código?](https://www.perforce.com/blog/sca/what-static-analysis)
