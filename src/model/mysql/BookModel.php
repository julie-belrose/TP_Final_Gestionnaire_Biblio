<?php

declare(strict_types=1);

namespace App\Model\Mysql;

use PDO;
use PDOException;

class BookModel
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function findAll(): array    
    {
            try {
                $stmt = $this->db->query('SELECT * FROM books');
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
            } catch (PDOException $e) {
                error_log('Database error: ' . $e->getMessage());
                return [];
            }
    }

    public function findById(int $id): ?array    
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM books WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return null;
        }
    }   

    public function insert(Book $book): int    
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO books (title, author, isbn, user_id) VALUES (:title, :author, :isbn, :user_id)');
            $stmt->execute([
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn(),
                'user_id' => $book->getUserId()
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return 0;
        }
    }

    public function update(Book $book): int    
    {
        try {
            $stmt = $this->db->prepare('UPDATE books SET title = :title, author = :author, isbn = :isbn, user_id = :user_id WHERE id = :id');
            $stmt->execute([
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'isbn' => $book->getIsbn(),
                'user_id' => $book->getUserId()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return 0;
        }
    }

    public function delete(int $id): int    
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM books WHERE id = :id');
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return 0;
        }
    }
    
}
