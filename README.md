# API for TTT

This is version 1.0.0 of the TicTacToe bot and a web-client.

It satisfies all of the original requirements:

  - has an API
  - has a web-interface where a game can be played against the bot

# Quick start

The easiest way to start an application is to use PHP's built-in server.
That obviously requires having `php-cli` installed.

```bash
$ git clone git@github.com:nev3rm0re/api-for-ttt.git
$ cd api-for-ttt && composer install --no-dev
$ cd public
$ php -d always_populate_raw_post_data=-1 -S localhost:8000
```

This works with PHP5.4 and up. My version of PHP5.6 has a bug that requires
updating configuration setting (something about "automatically populating
 `HTTP_RAW_POST_DATA`"). I included it as a directive to php command just
 in case your config setting is not updated.

# Testing

All tests are located in `tests/` folder. There are PHPUnit tests that can
be run from within project directory. Installation of `dev` dependencies
would be required.

```bash
$ composer install
$ vendor/bin/phpunit
```

Unittests verify the "brains" behind the bot, integration tests verify that
API responds as expected.

To run integration tests you need to have either Postman or Newman installed.
Newman can be installed (along with other dependecies) using provided
`package.json`.

```bash
$ yarn
$ yarn run test:newman:release
```

# Slower start

Easiest way to get application up and running is to run `vagrant up`
from project root's folder (requires having Vagrant installed).

Once Vagrant finishes provisioning the machine, API will be available
at http://localhost:8080 and web client will be available at http://localhost:8080/client