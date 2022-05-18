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
     * @param string $trackName 单集名称(必填)
     * @param null|string $transName 单集翻译名
     * @param null|string $otherName 单集其他名
     * @param int $location // 曲序，从1开始计数(必填)
     * @param int $language // 语言(必填)
     * @param int $trackNumber // 传输方用于唯一标识章节的编码(必填)
     * @param string $publishTime // 发行时间(必填)
     * @param null|string $saleTime // 上线时间
     * @param string $audioUrl // 音频链接(必填)
     * @param string $company // 传输方名(必填)
     * @param string $number // 传输方用于唯一标识的书籍编码(必填)
     * @param null|int $audioChange // 如果希望更新音频，则置为 1
     *
     * @param array $singers
     */
    public function __construct(
        public string $trackName,
        public ?string $transName = null,
        public ?string $otherName = null,
        public int $location,
        public int $language,
        public int $trackNumber,
        public string $publishTime,
        public ?string $saleTime = null,
        public string $audioUrl,
        public string $company,
        public string $number,
        public ?int $audioChange = null,
        public object $singers,
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
                'track' => [
                    'Flong_track_name' => $this->trackName,
                    'Ftrans_name' => $this->transName,
                    'Fother_name' => $this->otherName,
                    'Flocation' => $this->location,
                    'Flanguage' => $this->language,
                    'Ftrack_number' => $this->trackNumber,
                    'Fpublic_time' => $this->publishTime,
                    'Fsale_time' => $this->saleTime,
                    'Fori_audio_url' => $this->audioUrl,
                    'Ftrans_company' => $this->company,
                    'Flong_album_number' => $this->number,
                    'Fis_audio_change' => $this->audioChange,
                ],
                'track_singers' => [
                    $this->singers,
                ],
            ],
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
