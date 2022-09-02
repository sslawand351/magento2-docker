<?php

namespace Adapty\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Listing extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // echo 'Hello Blog Listing';
        $resultPage = $this->resultPageFactory->create();
        $this->_setActiveMenu('Adapty_Blog::blog_listing');
        $resultPage->getConfig()->getTitle()->prepend((__('Blogs')));
        // dump($resultPage);
        return $resultPage;
    }
}
