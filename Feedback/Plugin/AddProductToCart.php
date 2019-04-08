<?php


namespace Ravkovich\Feedback\Plugin;


class AddProductToCart
{

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $add)
    {

        $product = $this->productRepository->get($add->getRequest()->getParam('sku'));
        $add->getRequest()->setParams([
            'product' => $product->getId(),
            'qty' => $add->getRequest()->getParam('qty'),
        ]);


    }
}
