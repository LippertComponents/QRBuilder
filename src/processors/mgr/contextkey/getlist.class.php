<?php
/**
 * Get a list of Context Keys ~ excluding manager
 *
 * @package qrbuilder
 * @subpackage processors
 */
class QRContextKeyGetListProcessor extends modObjectGetListProcessor {
    /**
     * xpdo class name
     */
    public $classKey = 'modContext';
    /**
     * lexicon 
     */
    public $languageTopics = array('qrbuilder:default');
    /**
     * column to order by for SQL query
     */
    public $defaultSortField = 'rank';
    /**
     * order by direction
     */
    public $defaultSortDirection = 'ASC';
    
    public $objectType = 'qrbuilder.context';
    
    public $primaryKeyField = 'key';
    
    /**
     * Allow to add a condition to the query if the value from the search bar has been passed and is not empty
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->where(array(
            'key:!=' => 'mgr'
        ));
        return $c;
    }
    
}
return 'QRContextKeyGetListProcessor';