<?php

namespace Adapty\Product\Plugin;

use Magento\Catalog\Model\Product as CatalogProduct;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Product
{
    private $categoryCollection;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->categoryCollection = $collectionFactory;
    }

    public function afterGetName(CatalogProduct $product, $result): ?string
    {

        // dump($product->getName());
        $categories = $this->getProductCategories($product);
        // dump($categories);
        return $result . ' - ' . implode($categories);
    }

    private function getProductCategories(CatalogProduct $product): array
    {
        $categoryIds = $product->getCategoryIds();
        //  dump($categoryIds);
        $categories = $this->categoryCollection->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', $categoryIds)->load();
        // dump($categories);
        $categoriesNames = [];
        foreach ($categories as $category) {
            // dump($category);
            $categoriesNames[] = $category->getName();
        }
        return $categoriesNames;
    }
}
