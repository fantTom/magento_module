<?php


namespace Ravkovich\Feedback\Model\Quote;


class Discount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\SalesRule\Model\Validator
     */
    protected $calculator;
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager = null;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\SalesRule\Model\Validator $validator
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\SalesRule\Model\Validator $validator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->eventManager = $eventManager;
        $this->calculator = $validator;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        $appliedCartDiscount = $total->getDiscountAmount();
        $discount = - $this->getDiscouts($total);
        $total->setDiscountAmount($discount+$appliedCartDiscount);
        $total->addTotalAmount('testdiscount', $discount);
        return $this;
    }


    public function getDiscouts($total)
    {
        $disc = (array)json_decode($this->scopeConfig->getValue('discounts/general/disct'));
        $disc_arr = [];
        foreach ($disc as $key) {
            $disc_arr[$key->amount_for_discounts] = $key->discounts_amount;
        }
        krsort($disc_arr);
        $summ = $total->getSubtotal();
        foreach ($disc_arr as $summTotal => $discount) {
            if ($summTotal <= $summ) {
                return ($summ * $discount) / 100;
            }
        }
        return 0;
    }
}
