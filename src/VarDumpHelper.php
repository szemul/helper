<?php
declare(strict_types=1);

namespace Szemul\Helper;

class VarDumpHelper
{
    public function varDumpToString(mixed ...$values): string
    {
        $result = '';

        $bufferCallback = function (string $buffer) use (&$result) {
            $result .= $buffer;

            return '';
        };

        $this->runVarDump($bufferCallback, ...$values);

        return $result;
    }

    public function varDumpToFile(\SplFileObject $file, mixed ...$values): void
    {
        $bufferCallback = function (string $buffer) use ($file) {
            $file->fwrite($buffer);

            return '';
        };

        $this->runVarDump($bufferCallback, ...$values);
    }

    private function runVarDump(callable $bufferCallback, mixed ...$values): void
    {
        ob_start($bufferCallback, 1048576);

        try {
            var_dump(...$values);
        } finally {
            ob_end_flush();
        }
    }
}
