<?php

namespace ManagerButtons;

class Color
{
    public const DEFAULT_BACKGROUND = '#1d4ed8';
    public const DEFAULT_COLOR = '#ffffff';

    /**
     * Accepts #rgb, #rrggbb and #rrggbbaa. Anything else becomes an empty string,
     * which means "use the default".
     */
    public static function normalize(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }
        if ($value[0] !== '#') {
            $value = '#' . $value;
        }
        if (!preg_match('/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value)) {
            return '';
        }

        return strtolower($value);
    }
}
