<?php
/**
 * Get a list of QR Codes (links)
 *
 * @package qrbuilder
 * @subpackage processors
 */
class QrcodeGetListProcessor extends modObjectGetListProcessor {
    /**
     * 
     */
    protected $context_key_urls = array();
    
    /**
     * xpdo class name
     */
    public $classKey = 'Qrcodes';
    /**
     * lexicon 
     */
    public $languageTopics = array('qrbuilder:default');
    /**
     * column to order by for SQL query
     */
    public $defaultSortField = 'name';
    /**
     * order by direction
     */
    public $defaultSortDirection = 'ASC';
    
    public $objectType = 'qrbuilder.qrcodes';
    
    /**
     * Allow to add a condition to the query if the value from the search bar has been passed and is not empty
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'name:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
                'OR:short_link:LIKE' => '%'.$query.'%'
            ));
        }
        $context_key = $this->getProperty('context_key');
        if (!empty($context_key)) {
            $c->where(array(
                'context_key' => $context_key
            ));
        }
        return $c;
    }
    
    
    /**
     * Prepare the row for iteration, Override the default method
     * @param xPDOObject $object
     * @return array
     * 
     */
    public function prepareRow(xPDOObject $object) {
        $data = $object->toArray();
        
        // build qr_link:
        $site_url = $this->modx->getOption('site_url');
        if ( isset($data['context_key']) && !isset($this->context_key_urls[$data['context_key']]) ) {
            $contextSetting = $this->modx->getObject('modContextSetting', 
                array(
                    'context_key' => $data['context_key'], 
                    'key' => 'site_url'
                    )
                );
            if ( is_object($contextSetting) ) {
                $site_url = $contextSetting->get('value');
            }
            $this->context_key_urls[$data['context_key']] = $site_url;
        }
        //if ( !$data['use_ad_link'] ){ }
        $data['qr_link'] = rtrim($site_url, '/').'/'.$data['short_link'];
        
        // build custom params:
        if ( !$data['override_url_input'] ) {
            
            $params = json_decode($data['build_url_params'], TRUE);
            foreach ( $params as $name => $value ) {
                // do not allow to override db column data 
                if ( !isset($data[$name])) {
                    $data[$name] = $value;
                }
            }
        }
        
        return $data;
    }
}
return 'QrcodeGetListProcessor';