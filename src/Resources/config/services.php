<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Setono\GLS\Webservice\Client\Client;
use Setono\GLS\Webservice\Client\ClientInterface;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Factory\SoapClientFactoryInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('setono_gls_webservice.factory.soap_client', SoapClientFactory::class)
        ->args([
            param('setono_gls_webservice.wsdl'),
            param('setono_gls_webservice.options'),
        ]);

    $services->alias(SoapClientFactoryInterface::class, 'setono_gls_webservice.factory.soap_client');

    $services->set('setono_gls_webservice.client', Client::class)
        ->args([service('setono_gls_webservice.factory.soap_client')]);

    $services->alias(ClientInterface::class, 'setono_gls_webservice.client');
};
