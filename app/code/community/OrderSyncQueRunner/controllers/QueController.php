<?php

/**
 * 
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */

class ProxiBlue_OrderSyncQueRunner_QueController extends Mage_Adminhtml_Controller_Action {

    /**
     * Initialize the controller
     * @return Object
     */
    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('sale/ordersyncquerunner');
        return $this;
    }

    /**
     * Index Action
     *
     * @return void
     */
    public function indexAction() {
        $this->_forward('report');
    }

    /**
     * Display report grid
     *
     * @return void
     */
    public function reportAction() {

        $block = $this->getLayout()->createBlock('ordersyncquerunner/adminhtml_que', 'ordersyncquerunner.adminhtml.que.grid');
        $this->_initAction()
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Sales'), Mage::helper('adminhtml')->__('Que Manage'))
                ->_addContent($block)
                ->renderLayout();
    }

}
