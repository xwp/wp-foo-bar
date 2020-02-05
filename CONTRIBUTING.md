# Foo Bar Contributing Guide

Before submitting your contribution, please make sure to take a moment and read through the following requirements and guidelines for getting setup.

## Requirements

- WordPress 5.0+ or the [Gutenberg Plugin](https://wordpress.org/plugins/gutenberg/).
- PHP 5.6.20 or greater, [Composer](https://getcomposer.org) and [Node.js](https://nodejs.org) for dependency management.
- [Docker](https://docs.docker.com/install/) for a local development environment.

We suggest using a software package manager for installing the development dependencies such as [Homebrew](https://brew.sh) on MacOS:

	brew install php composer node docker docker-compose

or [Chocolatey](https://chocolatey.org) for Windows:

	choco install php composer node nodejs docker-compose

## Issue Reporting Guidelines

- The issue list of this repo is **exclusively** for bug reports and feature requests.
- Try to search for your issue, it may have already been answered or even fixed in the `develop` branch.
- Check if the issue is reproducible with the latest stable version. If you are using a pre-release, please indicate the specific version you are using.
- It is **required** that you clearly describe the steps necessary to reproduce the issue you are running into. Issues without clear reproducible steps will be closed immediately.
- If your issue is resolved but still open, don't hesitate to close it. In case you found a solution by yourself, it could be helpful to explain how you fixed it.

## Pull Request Guidelines

- Checkout a topic branch from `develop` and merge back against `develop`.
    - If you are not familiar with branching please read [_A successful Git branching model_](http://nvie.com/posts/a-successful-git-branching-model/) before you go any further.
- Follow the [WordPress Coding Standards](https://make.wordpress.org/core/handbook/coding-standards/).
- Make sure the `phpcs` and `phpunit` composer scripts pass. (see [development setup](#development-setup))
- If adding a new feature:
    - Add accompanying test case.
    - Provide convincing reason to add this feature. Ideally you should open a suggestion issue first and have it green-lit before working on it.
- If fixing a bug:
    - Provide detailed description of the bug in the PR. Live demo preferred.
    - Add appropriate test coverage if applicable.

Travis CI will run the unit tests and perform sniffs against the WordPress Coding Standards whenever you push changes to your PR. Tests are required to pass successfully for a merge to be considered.

## Development

1. Clone the plugin repository.

	    git clone git@github.com:xwp/wp-foo-bar.git

2. Setup the development tools using [Composer](https://getcomposer.org):

	    composer install

    This will automatically install the `pre-commit` hook from the `wp-dev-lib` Composer package and setup the unit tests.

### Docker

This repository includes a WordPress development environment based on [Docker](https://docs.docker.com/install/) that can be run on your computer.

To use the Docker based environment with the Docker engine running on your host, run:

	docker-compose up

which will make it available at [localhost](http://localhost). Ensure that no other Docker containers or services are using port `80` or `3306` on your machine. 

**Important**: You must execute the `docker-compose up` command before the `pre-commit` hook will work properly. This is because the unit tests depend on the MySQL database being initialized.

To stop the Docker environment and free up port `80` and `3306` open a new shell and run:

	docker-compose down

Visit [localhost:8025](http://localhost:8025) to check all emails sent by WordPress.

Add the following entry to your hosts file if you want to map `localhost` to a domain like [wp-foo-bar.local](http://wp-foo-bar.local).

	127.0.0.1 wp-foo-bar.local

### Scripts

- `composer format` to format the PHP files with [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer).

- `composer lint` to lint the PHP files with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer).

- `composer readme` to generate the `readme.md` from the `readme.txt`.

    _The `readme.md` file will automatically generate on commit when the `readme.txt` changes_

- `composer test` to run PHPUnit tests without generating a coverage report.

- `composer test-coverage` to run PHPUnit tests while generating an HTML coverage report.

    _The coverage report is stored in the `tests/reports/html` directory._
