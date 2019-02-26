<?php
use LCI\MODX\QRBuilder\QRBuilder;

/**
 * @package qrbuilder
 * @subpackage processors
 * 
 * parent class is found at: /core/modx/model/modprocessor.class.php
 */
class QrcodeCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'Qrcodes';
    public $languageTopics = array('qrbuilder:default');
    public $objectType = 'qrbuilder.qrcodes';
    
    /**
     * This is ran before things are set to the DB object also before beforeSave()
     * @return boolean
     */
    public function beforeSet() {
        $name = $this->getProperty('name');
        //$this->addFieldError('name', 'Error Check for Create->beforeSet()');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('qrbuilder.qrcode_err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('qrbuilder.qrcode_err_ae'));
        }
        
        $sdate = DateTime::createFromFormat($this->modx->getOption('manager_date_format', null, 'Y-m-d'), $this->getProperty('start_date'));
        $this->setProperty('start_date', $sdate->format('Y-m-d'));

        $edate = DateTime::createFromFormat($this->modx->getOption('manager_date_format', null, 'Y-m-d'), $this->getProperty('end_date'));
        $this->setProperty('end_date', $edate->format('Y-m-d'));

        if ( $sdate > $edate && $this->getProperty('use_end_date') ) {
            $this->addFieldError('end_date', $this->modx->lexicon('qrbuilder.qrcode_err_end_date'));
        }

        // build URL params:
        if ( $this->getProperty('override_url_input') ) {
            // override analytics tab:
            
            // @TODO check if valid JSON: 
            $this->addFieldError('name', 'Override URL input');
            
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
            $short_link = $this->getProperty('short_link');
            if ( empty($short_link) ) {
                // @TODO check that SEO/Freindly URLs are in place
                $this->addFieldError('short_link', $this->modx->lexicon('qrbuilder.qrcode_err_empty_short_link'));
            }
            
            
        }
        
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
        // build the qr link: Version 1 does not allow user to choose this option on create
        // @TODO make a system setting of setting in CMP to change the prefix
        $short_link = 'qr*'.base_convert($this->object->get('id'), 10, 36);
        $this->object->set('short_link', $short_link );

        // build qr_link:
        $site_url = str_replace('https://', 'http://', $this->modx->getOption('site_url'));

        $contextSetting = $this->modx->getObject(
            'modContextSetting',
            [
                'context_key' => $this->object->get('context_key'),
                'key' => 'site_url'
            ]
        );
        if ( $contextSetting ) {
            $site_url = $contextSetting->get('value');
        }

        $url = rtrim($site_url, '/').'/'.$short_link;
        // build the QR Code:
        $qrBuilder = new QRBuilder($this->modx);
        $qr_codes = $qrBuilder->buildQRCode($url, 'qr-'.$this->object->get('id') );
        $this->object->set('qr_png_path', $qr_codes['png']);
        $this->object->set('qr_svg_path', $qr_codes['svg']);

        $this->object->save();

        return true;
    }


}
return 'QrcodeCreateProcessor';