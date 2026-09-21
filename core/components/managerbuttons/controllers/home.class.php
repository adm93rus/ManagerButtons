<?php

use ManagerButtons\Service;
use MODX\Revolution\modExtraManagerController;

class ManagerbuttonsHomeManagerController extends modExtraManagerController
{
    protected Service $service;

    public function initialize()
    {
        if ($this->modx->services->has('managerbuttons')) {
            $this->service = $this->modx->services->get('managerbuttons');
        } else {
            $this->service = new Service($this->modx);
        }
        parent::initialize();
    }

    public function getLanguageTopics()
    {
        return ['managerbuttons:default'];
    }

    public function checkPermissions()
    {
        return true;
    }

    public function getPageTitle()
    {
        return $this->modx->lexicon('ManagerButtons') ?: 'ManagerButtons';
    }

    public function loadCustomCssJs()
    {
        $config = $this->service->config;
        $config['modAuth'] = $this->modx->user ? $this->modx->user->getUserToken('mgr') : '';
        $config['manager_url'] = $this->modx->getOption('manager_url');
        $config['cultureKey'] = $this->modx->getOption('cultureKey', $_SESSION, 'en');

        $assetsPath = $this->modx->getOption('assets_path') . 'components/managerbuttons/';
        $vueExists = is_file($assetsPath . 'js/mgr/vue-dist/home.min.js');
        $cssExists = is_file($assetsPath . 'css/mgr/vue-dist/home.min.css');

        $this->addHtml(
            '<script>window.ManagerButtons = ' . json_encode([
                'config' => $config,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';</script>'
        );

        if ($vueExists) {
            if ($cssExists) {
                $this->addCss($this->service->versionedAsset('css/mgr/vue-dist/home.min.css'));
            }
            $this->service->addVueModule($this, $this->service->versionedAsset('js/mgr/vue-dist/home.min.js'));
        } else {
            $msg = json_encode($this->modx->lexicon('managerbuttons_vuetools_required'), JSON_UNESCAPED_UNICODE);
            $this->addHtml(
                '<script>document.addEventListener("DOMContentLoaded",function(){var el=document.getElementById("managerbuttons-app");if(el){el.textContent=' . $msg . ';}});</script>'
            );
        }
    }

    public function getTemplateFile()
    {
        return $this->service->config['templatesPath'] . 'home.tpl';
    }
}
