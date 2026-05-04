# GLS webservice bundle

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]

Integrates the [GLS webservice PHP SDK](https://github.com/Setono/gls-webservice-php-sdk) into Symfony.

## Installation

### Step 1: Download the bundle

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/gls-webservice-bundle
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the bundle

Enable the plugin by adding it to the list of registered plugins/bundles in `config/bundles.php`:

```php
<?php
$bundles = [
    // ...
    
    Setono\GlsWebserviceBundle\SetonoGlsWebserviceBundle::class => ['all' => true],
    
    // ...
];
```

## Usage
Now you can inject the `ClientInterface` into your service:

```php
<?php

use Setono\GLS\Webservice\Client\ClientInterface;

final class YourService
{
    public function __construct(private readonly ClientInterface $client)
    {
    }
}
```

With autowiring this will work out of the box. If you're not using autowiring you have to inject it in your service definition:

```php
<?php

use Setono\GLS\Webservice\Client\ClientInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(YourService::class)
        ->args([service(ClientInterface::class)]);
};
```

[ico-version]: https://poser.pugx.org/setono/gls-webservice-bundle/v/stable
[ico-license]: https://poser.pugx.org/setono/gls-webservice-bundle/license
[ico-github-actions]: https://github.com/Setono/GlsWebserviceBundle/workflows/build/badge.svg

[link-packagist]: https://packagist.org/packages/setono/gls-webservice-bundle
[link-github-actions]: https://github.com/Setono/GlsWebserviceBundle/actions
