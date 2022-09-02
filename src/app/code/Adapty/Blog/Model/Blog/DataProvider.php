<?php

namespace Adapty\Blog\Model\Blog;

use Adapty\Blog\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Store\Model\Store;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManager;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    private $loadedData;

    private $storeManager;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request,
     * @param Processor $processor,
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        StoreManager $storeManager,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        // $storeId = $this->request->getParam('store', Store::DEFAULT_STORE_ID);
        /** @var Blog $blog */
        $blog = $this->collection->getFirstItem();

        $image[0] = [
            'name' => '',
            'url' => $this->getMediaUrl(). $blog->getData('image_name')
        ];
        $thumbnail[0] = [
            'name' => '',
            'url' => $this->getMediaUrl(). $blog->getData('thumbnail_name')
        ];
        $blog->setData('image', $image);
        $blog->setData('thumbnail', $thumbnail);
        $this->loadedData[$blog->getId()] = $blog->getData();
        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}
