<?php

namespace Adapty\Customer\Controller\Blogs;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Favourites extends \Magento\Customer\Controller\AbstractAccount implements HttpGetActionInterface
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // dd('Favourite Blogs');
        return $this->resultPageFactory->create();
    }
}
