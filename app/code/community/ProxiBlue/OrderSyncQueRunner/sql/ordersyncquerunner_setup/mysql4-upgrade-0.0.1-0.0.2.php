<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($this->getTable('ordersyncquerunner_que'), 'is_new_order', 'int(11) NOT NULL DEFAULT 1');
$installer->endSetup();
