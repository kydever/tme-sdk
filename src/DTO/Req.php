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

use Hyperf\Contract\Arrayable;
use KY\TME\Constants\Module;
use KY\TME\Json;

class Req implements Arrayable, \Stringable, \JsonSerializable
{
    public function __construct(public string $method, public ParamInterface $param, public string $module = Module::DEFAULT)
    {
    }

    public function __toString(): string
    {
        return Json::encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'module' => $this->module,
            'method' => $this->method,
            'param' => $this->param->toArray(),
        ];
    }

    public function jsonSerialize(): mixed
    {
        return [
            'module' => $this->module,
            'method' => $this->method,
            'param' => $this->param,
        ];
    }
}
