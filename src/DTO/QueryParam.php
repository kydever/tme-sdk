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

class QueryParam implements ParamInterface
{
    /**
     * @param string $company 传输方名
     * @param string $number 传输方用于唯一标识的书籍编码
     */
    public function __construct(public string $company, public string $number)
    {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'Ftrans_company' => $this->company,
            'Flong_album_number' => $this->number,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
