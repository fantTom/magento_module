<?php

namespace Ravkovich\Feedback\Controller\Cart;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

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
        $qty = $this->getRequest()->getParam('qty');

        if (!($sku && $qty)) {
            return $this->_redirect($this->_redirect->getRefererUrl());
        }

        try {
            $product = $this->productRepository->get($sku);

            $params = array(
                'product' => $product->getId(),//product Id
                'qty' => $qty                  //quantity of product
            );
            $this->cart->addProduct($product, $params);
            $this->cart->save();
            $this->messageManager->addSuccessMessage(__('Товар добавлен!'));
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Совпадений в базе не найдено!'));
        } catch (LocalizedException $exception) {
            $this->messageManager->addExceptionMessage($exception);
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception);
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }
}
