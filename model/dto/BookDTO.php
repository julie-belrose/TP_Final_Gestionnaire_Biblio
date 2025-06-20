<?php

declare(strict_types=1);

namespace App\Model\DTO;

class BookDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $author,
        public readonly ?string $isbn,
        public readonly int $userId
    ) {
    }

    public static function fromEntity(\App\Model\Entity\Book $book): self
    {
        return new self(
            $book->getId(),
            $book->getTitle(),
            $book->getAuthor(),
            $book->getIsbn(),
            $book->getUserId()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'user_id' => $this->userId
        ];
    }
}