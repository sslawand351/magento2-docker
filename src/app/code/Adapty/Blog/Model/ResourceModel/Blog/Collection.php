<?php

namespace Adapty\Blog\Model\ResourceModel\Blog;

use Adapty\Blog\Model\Blog;
use Adapty\Blog\Model\ResourceModel\Blog as BlogResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(Blog::class, BlogResource::class);
    }
}
