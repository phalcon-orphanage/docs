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

A veces debido a un error de [Fallo de segmentación](https://en.wikipedia.org/wiki/Segmentation_fault), Phalcon podría bloquear algunos procesos de su servidor web. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Pull Request Checklist

- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase your changes
- Don't put submodule updates, `composer.lock`, etc in your pull request unless they are to merged commits
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon is written in [Zephir](https://zephir-lang.com/), please do not submit commits that modify C generated files directly or those whose functionality/fixes are implemented in the C programming language
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](http://www.php-fig.org/psr/)
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request

Before submit **new functionality**, please open a [NFR](/[[language]]/[[version]]/new-feature-request) as a new issue on GitHub to discuss the impact of include the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

<a name='getting-support'></a>

## Getting Support

If you have a question about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Requesting Features

If you have a change or new feature in mind, please fill an [NFR](/[[language]]/[[version]]/new-feature-request).

Thanks!

<3 Phalcon Team