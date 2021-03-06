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
namespace KY\TME\DTO;

use KY\TME\Json;

class CreateParam implements ParamInterface
{
    /**
     * @param string $url 将 CreateJson 上传到云端后的访问地址
     */
    public function __construct(public string $url)
    {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'info' => [
                'album_info_path' => $this->url,
            ],
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
