A NFR is a short document explaining how a new feature request must work, how it can be implemented, how it can help, allowing the core developers to understand and facilitate its implementation. A NFR contains:

* Suggested syntax
* Suggested class names and methods
* A short documentation
* If the feature is already implemented in other frameworks, a short explanation of how that was implemented and its advantages

In the following cases a new feature request will be rejected:

* The feature makes the framework slow
* The feature doesn't provide any value to the framework
* The NFR is not clear, bad documented, bad explained, etc.
* The NFR doesn't follow the current guidelines/philosophy of the framework
* The NFR affects/breaks applications developed in current/older versions of the framework
* The OP doesn't provide feedback/input when requested
* It's technically impossible to implement
* It's a functionality that only will be used on development/testing stages
* Submitted/proposed classes/components don't follow the [Single Responsibility Principle][SRP] 
* Static methods aren't allowed

To send a NFR you don't need to provide Zephir or C code or develop the feature, the NFR is just about explain the goal of the NFR. 

All NFRs should be posted as a new issue on Github.

[SRP]: http://en.wikipedia.org/wiki/Single_responsibility_principle