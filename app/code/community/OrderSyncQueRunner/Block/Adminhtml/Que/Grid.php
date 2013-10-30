<?php

/**
 * Grid for que manager
 *
 * @category   ProxiBlue
 * @package    ProxiBlue_OrderSyncQueRunner
 * @author     Lucas van Staden (support@proxiblue.com.au)
 */
class ProxiBlue_OrderSyncQueRunner_Block_Adminhtml_Que_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("queGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("ordersyncquerunner/que")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn("id", array(
            "header" => Mage::helper("ordersyncquerunner")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("increment_id", array(
            "header" => Mage::helper("ordersyncquerunner")->__("Order ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "increment_id",
        ));

        $this->addColumn("entity_id", array(
            "header" => Mage::helper("ordersyncquerunner")->__("Entity ID"),
            "align" => "right",
            "width" => "50px",
            "type"  => "number",
            "index" => "entity_id",
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('customer')->__('Created at'),
            'type' => 'datetime',
            "width" => '50px',
            'align' => 'center',
            'index' => 'created_at',
            'gmtoffset' => false
        ));
        
        $this->addColumn('synced_at', array(
            'header' => Mage::helper('customer')->__('Synced at'),
            'type' => 'datetime',
            "width" => '50px',
            'align' => 'center',
            'index' => 'synced_at',
            'gmtoffset' => true
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return '#';
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}