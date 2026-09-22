<?php

require dirname(__DIR__) . '/core/components/managerbuttons/src/Color.php';

use ManagerButtons\Color;

$failed = 0;

function check(bool $ok, string $message): void
{
    global $failed;
    if ($ok) {
        echo "ok  {$message}\n";
        return;
    }
    $failed++;
    echo "FAIL {$message}\n";
}

check(Color::normalize('') === '', 'empty stays empty');
check(Color::normalize('  #e5e5e5 ') === '#e5e5e5', 'hex is trimmed and lowercased');
check(Color::normalize('E5E5E5') === '#e5e5e5', 'hash is added');
check(Color::normalize('#abc') === '#abc', 'short hex is kept');
check(Color::normalize('#aabbccdd') === '#aabbccdd', 'alpha hex is kept');
check(Color::normalize('red') === '', 'named colors are rejected');
check(Color::normalize('#gg0000') === '', 'invalid hex is rejected');
check(Color::normalize('javascript:alert(1)') === '', 'unsafe text is rejected');
check(Color::DEFAULT_BACKGROUND === '#e5e5e5', 'default background is gray');

exit($failed > 0 ? 1 : 0);
