<?php

/**
 * 
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */

class ProxiBlue_OrderSyncQueRunner_Model_Observer {

    /**
     * Event to save order to que
     * 
     * @param Varien_Event_Observer $observer
     * @return ProxiBlue_OrderSyncQueRunner_Model_Observer
     */
    public function sales_order_place_after($observer) {
        
        $order = $observer->getEvent()->getOrder();
        try {
            $syncModel = mage::getModel('ordersyncquerunner/que');
            $data = array('increment_id'=>$order->getIncrementId(),
                          'entity_id'=>$order->getId(),
                          'created_at'=> now(),
                );
            $syncModel->setData($data);
            $syncModel->save();
        } catch (Exception $e) {
            mage::log('could not place order into sync que !' . $e->getMessage());
            // attempt to sync right now.
            Mage::dispatchEvent('sales_order_place_after_que', array('order'=>$order));
        }
        return $this;
    }

}