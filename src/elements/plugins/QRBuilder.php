<?php
/**
 * @package qrbuilder
 */
/* load Qrbuilder class */
use LCI\MODX\QRBuilder\QRBuilder;

$qrBuilder = new QRBuilder($modx);

$eventName = $modx->event->name;
switch($eventName) {
    case 'OnPageNotFound':

        /* handle redirects */
        $parts = parse_url($_SERVER['REQUEST_URI']);
        $uri = $parts['path'];

        $baseUrl = $modx->getOption('base_url', null, MODX_BASE_URL);
        if(!empty($baseUrl) && $baseUrl != '/' && $baseUrl != ' ' /* && $baseUrl != '/'.$modx->context->get('key').'/' */) {
            $uri = str_replace($baseUrl,'',$uri);
        }
        $uri = ltrim($uri,'/');
        
        if ( !empty($uri) ) {
            /**
             * Will redirect to proper link if found and valid
             */
            $qrBuilder->redirect($uri, $modx->context->key);
        }

    break;
}