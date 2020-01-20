<?php

declare(strict_types=1);

namespace Tests\Setono\GlsWebserviceBundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\GlsWebserviceBundle\DependencyInjection\SetonoGlsWebserviceExtension;

final class SetonoGlsWebserviceExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new SetonoGlsWebserviceExtension()];
    }

    protected function getMinimalConfiguration(): array
    {
        return [
            'connection_timeout' => 15,
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_gls_webservice.wsdl', 'https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');
        $this->assertContainerBuilderHasParameter('setono_gls_webservice.options', ['connection_timeout' => 15]);
    }
}
