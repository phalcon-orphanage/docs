---
layout: article
language: 'en'
version: '4.0'
---
# Создание пулл реквеста

A pull request a collection of changes to the code that: - fux a bug (current issue) - introduce new functionality

Your Pull request must include: * Issued to the correct branch. * Update to the `CHANGELOG` * Unit tests * Documentation if necessary and usage examples

> **We do not accept Pull Requests to the `master` branch** {:.alert .alert-danger}

If your pull request relates to fixing an issue/bug, please link the issue number in the pull request body. You can utilize the template we have in Github to present this information. If no issue exists, please create one.

For new functionality, again we will need to have an issue created and referenced. If the functionality you are introducing collides with the philosophy and implementation of Phalcon, the pull request will be rejected.

Additionally any new functionality that introduces breaking changes will be rejected at least for the current version but could very well be implemented in the next major version.

It is highly recommended to discuss your NFR and PR with the core team and most importantly with the community so as to get feedback, guidance and to work on a release plan that will benefit everyone.