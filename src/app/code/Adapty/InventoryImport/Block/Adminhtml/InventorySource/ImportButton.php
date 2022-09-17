<?php

namespace Adapty\InventoryImport\Block\Adminhtml\InventorySource;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ImportButton implements ButtonProviderInterface
{
    /** @var \Magento\Framework\UrlInterface */
    protected $urlBuilder;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Import'),
            'class' => 'save primary',
            // 'data_attribute' => [
            //     'mage-init' => ['button' => ['event' => 'save']],
            //     'form-role' => 'import',
            // ],
            'sort_order' => 90,
        ];
    }

    public function getSaveUrl(): string
    {
        return $this->urlBuilder->getUrl('*/*/import');
    }
}