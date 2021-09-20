<?php
declare(strict_types=1);

namespace Szemul\Helper;

class VarDumpHelper
{
    public function varDumpToString(mixed ...$values): string
    {
        ob_start();

        try {
            var_dump(...$values);
        } finally {
            $result = ob_get_clean();
            ob_end_clean();

            return $result;
        }
    }

    public function varDumpToFile(\SplFileObject $file, mixed ...$values): void
    {
        ob_start(function (string $buffer) use ($file) {
            $file->fwrite($buffer);

            return '';
        }, 1048576);

        try {
            var_dump(...$values);
        } finally {
            ob_end_flush();
        }
    }
}
