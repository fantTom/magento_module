<?php

namespace Ravkovich\Feedback\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Ravkovich\Feedback\Helper\Data;

class Test extends Template
{
    public $helper;

    public function __construct(
        Context $context,
        Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }
}

?>

