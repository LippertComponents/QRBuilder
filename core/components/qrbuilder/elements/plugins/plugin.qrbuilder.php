<?php
/**
 * @package qrbuilder
 */
/* load Qrbuilder class */
$corePath = $modx->getOption('qrbuilder.core_path',null,$modx->getOption('core_path').'components/qrbuilder/');
require_once $corePath.'model/qrbuilder/qrbuilder.class.php';
if ( !isset($modx->qrbuilder) ){
    $modx->qrbuilder = new Qrbuilder($modx);
}

$eventName = $modx->event->name;
switch($eventName) {
    case 'OnPageNotFound':

        /* handle redirects */
        $uri = $_SERVER['REQUEST_URI'];
        $baseUrl = $modx->getOption('base_url',null,MODX_BASE_URL);
        if(!empty($baseUrl) && $baseUrl != '/' && $baseUrl != ' ' /* && $baseUrl != '/'.$modx->context->get('key').'/' */) {
            $uri = str_replace($baseUrl,'',$uri);
        }
        $uri = ltrim($uri,'/');
        
        if ( !empty($uri) ) {
            /**
             * Will redirect to proper link if found and valid
             */
            $modx->qrbuilder->redirect($uri, $modx->context->key);
        }

    break;

}

return '';