<?php
/**
 * Get a list of QR Codes (links)
 *
 * @package qrbuilder
 * @subpackage processors
 */
class QrcodeGetListProcessor extends modObjectGetListProcessor {
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
        
        // build qr_link: @TODO make work for site contexts
        $site_url = $this->modx->getOption('site_url');
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