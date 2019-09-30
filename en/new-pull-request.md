---
layout: default
language: 'en'
version: '4.0'
title: 'New Pull Request'
keywords: 'new pull request, pull request, pr'
---
# New Pull Request
<hr/>
![](/assets/images/document-status-stable-success.svg)

A pull request for Phalcon must be against our [main repository[cphalcon]. It is a collection of changes to the code that:
- fix a bug (current issue)
- introduce new functionality or enhancement.

Your pull request must include:
* Target the correct branch.
* Update the relevant `CHANGELOG.md`
* Contain unit tests
* Updates to the documentation and usage examples as necessary
* Your code must abide by the coding standards that Phalcon uses. For PHP code we use [PSR-2](https://www.php-fig.org/psr/) while for Zephir code, we have an `.editorconfig` file available at the root of the repository to help you follow the standards.

> **We do not accept Pull Requests to the `master` branch**
{:.alert .alert-danger}

If your pull request relates to fixing an issue/bug, please link the issue number in the pull request body. You can utilize the template we have in GitHub to present this information. If no issue exists, please create one.

For new functionality, we will need to have an issue created and referenced. If the functionality you are introducing collides with the philosophy and implementation of Phalcon, the pull request will be rejected. 

Additionally any new functionality that introduces breaking changes will not be accepted for the current release but instead will need to be updated to target the next major version. 

It is highly recommended to discuss your NFR and PR with the core team and most importantly with the community so as to get feedback, guidance and to work on a release plan that will benefit everyone.

[cphalcon]: https://github.com/phalcon/cphalcon