<?php

namespace Adapty\Blog\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';
    protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }
        $fieldName = $this->getData('name');
        $path = $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        // dd($fieldName);
        foreach ($dataSource['data']['items'] as & $item) {       
            // dd($path.$item['image_name']);        
            $item[$fieldName . '_src'] = $path.$item['image_name'];
            $item[$fieldName . '_alt'] = $item['title'];
            $item[$fieldName . '_orig_src'] = $path.$item['image_name'];
        }

        return $dataSource;
    }
}
