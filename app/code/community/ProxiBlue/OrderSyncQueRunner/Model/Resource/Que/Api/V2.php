<?php

/**
 * Class ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Api_V2
 */
class ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Api_V2 extends Mage_Api_Model_Resource_Abstract
{
    /**
     * Update Order Sync Que
     * @param array $data
     * @throws Exception
     * @return bool
     */
    public function UpdateOrdersQue($data=array())
    {
        $data = (array)$data;

        try{
            if(!empty($data['increment_id'])){
                $model = Mage::getModel('ordersyncquerunner/que')->load($data['increment_id'], 'increment_id');

                if($model->getId()){
                    foreach ($data as $k => $v){
                        if(!empty($v) || $v === 0){
                            $model->setData($k, $v);
                        }
                    }
                    $model->save();

                    return true;
                }
            }
        } catch (Exception $e) {
            $this->_apiFault($e->getMessage());
        }

        return false;
    }

    /**
     * List all new orders
     *
     * @throws Exception
     * @return array
     */
    public function listNewOrdersQue()
    {
        /* @var ProxiBlue_OrderSyncQueRunner_Model_Resource_Que_Collection $collection */
        $collection = Mage::getModel('ordersyncquerunner/que')->getResourceCollection();

        /* add is_new_order filter */
        $collection->addFieldToFilter('is_new_order', 1);

        $orderIds = array();
        try {
            /* @var ProxiBlue_OrderSyncQueRunner_Model_Que $order */
            foreach ($collection as $order) {
                $id = $order->getIncrementId();
                $orderIds[] = $order->getData();
            }
        } catch (Exception $e) {
            $this->_apiFault($e->getMessage());
        }

        return $orderIds;
    }


    protected function _apiFault($msg, $code = 'data_invalid')
    {
        Mage::log($msg, null, 'OrderSyncQueRunner_api_faults.log');
        throw new Mage_Api_Exception($code, $msg);
    }
}