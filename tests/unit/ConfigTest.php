<?php

use Codeception\Test\Unit;
use Insly\QmtApiClient\Config;
use Insly\QmtApiClient\Exceptions\ConfigException;

class ConfigTest extends Unit
{
    /**
     * Test Getting a config variable from set config
     *
     * @dataProvider getConfigData
     *
     * @param array $config
     * @param string $param
     * @param mixed $expectedValue
     * @param mixed $defaultValue
     * @throws ConfigException
     */
    public function testGettingConfigVariable(array $config, string $param, $expectedValue, $defaultValue): void
    {
        $this->assertEquals(
            $expectedValue,
            (new Config($config))->get($param, $defaultValue)
        );
    }

    /**
     * @return void
     */
    public function testMissingConfigVariables(): void
    {
        $throws = false;

        try {
            new Config([]);
        } catch (ConfigException $e) {
            $throws = true;
        }

        $this->assertTrue($throws);
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testVariableHelpers(): void
    {
        $cfg = new Config([
            Config::PARAM_HOST => 'foo baseurl',
            Config::PARAM_AUTH_TOKEN => 'bar token',
            Config::PARAM_TENANT => 'baz tenant'
        ]);

        $this->assertEquals('foo baseurl', $cfg->getBaseUrl());
        $this->assertEquals('bar token', $cfg->getAuthToken());
        $this->assertEquals('baz tenant', $cfg->getTenant());
    }

    /**
     * @return array
     */
    public function getConfigData(): array
    {
        return [
            // Existing parameter
            [
                [
                    Config::PARAM_HOST => 'https://api.example.com',
                ],
                Config::PARAM_HOST,
                'https://api.example.com',
                null
            ],
            // Non-existing parameter
            [
                [
                    Config::PARAM_HOST => 'https://api.example.com',
                ],
                'foo',
                null,
                null
            ],
            // Empty parameter
            [
                [
                    Config::PARAM_HOST => 'https://api.example.com',
                ],
                '',
                null,
                null
            ],
            // Return default value
            [
                [
                    Config::PARAM_HOST => 'https://api.example.com',
                ],
                'bar',
                'default value',
                'default value'
            ],
        ];
    }
}
