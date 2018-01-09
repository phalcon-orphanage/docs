<div class='article-menu'>
  <ul>
    <li>
      <a href="#contributing">Contribuir con Phalcon</a> <ul>
        <li>
          <a href="#contributions">Contribuciones</a>
        </li>
        <li>
          <a href="#questions-and-support">Preguntas y ayuda</a>
        </li>
        <li>
          <a href="#bug-report-checklist">Lista de verificación para Reportes de Errores</a> 
          <ul>
            <li>
              <a href="#bug-report-generating-backtrace">Generar una traza inversa</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#pull-request-checklist">Checklist para una solicitud de Pull</a>
        </li>
        <li>
          <a href="#getting-support">Obtener ayuda</a>
        </li>
        <li>
          <a href="#requesting-features">Solicitar funcionalidades</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='contributing'></a>

# Contribuir con Phalcon

Phalcon es un proyecto de código abierto y depende en gran medida del esfuerzo de voluntarios. ¡Agradecemos las contribuciones de todo el mundo!

Por favor tome un momento para revisar este documento con el fin de hacer el proceso de contribución más fácil y eficaz.

Seguir estas directrices, permite una mejor comunicación, más rápida resolución de problemas y permite que el proyecto avance.

<a name='contributions'></a>

## Contribuciones

Las contribuciones para Phalcon deben realizarse en la forma de [Pull Requests de GitHub](https://help.github.com/articles/using-pull-requests/). Cada pull request será revisada por un colaborador principal (alguien con permiso para fusionar los pull requests). Basado en el tipo y contenido del pull request, puede ser fusionado inmediatamente, puesto en espera si se requieren aclaraciones, o bien, rechazado.

Por favor asegúrese que está enviando su pull request a la rama correcta y que ya cuenta con un rebase en el código.

<a name='questions-and-support'></a>

## Preguntas y Ayuda

<div class="alert alert-warning">
    <p>
       Solo aceptamos reportes de errores, solicitudes de nuevas características y pull requests en GitHub. Para preguntas referentes al uso del framework o solicitudes de ayuda, por favor visite los <a href="https://phalcon.link/forum">foros oficiales</a>.
    </p>
</div>

<a name='bug-report-checklist'></a>

## Lista de verificación para Reportes de Errores

- Asegúrese de que está utilizando la última versión publicada de Phalcon antes de presentar un informe de error. Los errores en versiones anteriores a la última lanzada no serán abordados por el equipo principal.
- Si has encontrado un error, es esencial añadir información relevante para reproducirlo. Ser capaz de reproducir un error reduce en gran manera el tiempo para investigar y solucionarlo. Esta información debe venir en la forma de un script, pequeña aplicación o incluso una prueba que falla. Para obtener más información, compruebe por favor [Presentar prueba Reproducible](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test).
- Como parte de su informe, por favor incluya información adicional, como el sistema operativo, versión de PHP, versión de Phalcon, servidor web, memoria, etcétera.
- Si estás enviando un error de [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), requerimos un backtrace. Consulte [generación de un Backtrace](#bug-report-generating-backtrace) para obtener más información.

<a name='bug-report-generating-backtrace'></a>

### Generación de un Backtrace

A veces debido a un error de [Fallo de segmentación](https://en.wikipedia.org/wiki/Segmentation_fault), Phalcon podría bloquear algunos procesos de su servidor web. Por favor ayúdenos a averiguar el problema añadiendo un backtrace del bloqueo de procesos a su informe de fallo.

Por favor siga estas indicaciones para entender cómo generar el backtrace:

- [Generando un backtrace de gdb](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generar una backtrace, con un compilador, en Win32](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Símbolos de depuración](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Compilando PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Lista de Verificación para Pull Request

- No envíe su pull request directamente a la rama `master`. Cree una rama de la rama requerida y, si es necesario, rebase a la rama adecuada antes de enviar su solicitud de pull request. Si no es posible hacer una fusión limpia con la rama master se te pedirá que hagas una nueva rama como base para tus cambios
- No pongas actualizaciones de submódulos, `composer.lock`, etc. en tu solicitud de extracción a menos que sean para commits fusionados
- Añadir pruebas relevantes para el error corregido o la nueva característica. Consulte nuestra [guía de la pruebas](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) para obtener más información
- Phalcon está escrito en [Zephir](https://zephir-lang.com/), por favor no envíe cambios que modifiquen archivos C que se generan directamente o de aquellos cuyas funcionalidad/correcciones se aplican en el lenguaje de programación C
- Asegúrese de que el código PHP que escriba ajusta con el estilo general y codificación estándar de las [Normas Aceptadas de PHP](http://www.php-fig.org/psr/)
- Retire cualquier cambio a los archivos `ext/kernel`, `*. zep.c` y `*. zep.h` antes de enviar su pull request

Antes de presentar **nuevas funcionalidades**, por favor abra una [NFR](/[[language]]/[[version]]/new-feature-request) (New Feature Request) como un tema nuevo en GitHub para debatir el impacto de incluir la funcionalidad o los cambios en la extensión. Una vez aprobada la funcionalidad, asegúrese de que su PR contiene lo siguiente:

- Una actualización al `CHANGELOG.md`
- Pruebas unitarias
- Documentación o ejemplos de uso

<a name='getting-support'></a>

## Solicitar Soporte

Si usted tiene una pregunta acerca de cómo utilizar Phalcon, consulte la [Página de soporte](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Solicitar Funcionalidades

Si usted tiene un cambio o una nueva funcionalidad en mente, por favor llene una [NFR](/[[language]]/[[version]]/new-feature-request).

¡Gracias!

<3 Phalcon Team