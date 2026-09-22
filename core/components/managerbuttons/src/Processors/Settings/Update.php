<?php

namespace ManagerButtons\Processors\Settings;

use ManagerButtons\Processors\ProcessorBase;

class Update extends ProcessorBase
{
    public function process()
    {
        $this->service->saveAppearance(
            (string) $this->getProperty('background', ''),
            (string) $this->getProperty('color', '')
        );

        return $this->success($this->modx->lexicon('managerbuttons_settings_saved'), $this->service->getAppearance());
    }
}
