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

class Config
{
    public function __construct(
        protected int $appid,
        protected string $secret,
        protected string $baseUri
    ) {
    }

    public function getAppid(): int
    {
        return $this->appid;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
