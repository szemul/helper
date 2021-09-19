<?php
declare(strict_types=1);

namespace Szemul\Helper;

class VarDumpHelper
{
    public function captureVarDumpToString(mixed ...$values): string
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
}
