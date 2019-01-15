* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

# New Pull Request

A pull request is alterations to the code that either fixes a current issue or introduces new functionality.

Your Pull request must include: * Issued to the correct branch. **We do not accept Pull Requests to the `master` branch** * Update to the CHANGELOG * Unit tests * Documentation if necessary and usage examples

For fixing bugs, please ensure that you reference the issue in Github. If such issue does not exist, create one.

For new functionality, again we will need to have an issue created and referenced. If the functionality you are introducing collides with the philosophy and implementation of Phalcon it will be rejected. Additionally any new functionality that introduces breaking changes will be rejected at least for the current version but could very well be implemented in the next major version. It is highly recommended to discuss your NFR and PR with the core team and most importantly with the community so as to get feedback.