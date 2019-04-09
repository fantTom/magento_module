<?php


namespace Ravkovich\Feedback\Block\Adminhtml\Form\Field;


class StockList extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        //$this->addColumn('product_sku', ['label' => __('SKU product')]);
        $this->addColumn('stock_sku', ['label' => __('SKU for stock')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add product');
    }
}