<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Processors\ProcessorBase;

class Import extends ProcessorBase
{
    public function process()
    {
        $raw = (string) $this->getProperty('payload', '');
        if ($raw === '') {
            return $this->failure($this->modx->lexicon('managerbuttons_err_import_empty'));
        }
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_import_format'));
        }
        try {
            $group = $this->service->importGroup($data, false);
        } catch (\Throwable $e) {
            return $this->failure($e->getMessage());
        }

        return $this->success($this->modx->lexicon('managerbuttons_group_imported'), [
            'id' => (int) $group->get('id'),
            'name' => (string) $group->get('name'),
        ]);
    }
}
