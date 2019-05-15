<?php

declare(strict_types=1);

namespace Tests\Setono\GlsWebserviceBundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\GlsWebserviceBundle\DependencyInjection\SetonoGlsWebserviceExtension;

final class SetonoTagBagExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new SetonoGlsWebserviceExtension()];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameter_has_been_set()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_gls_webservice.wsdl', 'https://www.gls.dk/webservices_v4/wsShopFinder.asmx?WSDL');
    }
}
