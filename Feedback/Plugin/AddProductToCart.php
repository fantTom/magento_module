<?php


namespace Ravkovich\Feedback\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;


class AddProductToCart
{

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $add)
    {

        $sku = $add->getRequest()->getParam('sku');

        $hiddent = $add->getRequest()->getParam('addedfromamasty');

        if ($hiddent == 1) {
            try {
                $product = $this->productRepository->get($sku);
                $add->getRequest()->setParams([
                    'product' => $product->getId(),
                    'price' => 0.00,
                    'qty' => $add->getRequest()->getParam('qty'),
                ]);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addExceptionMessage($exception, __('Совпадений в базе не найдено!'));

            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
            }
        }
    }
}
