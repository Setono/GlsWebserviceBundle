<?php

declare(strict_types=1);

namespace Setono\GlsWebserviceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('setono_gls_webservice');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('setono_gls_webservice');
        }

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('wsdl')
                    ->cannotBeEmpty()
                    ->defaultValue('https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL')
                    ->info('The WSDL where the GLS webservice is located')
                ->end()
                ->integerNode('connection_timeout')
                    ->defaultValue(0)
                    ->info('This is the connection timeout to wait for the SoapClient to connect to the remote server. Basically this sets the connection_timeout which is documented here: https://www.php.net/manual/en/soapclient.soapclient.php')
                    ->example(5)
                    ->min(0)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
