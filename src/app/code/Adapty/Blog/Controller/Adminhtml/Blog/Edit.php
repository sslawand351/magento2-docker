<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Adapty\Blog\Model\Blog;
use Adapty\Blog\Model\BlogFactory;
// use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
// use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
    private $blogFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        BlogFactory $blogFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->blogFactory = $blogFactory;
    }

    /**
     * Edit A Blog Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $blog = $this->blogFactory->create();
        if ($id) {
            $blog = $blog->load($id);
            $rowTitle = $blog->getTitle();
            if (!$blog->getId()) {
                $this->messageManager->addErrorMessage(__('Blog data no longer exist.'));
                $this->_redirect('blog/blog/listing');
                return;
            }
        }
        $this->coreRegistry->register('blog', $blog);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $id ? __('Edit Blog - ').$rowTitle : __('Add Blog');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
