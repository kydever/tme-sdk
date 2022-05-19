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

class AppendOrUpdateParam implements ParamInterface
{
    public function __construct(
        public Track $track,
        public Singer $singer,
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
                'track' => $this->track,
                'track_singers' => [
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
