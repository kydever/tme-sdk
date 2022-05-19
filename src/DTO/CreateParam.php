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
    public function __construct(
        public Chapter $chapter,
        public Singer $chapterSinger,
        public Album $book,
        public Singer $bookSinger,
        public Singer $author
    ) {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'chapter_infos' => [
                [
                    'base_info' => $this->chapter,
                    'singer_infos' => [
                        $this->chapterSinger,
                    ],
                ],
            ],
            'book_info' => [
                'base_info' => $this->book,
                'singer_infos' => [
                    $this->bookSinger,
                ],
                'author_infos' => [
                    $this->author,
                ],
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
