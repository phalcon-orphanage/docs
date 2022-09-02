---
layout: default
language: 'es-es'
version: '4.0'
title: 'Migraciones de Bases de Datos'
keywords: 'base de datos, migraciones, esquema, tablas, columnas'
---

# Migraciones de Bases de Datos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> **NOTA**: Las migraciones de Phalcon se han quitado de DevTools y se han movido a un repositorio separado.
{: .alert .alert-info } 

## Repositorio git del paquete

https://github.com/phalcon/migrations

## Requerimientos

* PHP >= 7.2
* Phalcon >= 4.0.5

## Instalación vía Composer

    composer require --dev phalcon/migrations
    

## Inicio rápido

Lo que necesita para un inicio rápido:

* Fichero de configuración en la raíz de su proyecto (también puede pasarlos como parámetros dentro del entorno CLI)
* Crear estructura de tablas de la base de datos
* Ejecutar comando para generar las migraciones

Después de eso puede ejecutar esas migraciones (run) en otro entorno para crear la misma estructura de BD.

### Crear fichero de configuración

```php
<?php

use Phalcon\Config;

return new Config([
    'database' => [
        'adapter' => 'mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname' => 'db-name',
        'charset' => 'utf8',
    ],
    'application' => [
        'logInDb' => true,
        'migrationsDir' => 'db/migrations',
        'migrationsTsBased' => true, // true - Use TIMESTAMP as version name, false - use versions
        'exportDataFromTables' => [
            // Tables names
            // Attention! It will export data every new migration
        ],
    ],
]);
```

### Generar migraciones

**Generación básica**

    vendor/bin/phalcon-migrations generate
    

**Genera una tabla específica y exporta sus datos

    vendor/bin/phalcon-migrations generate \
        --config=migrations.php \
        --table=users \
        --exportDataFromTables=users \
        --data=oncreate
    

### Ejecutar migraciones

    vendor/bin/phalcon-migrations run
    

### Listar migraciones existentes

    vendor/bin/phalcon-migrations list
    

## Ejemplo de uso

**Ejecutar migraciones desde directorio de migraciones específico**

    use Phalcon\Migrations\Migrations;
    
    $migration = new Migrations();
    $migration::run([
        'migrationsDir' => [
            __DIR__ . '/migrations',
        ],
        'config' => [
            'database' => [
                'adapter' => 'Mysql',
                'host' => 'phalcon-db-mysql',
                'username' => 'root',
                'password' => 'root',
                'dbname' => 'vokuro',
            ],
        ]
    ]);
    

## Métodos de migración

Cada migración está en una clase separada que trabaja como entidad para una tabla de base de datos específica. Dentro de cada clase hay diferentes métodos que pueden ocurrir durante la ejecución de la migración.

Cada fichero de migración (y clase) puede implementar métodos específicos, que serán ejecutados según la operación solicitada. No hay restricciones sobre la lógica encapsulada en cada método.

Las tablas siguiente muestran los métodos de la Clase `Migration`. Se almacenan por orden de ejecución, del más antiguo al más reciente.

**Ejecutándose hacia arriba**

| Nombre del método | Descripción                                             |
| ----------------- | ------------------------------------------------------- |
| morph             | Estructura morfológica de la tabla                      |
| afterCreateTable  | Hace algo inmediatamente después de crear la tabla      |
| up                | Tabla creada y lista para trabajar con ella             |
| afterUp           | Método extra para trabajar en algunos casos específicos |

**Ejecutándose hacia abajo**

| Nombre del método                 | Descripción                                                                                        |
| --------------------------------- | -------------------------------------------------------------------------------------------------- |
| down                              | Normalmente se pone aquí eliminación de la tabla o truncamiento de datos                           |
| afterDown                         | Método extra para trabajar después de que todo se haya limpiado                                    |
| morph (**de migración anterior**) | Como la migración ha sido movida hacia atrás, es necesario que todo se devuelva al estado anterior |

## Argumentos y opciones CLI

**Argumentos**

| Argumento | Descripción                             |
| --------- | --------------------------------------- |
| generate  | Genera una Migración                    |
| run       | Ejecuta una Migración                   |
| list      | Lista todas las migraciones disponibles |

**Opciones**

| Acción                   | Descripción                                                                                                         |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------- |
| --config=s               | Fichero de configuración                                                                                            |
| --migrations=s           | Directorio de migraciones. Use cadena separada por comas para especificar múltiples directorios                     |
| --directory=s            | Directorio donde se creó el proyecto                                                                                |
| --table=s                | Tabla a migrar. Nombre de la tabla o prefijo de tabla con asterisco. Por defecto: todas                             |
| --version=s              | Versión a migrar                                                                                                    |
| --descr=s                | Descripción de la migración (usado para migraciones basadas en marcas de tiempo)                                    |
| --data=s                 | Exportar datos \['always' o 'oncreate'\] (Los datos se importan durante la ejecución de la migración)               |
| --exportDataFromTables=s | Exportar datos de tablas específicas, usar cadena separadas por comas.                                              |
| --force                  | Fuerza a sobreescribir migraciones existentes                                                                       |
| --ts-based               | Versión de migraciones basadas en marcas de tiempo                                                                  |
| --log-in-db              | Mantiene el registro de migraciones en la tabla de base de datos en lugar de en fichero                             |
| --dry                    | Intenta la operación solicitada sin hacer cambios en el sistema (sólo generando)                                    |
| --verbose                | Muestra información de depuración durante la operación (sólo ejecutando)                                            |
| --no-auto-increment      | Deshabilita autoincremento (sólo generando)                                                                         |
| --skip-ref-schema        | Omitir referencedSchema en la migración generada (sólo generando)                                                   |
| --skip-foreign-checks    | Envuelve la consulta con `SET FOREIGN_KEY_CHECKS` antes y después de la ejecución de una consulta (sólo ejecutando) |
| --help                   | Muestra esta ayuda                                                                                                  |

## Migraciones basadas en marcas de tiempo

El uso de este enfoque es útil cuando más de un desarrollador está participando en la gestión de la estructura de base de datos. Use `'migrationsTsBased' => true` en el fichero de configuración o la opción `--ts-based` en el entorno CLI. También, necesita especificar el sufijo `descr`, que podría ser cualquier cosa que quiera, por ejemplo: versión semántica.

Comando actual

    vendor/bin/phalcon-migrations generate --ts-based --descr=1.0.0
    

Producirá el nombre de carpeta con tales nombres

* 1582539287636860_1.0.0
* 1682539471102635_1.0.0
* 1782539471102635_1.0.0

Las migraciones se ejecutarán de la más antigua a la más reciente.

> **NOTA**: Cuando se ejecuten las migraciones, las aplicación escanea todas las migraciones disponibles y su estado independientemente de su "edad". Si una o más no fueron ejecutadas en una ejecución anterior, serán ejecutadas en la siguiente ejecución.
{: .alert .alert-info }
