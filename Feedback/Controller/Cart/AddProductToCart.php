<?php

namespace Ravkovich\Feedback\Controller\Cart;

use Magento\Framework\App\Action\Context;

class AddProductToCart extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private $cart;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;


    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
    }

    public function execute()
    {

        $sku = $this->getRequest()->getParam('sku');
        $qty = 1;


        try {

            // $this->_eventManager->dispatch('update_price_for_my_controller',['product' => $product->getId()]);
            $product = $this->productRepository->get($sku);

            $params = array(
                'product' => $product->getId(), //product Id
                'price'=> 0.00,
                'qty' => $qty                     //quantity of product
            );
            $product->setPrice(0.00);
            $this->cart->addProduct($product, $params);

            $this->cart->save();
//            $quote= $this->cart->getQuote();
//            $items = $quote->getItems();
//            foreach ($items as $item) {
//                $item['sku'];
//                $item->sku ;
//               if ($item['sku'] == $sku){
//                    $item->setCustomPrice(0.00);
//                    $item->setOriginalCustomPrice(0.00);
//                    $item->getProduct()->setIsSuperMode(true);
//                }
//
//            }
//
//            $item = $quote->getItem($sku);
//            $item->setCustomPrice(0.00);
//            $item->setOriginalCustomPrice(0.00);
//            $item->getProduct()->setIsSuperMode(true);


            $this->messageManager->addSuccessMessage(__('Товар добавлен!'));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception);
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }

}
