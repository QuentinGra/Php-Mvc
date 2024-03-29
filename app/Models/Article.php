<?php

namespace App\Models;

use App\Models\Model;

class Article extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $title = null,
        protected ?string $content = null,
        protected ?int $enable = null
    ) {
        $this->table = 'article';
    }

    /**
     * Get the value of id
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param ?int $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param ?string $title
     *
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param ?string $content
     *
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of enable
     *
     * @return ?int
     */
    public function getEnable(): ?int
    {
        return $this->enable;
    }

    /**
     * Set the value of enable
     *
     * @param ?int $enable
     *
     * @return self
     */
    public function setEnable(?int $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
