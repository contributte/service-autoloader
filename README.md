![](https://heatbadger.now.sh/github/readme/contributte/service-autoloader/?deprecated=1)

<p align=center>
    <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
    <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
    <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
    Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

## Disclaimer

| :warning: | This project is no longer being maintained. Please use [contributte/di](https://github.com/contributte/di).
|---|---|

| Composer | [`minetro/service-autoloader`](https://packagist.org/packages/minetro/service-autoloader) |
|---| --- |
| Version | ![](https://badgen.net/packagist/v/minetro/service-autoloader) |
| PHP | ![](https://badgen.net/packagist/php/minetro/service-autoloader) |
| License | ![](https://badgen.net/github/license/contributte/service-autoloader) |

## Usage

```neon
extensions:
	autoload: Minetro\Autoloader\DI\ServiceAutoloadExtension
```

### By default

This configuration is enabled by default.

```neon
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

```neon
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


## Development

This package was maintain by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for being used this package.
