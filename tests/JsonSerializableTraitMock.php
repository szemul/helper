<?php
declare(strict_types=1);

namespace Szemul\Helper\Test;

use Carbon\CarbonInterface;
use DateTime;
use DateTimeImmutable;
use JsonSerializable;
use Szemul\Helper\JsonSerializableTrait;

class JsonSerializableTraitMock implements JsonSerializable
{
    use JsonSerializableTrait;

    /** @var string[] */
    public array $ignoredProperties = [
        'ignoredProperties',
    ];

    /**
     * @param mixed[] $array
     */
    public function __construct(
        private ?DateTime $date = null,
        protected ?DateTimeImmutable $dateImmutable = null,
        public ?CarbonInterface $carbon = null,
        public ?JsonSerializable $jsonSerializable = null,
        public ?string $string = null,
        public array $array = [],
    ) {
    }

    /**
     * @return string[]
     */
    protected function getIgnoredProperties(): array
    {
        return $this->ignoredProperties;
    }

    /**
     * @param mixed[]  $array
     * @param string[] $ignoredIndexes
     *
     * @return mixed[]
     */
    public function serializeTestArray(array $array, array $ignoredIndexes = []): array
    {
        return $this->serializeArray($array, $ignoredIndexes);
    }
}
