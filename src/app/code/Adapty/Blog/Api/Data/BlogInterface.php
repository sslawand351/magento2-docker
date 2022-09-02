<?php

namespace Adapty\Blog\Api\Data;

interface BlogInterface
{
    const ENTITY_ID = 'id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const SHORT_DESCRIPTION = 'short_description';
    const IMAGE_NAME = 'image_name';
    const THUMBNAIL_NAME = 'thumbnail_name';

    /** @return int|null */
    public function getId(): ?int;

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self;

    /** @return string|null */
    public function getTitle(): ?string;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self;

    /** @return string|null */
    public function getDescription(): ?string;

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self;

    /** @return string|null */
    public function getShortDescription(): ?string;

    /**
     * @param string $description
     * @return $this
     */
    public function setShortDescription(string $description): self;

    /** @return string|null */
    public function getImage(): ?string;

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self;

    /** @return string|null */
    public function getThumbnail(): ?string;

    /**
     * @param string $thumbnail
     * @return $this
     */
    public function setThumbnail(string $thumbnail): self;
}
