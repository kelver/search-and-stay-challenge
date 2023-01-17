<?php

namespace App\Observers;

use App\Models\Store;
use Illuminate\Support\Str;

class StoreObserver
{
    public function creating(Store $store)
    {
        $store->uuid = (string) Str::uuid();
    }
}
