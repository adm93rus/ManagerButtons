<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Export extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var ButtonGroup|null $group */
        $group = $this->modx->getObject(ButtonGroup::class, $id);
        if (!$group) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        $payload = $this->service->exportGroup($group);
        $filename = 'managerbuttons-' . $this->slug((string) $group->get('name')) . '.json';

        return $this->success('', [
            'filename' => $filename,
            'payload' => $payload,
            'json' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        ]);
    }

    protected function slug(string $name): string
    {
        $name = preg_replace('~[^\pL\d]+~u', '-', $name) ?: 'group';
        $name = trim($name, '-');

        return $name !== '' ? mb_strtolower($name) : 'group';
    }
}
