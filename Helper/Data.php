<?php

namespace Darvishani\AdminStatus\Helper;

use Magento\Backend\App\ConfigInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    const XML_BASE_PATH = "sales/admin_status/";

    private $_authSession;

    private $_config;

    public function __construct(
        Session $authSession,
        Context $context,
        ConfigInterface $config
    )
    {
        parent::__construct($context);

        $this->_authSession = $authSession;
        $this->_config = $config;
    }

    private function getConfig($flag)
    {
        return $this->_config->getValue(self::XML_BASE_PATH . $flag);
    }

    public function getAdminStatus()
    {
        return $this->_authSession->getUser()->getData('order_status');
    }

    public function enable()
    {
        return $this->getConfig('enable');
    }
}
