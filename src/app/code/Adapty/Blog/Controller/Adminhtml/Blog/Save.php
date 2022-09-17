<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Validation\ValidationException;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Adapty\Blog\Model\BlogFactory;

class Save extends  \Magento\Backend\App\Action
{
    /**
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    protected $blogFactory;
  
    /** 
     * @var Filesystem\Directory\WriteInterface 
     */
    protected $mediaDirectory;
  
    public function __construct(
      Context $context,
      UploaderFactory $uploaderFactory,
      Filesystem $filesystem,
      BlogFactory $blogFactory
    )
    {
      parent::__construct($context);
      $this->uploaderFactory = $uploaderFactory;
      $this->blogFactory = $blogFactory;
      $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }
  
    public function execute()
    {
        try {
            if ($this->getRequest()->getMethod() !== 'POST' || !$this->_formKeyValidator->validate($this->getRequest())) {
                throw new LocalizedException(__('Invalid Request'));
            }

            $params = $this->getRequest()->getParams();
            try {
                /** @var Adapty\Blog\Model\Blog */
                $blog = $this->blogFactory->create();
                if (isset($params['id'])) {
                    $blog->load($params['id']);
                }
                $blog->setTitle($params['title']);
                $blog->setDescription($params['description']);
                $blog->setShortDescription($params['short_description']);

                if (isset($params['image'][0]['tmp_name'])) {
                    $info = $this->imageUpload($params, 'image');
                    $blog->setImageName($this->mediaDirectory->getRelativePath('blogs/images') . '/' . $info['file']);
                }
                if (isset($params['thumbnail'][0]['tmp_name'])) {
                    $info = $this->imageUpload($params, 'thumbnail');
                    $blog->setThumbnailName($this->mediaDirectory->getRelativePath('blogs/thumbnails') . '/' . $info['file']);
                }
                $blog->save();
            } catch (ValidationException $e) {
                // dd($e);
                throw new LocalizedException(__('Image extension is not supported. Only extensions allowed are jpg, jpeg and png'));
            } catch (\Throwable $e) {
                // dd($e);
                //if an except is thrown, no image has been uploaded
                throw new LocalizedException(__('Image is required'));
            }

            $this->messageManager->addSuccessMessage(__('Blog updated successfully'));

            return $this->_redirect('*/*/listing');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('*/*/new');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $this->messageManager->addErrorMessage(__('An error occurred, please try again later.'));
            return $this->_redirect('*/*/new');
        }
    }

    private function imageUpload(array $params, string $inputName)
    {
        $imageId = $inputName;
        if (isset($params[$inputName]) && count($params[$inputName])) {
            $imageId = $params[$inputName][0];
            if (!file_exists($imageId['tmp_name'])) {
                $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
            }
        }
        $fileUploader = $this->uploaderFactory->create(['fileId' => $imageId]);
        $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $fileUploader->setAllowRenameFiles(true);
        $fileUploader->setAllowCreateFolders(true);
        $fileUploader->validateFile();
        //upload image
        return $fileUploader->save($this->mediaDirectory->getAbsolutePath('blogs/'.$inputName.'s'));
    }
}
