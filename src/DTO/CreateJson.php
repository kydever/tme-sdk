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

class CreateJson implements ParamInterface
{
    /**
     * @param Chapter[] $chapters
     */
    public function __construct(public array $chapters, public Book $book)
    {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'chapter_infos' => $this->chapters,
            'book_info' => $this->book,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
