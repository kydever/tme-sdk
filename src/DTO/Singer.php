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
use function KY\TME\array_filter_null;

class Singer implements ParamInterface
{
    /**
     * @param string $name 主播名
     * @param null|int $sort 主播排序
     */
    public function __construct(
        public string $name,
        public ?int $sort = null
    ) {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return array_filter_null([
            'Forder_index' => $this->sort,
            'Fsinger_name' => $this->name,
        ]);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
