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
namespace HyperfTest\Cases;

use function KY\TME\array_filter_null;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends AbstractTestCase
{
    public function testArrayFilterNull()
    {
        $items = [
            'id' => 1,
            'name' => '',
            'gender' => null,
        ];

        $this->assertSame(['id' => 1, 'name' => ''], array_filter_null($items));
    }
}
