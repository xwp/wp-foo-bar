# Foo Bar Contributing Guide

Before submitting your contribution, please make sure to take a moment and read through the following guidelines.

## Issue Reporting Guidelines

- The issue list of this repo is **exclusively** for bug reports and feature requests.
- Try to search for your issue, it may have already been answered or even fixed in the `wip` (Work in Progress) branch.
- Check if the issue is reproducible with the latest stable version. If you are using a pre-release, please indicate the specific version you are using.
- It is **required** that you clearly describe the steps necessary to reproduce the issue you are running into. Issues without clear reproducible steps will be closed immediately.
- If your issue is resolved but still open, don't hesitate to close it. In case you found a solution by yourself, it could be helpful to explain how you fixed it.

## Pull Request Guidelines

- Checkout a topic branch from `wip` and merge back against `wip`.
    - If you are not familiar with branching please read [_A successful Git branching model_](http://nvie.com/posts/a-successful-git-branching-model/) before you go any further.
- **DO NOT** check-in the `build` directory with your commits.
- Follow the [WordPress Coding Standards](https://make.wordpress.org/core/handbook/coding-standards/).
- Make sure the default grunt task passes. (see [development setup](#development-setup))
- If adding a new feature:
    - Add accompanying test case.
    - Provide convincing reason to add this feature. Ideally you should open a suggestion issue first and have it green-lit before working on it.
- If fixing a bug:
    - Provide detailed description of the bug in the PR. Live demo preferred.
    - Add appropriate test coverage if applicable.

## Development Setup

The simplest method to get a testing environment up is by using [Varying Vagrant Vagrants](https://github.com/Varying-Vagrant-Vagrants/VVV).

To clone this repository
``` bash
$ cd {your-vvv-root}/www/wordpress-develop/public_html/src/wp-content/plugins
$ git clone git@github.com:xwp/wp-foo-bar.git foo-bar
```

Install Composer packages

``` bash
$ composer install
```

### PHPUnit Testing

Run tests:

``` bash
$ composer phpunit
```

Run tests with an HTML coverage report:

``` bash
$ composer phpunit-coverage
```

The coverage report is stored in the `{your-vvv-root}/www/default/coverage/foo-bar` directory.

Travis CI will run the unit tests and perform sniffs against the WordPress Coding Standards whenever you push changes to your PR. Tests are required to pass successfully for a merge to be considered.