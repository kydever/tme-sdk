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

class Book implements ParamInterface
{
    /**
     * @param Album $album
     * @param Singer[] $singers
     * @param Singer[] $authors
     */
    public function __construct(public Album $album, public array $singers = [], public array $authors = [])
    {
    }

    public function __toString(): string
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'base_info' => $this->album,
            'singer_infos' => $this->singers,
            'author_infos' => $this->authors,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
