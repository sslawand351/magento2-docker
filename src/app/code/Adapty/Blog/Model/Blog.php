<?php

namespace Adapty\Blog\Model;

use Adapty\Blog\Api\Data\BlogInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\AbstractModel;

class Blog extends AbstractModel implements BlogInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel\Blog::class);
    }

    public static function create(array $data): self
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /* Create a new blog object */
        $blog = $objectManager->create(Blog::class);
        $blog->setTitle($data['title']);
        $blog->setDescription($data['description']);
        $blog->setShortDescription($data['short_description']);
        $blog->setImage($data['image_name']);
        $blog->setThumbnail($data['thumbnail_name']);
        return $blog;
    }

    /** @return int|null */
    public function getId(): ?int
    {
        return $this->_getData(self::ENTITY_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->setData(self::ENTITY_ID, $id);
        return $this;
    }

    /** @return string|null */
    public function getTitle(): ?string
    {
        return $this->_getData(self::TITLE);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    /** @return string|null */
    public function getDescription(): ?string
    {
        return $this->_getData(self::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->setData(self::DESCRIPTION, $description);
        return $this;
    }

    /** @return string|null */
    public function getShortDescription(): ?string
    {
        return $this->_getData(self::SHORT_DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setShortDescription(string $description): self
    {
        $this->setData(self::SHORT_DESCRIPTION, $description);
        return $this;
    }

    /** @return string|null */
    public function getImage(): ?string
    {
        return $this->_getData(self::IMAGE_NAME);
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->setData(self::IMAGE_NAME, $image);
        return $this;
    }

    /** @return string|null */
    public function getThumbnail(): ?string
    {
        return $this->_getData(self::THUMBNAIL_NAME);
    }

    /**
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self
    {
        $this->setData(self::THUMBNAIL_NAME, $thumbnail);
        return $this;
    }
}
