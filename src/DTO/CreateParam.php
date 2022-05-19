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
    /**
     * @param Chapter $chapter
     * @param Singer[] $chapterSingers
     * @param Album $book
     * @param Singer[] $bookSingers
     * @param Singer[] $authors
     */
    public function __construct(
        public Chapter $chapter,
        public array $chapterSingers,
        public Album $book,
        public array $bookSingers,
        public array $authors
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
                    'singer_infos' => $this->chapterSingers,
                ],
            ],
            'book_info' => [
                'base_info' => $this->book,
                'singer_infos' => $this->bookSingers,
                'author_infos' => $this->authors,
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
