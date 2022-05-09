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
namespace KY\TME;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use KY\TME\Exception\RequestTimeoutException;

class TMEClient
{
    use HasSignature;

    public function __construct(protected Config $config)
    {
    }

    public function client(): Client
    {
        $config = [
            'base_uri' => $this->config->getBaseUri(),
            'headers' => [
                'comm' => [
                    'appid' => $this->config->getAppid(),
                    'timestamp' => $this->timestamp,
                    'sign' => $this->sign(time()),
                ],
            ],
        ];

        return new Client($config);
    }

    /**
     * 书籍添加
     *
     * @param array $paramters
     * @return array
     */
    public function add(array $paramters): array
    {
        return $this->base($paramters, 'InsertAlbum');
    }

    /**
     * 章节追加/更新
     *
     * @param array $paramters
     * @return array
     */
    public function push(array $paramters): array
    {
        return $this->base($paramters, 'InsertTrack');
    }

    /**
     * 书籍更新
     *
     * @param array $paramters
     * @return array
     */
    public function update(array $paramters): array
    {
        return $this->add($paramters);
    }

    /**
     * 查询书籍入库情况
     *
     * @param array $paramters
     * @return array
     */
    public function review(array $paramters): array
    {
        return $this->base($paramters, 'QueryAlbumStatus');
    }

    protected function base(array $paramters, string $method): array
    {
        try {
            $response = $this->client()
                ->post('cgi-bin/musicu.fcg', [
                    'json' => [
                        'req' => [
                            'module' => 'tme_music.LongMusicAccessServer.LongMusicAccessObj',
                            'method' => $method,
                            'param' => $paramters,
                        ],
                    ],
                ]);
        } catch (GuzzleException) {
            throw new RequestTimeoutException();
        }

        return $this->body($response);
    }

    /**
     * 返回响应
     *
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "item_id": 1000
     * }
     *
     * @param Response $response
     * @return array
     */
    protected function body(Response $response): array
    {
        $body = (string) $response->getBody();
        $data = json_decode($body, true);

        return $data['req']['data'] ?? [];
    }
}
