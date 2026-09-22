<?php

$root = dirname(__DIR__);
$ru = $root . '/core/components/managerbuttons/lexicon/ru/default.inc.php';
$en = $root . '/core/components/managerbuttons/lexicon/en/default.inc.php';

function mb_load_lexicon(string $file): array
{
    $_lang = [];
    include $file;

    return $_lang;
}

$ruLang = mb_load_lexicon($ru);
$enLang = mb_load_lexicon($en);

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

check(($ruLang['managerbuttons_description'] ?? '') === 'Описание', 'ru description caption is Описание');
check(($enLang['managerbuttons_description'] ?? '') === 'Description', 'en description caption is Description');
check(($ruLang['managerbuttons_actions'] ?? '') === 'Действия', 'ru actions caption is present');
check(str_contains(
    file_get_contents($root . '/core/components/managerbuttons/src/Service.php'),
    'function lexiconEntries'
), 'service reads lexicon files for the manager page');
check(str_contains(
    file_get_contents($root . '/vueManager/src/composables/useLexicon.js'),
    'ManagerButtons?.config?.lexicon'
), 'vue lexicon prefers the page payload over the cached topic');

exit($failed === 0 ? 0 : 1);
