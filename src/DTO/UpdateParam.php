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

class UpdateParam implements ParamInterface
{
    public function __construct(
        public Album $album,
        public Singer $singer
    ) {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'info' => [
                'album' => $this->album,
                'album_singers' => [
                    $this->singer,
                ],
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
