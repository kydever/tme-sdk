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
namespace KY\TME;

trait HasSignature
{
    public function setupCommon(?int $timestamp = null): array
    {
        $timestamp || $timestamp = time();
        return [
            'appid' => $this->config->getAppid(),
            'timestamp' => $timestamp,
            'sign' => $this->sign($timestamp),
        ];
    }

    public function sign(int $timestamp): string
    {
        $appid = $this->config->getAppid();
        $secret = $this->config->getSecret();

        return strtoupper(
            md5($appid . '_' . $secret . '_' . $timestamp)
        );
    }
}
