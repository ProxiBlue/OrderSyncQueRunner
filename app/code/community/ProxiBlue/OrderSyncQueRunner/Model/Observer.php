<?php

/**
 *
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */

class ProxiBlue_OrderSyncQueRunner_Model_Observer
{

    /**
     * Event to save order to que
     *
     * @param Varien_Event_Observer $observer
     * @return ProxiBlue_OrderSyncQueRunner_Model_Observer
     */
    public function sales_order_place_after(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        try {
            $syncModel = Mage::getModel('ordersyncquerunner/que');
            $data = array(
                'increment_id'=>$order->getIncrementId(),
                'entity_id'=>$order->getId(),
                'created_at'=> now(),
            );
            $syncModel->setData($data);
            $syncModel->save();
        } catch (Exception $e) {
            Mage::log("Couldn't place order into sync queue! " . $e->getMessage());

            // Attempt to sync right now if sync isn't paused
            if (!Mage::helper('ordersyncquerunner')->isSyncPaused()) {
                Mage::dispatchEvent(
                    'sales_order_place_after_que',
                    array('order' => $order)
                );
            }

        }
        return $this;
    }

}
