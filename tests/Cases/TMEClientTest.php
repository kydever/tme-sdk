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
use KY\TME\DTO\QueryParam;
use KY\TME\TMEClient;
use Mockery;

/**
 * @internal
 * @coversNothing
 */
class TMEClientTest extends AbstractTestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testComm()
    {
        $client = new TMEClient(new Config(123, 'tmemusic', ''));

        $comm = $client->setupCommon(1554880000);

        $this->assertSame('8773212CD0C852C2BC16C7F2C98895C8', $comm['sign']);
    }

    public function testSign()
    {
        $client = new TMEClient(new Config(123, 'tmemusic', ''));

        $sign = $client->sign(1554880000);

        $this->assertSame('8773212CD0C852C2BC16C7F2C98895C8', $sign);
    }

    public function testQuery()
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($uri, $options) {
            $this->assertSame(12345678, $options['json']['comm']['appid']);
            $this->assertSame(['Ftrans_company' => 'KnowYourself', 'Flong_album_number' => 'rdxxx'], $options['json']['req']['param']);
            return new Response(200, body: file_get_contents(__DIR__ . '/../json/query.json'));
        });

        /** @var TMEClient $client */
        $client = Mockery::mock(TMEClient::class . '[client]', [new Config(12345678, 'secret', 'https://api.github.com/')]);
        $client->shouldReceive('client')->andReturn($guzzle);

        $res = $client->query(new QueryParam('KnowYourself', 'rdxxx'));

        $this->assertSame(0, $res['code']);
    }
}
