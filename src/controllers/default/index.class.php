<?php
use LCI\MODX\QRBuilder\QRBuilder;
/**
 * @package qrbuilder
 * @subpackage controllers
 */

class QrbuilderIndexManagerController extends modExtraManagerController {
    /** @var QRBuilder $qrBuilder */
    public $qrBuilder;
    
    public function initialize() {
        $this->qrBuilder = new QRBuilder($this->modx);

        $this->addJavascript($this->qrBuilder->config['jsUrl'].'mgr/qrbuilder.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Qrbuilder.config = '.$this->modx->toJSON($this->qrBuilder->config).';
        });
        </script>');
        return parent::initialize();
    }
    
    public function getLanguageTopics() {
        return ['qrbuilder:default'];
    }
    
    public function checkPermissions() {
        return true;
    }
    
    public function getPageTitle() {
        return $this->modx->lexicon('qrbuilder');
    }
    
    public function loadCustomCssJs() {
        // @TODO build JS to read proper permissions 
        $this->addJavascript($this->qrBuilder->config['jsUrl'].'mgr/widgets/qrbuilder.grid.js');
        $this->addJavascript($this->qrBuilder->config['jsUrl'].'mgr/widgets/webads.grid.js');
        $this->addJavascript($this->qrBuilder->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->qrBuilder->config['jsUrl'].'mgr/sections/index.js');
    }
    
    public function getTemplateFile() {
        return 'home.tpl';
    }
}