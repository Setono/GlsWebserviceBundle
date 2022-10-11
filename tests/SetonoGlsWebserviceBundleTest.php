<?php

declare(strict_types=1);

namespace Tests\Setono\GlsWebserviceBundle;

use Nyholm\BundleTest\TestKernel;
use Setono\GLS\Webservice\Client\Client;
use Setono\GLS\Webservice\Client\ClientInterface;
use Setono\GLS\Webservice\Factory\SoapClientFactory;
use Setono\GLS\Webservice\Factory\SoapClientFactoryInterface;
use Setono\GlsWebserviceBundle\SetonoGlsWebserviceBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

final class SetonoGlsWebserviceBundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(SetonoGlsWebserviceBundle::class);
        $kernel->handleOptions($options);
        $kernel->addTestCompilerPass(new class() implements CompilerPassInterface {
            public function process(ContainerBuilder $container): void
            {
                $regex = '|setono.*|';

                foreach ($container->getDefinitions() as $id => $definition) {
                    if (preg_match($regex, $id)) {
                        $definition->setPublic(true);
                    }
                }

                foreach ($container->getAliases() as $id => $alias) {
                    if (preg_match($regex, $id)) {
                        $alias->setPublic(true);
                    }
                }
            }
        });

        return $kernel;
    }

    /**
     * @test
     */
    public function it_inits(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var list<array{id: string, class: class-string}> $services */
        $services = [
            ['id' => SoapClientFactoryInterface::class, 'class' => SoapClientFactory::class],
            ['id' => 'setono_gls_webservice.factory.soap_client', 'class' => SoapClientFactory::class],
            ['id' => ClientInterface::class, 'class' => Client::class],
            ['id' => 'setono_gls_webservice.client', 'class' => Client::class],
        ];

        foreach ($services as $service) {
            self::assertTrue($container->has($service['id']), sprintf('Service %s does not exist', $service['id']));

            /** @var object $obj */
            $obj = $container->get($service['id']);

            self::assertInstanceOf($service['class'], $obj, sprintf(
                'Service %s was not an instance of %s, but an instance of %s',
                $service['id'],
                $service['class'],
                get_class($obj)
            ));
        }
    }
}
