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
        protected string $appid,
        protected string $secret,
        protected string $mode = Mode::TEST
    ) {
    }

    public function getAppid(): string
    {
        return $this->appid;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}
