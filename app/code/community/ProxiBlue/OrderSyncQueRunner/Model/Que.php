<?php

/**
 * Queue model
 *
 * @method int      getIncrementId()
 * @method int      getEntityId()
 * @method string   getCreatedAt()
 * @method string   getSyncedAt()
 * @method int      getIsNewOrder()
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */
class ProxiBlue_OrderSyncQueRunner_Model_Que extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
       $this->_init("ordersyncquerunner/que");
    }

    /**
     * Handle sync of data
     * Dispatches new event to effect sync
     *
     * @param ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Collection $syncModel
     */
    static public function doSync(
        ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Collection $syncModel
    ) {
        $helper = Mage::helper('ordersyncquerunner');

        if ($helper->isSyncPaused()) {
            return;
        }

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
