<?php


namespace Ravkovich\Feedback\Controller;


class MyRouter implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_response;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $myUrl = $this->scopeConfig->getValue('feedback/general/frontend_url', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (strcmp($identifier,$myUrl) == false) {
            $request->setModuleName('myrouter')-> //module name
            setControllerName('index')-> //controller name
            setActionName('index'); //action name
        } else {
            return false;
        }
        return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );
    }
}