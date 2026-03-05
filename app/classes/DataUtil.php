<?php

class DataUtil {

    public static function toIntBool(mixed $v): int {
        if (is_bool($v)) return $v ? 1 : 0;
        $s = strtolower(trim((string)$v));
        return in_array($s, ['1', 'true', 'on', 'yes', 'si'], true) ? 1 : 0;
    }

}