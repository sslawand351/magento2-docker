<?php

namespace Adapty\Blog\Model;

use Adapty\Blog\Api\BlogRepositoryInterface;
use Adapty\Blog\Api\Data\BlogInterface;
use Adapty\Blog\Model\ResourceModel\Blog\{Collection, CollectionFactory};
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Throwable;

class BlogRepository implements BlogRepositoryInterface
{
    private $blogFactory;
    private $blogCollection;

    public function __construct(
        BlogFactory $blogFactory,
        CollectionFactory $blogCollectionFactory
    )
    {
        $this->blogFactory = $blogFactory;
        $this->blogCollection = $blogCollectionFactory;
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

    /** @inheritDoc */
    public function all()
    {
        $blogCollection = $this->blogCollection->create();
        $blogs = $blogCollection->load();

        return [$blogs->toArray()];
        // foreach ($blogs as $blog) {

        // }
        return [
            'status' => 'success',
            'message' => 'Blogs fetched successfully',
            'blogs' => array_map(function ($blog) {
                return $blog->toArray();
            }, $blogs->getItems())
        ];
        // dd($blogs->getItems());
        // return $blogs->map();
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $blogCollection = $this->blogCollection->create();
        $blogs = $blogCollection->load();
        return $blogs;
    }
}
