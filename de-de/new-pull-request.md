---
layout: default
language: 'de-de'
version: '4.0'
title: 'New Pull Request'
keywords: 'new pull request, pull request, pr'
---

# New Pull Request

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

A pull request for Phalcon must be against our [main repository[cphalcon](https://github.com/phalcon/cphalcon). It is a collection of changes to the code that: - fix a bug (current issue) - introduce new functionality or enhancement.

Your pull request must include: * Target the correct branch. * Update the relevant `CHANGELOG.md` * Contain unit tests * Updates to the documentation and usage examples as necessary * Your code must abide by the coding standards that Phalcon uses. For PHP code we use [PSR-2](https://www.php-fig.org/psr/) while for Zephir code, we have an `.editorconfig` file available at the root of the repository to help you follow the standards.

> **NOTE**: **We do not accept Pull Requests to the `master` branch**
{:.alert .alert-danger}

If your pull request relates to fixing an issue/bug, please link the issue number in the pull request body. You can utilize the template we have in GitHub to present this information. If no issue exists, please create one.

For new functionality, **we will need to have an issue created and referenced**. If the functionality you are introducing collides with the philosophy and implementation of Phalcon, the pull request will be rejected.

Additionally any new functionality that introduces breaking changes will not be accepted for the current release but instead will need to be updated to target the next major version.

It is highly recommended to discuss your NFR and PR with the core team and most importantly with the community so as to get feedback, guidance and to work on a release plan that will benefit everyone.

## Branch and Commits

The following steps are recommended but not mandatory.

If you are working on an issue, note the number of the issue down. Let us assume that the issue is:

`#12345 - Create New Object`

- Checkout the `4.0.x` branch
- Create a branch: `T12345-create-new-object`

The name of the branch starts with `T`, followed by the number of the issue and then the title of the issue as a slug.

In your `cphalcon` folder navigate to `.git/hooks`

Create a new file called `commit-msg` and paste the code below in it and save it:

```bash
#!/bin/bash
# This Way You can Customize Which Branches Should be Skipped When
# Prepending Commit Message.
if [ -z "$BRANCHES_TO_SKIP" ]; then
  BRANCHES_TO_SKIP=(master develop)
fi
BRANCH_NAME=$(git symbolic-ref --short HEAD)
BRANCH_NAME="${BRANCH_NAME##*/}"
BRANCH_EXCLUDED=$(printf "%s\n" "${BRANCHES_TO_SKIP[@]}" | grep -c "^$BRANCH_NAME$")
BRANCH_IN_COMMIT=$(grep -c "\[$BRANCH_NAME\]" $1)
if [ -n "$BRANCH_NAME" ] && ! [[ $BRANCH_EXCLUDED -eq 1 ]] && ! [[ $BRANCH_IN_COMMIT -ge 1 ]]; then
  ISSUE="$(echo $BRANCH_NAME | cut -d'-' -f 1)"
  ISSUE="${ISSUE/T/#}"
  sed -i.bak -e "1s/^/[$ISSUE] - /" $1
fi
```

Ensure that the file is executable

```bash
chmod a+x commit-msg
```

Any commits you add now to your branch will appear tied to the `12345` issue.

Doing the above allows everyone to see which commits relate to which issue.