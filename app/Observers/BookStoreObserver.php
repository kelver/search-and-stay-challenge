<?php

namespace App\Observers;

use App\Models\BooksStore;
use Illuminate\Support\Str;

class BookStoreObserver
{
    public function creating(BooksStore $book)
    {
        $book->uuid = (string) Str::uuid();
    }
}
