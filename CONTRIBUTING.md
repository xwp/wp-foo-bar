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

## Continuous Integration

We use [Travis CI](https://travis-ci.com) to lint all code, run tests and report test coverage to [Coveralls](https://coveralls.io) as defined in [`.travis.yml`](.travis.yml). Travis CI will run the unit tests and perform sniffs against the WordPress Coding Standards whenever you push changes to your PR. Tests are required to pass successfully for a merge to be considered.

## Development

1. Clone the plugin repository.

	    git clone git@github.com:xwp/wp-foo-bar.git

2. Setup the development tools using [Node.js](https://nodejs.org) and [Composer](https://getcomposer.org):

	    npm install

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

We use `npm` as the canonical task runner for the project. Some of the PHP related scripts are defined in `composer.json` but are not meant to be executed directly.

**Important**: The commands that execute unit tests or generate coverage reports (i.e. contain `test` in the name) should be executed inside the Docker container.

#### NPM

- `npm run build` to build the plugin JS and CSS assets. Use `npm run dev` to watch and re-build as you work.

- `npm run lint` to lint both PHP and JS files.

- `npm run lint:js` to lint only JavaScript files with [eslint](https://eslint.org/).

- `npm run lint:php` to lint only PHP files with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer).

- `npm run format:php` to format the PHP files with [phpcbf](https://github.com/squizlabs/PHP_CodeSniffer).

- `npm run readme` to generate the `readme.md` from the `readme.txt`.

	_The `readme.md` file will automatically generate on commit when the `readme.txt` changes_

- `npm run test:js` to run tests for JS.

- `npm run test:js:coverage` to run tests for JS with coverage reporting.

	_The coverage report is stored in the `tests/coverage/js` directory._

- `npm run docker -- npm run test` to run both PHP and JS tests without coverage reporting.

- `npm run docker -- npm run test-with-coverage` to run both PHP and JS tests with coverage reporting.

- `npm run docker -- npm run test:php` to run tests for PHP.

- `npm run docker -- npm run test:php:coverage` to run tests for PHP with coverage reporting.

	_The coverage report is stored in the `tests/coverage/html` directory._
