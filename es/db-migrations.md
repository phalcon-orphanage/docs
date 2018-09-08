<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Migraciones de Bases de Datos</a> <ul>
        <li>
          <a href="#schema-dumping">Volcado de esquema</a>
        </li>
        <li>
          <a href="#migration-class-anatomy">Anatomía de la clase de migración</a>
        </li>
        <li>
          <a href="#defining-columns">Definición de columnas</a>
        </li>
        <li>
          <a href="#defining-indexes">Definición de índices</a>
        </li>
        <li>
          <a href="#defining-references">Definición de referencias</a>
        </li>
        <li>
          <a href="#writing-migrations">Escribiendo migraciones</a>
        </li>
        <li>
          <a href="#running-migrations">Ejecutando migraciones</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Migraciones de Bases de Datos

Las migraciones son una manera conveniente para modificar su base de datos en una forma estructurada y organizada.

<div class="alert alert-danger">
    <p>
        Las migraciones están disponibles en las <a href="/[[language]]/[[version]]/devtools-usage">Herramientas de desarrollador de Phalcon</a> usted necesita por lo menos Phalcon versión 0.5.0 para utilizar herramientas de desarrollo.
    </p>
</div>

A menudo en el desarrollo necesitamos actualizar cambios en entornos de producción. Algunos de estos cambios podrían ser modificaciones de la base de datos como nuevos campos, nuevas tablas, eliminación de índices, etcétera.

Cuando se genera una migración se crea un conjunto de clases para describir cómo está estructurada la base de datos en ese preciso momento. Estas clases pueden utilizarse para sincronizar la estructura del esquema en bases de datos remotas configurando su base de datos para trabajar con los nuevos cambios que implementa la aplicación. Las migraciones describen estas transformaciones usando simple PHP.

<div align='center'>
    <iframe src='https://player.vimeo.com/video/41381817' width='500' height='281' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>

<a name='schema-dumping'></a>

## Volcado de esquema

Las [Herramientas de desarrollador de Phalcon](/[[language]]/[[version]]/devtools-usage) proporcionan secuencias de comandos para administrar las migraciones (generación, ejecución y cancelación).

Las opciones disponibles para la generación de migraciones son:

![](/images/content/migrations-1.png)

Ejecutando este script sin ningún parámetro simplemente descargará todos los objetos (tablas y vistas) de la base de datos en clases de migración.

Cada migración tiene un identificador de versión asociado. El número de versión nos permite identificar si la migración es más reciente o no, de la actual 'versión' de nuestra base de datos. Las versiones también informarán a Phalcon del orden de ejecución, cuando se ejecuta una migración.

![](/images/content/migrations-2.png)

Cuando se genera una migración, las instrucciones se muestran en la consola para describir los diferentes pasos de la migración y el tiempo de ejecución de esas declaraciones. Al final, se genera la versión de la migración.

Por defecto la [Herramienta para desarrolladores de Phalcon](/[[language]]/[[version]]/devtools-usage) utiliza el directorio `app/migrations` para volcar los archivos de migración. Usted puede cambiar la ubicación ajustando uno de los parámetros en el script de generación. Cada tabla de la base de datos tiene su respectiva clase generada en un archivo separado en un directorio que referencia su versión:

![](/images/content/migrations-2.png)

<a name='migration-class-anatomy'></a>

## Anatomía de la clase de migración

Cada archivo contiene una clase única que extiende la clase `Phalcon\Mvc\Model\Migration`. Estas clases normalmente tienen dos métodos: `up()` y `down()`. `up()` realiza la migración, mientras que `down()` la deshace.

`up()` también contiene el método mágico `morphTable()`. La magia viene cuando reconoce los cambios necesarios para sincronizar la tabla real en la base de datos a la descripción dada.

```php
<?php

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index as Index;
use Phalcon\Db\Reference as Reference;
use Phalcon\Mvc\Model\Migration;

class ProductsMigration_100 extends Migration
{
    public function up()
    {
        $this->morphTable(
            'products',
            [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type'          => Column::TYPE_INTEGER,
                            'size'          => 10,
                            'unsigned'      => true,
                            'notNull'       => true,
                            'autoIncrement' => true,
                            'first'         => true,
                        ]
                    ),
                    new Column(
                        'product_types_id',
                        [
                            'type'     => Column::TYPE_INTEGER,
                            'size'     => 10,
                            'unsigned' => true,
                            'notNull'  => true,
                            'after'    => 'id',
                        ]
                    ),
                    new Column(
                        'name',
                        [
                            'type'    => Column::TYPE_VARCHAR,
                            'size'    => 70,
                            'notNull' => true,
                            'after'   => 'product_types_id',
                        ]
                    ),
                    new Column(
                        'price',
                        [
                            'type'    => Column::TYPE_DECIMAL,
                            'size'    => 16,
                            'scale'   => 2,
                            'notNull' => true,
                            'after'   => 'name',
                        ]
                    ),
                ],
                'indexes' => [
                    new Index(
                        'PRIMARY',
                        [
                            'id',
                        ]
                    ),
                    new Index(
                        'product_types_id',
                        [
                            'product_types_id',
                        ]
                    ),
                ],
                'references' => [
                    new Reference(
                        'products_ibfk_1',
                        [
                            'referencedSchema'  => 'invo',
                            'referencedTable'   => 'product_types',
                            'columns'           => ['product_types_id'],
                            'referencedColumns' => ['id'],
                        ]
                    ),
                ],
                'options' => [
                    'TABLE_TYPE'      => 'BASE TABLE',
                    'ENGINE'          => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci',
                ],
            ]
        );
    }
}
```

La clase se llama `ProductsMigration_100`. El sufijo 100 se refiere a la versión 1.0.0. El método `morphTable()` recibe un array asociativo con 4 secciones posibles:

| Índice       | Descripción                                                                                                                                                            | Opcional |
| ------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | Una matriz con el conjunto de columnas de la tabla                                                                                                                     |    No    |
| `indexes`    | Una matriz con el conjunto de índices de la tabla.                                                                                                                     |    Sí    |
| `references` | Una matriz con el conjunto de referencias de la tabla (claves foráneas).                                                                                               |    Sí    |
| `options`    | Un array con un conjunto de opciones de creación de la tabla. Estas opciones están a menudo relacionadas al sistema de base de datos en la que se generó la migración. |    Sí    |

<a name='defining-columns'></a>

### Definición de columnas

`Phalcon\Db\Column` se utiliza para definir las columnas de la tabla. Encapsula una gran variedad de características relacionadas con la columna. Su constructor recibe como primer parámetro el nombre de columna y como segundo, una matriz que describe la misma. Las siguientes opciones están disponibles cuando se describen las columnas:

| Opción          | Descripción                                                                                                                         | Opcional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `type`          | Tipo de columna. Debe ser una constante de `Phalcon\Db\Column` (ver lista de abajo)                                               |    No    |
| `size`          | Algunos tipos de columnas como `VARCHAR` o `INTEGER` puede tener un tamaño específico                                               |    Sí    |
| `scale`         | Las columnas `DECIMAL` o `NUMBER` pueden tener una escala para especificar cuántos decimales deben almacenarse                      |    Sí    |
| `unsigned`      | Las columnas `INTEGER` pueden tener signo o no. Esta opción no se aplica a otros tipos de columnas                                  |    Sí    |
| `notNull`       | ¿La columna puede almacenar valores nulos?                                                                                          |    Sí    |
| `default`       | Define un valor predeterminado para una columna (sólo puede ser un valor real, no una función como `NOW()`)                         |    Sí    |
| `autoIncrement` | Con este atributo la columna se incrementará automáticamente con un entero. Solo una columna en la tabla puede tener este atributo. |    Sí    |
| `first`         | La columna debe colocarse en primera posición en el orden de columnas                                                               |    Sí    |
| `after`         | La columna debe colocarse después de la columna indicada                                                                            |    Sí    |

Las migraciones de bases de datos admiten los siguientes tipos de columna:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_TIMESTAMP`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_TEXT`
* `Phalcon\Db\Column::TYPE_BOOLEAN`
* `Phalcon\Db\Column::TYPE_FLOAT`
* `Phalcon\Db\Column::TYPE_DOUBLE`
* `Phalcon\Db\Column::TYPE_TINYBLOB`
* `Phalcon\Db\Column::TYPE_BLOB`
* `Phalcon\Db\Column::TYPE_MEDIUMBLOB`
* `Phalcon\Db\Column::TYPE_LONGBLOB`
* `Phalcon\Db\Column::TYPE_JSON`
* `Phalcon\Db\Column::TYPE_JSONB`
* `Phalcon\Db\Column::TYPE_BIGINTEGER`

<a name='defining-indexes'></a>

### Definición de índices

`Phalcon\Db\Index` define los índices de la tabla. Un índice solo requiere que definas un nombre y una lista de sus columnas. Tenga en cuenta que si cualquier índice tiene el nombre `PRIMARY`, Phalcon creará un índice de clave principal para esa tabla.

<a name='defining-references'></a>

### Definición de referencias

`Phalcon\Db\Reference` define las referencias de una tabla (también llamadas llaves foráneas). Las siguientes opciones pueden utilizarse para definir una referencia:

| Índice              | Descripción                                                                                               | Opcional | Implementado en  |
| ------------------- | --------------------------------------------------------------------------------------------------------- |:--------:| ---------------- |
| `referencedTable`   | Es auto descriptivo. Se refiere al nombre de la tabla referenciada.                                       |    No    | Todos            |
| `columns`           | Una matriz con el nombre de las columnas en la tabla que tiene la referencia                              |    No    | Todos            |
| `referencedColumns` | Una matriz con el nombre de las columnas de la tabla de referencia                                        |    No    | Todos            |
| `referencedSchema`  | La tabla de referencia está tal vez en otro esquema o base de datos. Esta opción le permite definir esto. |    Sí    | Todos            |
| `onDelete`          | Si se elimina el registro foráneo, realizar esta acción en el o los registros locales.                    |    Sí    | MySQL PostgreSQL |
| `onUpdate`          | Si se actualiza el registro foráneo, realizar esta acción en el o los registros locales.                  |    Sí    | MySQL PostgreSQL |

<a name='writing-migrations'></a>

## Escribiendo migraciones

Las migraciones no son sólo diseñadas para 'modificar' tablas. Una migración es sólo una clase regular de PHP por lo que no está limitado simplemente a estas funciones. Por ejemplo, después de agregar una columna, puedes escribir un código para establecer el valor de la columna en los registros existentes. Para más detalles y ejemplos de cada método, revise el [componente de base de datos](/[[language]]/[[version]]/db-layer).

```php
<?php

use Phalcon\Mvc\Model\Migration;

class ProductsMigration_100 extends Migration
{
    public function up()
    {
        // ...

        self::$_connection->insert(
            'products',
            [
                'Malabar spinach',
                14.50,
            ],
            [
                'name',
                'price',
            ]
        );
    }
}
```

<a name='running-migrations'></a>

## Ejecutando migraciones

Una vez que las migraciones generadas se cargan en el servidor de destino, usted puede fácilmente ejecutarlas como se muestra en el ejemplo siguiente:

![](/images/content/migrations-4.png)

![](/images/content/migrations-5.png)

Dependiendo de cuan desactualizada este la base de datos con respecto a las migraciones, Phalcon puede ejecutar varias versiones de la migración en el mismo proceso de migración. Si especifica una versión de destino, Phalcon ejecutará las migraciones necesarias hasta llegar a la versión especificada.