<?php

namespace ManagerButtons\Processors\Button;

use ManagerButtons\Icons;
use ManagerButtons\Model\Button;
use ManagerButtons\Processors\ProcessorBase;

class Update extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var Button|null $button */
        $button = $this->modx->getObject(Button::class, $id);
        if (!$button) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_button_nf'));
        }
        $name = trim((string) $this->getProperty('name', $button->get('name')));
        $url = trim((string) $this->getProperty('url', $button->get('url')));
        if ($name === '' || $url === '') {
            return $this->failure($this->modx->lexicon('managerbuttons_err_button_fields'));
        }
        $button->fromArray([
            'name' => $name,
            'url' => $url,
            'icon' => Icons::normalizeName((string) $this->getProperty('icon', $button->get('icon'))),
            'cols' => $this->service->normalizeCols($this->getProperty('cols', $button->get('cols'))),
        ]);
        if (!$button->save()) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_save'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_button_updated'), [
            'id' => $id,
        ]);
    }
}
