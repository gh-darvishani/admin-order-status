<?php

namespace Darvishani\AdminStatus\Plugin;

use Magento\Framework\Data\Form;
use Magento\Framework\Registry;
use Magento\Sales\Model\Config\Source\Order\Status;
use Magento\User\Block\User\Edit\Tab\Main;

class AdminForm
{
    /** @var Registry */
    protected $registry;

    private $status;

    public function __construct(Status $status, Registry $registry)
    {
        $this->status = $status;
        $this->registry = $registry;
    }

    public function beforeGetFormHtml(Main $subject)
    {
        /** @var Form $form */
        $form = $subject->getForm();

        if (!is_object($form)) {
            return;
        }

        $fieldset = $form->getElement('base_fieldset');

        $orderStatus = $fieldset->addField('order_status', 'multiselect', [
            'name' => 'order_status',
            'label' => __('Order Status'),
            'title' => __('Order status'),
            'values' => $this->getOrderStatus()
        ]);

        /** @var $model \Magento\User\Model\User */
        $model = $this->registry->registry('permissions_user');

        if (!empty($model) && $model->hasData('order_status')) {
            $orderStatus->setValue(
                $model->getData('order_status')
            );
        }
    }

    private function getOrderStatus()
    {
        return $this->status->toOptionArray();
    }
}
