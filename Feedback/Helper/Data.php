<?php

namespace Ravkovich\Feedback\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getModel($modelName)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Ravkovich\Feedback\Model\\' . ucfirst($modelName));
        return $model;
    }
}

?>
