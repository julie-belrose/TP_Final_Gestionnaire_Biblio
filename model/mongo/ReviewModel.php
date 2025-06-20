<?php
namespace App\Model\Mongo;

use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use MongoDB\BSON\ObjectId;

class ReviewModel
{
    private Collection $collection;

    public function __construct(Database $database)
    {
        $this->collection = $database->selectCollection('reviews');
    }
    
}
