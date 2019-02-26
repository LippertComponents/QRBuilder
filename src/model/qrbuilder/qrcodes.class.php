<?php
class Qrcodes extends xPDOSimpleObject {
    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    /**
     * Overrides xPDOObject::save to add edited/created auto-filling fields
     *
     * {@inheritDoc}
     */
    public function save($cacheFlag = null) {
        /* set createdon/editedon */
        $now = new DateTime();
        $type = $this->isNew() ? 'create' : 'edit';
        
        // @TODO need to respect system settings time offset!
        $this->set($type.'_date',$now->format('Y-m-d h:i:s'));
        if ($this->xpdo instanceof modX && $this->xpdo->user) {
            $this->set($type.'by',$this->xpdo->user->get('id'));
        }

        return parent :: save($cacheFlag);
    }
}