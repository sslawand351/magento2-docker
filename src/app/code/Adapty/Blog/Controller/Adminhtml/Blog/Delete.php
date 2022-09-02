<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Adapty\Blog\Model\BlogFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Delete extends Action
{
    private $blogFactory;

    public function __construct(
        Context $context,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $blog = $this->blogFactory->create();
        $blog->load($id);
        if (!$blog->getId()) {
            $this->messageManager->addErrorMessage(__('Blog data no longer exist.'));
            $this->_redirect('blog/blog/listing');
            return;
        }
        $this->deleteImages();
        $blog->delete();
        $this->messageManager->addSuccessMessage(__('Blog deleted successfully.'));
        $this->_redirect('blog/blog/listing');
        return;
    }

    private function deleteImages()
    {
        // TODO: delete blog images and thumbnails
    }
}
