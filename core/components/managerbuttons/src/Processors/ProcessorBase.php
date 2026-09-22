<?php

namespace ManagerButtons\Processors;

use ManagerButtons\Service;
use MODX\Revolution\Processors\Processor;

abstract class ProcessorBase extends Processor
{
    protected Service $service;

    public function initialize()
    {
        $this->modx->lexicon->load('managerbuttons:default');
        if ($this->modx->services->has('managerbuttons')) {
            $this->service = $this->modx->services->get('managerbuttons');
        } else {
            $this->service = new Service($this->modx);
        }

        return parent::initialize();
    }

    public function checkPermissions()
    {
        if (!$this->modx->user || !$this->modx->user->hasSessionContext('mgr')) {
            return false;
        }

        return (new Service($this->modx))->canManage();
    }

    /**
     * @return list<int>
     */
    protected function intList(string $key): array
    {
        $value = $this->getProperty($key, []);
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = $decoded;
            } else {
                $value = preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY) ?: [];
            }
        }
        if (!is_array($value)) {
            return [];
        }

        return array_values(array_unique(array_map('intval', $value)));
    }
}
