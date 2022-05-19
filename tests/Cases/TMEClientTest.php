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
use KY\TME\Constants\Area;
use KY\TME\Constants\Language;
use KY\TME\Constants\ScheduleStatus;
use KY\TME\Constants\Type;
use KY\TME\DTO\Album;
use KY\TME\DTO\AppendOrUpdateParam;
use KY\TME\DTO\Chapter;
use KY\TME\DTO\CreateParam;
use KY\TME\DTO\QueryParam;
use KY\TME\DTO\Singer;
use KY\TME\DTO\Track;
use KY\TME\DTO\UpdateParam;
use KY\TME\Json;
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

    public function testCreate()
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url, $options) {
            $this->assertSame(12345678, $options['json']['comm']['appid']);
            $json = Json::encode($options['json']['req']['param']);
            $json = Json::decode($json);

            $this->assertSame([
                'chapter_infos' => [
                    [
                        'base_info' => [
                            'Flong_track_name' => '测试书籍第1章',
                            'Flocation' => 1,
                            'Flanguage' => Language::CHINESE_MANDARIN,
                            'Ftrack_number' => 'rdxxx',
                            'Fpublic_time' => '2020-03-25 00:00:00',
                            'Fori_audio_url' => 'http://xxx/1.mp3',
                        ],
                        'singer_infos' => [
                            [
                                'Fsinger_name' => '主播1',
                            ],
                        ],
                    ],
                ],
                'book_info' => [
                    'base_info' => [
                        'Ftrans_company' => 'KnowYourself',
                        'Flong_album_name' => '测试书籍',
                        'Flong_album_number' => 'rdxxx',
                        'Fschedule_status' => ScheduleStatus::CLOSED,
                        'Farea' => Area::MAINLAND,
                        'Ftype' => Type::HELP_SLEEP,
                        'Flanguage' => '0',
                        'Fori_photo_url' => 'http://xxx/book.jpg',
                        'Fpublic_time' => '2020-03-25 00:00:00',
                    ],
                    'singer_infos' => [
                        [
                            'Fsinger_name' => '主播1',
                        ],
                    ],
                    'author_infos' => [
                        [
                            'Fsinger_name' => '作者1',
                        ],
                    ],
                ],
            ], $json);

            return new Response(body: file_get_contents(__DIR__ . '/../json/musicu.json'));
        });

        $client = Mockery::mock(TMEClient::class . '[client]', [new Config(12345678, 'secret', 'https://api.github.com/')]);
        $client->shouldReceive('client')->andReturn($guzzle);
        $res = $client->create(new CreateParam(
            new Chapter(
                '测试书籍第1章',
                1,
                Language::CHINESE_MANDARIN,
                'rdxxx',
                '2020-03-25 00:00:00',
                'http://xxx/1.mp3'
            ),
            new Singer('主播1'),
            new Album(
                'KnowYourself',
                '测试书籍',
                'rdxxx',
                ScheduleStatus::CLOSED,
                Area::MAINLAND,
                Type::HELP_SLEEP,
                [Language::CHINESE_MANDARIN],
                'http://xxx/book.jpg',
                '2020-03-25 00:00:00',
            ),
            new Singer('主播1'),
            new Singer('作者1')
        ));

        $this->assertSame(0, $res['code']);
    }

    public function testAppendOrUpdate()
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url, $options) {
            $this->assertSame(12345678, $options['json']['comm']['appid']);
            $json = Json::encode($options['json']['req']['param']);
            $json = Json::decode($json);

            $this->assertSame([
                'info' => [
                    'track' => [
                        'Flong_track_name' => '测试书籍第3章',
                        'Flocation' => 3,
                        'Flanguage' => Language::CHINESE_MANDARIN,
                        'Ftrack_number' => 'rdxxx',
                        'Fpublic_time' => '2020-03-25 00:00:00',
                        'Fori_audio_url' => 'http://xxx/2.mp3',
                        'Ftrans_company' => 'KnowYourself',
                        'Flong_album_number' => 'rdxxx',
                    ],
                    'track_singers' => [
                        [
                            'Fsinger_name' => '主播1',
                        ],
                    ],
                ],
            ], $json);

            return new Response(body: file_get_contents(__DIR__ . '/../json/musicu.json'));
        });

        $client = Mockery::mock(TMEClient::class . '[client]', [new Config(12345678, 'secret', 'https://api.github.com/')]);
        $client->shouldReceive('client')->andReturn($guzzle);

        $res = $client->appendOrUpdate(new appendOrUpdateParam(
            new Track(
                '测试书籍第3章',
                3,
                Language::CHINESE_MANDARIN,
                'rdxxx',
                '2020-03-25 00:00:00',
                'http://xxx/2.mp3',
                'KnowYourself',
                'rdxxx',
            ),
            new Singer('主播1')
        ));
        $this->assertSame(0, $res['code']);
    }

    public function testUpdate()
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($url, $options) {
            $this->assertSame(12345678, $options['json']['comm']['appid']);
            $json = Json::encode($options['json']['req']['param']);
            $json = Json::decode($json);

            $this->assertSame([
                'info' => [
                    'album' => [
                        'Ftrans_company' => 'KnowYourself',
                        'Flong_album_name' => '测试书籍',
                        'Flong_album_number' => 'rdxxx',
                        'Fschedule_status' => ScheduleStatus::CLOSED,
                        'Farea' => Area::MAINLAND,
                        'Ftype' => Type::HELP_SLEEP,
                        'Flanguage' => '0',
                        'Fori_photo_url' => 'http://xxx/book.jpg',
                        'Fpublic_time' => '2020-03-25 00:00:00',
                    ],
                    'album_singers' => [
                        [
                            'Fsinger_name' => '主播1',
                        ],
                    ],
                ],
            ], $json);

            return new Response(body: file_get_contents(__DIR__ . '/../json/musicu.json'));
        });

        $client = Mockery::mock(TMEClient::class . '[client]', [new Config(12345678, 'secret', 'https://api.github.com/')]);
        $client->shouldReceive('client')->andReturn($guzzle);

        $res = $client->update(
            new UpdateParam(
                new Album(
                    'KnowYourself',
                    '测试书籍',
                    'rdxxx',
                    ScheduleStatus::CLOSED,
                    Area::MAINLAND,
                    Type::HELP_SLEEP,
                    [Language::CHINESE_MANDARIN],
                    'http://xxx/book.jpg',
                    '2020-03-25 00:00:00',
                ),
                new Singer('主播1')
            )
        );
        $this->assertSame(0, $res['code']);
    }

    public function testQuery()
    {
        $guzzle = Mockery::mock(Client::class);
        $guzzle->shouldReceive('post')->withAnyArgs()->andReturnUsing(function ($uri, $options) {
            $this->assertSame(12345678, $options['json']['comm']['appid']);
            $json = Json::encode($options['json']['req']['param']);
            $json = Json::decode($json);
            $this->assertSame(['Ftrans_company' => 'KnowYourself', 'Flong_album_number' => 'rdxxx'], $json);
            return new Response(200, body: file_get_contents(__DIR__ . '/../json/query.json'));
        });

        /** @var TMEClient $client */
        $client = Mockery::mock(TMEClient::class . '[client]', [new Config(12345678, 'secret', 'https://api.github.com/')]);
        $client->shouldReceive('client')->andReturn($guzzle);

        $res = $client->query(new QueryParam('KnowYourself', 'rdxxx'));

        $this->assertSame(0, $res['code']);
    }
}
