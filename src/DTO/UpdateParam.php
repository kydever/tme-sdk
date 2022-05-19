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

use KY\TME\Constants\Status;
use KY\TME\Json;

class UpdateParam implements ParamInterface
{
    /**
     * @param Singer[] $singers
     */
    public function __construct(
        public Album $album,
        public array $singers,
        public int $isPicChange = Status::NO
    ) {
    }

    public function __toString(): string
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'info' => [
                'album' => array_merge($this->album->toArray(), [
                    'Fis_pic_change' => $this->isPicChange,
                ]),
                'album_singers' => $this->singers,
            ],
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
