<?php
$xpdo_meta_map['Gallery']= array (
  'package' => 'galleries',
  'table' => 'galleries',
  'fields' =>
  array (
    'id' => NULL,
    'name' => NULL,
    'image_folder' => NULL,
    'file_folder' => NULL,
    'allow_file_download' => 'false',
    'published' => 0,
    'datetime_created' => NULL,
    'datetime_modified' => 'CURRENT_TIMESTAMP',
  ),
  'fieldMeta' =>
  array (
    'id' =>
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'pk',
      'generated' => 'native',
    ),
    'name' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => 'NULL',
    ),
    'image_folder' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'file_folder' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
    ),
    'allow_file_download' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '1',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
    ),
    'published' =>
    array (
      'dbtype' => 'varchar',
      'precision' => '1',
      'phptype' => 'int',
      'null' => false,
      'default' => '0',
    ),
    'datetime_created' =>
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => true,
    ),
    'datetime_modified' =>
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'string',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
    ),
  ),
  'indexes' =>
  array (
    'PRIMARY' =>
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'columns' =>
      array (
        'id' =>
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
