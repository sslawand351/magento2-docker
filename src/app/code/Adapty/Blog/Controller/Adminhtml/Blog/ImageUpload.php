<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
// use Monolog\Logger;
use Psr\Log\LoggerInterface;

class ImageUpload extends \Magento\Backend\App\Action
{
    /**
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /** 
     * @var Filesystem\Directory\WriteInterface 
     */
    protected $mediaDirectory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    private $logger;

    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    public function execute()
    {
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        $params = $this->getRequest()->getParams();
        $tmpDir = $params['param_name'] == 'image' ? 'images': 'thumbnails';
        try {
            $fileUploader = $this->validateImage($params['param_name']);
            $result = $this->saveImage($fileUploader, $tmpDir);
            return $jsonResult->setData($result);
        } catch (LocalizedException $e) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            // error_log($e->getMessage());
            // error_log($e->getTraceAsString());
            return $jsonResult->setData(['errorcode' => 0, 'error' => __('An error occurred, please try again later.')]);
        }
    }

    private function validateImage(string $fileId)
    {
        $fileUploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $fileUploader->setAllowRenameFiles(true);
        $fileUploader->setAllowCreateFolders(true);
        $fileUploader->setFilesDispersion(false);
        $fileUploader->validateFile();
        return $fileUploader;
    }

    private function saveImage($fileUploader, string $path)
    {
        $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath('tmp/blogs/'. $path));
        $result['url'] = $this->getMediaUrl() . 'tmp/blogs/'. $path .'/'.
            $this->getImageName($result['file']);
        return $result;
    }

    private function getImageName(string $file): string
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }

    private function getMediaUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}
