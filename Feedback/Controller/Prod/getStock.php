<?php


namespace Ravkovich\Feedback\Controller\Prod;


use Magento\Framework\Controller\ResultFactory;
use function PHPSTORM_META\elementType;

class getStock extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Ravkovich\Feedback\Model\ProductStore
     */
    protected $productStore;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Ravkovich\Feedback\Model\ProductStore $productStore,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->productStore = $productStore;
        $this->scopeConfig = $scopeConfig;
        return parent::__construct($context);
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $prod_array = json_decode($this->scopeConfig->getValue('stock/general/prod')); //product_sku)
        $stock_arr = json_decode($this->scopeConfig->getValue('stock/general/stock_free')); //stock_sku
        $arr = [];
        foreach ($prod_array as $val) {
            if ($val->product_sku == $sku){
                foreach ($stock_arr as $stock){
                    $arr+=$this->productStore->getSkuField($stock->stock_sku);
                }
            }
        }
        $resultJson->setData($arr);
        return $resultJson;
    }

}