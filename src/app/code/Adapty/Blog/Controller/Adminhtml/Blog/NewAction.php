<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Adapty\Blog\Model\Blog;
// use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

// use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    protected $resultRedirectFactory;
    /**
     * Edit A Blog Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend('Add Blog');
        $this->_view->loadLayout();
        $this->_view->renderLayout();
// dump($this->_view);
        // $this->_view->getTitle()->prepend((__('Blogs')));
        $this->_setActiveMenu('Adapty_Blog::blog_add');
        $blogDatas = $this->getRequest()->getParam('blog');
        if (is_array($blogDatas)) {
            $blog = $this->_objectManager->create(Blog::class);
            $blog->setData($blogDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/listing');
        }
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
