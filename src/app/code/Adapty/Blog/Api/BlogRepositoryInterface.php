<?php

namespace Adapty\Blog\Api;

use Adapty\Blog\Api\Data\BlogInterface;
use Adapty\Blog\Model\ResourceModel\Blog\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\{
    CouldNotSaveException,
    InputException,
    NoSuchEntityException,
    StateException
};

/**
 * @api
 */
interface BlogRepositoryInterface
{
    /**
     * Create Blog
     *
     * @param \Adapty\Blog\Api\Data\BlogInterface $blog
     * @return BlogInterface
     * @throws InputException
     * @throws StateException
     * @throws CouldNotSaveException
     */
    public function save(BlogInterface $blog): BlogInterface;

    /**
     * @param int $id
     * @return \Adapty\Blog\Api\Data\BlogInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): BlogInterface;

    /**
     * Delete blog
     *
     * @param \Adapty\Blog\Api\Data\BlogInterface $blog
     * @return bool Will returned True if deleted
     * @throws StateException
     */
    public function delete(BlogInterface $blog): bool;

    /**
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool;

    /**
     * Get blog list
     *
     * @return \array[]
     */
    public function all();

    /**
     * Get blog list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
