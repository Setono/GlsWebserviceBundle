<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Setono\GLS\Webservice\Client\Client;
use Setono\GLS\Webservice\Client\ClientInterface;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Factory\SoapClientFactoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(SoapClientFactory::class)
        ->args([
            param('setono_gls_webservice.wsdl'),
            param('setono_gls_webservice.options'),
        ]);

    $services->alias(SoapClientFactoryInterface::class, SoapClientFactory::class);
    $services->alias('setono_gls_webservice.factory.soap_client', SoapClientFactoryInterface::class)
        ->deprecate('setono/gls-webservice-bundle', '1.4', 'The "%alias_id%" service alias is deprecated. Use "' . SoapClientFactoryInterface::class . '" instead.');

    $services->set(Client::class)
        ->args([service(SoapClientFactory::class)]);

    $services->alias(ClientInterface::class, Client::class);
    $services->alias('setono_gls_webservice.client', ClientInterface::class)
        ->deprecate('setono/gls-webservice-bundle', '1.4', 'The "%alias_id%" service alias is deprecated. Use "' . ClientInterface::class . '" instead.');
};
