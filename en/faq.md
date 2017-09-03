# FAQ - Frequently Asked Questions

## What is Phalcon
Phalcon in an open source full stack PHP framework written as a C language extension.

## How Phalcon Works
Phalcon is *not* an accelerator for PHP or projects written in PHP. 

Phalcon is a framework that implements its functionality using the low-level C language. C extensions are compiled together with your PHP code on load. Increasing the speed of you application and lowering your overhead.

#### Phalcon achieves this by:

- Taking advantage of native compilation by producing a binary executable representation of the code that a processor can directly understand and execute without the overhead of running bytecode in a virtual machine (VM).

- Reducing the memory footprint by using optimised specific-purpose C structures and static types
C compilers, like GCC/CLANG/VCC. These perform several optimisations over the code improving performance.

- The ability to place variables and data in the stack. These would typically have a higher locality of access.

- Branch prediction is easier as it operates directly over the user code and not over the VM implementation.

- Having direct access to internal structures and functions reducing the computation overhead.

- Using Profile Guided Optimization (PGO) to improve performance based on existing execution profiles.

<br>
*Per [Wikipedia](https://en.wikipedia.org/wiki/Profile-guided_optimization). Profile-guided optimization (PGO, sometimes pronounced as pogo), is a compiler optimization technique in computer programming that uses profiling to improve program runtime performance.*
<br><br>

Phalcon relies on several internal design aspects of PHP such as memory management, garbage collection and its internal structures. The improvement of any of these aspects have a positive impact on Phalcon's performance as well in PHP.

credit: [https://github.com/andresgutierrez](https://github.com/andresgutierrez)

## How do I help?

Join our [Discord](https://phalcon.link/discord) channel, visit us at [GitHub](https://github.com/phalcon), or on the web at [https://phalconphp.com/](https://phalconphp.com/en/).
