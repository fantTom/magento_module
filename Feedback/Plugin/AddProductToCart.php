<?php


namespace Ravkovich\Feedback\Plugin;


use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

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

        $sku = $add->getRequest()->getParam('sku');

        $hiddent = $add->getRequest()->getParam('addedfromamasty');

        if ($hiddent == 1) {
            $product = $this->productRepository->get($sku);
            try {
                $add->getRequest()->setParams([
                    'product' => $product->getId(),
                    'qty' => $add->getRequest()->getParam('qty'),
                ]);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addExceptionMessage($exception, __('Совпадений в базе не найдено!'));
            } catch (LocalizedException $exception) {
                $this->messageManager->addExceptionMessage($exception);
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
            }
        }
    }
}
