<?php

namespace ManagerButtons\Processors\Settings;

use ManagerButtons\Processors\ProcessorBase;

class Get extends ProcessorBase
{
    public function process()
    {
        $this->service->ensureSettings();

        return $this->success('', $this->service->getAppearance());
    }
}
