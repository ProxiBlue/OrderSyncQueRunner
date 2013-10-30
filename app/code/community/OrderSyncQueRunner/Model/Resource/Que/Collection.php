<?php

/**
 * 
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */

class ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        $this->_init("ordersyncquerunner/que");
    }

}

