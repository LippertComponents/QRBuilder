<?php
$xpdo_meta_map['Qrcodes']= array (
  'package' => 'qrbuilder',
  'version' => '1.1',
  'table' => 'qrcodes',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'type' => 'qrcode',
    'name' => NULL,
    'description' => NULL,
    'destination_url' => NULL,
    'hits' => 0,
    'override_url_input' => 0,
    'build_url_params' => NULL,
    'short_link' => NULL,
    'use_ad_link' => 0,
    'redirect_type' => '301',
    'qr_code_path' => NULL,
    'active' => 1,
    'start_date' => '2015-02-01',
    'use_end_date' => 1,
    'end_date' => NULL,
    'create_date' => NULL,
    'edit_date' => NULL,
  ),
  'fieldMeta' => 
  array (
    'type' => 
    array (
      'dbtype' => 'set',
      'precision' => '\'qrcode\',\'webad\'',
      'phptype' => 'string',
      'null' => true,
      'default' => 'qrcode',
    ),
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'description' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'string',
      'null' => true,
    ),
    'destination_url' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'hits' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'override_url_input' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'build_url_params' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'short_link' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'use_ad_link' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'redirect_type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '4',
      'phptype' => 'string',
      'null' => true,
      'default' => '301',
    ),
    'qr_code_path' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 1,
    ),
    'start_date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
      'default' => '2015-02-01',
    ),
    'use_end_date' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => true,
      'default' => 1,
    ),
    'end_date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'create_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
    'edit_date' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'URL Query' => 
    array (
      'alias' => 'URL Query',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'short_link' => 
        array (
          'length' => '10',
          'collation' => 'A',
          'null' => true,
        ),
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Stats' => 
    array (
      'class' => 'QrcodeStats',
      'local' => 'id',
      'foreign' => 'qrcode_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
