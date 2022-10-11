<?php

declare(strict_types=1);

namespace Tests\Setono\GlsWebserviceBundle\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\GlsWebserviceBundle\DependencyInjection\Configuration;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function processed_config_has_correct_values(): void
    {
        $this->assertProcessedConfigurationEquals([
            ['wsdl' => 'test wsdl1'],
            ['wsdl' => 'test wsdl2'],
        ], [
            'wsdl' => 'test wsdl2',
            'connection_timeout' => 5,
        ]);
    }
}
