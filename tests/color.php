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
check(Color::normalize('  #234368 ') === '#234368', 'hex is trimmed and lowercased');
check(Color::normalize('234368') === '#234368', 'hash is added');
check(Color::normalize('#abc') === '#abc', 'short hex is kept');
check(Color::normalize('#aabbccdd') === '#aabbccdd', 'alpha hex is kept');
check(Color::normalize('red') === '', 'named colors are rejected');
check(Color::normalize('#gg0000') === '', 'invalid hex is rejected');
check(Color::normalize('javascript:alert(1)') === '', 'unsafe text is rejected');
check(Color::DEFAULT_BACKGROUND === '#234368', 'default background is the MODX 3 blue');
check(Color::DEFAULT_COLOR === '#ffffff', 'default text is white');

exit($failed > 0 ? 1 : 0);
