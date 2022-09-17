<?php

namespace Adapty\InventoryImport\Controller\Adminhtml\InventorySource;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Import extends Action
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
        // echo 'Hello world'; exit;
        return $this->resultPageFactory->create();
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*//import');
    }
}
