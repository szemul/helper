<?php
declare(strict_types=1);

namespace Szemul\Helper;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class DateHelper
{
    public function getCurrentTime(bool $immutable = true): CarbonInterface
    {
        return $immutable ? CarbonImmutable::now() : Carbon::now();
    }
}
