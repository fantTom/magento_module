<?php


namespace Ravkovich\Feedback\Controller\Prod;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Autocomplete extends Action
{

    public function __construct(
        Context $context,
        \Ravkovich\Feedback\Model\ProductStore $productStore
    ) {
        parent::__construct($context);

        $this->prductStore = $productStore;
    }

    public function execute()
    {

        $this->messageManager->addSuccessMessage(__('Autocomplete!'));
        return $this->_redirect($this->_redirect->getRefererUrl());
    }
}