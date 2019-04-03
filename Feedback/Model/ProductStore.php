<?php


namespace Ravkovich\Feedback\Model;


class ProductStore extends \Magento\Framework\Model\AbstractModel
{

    protected $collectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::_construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->collectionFactory = $collectionFactory;
    }


    public function getSkuField(string $skuValue)
    {
        $collection = $this->collectionFactory->create();

        $collection
            ->addAttributeToSelect('sku', 'name') // выбираем атрибуты товара
            ->addFieldToFilter('sku',['like' => $skuValue.'%'])
            ->setPageSize(6) // делаем выборку только 10 товаров
            ->setCurPage(1); //вывод первой страницы

        $arr = [];
        foreach ($collection as $product){
            $arr[$product->getSku()] = $product->getName();
        }

        return $arr;
    }
}
