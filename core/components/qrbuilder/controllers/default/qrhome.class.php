<?php
/**
 * @package qrbuilder
 * @subpackage controllers
 */
require_once 'index.class.php';

class QrbuilderQrhomeManagerController extends QrbuilderIndexManagerController {
    /**
     * This class exists solely to provide unique Action: qrhome in the Manager -> Menus
     * As of 2.3.3 you cannot assign the different permissions to different Menu items with the same Action 
     * I unique Action must be created along with a unique Permission to grant or deny access to CMP/Extras
     * for individual CMPs
     */
}