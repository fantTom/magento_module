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
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $add)
    {

        $sku = $add->getRequest()->getParam('sku');

        $hiddent = $add->getRequest()->getParam('addedfromamasty');

        if ($hiddent == 1) {
            try {
               $prod_array = (array)json_decode($this->scopeConfig->getValue('stock/general/prod'));
               foreach ($prod_array as $val){
//                   if ($val->product_sku == $sku){
//                   }

               }

                $product = $this->productRepository->get($sku);
                $add->getRequest()->setParams([
                    'product' => $product->getId(),
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
