<?php
/**
 * @package QR-Buider
 * @subpackage processors
 */
class QrcodeRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'Qrcodes';
    public $languageTopics = array('qrbuilder:default');
    public $objectType = 'qrbuilder.qrcodes';
}
return 'QrcodeRemoveProcessor';