<?php
/**
 * install the db tables 
 */

// add package
$s_path = $modx->getOption('core_path').'components/qrbuilder/model/';
$modx->addPackage('qrbuilder', $s_path);
 
$m = $modx->getManager();
// the class table object name
$m->createObjectContainer('Qrcodes');
$m->createObjectContainer('QrcodeStats');

return 'Tables created.';