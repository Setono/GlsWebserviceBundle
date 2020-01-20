<?php

declare(strict_types=1);

namespace Setono\GlsWebserviceBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoGlsWebserviceExtension extends Extension
{
    /**
     * @throws Exception
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('setono_gls_webservice.wsdl', $config['wsdl']);

        $options = [];
        if ($config['connection_timeout'] > 0) {
            $options['connection_timeout'] = $config['connection_timeout'];
        }

        $container->setParameter('setono_gls_webservice.options', $options);

        $loader->load('services.xml');
    }
}
