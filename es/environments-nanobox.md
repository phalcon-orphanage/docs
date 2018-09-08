<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Resumen</a> 
      <ul>
        <li>
          <a href="#create-project">Crear un Nuevo Proyecto</a>
        </li>
        <li>
          <a href="#boxfile-yml">Añadir un <code>boxfile.yml</code></a>
        </li>
        <li>
          <a href="#add-devtools">Añadir Phalcon Devtools a su <code>composer.json</code></a>
        </li>
        <li>
          <a href="#new-phalcon-app">Iniciar Nanobox y generar una nueva aplicación de Phalcon</a>
        </li>
        <li>
          <a href="#run-app">Ejecutar la aplicación localmente</a>
        </li>
        <li>
          <a href="#environment">Revisar el entorno</a>
        </li>
        <li>
          <a href="#conclusion">Phalcon y Nanobox</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Resumen

[Nanobox](https://nanobox.io) es una micro plataforma portable, para desarrollar y desplegar aplicaciones. Cuando trabajamos localmente, Nanobox utiliza cargadores de girar y configurar un entorno de desarrollo virtual configurado a sus necesidades específicas. Cuando esté listo para implementar servidores en vivo, Nanobox tomará ese mismo entorno y los girará para arriba en su proveedor de la nube de elección, donde puede gestionar y ampliar su aplicación a través de la consola de Nanobox.

En esta publicación, veremos cómo funciona una nueva aplicación Phalcon localmente, sin instalar nada más que Nanobox. Primero deberá [crear una cuenta gratuita en Nanobox](https://dashboard.nanobox.io/users/register), luego [descargar y ejecuta el instalador de Nanobox](https://dashboard.nanobox.io/download).

<a name='create-project'></a>

## Crear un Nuevo Proyecto

Crear una carpeta de proyecto y utilizar el comando `cd` en él:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

<a name='boxfile-yml'></a>

## Añadir un `boxfile.yml`

Nanobox utiliza el archivo [`boxfile.yml`](https://docs.nanobox.io/boxfile/) para construir y configurar su aplicación en tiempo de ejecución y entorno. En la raíz de su proyecto, crear un archivo `boxfile.yml` con lo siguiente:

```yaml
run.config:
  engine: php
  engine.config:
    runtime: php-7.1
    document_root: public
    extensions:

      - phalcon
  extra_steps:
    - echo "alias phalcon=\'phalcon.php\'" >> /data/var/home/gonano/.bashrc
```

Esto le indicará a Nanobox:

- Utilizar el [motor](https://docs.nanobox.io/engines/) de PHP, un conjunto de scripts que crean el tiempo de ejecución de la aplicación.
- Utilizar PHP 7.1.
- Establezca la raíz de documento de Apache en `public`.
- Incluir la extensión de Phalcon. *Nanobox adopta un enfoque básico para extensiones, así que es probable que necesite incluir otras extensiones. Puede encontrar más información [aquí](https://guides.nanobox.io/php/phalcon/php-extensions/).*
- Agregar un alias al bash para Phalcon Devtools por lo que se puede usar el comando `phalcon`.

<a name='add-devtools'></a>

## Añadir Phalcon Devtools a su `composer.json`

Cree un archivo `composer.json` en la raíz de su proyecto y agregue el paquete de `phalcon/devtools` a sus requisitos de dev:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

<div class='alert alert-warning'>
    <p>
        <strong>Nota</strong>: la versión de Phalcon Devtools depende de qué versión PHP estés utilizando.
    </p>
</div>

<a name='new-phalcon-app'></a>

## Iniciar Nanobox y generar una nueva aplicación de Phalcon

Desde la raíz de su proyecto, ejecute los siguientes comandos para iniciar Nanobox y generar una nueva aplicación de Phalcon. Cuando Nanobox inicia, el motor de PHP automáticamente instalará y habilitará la extensión de Phalcon, ejecutar un `composer install` para instalar Phalcon Devtools, luego lo dejará en una consola interactiva dentro del entorno virtual. El directorio de trabajo está montado en el directorio `/app` de la máquina virtual, los cambios que se hagan, se verán reflejados en la VM y en el directorio de trabajo local.

```bash
# iniciar nanobox e ingresar a la consola
nanobox run

# cambiar al directorio /tmp
cd /tmp

# generar una nueva aplicación Phalcon
phalcon project myapp

# cambiar al directorio /app
cd -

# copiar la aplicación generada al proyecto
cp -a /tmp/myapp/* .

# salir de la consola
exit
```

<a name='run-app'></a>

## Ejecutar la aplicación localmente

Antes de realmente ejecutar su nueva aplicación de Phalcon, recomendamos utilizar Nanobox para añadir un alias de DNS. Esto añade una entrada al archivo local `hosts` apuntando a su entorno dev y proporciona una manera conveniente de acceder a la aplicación desde un navegador.

```bash
nanobox dns add local phalcon.dev
```

Nanobox proporciona un script de ayuda `php-server` que inicia tanto Apache (o Nginx dependiendo de su configuración de `boxfile.yml`) y PHP. Cuando se pasa el comando `nanobox run`, iniciará el entorno dev local y ejecutar inmediatamente su aplicación.

```bash
nanobox run php-server
```

Una vez en funcionamiento, puede visitar su aplicación en [phalcon.dev](http://phalcon.dev).

<a name='environment'></a>

## Revisar el entorno

El entorno virtual incluye todo que lo necesario para ejecutar su aplicación Phalcon. Siéntase libre de investigar.

```bash
# ingresar a una consola Nanobox
nanobox run

# comprobar la versión de PHP
php -v

# comprobar la versión disponible de Phalcon Devtools
phalcon info

# Comprobar que tú código base esté montado
ls

# salir de la consola
exit
```

<a name='conclusion'></a>

## Phalcon y Nanobox

Nanobox le da todo lo que necesita para desarrollar y ejecutar su aplicación Phalcon en un entorno virtual aislado. Con el archivo `boxfile.yml` en su proyecto, los colaboradores se pueden poner en marcha en minutos simplemente ejecutando `nanobox run`.

Nanobox tiene un [Inicio rápido de Phalcon](https://github.com/nanobox-quickstarts/nanobox-phalcon) que incluye todo lo cubierto en esta publicación. También tienen guías para el [uso de Phalcon con Nanobox](https://guides.nanobox.io/php/phalcon/). En futuras publicaciones, nos gustaría cubrir otros aspectos de la utilización de Phalcon con Nanobox, como agregar y conectar a una base de datos, implementación de Phalcon en producción, etcétera. Si usted está interesado [háganoslo saber en Twitter](http://twitter.com/nanobox_io).