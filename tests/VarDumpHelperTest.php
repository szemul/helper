<?php

declare(strict_types=1);

namespace Szemul\Helper\Test;

use PHPUnit\Framework\TestCase;
use SplFileObject;
use Szemul\Helper\VarDumpHelper;

class VarDumpHelperTest extends TestCase
{
    private const TEST_DATA = [
        'foo' => 'bar',
    ];

    private const VAR_DUMP_FOR_TEST_DATA = <<<'EOF'
        array(1) {
          'foo' =>
          string(3) "bar"
        }
        EOF;

    public function testVarDumpToString(): void
    {
        $startObLevel = ob_get_level();
        $sut          = new VarDumpHelper();

        $result = $sut->varDumpToString(self::TEST_DATA);

        $this->assertStringContainsString(self::VAR_DUMP_FOR_TEST_DATA, $result);
        $this->assertSame($startObLevel, ob_get_level());
    }

    public function testVarDumpToFile(): void
    {
        $file         = new SplFileObject('php://temp', 'w+');
        $startObLevel = ob_get_level();
        $sut          = new VarDumpHelper();

        $sut->varDumpToFile($file, self::TEST_DATA);

        $file->fseek(0);
        $result = '';

        while (!$file->eof()) {
            $result .= $file->fread(1024);
        }

        $this->assertStringContainsString(self::VAR_DUMP_FOR_TEST_DATA, $result);
        $this->assertSame($startObLevel, ob_get_level());
    }
}
