<?php

declare(strict_types=1);

namespace App\src\model\mapper;

use App\src\model\dto\BookDTO;
use App\src\model\entity\BookEntity;

class BookMapper
{
    /**
     * Convert a SQL row (from the database) into a BookEntity entity.
     *
     * WHY?
     * The Entity represents the full internal object we use in the backend.
     * It's useful for processing, validation, or saving back to the database.
     *
     * WHEN TO USE IT?
     * - After fetching data from the database
     * - Before applying business logic (ex: validation, enrichment)
     *
     * @param array $row Example: ['id' => 1, 'title' => '1984', ...]
     * @return BookEntity A full backend object that reflects your DB model
     */
    public static function fromSqlRowToEntity(array $row): BookEntity
    {
        return new BookEntity(
            $row['title'],
            $row['author'],
            (int)$row['user_id'],
            $row['isbn'] ?? null,
            isset($row['id']) ? (int)$row['id'] : null
        );
    }

    /**
     * Convert a BookEntity entity into a Dto for the frontend.
     *
     * WHY?
     * The frontend (HTML or API) doesn't need to see the full backend object.
     * A Dto gives only the data needed to display — no logic, no complexity.
     *
     * WHEN TO USE IT?
     * - Before sending data to the frontend
     * - When preparing data for a JSON API or view
     *
     * @param BookEntity $book The complete backend object
     * @return BookDTO A simplified object made for the UI/API
     */
    public static function fromEntityToDTO(BookEntity $book): BookDTO
    {
        return BookDTO::fromEntity($book);
    }

    /**
     * Convert a SQL row directly into a Dto, skipping the entity.
     *
     * WHY?
     * In some cases (like simple list display), you don’t need the full entity logic.
     * Going directly to Dto saves time when you're just showing values.
     *
     * WHEN TO USE IT?
     * - For simple read-only displays (ex: table of books)
     * - When performance or simplicity is preferred over backend logic
     *
     * @param array $row Database row
     * @return BookDTO Display-ready object
     */
    public static function fromSqlRowToDTO(array $row): BookDTO
    {
        return new BookDTO(
            isset($row['id']) ? (int)$row['id'] : null,
            $row['title'],
            $row['author'],
            $row['isbn'] ?? null,
            (int)$row['user_id']
        );
    }

    /**
     * Convert an array of SQL rows into an array of DTOs.
     *
     * WHY?
     * Lists (like "my books") are often displayed with just key information.
     * We convert each database row into a lightweight object for the frontend.
     *
     * WHEN TO USE IT?
     * - On book index pages (listing all books)
     * - When sending arrays of data to JavaScript or HTML
     *
     * @param array $rows List of rows from database
     * @return BookDTO[] List of display-ready book objects
     */
    public static function fromSqlRowsToDTOArray(array $rows): array
    {
        return array_map(
            fn(array $row) => self::fromSqlRowToDTO($row),
            $rows
        );
    }
}