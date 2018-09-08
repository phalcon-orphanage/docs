<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">FAQ - Часто задаваемые вопросы</a>
      <ul>
        <li>
          <a href="#what-is-phalcon">Что такое Phalcon</a>
        </li>
        <li>
          <a href="#how-phalcon-works">Как работает Phalcon</a>
        </li>
        <li>
          <a href="#how-can-i-help">Чем я могу помочь</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# FAQ - Часто задаваемые вопросы

<a name='what-is-phalcon'></a>

## Что такое Phalcon

Phalcon is an open source full stack PHP framework written as a C language extension.

<a name='how-phalcon-works'></a>

## Как работает Phalcon

Phalcon *не является* акселератором для PHP или проектов, написанных на PHP. *(Если нужен PHP-подобный язык для создания высокопроизводительного Си-расширения, то взгляните на [Zephir](https://github.com/phalcon/zephir))*

Phalcon — это фреймворк, который реализует функциональность, используя низкоуровневый язык Си. При загрузке Си-расширения комплируются вместе с вашим PHP кодом. Это повышает скорость приложения и снижает затраты ресурсов.

Phalcon достигает этого благодаря следующим факторам:

- Использование преимущества компиляции в [машинный код](https://en.wikipedia.org/wiki/Machine_code), который процессор может выполнять напрямую, без лишних затрат, как при выполнении байт-кода в виртуальной машине (VM).

- Уменьшение потребляемой памяти посредством использования специально оптимизированных Си-структур и статически типизированных Си-компиляторов, таких как GCC/CLANG/VCC. Они выполняют [некоторые оптимизации](https://en.wikipedia.org/wiki/Category:Compiler_optimizations) кода, улучшая производительность.

- Возможность располагать переменные и данные и стеке. Такие переменные, как правило, имеют большую [локальность](https://en.wikipedia.org/wiki/Locality_of_reference) доступа.

- Более простое предсказание переходов, так как обрабатывается код пользователя напрямую, а не через имплементацию VM. *Mystical написал хорошее объяснение в [Stack Overflow](https://stackoverflow.com/a/11227902/1661465).*

- Наличие прямого доступа к внутренним структурам и функциям, что снижает [нагрузку на процессор](https://en.wikipedia.org/wiki/CPU-bound).

- [Использование Profile Guided Optimization (PGO)](https://en.wikipedia.org/wiki/Profile-guided_optimization) для улучшения производительности, основываясь на имеющихся результатах профилирования.

<br /> *Из [Wikipedia](https://en.wikipedia.org/wiki/Profile-guided_optimization). Profile-guided optimization (PGO, иногда произносится как pogo) — это техника оптимизации программы компилятором, которая использует профилирование для улучшения производительности программы.* <br />  


Phalcon опирается на некоторые внутренние аспекты архитектуры PHP, такие как управление памятью, [сборка мусора](https://en.wikipedia.org/wiki/Garbage_collection_(computer_science)), а также на внутренние структуры. Улучшение любого из этих аспектов позитивно влияет на производительность как Phalcon, так и самого PHP.

<a name='how-can-i-help'></a>

## Чем я могу помочь

Присоединяйтесь к нашему [Discord](https://phalcon.link/discord) каналу, посетите нас на [GitHub](https://github.com/phalcon), или на сайте [https://phalconphp.com/](https://phalconphp.com/en/).