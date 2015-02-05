<?php
/**
 * @package QR-Builder
 * @subpackage processors
 */
class QrcodeUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'Qrcodes';
    public $languageTopics = array('qrbuilder:default');
    public $objectType = 'qrbuilder.qrcodes';
    
    /**
     * This is ran before things are set to the DB object also before beforeSave()
     * @return boolean
     */
    public function beforeSet() {
        
        $this->unsetProperty('hits');
        
        $name = $this->getProperty('name');
        //$this->addFieldError('name', 'Error Check for Update->beforeSet(), Path: '.$this->modx->qrbuilder->config['qrCodePath']);

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('qrbuilder.qrcode_err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name, 'id:NOT IN' => array($this->object->get('id')) ))) {
            // @TODO exclude current ID
            $this->addFieldError('name',$this->modx->lexicon('qrbuilder.qrcode_err_ae'));
        }
        
        // fix date formats: 
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $sdate = DateTime::createFromFormat($this->modx->getOption('manager_date_format', null, 'Y-m-d'), $this->getProperty('start_date'));
            $this->setProperty('start_date', $sdate->format('Y-m-d'));
            
            $edate = DateTime::createFromFormat($this->modx->getOption('manager_date_format', null, 'Y-m-d'), $this->getProperty('end_date'));
            $this->setProperty('end_date', $edate->format('Y-m-d'));
        } else {
            $this->setProperty('start_date', date('Y-m-d', $sdate = strtotime( $this->getProperty('start_date'))) );
            
            $this->setProperty('start_date', date('Y-m-d', $edate = strtotime( $this->getProperty('end_date'))) );
        }
        if ( $sdate > $edate && $this->getProperty('use_end_date') ) {
            $this->addFieldError('end_date', $this->modx->lexicon('qrbuilder.qrcode_err_end_date'));
        }

        // build URL params:
        if ( $this->getProperty('override_url_input') ) {
            // override analytics tab:
            
            // @TODO check if valid JSON:
            $json = $this->modx->fromJSON($this->getProperty('build_url_params'));
            
            $string = $this->toJSON($json);
            if ( $string != $this->getProperty('build_url_params') ) {
                $this->addFieldError('override_url_input', $this->modx->lexicon('qrbuilder.qrcode_err_invalid_json') );
            } 
            
        } else {
            $params = array(
                'campaign_source' => $this->getProperty('campaign_source'),
                'campaign_medium' => $this->getProperty('campaign_medium'),
                'campaign_term' => $this->getProperty('campaign_term'),
                'campaign_content' => $this->getProperty('campaign_content'),
                'campaign_name' => $this->getProperty('campaign_name')
            );
            $params_str = json_encode($params);
            $this->setProperty('build_url_params', $params_str);
            
            //$this->addFieldError('name', 'Build URL params:'.json_encode($params));
        }
        
        // build link: destination
        if ( $this->getProperty('use_ad_link') ) {
            // override qr link builder
            $short_link = ltrim($this->getProperty('short_link'), '/');
            if ( empty($short_link) ) {
                // @TODO check that SEO/Freindly URLs are in place
                $this->addFieldError('short_link', $this->modx->lexicon('qrbuilder.qrcode_err_empty_short_link'));
            } else if ($this->doesAlreadyExist(array('short_link' => $short_link, 'id:NOT IN' => array($this->object->get('id')) ))) {
                $this->addFieldError('short_link', $this->modx->lexicon('qrbuilder.qrcode_err_short_link_exists'));
            }
        } else {
             // build the qr link:
            // this requires SEO/Friendly URLs: @TODO make work without friendly URLs
            // @TODO make a system setting of setting in CMP to change the prefix
            $short_link = 'qr*'.base_convert($this->object->get('id'), 10, 36);
            
            $this->setProperty('short_link', $short_link);
            
        }
        // build qr_link: @TODO make work for site contexts
        $site_url = str_replace('https://', 'http://', $this->modx->getOption('site_url'));
        $url = rtrim($site_url, '/').'/'.$this->getProperty('short_link');
        // build the QR Code:
        $qr_code_path = $this->modx->qrbuilder->buildQRCode($url, 'qr-'.$this->object->get('id') );
        //$this->addFieldError('name', 'Error Check for Update->beforeSet(), Path: '.$qr_code_path);
        $this->setProperty('qr_code_path', $qr_code_path);
        
        return parent::beforeSet();
    }
    
    
    /**
     * This is ran after beforeSet() and before save() is ran
     * @return boolean
     */
    // public function beforeSave() { return !$this->hasErrors(); }

    /**
     * Override in your derivative class to do functionality after save() is run
     * @return boolean
     */
    public function afterSave() {
        
        return true;
    }
    
    
}
return 'QrcodeUpdateProcessor';