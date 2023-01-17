<?php

namespace App\Services;

use App\Repositories\BookStoreRepository;

class BookStoreService
{
    private BookStoreRepository $repository;

    public function __construct(BookStoreRepository $store)
    {
        $this->repository = $store;
    }

    public function index(string $identifyStore)
    {
        return $this->repository->all($identifyStore);
    }

    public function store(array $data, string $identifyStore)
    {
        return $this->repository->store($data, $identifyStore);
    }

    public function show(string $identify, string $identifyStore)
    {
        return $this->repository->show($identify, $identifyStore);
    }

    public function update(array $data, string $identify, string $identifyStore)
    {
        return $this->repository->update($data, $identify, $identifyStore);
    }

    public function destroy(string $identify, string $identifyStore)
    {
        return $this->repository->destroy($identify, $identifyStore);
    }
}
