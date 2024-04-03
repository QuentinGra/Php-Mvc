<?php

namespace App\Models;

use DateTime;
use App\Models\Model;

class Categorie extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $title = null,
        protected ?int $enable = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
    ) {
        $this->table = 'categories';
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

    /**
     * Get the value of createdAt
     *
     * @return ?DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param null|string|DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(null|string|DateTime $createdAt): self
    {
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     *
     * @return ?DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param null|DateTime|string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(null|DateTime|string $updatedAt): self
    {
        if (is_string($updatedAt)) {
            $updatedAt = new DateTime($updatedAt);
        }
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
