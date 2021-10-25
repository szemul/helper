<?php
declare(strict_types=1);

namespace Szemul\Helper\Test;

use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use JsonSerializable;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class JsonSerializableTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private const DATE_AKL           = '2021-06-02T00:00:00+12:00';
    private const DATE_UTC           = '2021-06-01T12:00:00+00:00';
    private const DATE_IMMUTABLE_AKL = '2021-06-03T12:00:00+12:00';
    private const DATE_IMMUTABLE_UTC = '2021-06-03T00:00:00+00:00';
    private const CARBON_AKL         = '2021-06-04T06:00:00+12:00';
    private const CARBON_UTC         = '2021-06-03T18:00:00Z';
    private const STRING             = 'bar';
    private const SERIALIZABLE_DATA  = [
        'test' => 'foo',
    ];
    private const ARRAY              = [
        'testArray' => 'foo',
    ];

    public function testJsonSerializeWithoutIgnoredProperties(): void
    {
        $timeZone = new DateTimeZone('Pacific/Auckland');

        $sut = new JsonSerializableTraitMock(
            new DateTime(self::DATE_AKL, $timeZone),
            new DateTimeImmutable(self::DATE_IMMUTABLE_AKL, $timeZone),
            new Carbon(self::CARBON_AKL, $timeZone),
            $this->getJsonSerializableMock(self::SERIALIZABLE_DATA),
            self::STRING,
            self::ARRAY,
        );

        $expected = [
            'date'               => self::DATE_UTC,
            'dateImmutable'      => self::DATE_IMMUTABLE_UTC,
            'carbon'             => self::CARBON_UTC,
            'jsonSerializable'   => self::SERIALIZABLE_DATA,
            'string'             => self::STRING,
            'array'              => self::ARRAY,
        ];

        $result = json_encode($sut);

        $this->assertEquals($expected, json_decode($result, true));
    }

    public function testJsonSerializeWithIgnoredProperties(): void
    {
        $timeZone = new DateTimeZone('Pacific/Auckland');

        $sut = new JsonSerializableTraitMock(
            new DateTime(self::DATE_AKL, $timeZone),
            new DateTimeImmutable(self::DATE_IMMUTABLE_AKL, $timeZone),
            new Carbon(self::CARBON_AKL, $timeZone),
            $this->getJsonSerializableMock(self::SERIALIZABLE_DATA),
            self::STRING,
            self::ARRAY,
        );

        $sut->ignoredProperties = [
            'ignoredProperties',
            'date',
            'carbon',
        ];

        $expected = [
            'dateImmutable'     => self::DATE_IMMUTABLE_UTC,
            'jsonSerializable'  => self::SERIALIZABLE_DATA,
            'string'            => self::STRING,
            'array'             => self::ARRAY,
        ];

        $result = json_encode($sut);

        $this->assertEquals($expected, json_decode($result, true));
    }

    public function testWithoutIgnoredProperties(): void
    {
        $timeZone = new DateTimeZone('Pacific/Auckland');

        $sut = new JsonSerializableTraitMock(
            new DateTime(self::DATE_AKL, $timeZone),
            new DateTimeImmutable(self::DATE_IMMUTABLE_AKL, $timeZone),
            new Carbon(self::CARBON_AKL, $timeZone),
            $this->getJsonSerializableMock(self::SERIALIZABLE_DATA),
            self::STRING,
            self::ARRAY,
        );

        $expected = [
            'date'               => self::DATE_UTC,
            'dateImmutable'      => self::DATE_IMMUTABLE_UTC,
            'carbon'             => self::CARBON_UTC,
            'jsonSerializable'   => self::SERIALIZABLE_DATA,
            'string'             => self::STRING,
            'array'              => self::ARRAY,
        ];

        $result = $sut->toArray();

        $this->assertEquals($expected, $result);
    }

    public function testWithIgnoredProperties(): void
    {
        $timeZone = new DateTimeZone('Pacific/Auckland');

        $sut = new JsonSerializableTraitMock(
            new DateTime(self::DATE_AKL, $timeZone),
            new DateTimeImmutable(self::DATE_IMMUTABLE_AKL, $timeZone),
            new Carbon(self::CARBON_AKL, $timeZone),
            $this->getJsonSerializableMock(self::SERIALIZABLE_DATA),
            self::STRING,
            self::ARRAY,
        );

        $sut->ignoredProperties = [
            'ignoredProperties',
            'date',
            'carbon',
        ];

        $expected = [
            'dateImmutable'     => self::DATE_IMMUTABLE_UTC,
            'jsonSerializable'  => self::SERIALIZABLE_DATA,
            'string'            => self::STRING,
            'array'             => self::ARRAY,
        ];

        $result = $sut->toArray();

        $this->assertEquals($expected, $result);
    }

    /**
     * @param mixed[] $data
     */
    private function getJsonSerializableMock(array $data): MockInterface|LegacyMockInterface|JsonSerializable
    {
        $mock = Mockery::mock(JsonSerializable::class);

        // @phpstan-ignore-next-line
        $mock->shouldReceive('jsonSerialize')
            ->withNoArgs()
            ->andReturn($data);

        return $mock;
    }
}
