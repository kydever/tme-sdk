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

class Singer
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
}
