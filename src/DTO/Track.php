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

class Track implements ParamInterface
{
    /**
     * @param string $name 单集名称
     * @param int $location 曲序
     * @param int $language 语言
     * @param string $number 传输方用于唯一标识章节的编码
     * @param string $publishTime 发行时间
     * @param string $audioUrl 音频链接
     * @param string $company 传输方名
     * @param string $albumNumber 传输方用于唯一标识的书籍编码
     * @param null|string $transName 单集翻译名
     * @param null|string $otherName 单集其他名
     * @param null|string $saleTime 上线时间
     * @param null|int $audioChange 更新音频
     */
    public function __construct(
        public string $name,
        public int $location,
        public int $language,
        public string $number,
        public string $publishTime,
        public string $audioUrl,
        public string $company,
        public string $albumNumber,
        public ?string $transName = null,
        public ?string $otherName = null,
        public ?string $saleTime = null,
        public ?int $audioChange = null
    ) {
    }

    public function __toString()
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return array_filter_null([
            'Flong_track_name' => $this->name,
            'Ftrans_name' => $this->transName,
            'Fother_name' => $this->otherName,
            'Flocation' => $this->location,
            'Flanguage' => $this->language,
            'Ftrack_number' => $this->number,
            'Fpublic_time' => $this->publishTime,
            'Fsale_time' => $this->saleTime,
            'Fori_audio_url' => $this->audioUrl,
            'Ftrans_company' => $this->company,
            'Flong_album_number' => $this->albumNumber,
            'Fis_audio_change' => $this->audioChange,
        ]);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
