<div class='article-menu'>
  <ul>
    <li>
      <a href="#contributing">Contributing to Phalcon</a> <ul>
        <li>
          <a href="#contributions">Contributions</a>
        </li>
        <li>
          <a href="#questions-and-support">Questions & Support</a>
        </li>
        <li>
          <a href="#bug-report-checklist">Bug Report Checklist</a>
        </li>
        <li>
          <a href="#pull-request-checklist">Pull Request Checklist</a>
        </li>
        <li>
          <a href="#getting-support">Getting Support</a>
        </li>
        <li>
          <a href="#requesting-features">Requesting Features</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='contributing'></a>

# Contributing to Phalcon

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!.

Please take a moment to review this document in order to make the contribution process easy and effective all.

Following these guidelines, allows better communication, faster resolution of issues and moves the project forward.

<a name='contributions'></a>

## Contributions

Contributions to Phalcon should be made in the form of GitHub pull requests. Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>

## Questions & Support

##### We only accept bug reports, new feature requests and pull requests in GitHub {.alert.alert-warning}

For questions regarding the usage of the framework or support requests please visit the [official forums](https://phalcon.link/forum).

<a name='bug-report-checklist'></a>

## Bug Report Checklist

- Make sure you are using the latest released version of Phalcon before submitting a bug report. Bugs in versions older than the latest released one will not be addressed by the core team.
- If you have found a bug, it is essential to add relevant information to reproduce it. Being able to reproduce a bug greatly reduces the time to investigate and fix it. This information should come in the form of a script, small application, or even a failing test. Please check [Submit Reproducible Test](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test) for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a Segmentation Fault error, we would require a backtrace. Please check [Generating a Backtrace](https://github.com/phalcon/cphalcon/wiki/Generating-a-backtrace) for more information.

<a name='pull-request-checklist'></a>

## Pull Request Checklist

- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase your changes
- Don't put submodule updates in your pull request unless they are to merged commits
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information.
- Phalcon is written in [Zephir](https://zephir-lang.com/), please do not submit commits that modify C generated files directly or those whose functionality/fixes are implemented in the C programming language
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request

<a name='getting-support'></a>

## Getting Support

If you have a question about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Requesting Features

If you have a change or new feature in mind, please fill an [NFR](/en/[[version]]/new-feature-request).

Thanks!

<3 Phalcon Team