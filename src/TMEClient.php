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
use GuzzleHttp\RequestOptions;

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
        ];

        return new Client($config);
    }

    /**
     * 书籍添加.
     */
    public function add(array $paramters): array
    {
        return $this->post($paramters, 'InsertAlbum');
    }

    /**
     * 章节追加/更新.
     */
    public function push(array $parameters): array
    {
        return $this->post($parameters, 'InsertTrack');
    }

    /**
     * 书籍更新.
     */
    public function update(array $parameters): array
    {
        return $this->add($parameters);
    }

    /**
     * 查询书籍入库情况.
     */
    public function review(array $parameters): array
    {
        return $this->post($parameters, 'QueryAlbumStatus');
    }

    protected function post(array $parameters, string $method): array
    {
        $response = $this->client()->post('cgi-bin/musicu.fcg', [
            RequestOptions::JSON => [
                'req' => [
                    'module' => 'tme_music.LongMusicAccessServer.LongMusicAccessObj',
                    'method' => $method,
                    'param' => $parameters,
                ],
            ],
            RequestOptions::HEADERS => [
                'comm' => $this->setupCommon(),
            ],
        ]);

        return json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
