<?php
$xpdo_meta_map['QrcodeStats']= array (
  'package' => 'qrbuilder',
  'version' => '1.1',
  'table' => 'qrcode_stats',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'qrcode_id' => NULL,
    'date' => NULL,
    'day_hits' => NULL,
  ),
  'fieldMeta' => 
  array (
    'qrcode_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'index',
    ),
    'date' => 
    array (
      'dbtype' => 'date',
      'phptype' => 'date',
      'null' => true,
    ),
    'day_hits' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'before insert' => 
    array (
      'alias' => 'before insert',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'qrcode_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
        'date' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Qrcode' => 
    array (
      'class' => 'Qrcodes',
      'local' => 'qrcode_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
