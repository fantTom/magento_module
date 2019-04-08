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


    public function getSkuField($skuValue)
    {
        $collection = $this->collectionFactory->create();
        $arr = [];

        $collection
            ->addAttributeToSelect(['sku', 'name', 'qty'])// выбираем атрибуты товара
            ->addFieldToFilter('sku', ['like' => '%' . $skuValue . '%'])
            ->setPageSize(5)// делаем выборку только N товаров
            ->setCurPage(1); //вывод первой страницы

        foreach ($collection as $product) {
            $arr[$product->getSKU()] = $product->getName();
        }
        return $arr;
    }
}
