<?php
use LCI\MODX\QRBuilder\QRBuilder;

/**
 * QR-Builder Connector
 *
 * @package qrbuilder
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$modx->qrbuilder = new QRBuilder($modx);

$modx->lexicon->load('qrbuilder:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->qrbuilder->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));