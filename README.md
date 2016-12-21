# Setting up

Easiest way to get application up and running is to run `vagrant up`
from project root's folder (requires having Vagrant installed).

Once Vagrant finishes provisioning the machine, API will be available
at http://localhost:8080 and web client will be available at http://localhost:8080/client

# Verifying installation

## Unit tests

PhpUnit tests are available in `tests/unit` folder.
To run `phpunit` from Vagrant

```bash
$ cd /vagrant
$ vendor/bin/phpunit
```

`phpunit.xml` is provided, so no additional parameters to `phpunit` are required.

These tests test bot logic only.

## Integration tests

API tests in Postman Collection v2 format are provided in `tests/integration`

Collection contains 2 tests for error and success responses. Tests assume
that API is running at http://localhost:8080, this can be updated in Postman
during manual test run.