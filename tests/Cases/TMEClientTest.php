<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use KY\TME\Config;
use KY\TME\TMEClient;
use Mockery;

/**
 * @internal
 * @coversNothing
 */
class TMEClientTest extends AbstractTestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testSign()
    {
        $client = new TMEClient(new Config(123, 'tmemusic', ''));

        $sign = $client->sign(1554880000);

        $this->assertSame('8773212CD0C852C2BC16C7F2C98895C8', $sign);
    }

    public function testAdd()
    {
        $client = Mockery::mock(TMEClient::class, [new Config(123, 'tmemusic', '')]);
        $client->shouldReceive('client')->andReturn($this->client());
        $data = $client->add([
            'info' => [
                'album_info_path' => 'http://xxxx/xxx/sample.json',
            ],
        ]);
        var_dump($data);
    }

    protected function client()
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->withAnyArgs()->andReturnUsing(function () {
            $body = file_get_contents(__DIR__ . '/../musicu.json');

            return new Response(body: $body);
        });

        return $client;
    }
}
