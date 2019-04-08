<?php


namespace Ravkovich\Feedback\Controller\Prod;

use Magento\Framework\Controller\ResultFactory;

class Autocomplete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Ravkovich\Feedback\Model\ProductStore
     */
    protected $productStore;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Ravkovich\Feedback\Model\ProductStore $productStore
    ) {
        $this->productStore = $productStore;
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($this->productStore->getSkuField($this->getRequest()->getParam('sku')));
        return $resultJson;
    }

}