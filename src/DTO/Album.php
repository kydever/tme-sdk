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

class Album implements ParamInterface
{
    /**
     * @param string $company 传输方名
     * @param string $name 书籍名
     * @param string $number 传输方用于唯一标识的书籍编码
     * @param int $scheduleStatus 连载状态
     * @param int $area 书籍地区
     * @param int $type 节目主类型
     * @param string $language 书籍语言
     * @param string $photoUrl 书籍图片
     * @param string $publishTime 发行时间
     * @param null|string $transName 书籍翻译名
     * @param null|string $otherName 书籍其他名
     * @param null|string $description 书籍简介
     * @param null|string $originalWorkName 原著作品名
     * @param null|string $originalPublishTime 原著发行时间
     * @param null|string $saleTime 上线时间
     */
    public function __construct(
        public string $company,
        public string $name,
        public string $number,
        public int $scheduleStatus,
        public int $area,
        public int $type,
        public array $languages,
        public string $photoUrl,
        public string $publishTime,
        public ?string $transName = null,
        public ?string $otherName = null,
        public ?string $description = null,
        public ?string $originalWorkName = null,
        public ?string $originalPublishTime = null,
        public ?string $saleTime = null
    ) {
    }

    public function __toString(): string
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return array_filter_null([
            'Ftrans_company' => $this->company,
            'Flong_album_name' => $this->name,
            'Ftrans_name' => $this->transName,
            'Fother_name' => $this->otherName,
            'Flong_album_desc' => $this->description,
            'Flong_album_number' => $this->number,
            'Fschedule_status' => $this->scheduleStatus,
            'Farea' => $this->area,
            'Ftype' => $this->type,
            'Flanguage' => implode(',', $this->languages),
            'Foriginal_work_name' => $this->originalWorkName,
            'Foriginal_public_time' => $this->originalPublishTime,
            'Fori_photo_url' => $this->photoUrl,
            'Fpublic_time' => $this->publishTime,
            'Fsale_time' => $this->saleTime,
        ]);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
