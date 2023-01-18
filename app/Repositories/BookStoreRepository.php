<?php

namespace App\Repositories;

use App\Models\BooksStore;
use App\Models\Store;
use Symfony\Component\HttpFoundation\Response;

class BookStoreRepository
{
    private BooksStore $model;

    public function __construct(BooksStore $bookStore)
    {
        $this->model = $bookStore;
    }

    protected function findIdStoreByUuid(string $identifyStore): int
    {
        $store = Store::where(['user_id' => auth()->id(), 'uuid' => $identifyStore])->first();

        if(!$store) {
            abort(Response::HTTP_NOT_FOUND, 'Store not found');
        }

        return $store->id;
    }

    public function all(string $identifyStore)
    {
        return $this->model->where([
            'store_id' => $this->findIdStoreByUuid($identifyStore)
        ])->get();
    }

    public function findBookInStore(string $identify, string $identifyStore)
    {
        $book = $this->model->where([
            'user_id' => auth()->id(),
            'uuid' => $identify,
            'store_id' => $this->findIdStoreByUuid($identifyStore)
        ])->first();

        if(!$book) {
            abort(Response::HTTP_NOT_FOUND, 'Book not found');
        }

        return $book;
    }

    public function store(array $data, string $identifyStore)
    {
        $data['user_id'] = auth()->id();
        $data['store_id'] = $this->findIdStoreByUuid($identifyStore);
        return $this->model->create($data);
    }

    public function show(string $identify, string $identifyStore)
    {
        return $this->findBookInStore($identify, $identifyStore)->first();
    }

    public function update(array $data, string $identify, string $identifyStore)
    {
        $store = $this->findBookInStore($identify, $identifyStore);
        $store->update($data);
        return $store;
    }

    public function destroy(string $identify, string $identifyStore)
    {
        return $this->findBookInStore($identify, $identifyStore)->delete();
    }
}
