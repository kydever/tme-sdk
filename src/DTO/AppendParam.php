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

class AppendParam implements ParamInterface
{
    /**
     * @param array $track
     * @param array $singers
     */
    public function __construct(
        public array $track,
        public array $singers,
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
                'track_singers' => $this->singers,
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
