<?php

declare(strict_types=1);

namespace App\src\model\entity;

class BookEntity
{
    private ?int $id;
    private string $title;
    private string $author;
    private ?string $isbn;
    private int $userId;

    public function __construct(
        string $title,
        string $author,
        int $userId,
        ?string $isbn = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->userId = $userId;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function withTitle(string $title): self
    {
        $new = clone $this;
        $new->title = $title;
        return $new;
    }

    public function withAuthor(string $author): self
    {
        $new = clone $this;
        $new->author = $author;
        return $new;
    }

    public function withIsbn(?string $isbn): self
    {
        $new = clone $this;
        $new->isbn = $isbn;
        return $new;
    }

    public function withUserId(int $userId): self
    {
        $new = clone $this;
        $new->userId = $userId;
        return $new;
    }
}