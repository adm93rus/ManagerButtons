<?php

require dirname(__DIR__) . '/core/components/managerbuttons/src/Icons.php';

use ManagerButtons\Icons;

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

$names = Icons::names();
check(count($names) > 1000, 'native catalog has more than 1000 icons');
check(count($names) === count(array_unique($names)), 'icon names are unique');
check(in_array('home', $names, true) && in_array('plus', $names, true), 'home and plus are in the catalog');
check(Icons::cssClass('home') === 'icon icon-home', 'bare name becomes icon icon-home');
check(Icons::cssClass('icon icon-home') === 'icon icon-home', 'existing manager class is kept');
check(Icons::cssClass('fas fa-home') === 'icon icon-home', 'font awesome class maps to the manager class');
check(Icons::cssClass('fa-home') === 'icon icon-home', 'fa- prefix is stripped');
check(Icons::cssClass('icon-home') === 'icon icon-home', 'icon- prefix is stripped');
check(Icons::cssClass('ICON ICON-HOME') === 'icon icon-home', 'class is normalized to lower case');
check(Icons::cssClass('home" onclick="alert(1)') === 'icon icon-link', 'unsafe class text falls back to link');
check(Icons::cssClass('') === 'icon icon-link', 'empty icon falls back to link');
check(Icons::normalizeName('fas fa-plus') === 'plus', 'normalizeName stores the short name');

$catalog = Icons::catalog();
check(count($catalog) === count($names), 'catalog matches the name list');
check($catalog[0]['class'] === 'icon icon-' . $catalog[0]['name'], 'catalog class matches the name');

exit($failed === 0 ? 0 : 1);
