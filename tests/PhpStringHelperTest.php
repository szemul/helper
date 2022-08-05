<?php

declare(strict_types=1);

namespace Szemul\Helper\Test;

use PHPUnit\Framework\TestCase;
use Szemul\Helper\PhpStringHelper;

class PhpStringHelperTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function constantProvider(): array
    {
        return [
            ['word', 'WORD'],
            ['with spaces', 'WITH_SPACES'],
            ['special& char', 'SPECIAL_CHAR'],
            ['camelCase', 'CAMEL_CASE'],
            ['30days', 'DAYS_30'],
            ['dash-case', 'DASH_CASE'],
            ['30_days', 'DAYS_30'],
        ];
    }

    /**
     * @dataProvider constantProvider
     */
    public function testConvertToConstantName(string $input, string $expectedResult): void
    {
        $result = $this->getSut()->convertToConstantName($input);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return string[][]
     */
    public function methodProvider(): array
    {
        return [
            ['word', 'word'],
            ['with spaces in it', 'withSpacesInIt'],
            ['special& char', 'specialChar'],
            ['simpleCamelCase', 'simpleCamelCase'],
            ['UpperCase', 'upperCase'],
            ['dash-case', 'dashCase'],
            ['30_days', 'days30'],
        ];
    }

    /**
     * @dataProvider methodProvider
     */
    public function testConvertToMethodName(string $input, string $expectedResult): void
    {
        $result = $this->getSut()->convertToMethodOrVariableName($input);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return string[][]
     */
    public function classProvider(): array
    {
        return [
            ['word', 'Word'],
            ['with spaces in it', 'WithSpacesInIt'],
            ['special& char', 'SpecialChar'],
            ['simpleCamelCase', 'SimpleCamelCase'],
            ['30_days', 'Days30'],
            ['dash-case', 'DashCase'],
            ['internal.apiGateway', 'InternalApiGateway'],
        ];
    }

    /**
     * @dataProvider classProvider
     */
    public function testConvertToClassName(string $input, string $expectedResult): void
    {
        $result = $this->getSut()->convertToClassName($input);

        $this->assertSame($expectedResult, $result);
    }

    private function getSut(): PhpStringHelper
    {
        return new PhpStringHelper();
    }
}
