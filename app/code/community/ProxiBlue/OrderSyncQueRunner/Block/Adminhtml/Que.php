<?php

/**
 * 
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */
class ProxiBlue_OrderSyncQueRunner_Block_Adminhtml_Que extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = "adminhtml_que";
        $this->_blockGroup = "ordersyncquerunner";
        $this->_headerText = Mage::helper("ordersyncquerunner")->__("Order Sync Que Manager");
        parent::__construct();
        $this->_removeButton('add');
    }

    protected function _prepareLayout() {
        $this->setChild('grid', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_grid', $this->_controller . '.grid'));
        parent::_prepareLayout();
    }

}