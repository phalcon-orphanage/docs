# New Feature Request

A NFR is a short document explaining how a new feature request must be submitted, how it can be implemented, and how it can help core developers and others to understand implement it.

A NFR contains:
* Suggested syntax
* Suggested class names and methods
* A short documentation
* If the feature is already implemented in other frameworks, a short explanation of how that was implemented and its advantages

In the following cases a new feature request will be rejected:
* The feature makes the framework slow
* The feature doesn't provide any additional value to the framework
* The NFR is not clear, bad documentation, unclear explanation, etc.
* The NFR doesn't follow the current guidelines/philosophy of the framework
* The NFR affects/breaks applications developed in current/older versions of the framework
* The original poster doesn't provide feedback/input when requested
* It's technically impossible to implement
* It can only be used in the development/testing stages
* Submitted/proposed classes/components don't follow the [Single Responsibility Principle][SRP]
* Static methods aren't allowed

To send a NFR you don't need to provide Zephir or C code or develop the feature. New Feture requests explain the goal of the intended implementation and open discussion on how best to implement it.

All NFRs should be posted as a new issue on [Github][github-issues].

[SRP]: http://en.wikipedia.org/wiki/Single_responsibility_principle
[github-issues]: https://github.com/phalcon/cphalcon/issues
