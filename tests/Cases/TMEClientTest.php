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

use KY\TME\Config;
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

    public function testAdd()
    {
        $client = Mockery::mock(TMEClient::class, [new Config(123, 'tmemusic', '')]);
        $client->shouldReceive('add')->andReturn($this->body());
        $paramters = [
            'info' => [
                'album_info_path' => 'http://xxxx/xxx/sample.json',
            ],
        ];
        $data = $client->add($paramters);
        $this->assertNotEmpty($data);
        $this->assertSame(0, $data['code']);
    }

    public function testPush()
    {
        $client = Mockery::mock(TMEClient::class, [new Config(123, 'tmemusic', '')]);
        $client->shouldReceive('push')->andReturn($this->body());
        $paramters = [
            'info' => [
                'track' => [
                    'Flong_track_name' => '测试书籍第3章',
                    '...',
                ],
                '...',
            ],
        ];
        $data = $client->push($paramters);
        $this->assertNotEmpty($data);
        $this->assertSame(0, $data['code']);
    }

    public function testUpdate()
    {
        $client = Mockery::mock(TMEClient::class, [new Config(123, 'tmemusic', '')]);
        $client->shouldReceive('update')->andReturn($this->body());
        $paramters = [
            'info' => [
                'track' => [
                    'Flong_track_name' => '测试书籍第3章',
                    '...',
                ],
                '...',
            ],
        ];
        $data = $client->update($paramters);
        $this->assertNotEmpty($data);
        $this->assertSame(0, $data['code']);
    }

    public function testReview()
    {
        $client = Mockery::mock(TMEClient::class, [new Config(123, 'tmemusic', '')]);
        $client->shouldReceive('review')->andReturn($this->body());
        $paramters = [
            'Ftrans_company' => '公司名',
            'Flong_album_number' => 'xxx',
        ];
        $data = $client->review($paramters);
        $this->assertNotEmpty($data);
        $this->assertSame(0, $data['code']);
    }

    protected function body()
    {
        $body = file_get_contents(__DIR__ . '/../musicu.json');
        $data = json_decode($body, true);

        return $data['req']['data'] ?? [];
    }
}
