<?php
/**
 * @package qrbuilder
 * @subpackage controllers
 */
require_once dirname(dirname(dirname(__FILE__))) . '/model/qrbuilder/qrbuilder.class.php';

class QrbuilderIndexManagerController extends modExtraManagerController {
    /** @var Qrbuilder $qrbuilder */
    public $qrbuilder;
    
    public function initialize() {
        $this->qrbuilder = new Qrbuilder($this->modx);

        //$this->addCss($this->qrbuilder->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->qrbuilder->config['jsUrl'].'mgr/qrbuilder.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Qrbuilder.config = '.$this->modx->toJSON($this->qrbuilder->config).';
        });
        </script>');
        return parent::initialize();
    }
    
    public function getLanguageTopics() {
        return array('qrbuilder:default');
    }
    
    public function checkPermissions() {
        return true;
    }
    
    public function getPageTitle() {
        return $this->modx->lexicon('qrbuilder');
    }
    
    public function loadCustomCssJs() {
        // @TODO build JS to read proper permissions 
        $this->addJavascript($this->qrbuilder->config['jsUrl'].'mgr/widgets/qrbuilder.grid.js');
        $this->addJavascript($this->qrbuilder->config['jsUrl'].'mgr/widgets/webads.grid.js');
        $this->addJavascript($this->qrbuilder->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->qrbuilder->config['jsUrl'].'mgr/sections/index.js');
    }
    
    public function getTemplateFile() {
        return 'home.tpl';
    }
}
/**
 * @package qrbuilder
 * @subpackage controllers
 * /
class IndexManagerController extends QrbuilderIndexManagerController {
    public static function getDefaultController() {
        return 'home';
    }
}*/