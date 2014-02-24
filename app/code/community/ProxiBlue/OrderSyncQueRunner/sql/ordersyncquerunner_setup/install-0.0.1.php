<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ordersyncquerunner_que'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('increment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => true,
        ), 'Order Increment Id')
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => true,
        ), 'Magento Order Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'unsigned'  => true,
        'nullable'  => true,
        ), 'Created')
    ->addColumn('synced_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'unsigned'  => true,
        'nullable'  => true,
        ), 'Synced') ;   
$installer->getConnection()->createTable($table);
$installer->endSetup();
	 