<?php

/**
 * Cron functions
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */
class ProxiBlue_OrderSyncQueRunner_Model_Cron {

    /**
     * Sync via cron schedule
     *
     * @param object $schedule
     * @return mixed
     */
    public static function sync($schedule) {
        try {
            $syncModel = mage::getModel('ordersyncquerunner/que')->getCollection()
                    ->addFieldToFilter('synced_at', array('null' => true));
            ProxiBlue_OrderSyncQueRunner_Model_Que::doSync($syncModel);
            return $this;
        } catch (Dhmedia_Exception $e) {
            // save an errors.
            mage::logException($e);
            return $e->getMessage();
        }
    }

    /**
     * Clean old records on schedule
     *
     * @param object $schedule
     * @return mixed
     */
    public static function clean($schedule) {
        try {
          $syncModel = mage::getModel('ordersyncquerunner/que')->getCollection()
                    ->addFieldToFilter('created_at', array('lteq' => $schedule->getExecutedAt()))
                    ->addFieldToFilter('synced_at', array('notnull' => true));
           foreach ($syncModel as $key => $sync) {
               $sync->delete();
           }
           return $this;
        } catch (Dhmedia_Exception $e) {
            // save an errors.
            mage::logException($e);
            return $e->getMessage();
        }
    }



}
