<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

require_once rtrim((string) $namespace['path'], '/') . '/autoload.php';

$modx->addPackage('ManagerButtons\\Model', $namespace['path'] . 'src/', null, 'ManagerButtons\\');

$modx->services->add('managerbuttons', function ($c) use ($modx) {
    return new \ManagerButtons\Service($modx);
});
