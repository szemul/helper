<?php
declare(strict_types=1);

namespace Szemul\Helper;

use Carbon\CarbonInterface;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use JsonSerializable;

trait JsonSerializableTrait
{
    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        return $this->serializeArray(get_object_vars($this), $this->getIgnoredProperties());
    }

    /**
     * @param array<string,mixed> $array
     * @param string[]            $ignoredIndexes
     *
     * @return array<string,mixed>
     */
    protected function serializeArray(array $array, array $ignoredIndexes = []): array
    {
        foreach ($array as $index => $value) {
            if (in_array($index, $ignoredIndexes)) {
                unset($array[$index]);
                continue;
            }

            if ($value instanceof CarbonInterface) {
                $array[$index] = $value->toIso8601ZuluString();
            } elseif ($value instanceof DateTimeImmutable) {
                $array[$index] = $value->setTimezone(new DateTimeZone('UTC'))->format(DATE_ATOM);
            } elseif ($value instanceof DateTime) {
                $date          = clone $value;
                $array[$index] = $date->setTimezone(new DateTimeZone('UTC'))->format(DATE_ATOM);
            } elseif ($value instanceof JsonSerializable) {
                $array[$index] = $value->jsonSerialize();
            } elseif (is_array($value)) {
                $array[$index] = $this->serializeArray($value);
            }
        }

        return $array;
    }

    /**
     * @return string[]
     * @codeCoverageIgnore
     */
    protected function getIgnoredProperties(): array
    {
        return [];
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}
