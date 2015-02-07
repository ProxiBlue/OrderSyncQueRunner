<?php

/**
 *
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */
class ProxiBlue_OrderSyncQueRunner_Model_Que extends Mage_Core_Model_Abstract
{
    protected function _construct(){
       $this->_init("ordersyncquerunner/que");
    }

    /**
     * Handle sync of data
     * Dispatches new event to efect sync
     *
     * @param type $syncModel
     */
    static public function doSync($syncModel) {
        $helper = Mage::helper('ordersyncquerunner');
        foreach ($syncModel as $sync) {
            $order = Mage::getModel('sales/order')->load($sync->getEntityId());
            try {
                Mage::dispatchEvent(
                    'sales_order_place_after_que',
                    array('order' => $order)
                );
                $order->addStatusHistoryComment(
                    $helper->__('Order Synced')
                );
                $sync->setSyncedAt(now())->save();
            } catch (Exception $e) {
                $order->addStatusToHistory(
                    $order->getStatus(),
                    $helper->__('Order failed sync: %s', $e->getMessage()),
                    false
                );
            }
            $order->save();
        }
    }

}
