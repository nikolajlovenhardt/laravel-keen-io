[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](http://laravel.com) [![Latest Stable Version](https://poser.pugx.org/nikolajlovenhardt/laravel-keen-io/v/stable)](https://packagist.org/packages/nikolajlovenhardt/laravel-keen-io) [![Total Downloads](https://poser.pugx.org/nikolajlovenhardt/laravel-keen-io/downloads)](https://packagist.org/packages/nikolajlovenhardt/laravel-keen-io) [![Latest Unstable Version](https://poser.pugx.org/nikolajlovenhardt/laravel-keen-io/v/unstable)](https://packagist.org/packages/nikolajlovenhardt/laravel-keen-io) [![License](https://poser.pugx.org/nikolajlovenhardt/laravel-keen-io/license)](https://packagist.org/packages/nikolajlovenhardt/laravel-keen-io) [![Build Status](https://travis-ci.org/nikolajlovenhardt/laravel-keen-io.svg?branch=master)](https://travis-ci.org/nikolajlovenhardt/laravel-keen-io) [![Code Climate](https://codeclimate.com/github/nikolajlovenhardt/laravel-keen-io/badges/gpa.svg)](https://codeclimate.com/github/nikolajlovenhardt/laravel-keen-io) [![Test Coverage](https://codeclimate.com/github/nikolajlovenhardt/laravel-keen-io/badges/coverage.svg)](https://codeclimate.com/github/nikolajlovenhardt/laravel-keen-io/coverage)

# KeenIO integration for Laravel

## Installation

Install using composer

```bash
composer require nikolajlovenhardt/laravel-keen-io
```

### Provider
Add the `LaravelKeenIO\LaravelKeenIOProvider` in `config/app.php`

```php
[
    LaravelKeenIO\LaravelKeenIOProvider::class,
],
```

Then run `php artisan vendor:publish` to publishe the keen.io configuration file into `config/keen-io.php` and add
your projects.

### Facade (optional)
```php
[
    'KeenIO' => LaravelKeenIO\Facades\KeenIOFacade::class,
],
```

## Usage
This package is built as a configuration wrapper for [keen-io/keen-io](https://packagist.org/packages/keen-io/keen-io).

### Dependency injection (Recommended)
Example:

```php
<?php

namespace App\Controllers;

use LaravelKeenIO\Services\KeenIOService;
use LaravelKeenIO\Services\KeenIOServiceInterface;

class DemoController
{
    /** @var KeenIOServiceInterface */
    protected $keenIOService;

    public function __construct(KeenIOService $keenIOService)
    {
        $this->keenIOService = $keenIOService;
    }

    public function action()
    {
        /** @var KeenIOClient $keenIO */
        $keenIO = $this->keenIOService->client();

        echo 'KeenIOClient with the default project';
    }

    public function anotherAction()
    {
        $project = 'projectName';

        /** @var KeenIOClient $keenIO */
        $keenIO = $this->keenIOService->client($project);

        echo sprintf(
            'KeenIOClient with the \'%s\' project',
            $project
        );
    }
}
```

### Facade
```php
<?php

namespace App\Controllers;

use KeenIO;
use LaravelKeenIO\Services\KeenIOService;
use LaravelKeenIO\Services\KeenIOServiceInterface;

class DemoController
{
    public function action()
    {
        /** @var KeenIOClient $default */
        $keenIO = KeenIO::client();

        echo 'KeenIOClient with the default project';
    }

    public function anotherAction()
    {
        $project = 'projectName';

        /** @var KeenIOClient $default */
        $keenIO = KeenIO::client($project);

        echo sprintf(
            'KeenIOClient with the \'%s\' project',
            $project
        );
    }
}
```

## Documentation
For more information on the usage of `KeenIO`, please refer to the [documentation of the PHP client](https://github.com/keenlabs/KeenClient-PHP) and the
main [keen.io documentation](https://keen.io/docs/).