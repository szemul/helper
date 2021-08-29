<?php
declare(strict_types=1);

namespace Szemul\Helper\Test;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Szemul\Helper\DateHelper;
use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    public function testNonImmutable(): void
    {
        $helper = new DateHelper();

        $currentTime = $helper->getCurrentTime(false);

        $this->assertInstanceOf(Carbon::class, $currentTime);
        $this->assertEqualsWithDelta(time(), $currentTime->getTimestamp(), 2);
    }

    public function testImmutable(): void
    {
        $helper = new DateHelper();

        $currentTime = $helper->getCurrentTime();

        $this->assertInstanceOf(CarbonImmutable::class, $currentTime);
        $this->assertEqualsWithDelta(time(), $currentTime->getTimestamp(), 2);
    }
}
