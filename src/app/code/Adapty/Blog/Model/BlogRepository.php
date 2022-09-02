<?php

namespace Adapty\Blog\Model;

use Adapty\Blog\Api\BlogRepositoryInterface;
use Adapty\Blog\Api\Data\BlogInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Throwable;

class BlogRepository implements BlogRepositoryInterface
{
    private $blogFactory;

    public function __construct(BlogFactory $blogFactory)
    {
        $this->blogFactory = $blogFactory;
    }

    public function save(BlogInterface $blog): BlogInterface
    {
        // TODO: Save blog
        try {
            $blog->save();
        } catch (Throwable $e) {
            // TODO: log exception
        }
        return $blog;
    }

    public function getById(int $id): BlogInterface
    {
        $blog = $this->blogFactory->create();
        $blog->load($id);
        if (!$blog->getId()) {
            throw new NoSuchEntityException(
                __("The blog that was requested doesn't exist. Verify the blog and try again.")
            );
        }
        return $blog;
    }

    public function delete(BlogInterface $blog): bool
    {
        return true;
    }

    public function deleteById(int $id): bool
    {
        return true;
    }

    public function all(): array
    {
        return [];
    }

    public function getList(SearchCriteriaInterface $searchCriteria): array
    {
        return [];
    }
}
