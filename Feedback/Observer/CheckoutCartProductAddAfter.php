<?php


namespace Ravkovich\Feedback\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class CheckoutCartProductAddAfter implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
            $item = $observer->getEvent()->getData('quote_item');
            $item = ($item->getParentItem() ? $item->getParentItem() : $item);
            $price = 0.00;
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);


    }

}