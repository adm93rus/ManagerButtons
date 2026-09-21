<?php

namespace ManagerButtons\Processors\Button;

use ManagerButtons\Model\Button;
use ManagerButtons\Processors\ProcessorBase;

class Remove extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var Button|null $button */
        $button = $this->modx->getObject(Button::class, $id);
        if (!$button) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_button_nf'));
        }
        if (!$button->remove()) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_remove'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_button_removed'));
    }
}
