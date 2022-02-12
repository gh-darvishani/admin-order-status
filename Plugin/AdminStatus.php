<?php

namespace Darvishani\AdminStatus\Plugin;

use Darvishani\AdminStatus\Helper\Data;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

class AdminStatus
{
    public $helper;

    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param CollectionFactory $subject
     * @param callable $proceed
     * @param string $requestName
     * @return Collection
     */
    public function aroundGetReport(CollectionFactory $subject, callable $proceed, $requestName): Collection
    {
        $result = $proceed($requestName);

        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof \Magento\Sales\Model\ResourceModel\Order\Grid\Collection) {
                if ($this->helper->enable()) {
                    $status = explode(',', $this->helper->getAdminStatus());

                    if ($status && is_array($status)) {
                        $result->addFieldToFilter('status', ['in' => $status]);
                    }
                }

            }
        }

        return $result;
    }
}
