<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">FAQ - Preguntas frecuentes</a>
      <ul>
        <li>
          <a href="#what-is-phalcon">Qué es Phalcon</a>
        </li>
        <li>
          <a href="#how-phalcon-works">Cómo funciona Phalcon</a>
        </li>
        <li>
          <a href="#how-can-i-help">¿Cómo puedo ayudar?</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# FAQ - Preguntas frecuentes

<a name='what-is-phalcon'></a>

## Qué es Phalcon

Phalcon es un framework open source full stack para PHP, escrito como una extensión en C.

<a name='how-phalcon-works'></a>

## Cómo funciona Phalcon

Phalcon *no* es un acelerador de PHP o un proyecto escrito en PHP. *(Para un lenguaje similar a PHP para producir extensiones C de alto rendimiento, consulte [Zephir](https://github.com/falcon/zephir))*

Phalcon es un framework que implementa su funcionalidad utilizando el lenguaje C de bajo nivel. Las extensiones de C se compilan junto con tu código PHP en la carga. Aumentando la velocidad de aplicación y bajando su sobrecarga.

Phalcon logra esto por:

- Tomando ventaja de la compilación nativa mediante la producción de una [representación ejecutable binaria](https://en.wikipedia.org/wiki/Machine_code) del código que un procesador puede entender directamente y ejecutar sin la sobrecarga de ejecutar bytecode en una máquina virtual (VM).

- Reducir el impacto en memoria mediante el uso optimizado de estructuras de propósito específico C y tipos estáticos C compiladores, como GCC / CLANG / VCC. Estos realizan [varias optimizaciones](https://en.wikipedia.org/wiki/Category:Compiler_optimizations) sobre el código, mejorando el rendimiento.

- La capacidad de colocar las variables y datos en la pila. Por lo general hay un mayor [locality](https://en.wikipedia.org/wiki/Locality_of_reference) de acceso.

- La predicción de bifurcaciones es más fácil ya que funciona directamente sobre el código del usuario y no sobre la aplicación VM. *Místicamente puestos juntos en una gran explicación en [StackOverflow](https://stackoverflow.com/a/11227902/1661465).*

- Tener acceso directo a las estructuras internas y funciones reduce la [sobrecarga de cálculo](https://en.wikipedia.org/wiki/CPU-bound).

- [Usando el perfil guiado optimización (PGO)](https://en.wikipedia.org/wiki/Profile-guided_optimization) para mejorar el rendimiento en base a perfiles de ejecución existentes.

<br /> *Por [Wikipedia](https://en.wikipedia.org/wiki/Profile-guided_optimization). Optimización guiada por perfiles (PGO, a veces pronunciado como pogo), es una técnica de optimización del compilador en la programación de computadoras que utiliza perfiles para mejorar el rendimiento de tiempo de ejecución del programa.* <br />  


Phalcon depende de varios aspectos del diseño interno de PHP como la gestión de memoria, [recolección de basura](https://en.wikipedia.org/wiki/Garbage_collection_(computer_science)) y sus estructuras internas. La mejora de cualquiera de estos aspectos tienen un impacto positivo sobre el rendimiento de Phalcon, así como en PHP.

<a name='how-can-i-help'></a>

## ¿Cómo puedo ayudar?

Únete a nuestro canal [Discord](https://phalcon.link/discord), visítenos en [GitHub](https://github.com/phalcon), o en la web en [ https://phalconphp.com/](https://phalconphp.com/en/).