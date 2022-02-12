<?php

namespace Darvishani\AdminStatus\Plugin;

use Magento\User\Controller\Adminhtml\User\Save;

class AdminSave
{
    /**
     * @param Save $subject
     * @return array
     */
    public function beforeExecute(Save $subject): array
    {
        $data = $subject->getRequest()->getPostValue();

        $data['order_status'] = implode(',', $data['order_status']);

        $subject->getRequest()->setPostValue($data);

        return [];
    }
}
