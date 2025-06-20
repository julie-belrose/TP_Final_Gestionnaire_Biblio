<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController
{
    public function index(): void
    {
        require __DIR__ . '/../../src/Views/book_list.php';
    }
}
