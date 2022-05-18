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
use KY\TME\DTO\QueryParam;
use KY\TME\DTO\Req;

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

    // /**
    //  * 书籍添加.
    //  */
    // public function add(array $parameters): array
    // {
    //     return $this->post($parameters, 'InsertAlbum');
    // }
    //
    // /**
    //  * 章节追加/更新.
    //  */
    // public function push(array $parameters): array
    // {
    //     return $this->post($parameters, 'InsertTrack');
    // }
    //
    // /**
    //  * 书籍更新.
    //  */
    // public function update(array $parameters): array
    // {
    //     return $this->add($parameters);
    // }

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
