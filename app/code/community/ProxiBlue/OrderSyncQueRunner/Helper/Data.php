<?php

class ProxiBlue_OrderSyncQueRunner_Helper_Data
    extends Mage_Core_Helper_Abstract
{

    public function isSyncPaused()
    {
        $path = 'ordersyncquerunner/general/pause_order_sync';
        return (bool)Mage::getStoreConfig($path);
    }

}
