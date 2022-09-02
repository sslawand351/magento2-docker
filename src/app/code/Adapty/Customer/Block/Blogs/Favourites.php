<?php

namespace Adapty\Customer\Block\Blogs;

use Adapty\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Favourites extends Template
{
    private $blogRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        BlogRepositoryInterface $blogRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getBlogs()
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('id', 1, 'eq')->create();
        return $this->blogRepository->getList($searchCriteria);
    }
}
