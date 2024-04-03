<?php

namespace App\Models;

use DateTime;
use App\Models\Model;
use App\Models\Categorie;

class Article extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $title = null,
        protected ?string $content = null,
        protected ?int $enable = null,
        protected ?string $slug = null,
        protected ?DateTime $createdAt = null,
        protected ?DateTime $updatedAt = null,
        protected ?int $userId = null,
        protected ?int $categorieId = null,
    ) {
        $this->table = 'article';
    }

    /**
     * Select user by userId 
     *
     * @return User - firstName and lastName
     */
    public function getAuthor(): User
    {
        $user = $this->runQuery("SELECT firstName, lastName FROM users WHERE id = :id", ['id' => $this->userId])->fetch();

        return (new User)->hydrate($user);
    }

    /**
     * Undocumented function
     *
     * @return Categorie
     */
    public function getCategorie(): ?Categorie
    {
        $categorie = $this->runQuery("SELECT title FROM categories WHERE id = :id", ['id' => $this->categorieId])->fetch();

        return $categorie ? (new Categorie)->hydrate($categorie) : null;
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

        if ($title) {
            $this->slug = self::slugify($title);
        }

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

    /**
     * Get the value of slug
     *
     * @return ?string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @param ?string $slug
     *
     * @return self
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    private static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Get the value of userId
     *
     * @return ?int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @param ?int $userId
     *
     * @return self
     */
    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of categorieId
     *
     * @return ?int
     */
    public function getCategorieId(): ?int
    {
        return $this->categorieId;
    }

    /**
     * Set the value of categorieId
     *
     * @param ?int $categorieId
     *
     * @return self
     */
    public function setCategorieId(?int $categorieId): self
    {
        $this->categorieId = $categorieId;

        return $this;
    }
}
