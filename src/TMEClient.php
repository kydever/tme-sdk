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
use KY\TME\DTO\CreateParam;
use KY\TME\DTO\QueryParam;
use KY\TME\DTO\Req;
use KY\TME\DTO\SaveTrackParam;
use KY\TME\DTO\UpdateParam;

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
     * 整本入库.
     */
    public function create(CreateParam $param): array
    {
        return $this->request(new Req('InsertAlbum', $param));
    }

    /**
     * 章节追加/更新.
     */
    public function insertTrack(SaveTrackParam $param): array
    {
        return $this->request(new Req('InsertTrack', $param));
    }

    /**
     * 更新书籍.
     */
    public function update(UpdateParam $param)
    {
        return $this->request(new Req('InsertAlbum', $param));
    }

    /**
     * 查询书籍入库情况.
     */
    public function query(QueryParam $param): array
    {
        return $this->request(new Req('QueryAlbumStatus', $param));
    }

    protected function request(Req $req): array
    {
        $response = $this->client()->post('cgi-bin/musicu.fcg', [
            RequestOptions::JSON => [
                'req' => $req->toArray(),
                'comm' => $this->setupCommon(),
            ],
        ]);

        return Json::decode((string) $response->getBody());
    }
}
