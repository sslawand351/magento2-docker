<?php

namespace Adapty\Customer\Block\Blogs;

use Adapty\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Favourites extends Template
{
    private $blogRepository;
    private $searchCriteriaBuilder;
    private $storeManager;

    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
    }

    public function getBlogs()
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('id', 1, 'eq')->create();
        return $this->blogRepository->getList($searchCriteria);
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }
}
