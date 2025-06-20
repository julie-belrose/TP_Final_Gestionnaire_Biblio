<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Mysql\BookModel;

class BookController
{
    private BookModel $bookModel;

    public function __construct(BookModel $bookModel)
    {
        $this->bookModel = $bookModel;
    }

    public function listBooks(): array
    {
        return $this->bookModel->findAll();
    }

    public function show(int $id): ?array
    {
        return $this->bookModel->findById($id);
    }

}
