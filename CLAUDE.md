# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Symfony bundle that wires the [`setono/gls-webservice-php-sdk`](https://github.com/Setono/gls-webservice-php-sdk) into a Symfony application's DI container. The bundle itself contains no business logic — it loads an XML service definition file that registers the SDK's `SoapClientFactory` and `Client`, and exposes `wsdl` / `connection_timeout` as configurable parameters.

Supports PHP `>=7.4` and Symfony `^5.4 || ^6.0`. The CI matrix tests PHP 7.4 / 8.0 / 8.1 against both Symfony lines (excluding PHP 7.4 + Symfony 6).

## Common commands

Composer scripts (also exposed as zsh aliases — see user-level CLAUDE.md):

- `composer phpunit` (`phpunit`) — run the test suite.
- `composer analyse` (`ca`) — Psalm static analysis.
- `composer check-style` — ECS style check (read-only).
- `composer fix-style` (`cf`) — ECS auto-fix.
- `composer-require-checker check` (`crc`) — surface undeclared dependencies.
- `composer-unused` — surface unused composer dependencies. `composer-unused.php` contains a `NamedFilter` for `setono/gls-webservice-php-sdk` because that package is wired only through XML and so appears unused to static analysis; do not remove the filter.

Run a single test: `vendor/bin/phpunit --filter it_inits` (or pass a path: `vendor/bin/phpunit tests/SetonoGlsWebserviceBundleTest.php`).

## Architecture

Three files do all the work; understand them as a unit:

- `src/SetonoGlsWebserviceBundle.php` — empty `Bundle` subclass; the framework derives the extension class name (`SetonoGlsWebserviceExtension`) by convention.
- `src/DependencyInjection/Configuration.php` — defines the `setono_gls_webservice` config tree (`wsdl`, `connection_timeout`).
- `src/DependencyInjection/SetonoGlsWebserviceExtension.php` — processes config into two container parameters (`setono_gls_webservice.wsdl`, `setono_gls_webservice.options`) and loads `Resources/config/services.xml`. Note that `connection_timeout` is only added to `options` when `> 0` — falsy values are intentionally omitted so the `SoapClient` uses its own default.
- `src/Resources/config/services.xml` — instantiates `SoapClientFactory` and `Client` from the SDK and registers FQCN aliases (`Setono\GLS\Webservice\Client\ClientInterface`, `Setono\GLS\Webservice\Factory\SoapClientFactoryInterface`) so consumers can autowire by interface. When adding a new service, register both the snake-case id and the interface alias to preserve this convention.

Tests use `nyholm/symfony-bundle-test`'s `TestKernel`. The integration test in `tests/SetonoGlsWebserviceBundleTest.php` registers a compiler pass that marks every `setono.*` service / alias public so the assertions can fetch them from the container — required because the bundle's services are private by default.
