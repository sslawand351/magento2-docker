<?php

namespace Adapty\Blog\Block\Adminhtml\Blog\Edit;

use Magento\Search\Controller\RegistryConstants;

class GenericButton
{
    /** @var \Magento\Framework\UrlInterface */
    protected $urlBuilder;
    protected $registry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    public function getId(): ?int
    {
        $blog = $this->registry->registry('blog');
        return $blog ? $blog->getId() : null;
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
