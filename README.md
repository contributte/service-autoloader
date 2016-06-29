# Service Autoloader

Automatic autoload service by interface or annotation.

-----

[![Build Status](https://img.shields.io/travis/minetro/service-autoloader.svg?style=flat-square)](https://travis-ci.org/minetro/service-autoloader)
[![Code coverage](https://img.shields.io/coveralls/minetro/service-autoloader.svg?style=flat-square)](https://coveralls.io/r/minetro/service-autoloader)
[![Downloads this Month](https://img.shields.io/packagist/dm/minetro/service-autoloader.svg?style=flat-square)](https://packagist.org/packages/minetro/service-autoloader)
[![Downloads total](https://img.shields.io/packagist/dt/minetro/service-autoloader.svg?style=flat-square)](https://packagist.org/packages/minetro/service-autoloader)
[![Latest stable](https://img.shields.io/packagist/v/minetro/service-autoloader.svg?style=flat-square)](https://packagist.org/packages/minetro/service-autoloader)
[![HHVM Status](https://img.shields.io/hhvm/minetro/service-autoloader.svg?style=flat-square)](http://hhvm.h4cc.de/package/minetro/service-autoloader)

## Discussion / Help

[![Join the chat](https://img.shields.io/gitter/room/minetro/nette.svg?style=flat-square)](https://gitter.im/minetro/nette?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Install

```sh
composer require minetro/service-autoloader
```

## Usage

```yaml
extensions:
    autoload: Minetro\Autoloader\DI\ServiceAutoloadExtension
```

### By default

This configuration is enabled by default.

```yaml
autoload:
    dirs:
        - %appDir%

    annotations:
        - @Service
        
    interfaces:
        - Minetro\Autoloader\AutoloadService

    decorator:
        inject: off
```

### Custom

You can override all configuration settings you want to.

```yaml
autoload:
    dirs:
        - %appDir%
        - %libsDir%
        - %fooDir%

    annotations:
        - @Service
        - @MyCustomService
        
    interfaces:
        - Minetro\Autoloader\AutoloadService
        - App\Model\MyAutoloadServiceInterface

    decorator:
        inject: on / off
```

## Performance

Service loading is triggered only once at dependency injection container compile-time. You should be pretty fast, 
almost as [official registering presenter as services](https://api.nette.org/2.4/source-Bridges.ApplicationDI.ApplicationExtension.php.html#121-160).

-----

Thanks for testing, reporting and contributing.
