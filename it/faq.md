# FAQ - Frequently Asked Questions

## What is Phalcon

Phalcon in an open source full stack PHP framework written as a C language extension.

## How Phalcon Works

Phalcon is *not* an accelerator for PHP or projects written in PHP. *(For a PHP-like language to produce high-performance C extensions please see [Zephir](https://github.com/phalcon/zephir))*

Phalcon is a framework that implements its functionality using the low-level C language. C extensions are compiled together with your PHP code on load. Increasing the speed of you application and lowering your overhead.

#### Phalcon achieves this by:

- Taking advantage of native compilation by producing a [binary executable representation](https://en.wikipedia.org/wiki/Machine_code) of the code that a processor can directly understand and execute without the overhead of running bytecode in a virtual machine (VM).

- Reducing the memory footprint by using optimised specific-purpose C structures and static types C compilers, like GCC/CLANG/VCC. These perform [several optimisations](https://en.wikipedia.org/wiki/Category:Compiler_optimizations) over the code improving performance.

- The ability to place variables and data in the stack. These would typically have a higher [locality](https://en.wikipedia.org/wiki/Locality_of_reference) of access.

- Branch prediction is easier as it operates directly over the user code and not over the VM implementation. *Mystical put together a great explanation on [Stack Overflow](https://stackoverflow.com/a/11227902/1661465).*

- Having direct access to internal structures and functions reducing the [computation overhead](https://en.wikipedia.org/wiki/CPU-bound).

- [Using Profile Guided Optimization (PGO)](https://en.wikipedia.org/wiki/Profile-guided_optimization) to improve performance based on existing execution profiles.

<br /> *Per [Wikipedia](https://en.wikipedia.org/wiki/Profile-guided_optimization). Profile-guided optimization (PGO, sometimes pronounced as pogo), is a compiler optimization technique in computer programming that uses profiling to improve program runtime performance.* <br />  


Phalcon relies on several internal design aspects of PHP such as memory management, [garbage collection](https://en.wikipedia.org/wiki/Garbage_collection_(computer_science)) and its internal structures. The improvement of any of these aspects have a positive impact on Phalcon's performance as well in PHP.

credit: <https://github.com/andresgutierrez>

## How do I help?

Join our [Discord](https://phalcon.link/discord) channel, visit us at [GitHub](https://github.com/phalcon), or on the web at [https://phalconphp.com/](https://phalconphp.com/en/).