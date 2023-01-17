<?php

namespace App\Services;

use App\Repositories\StoreRepository;

class StoreService
{
    private StoreRepository $repository;

    public function __construct(StoreRepository $store)
    {
        $this->repository = $store;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    public function show(string $identify)
    {
        return $this->repository->show($identify);
    }

    public function update(array $data, string $identify)
    {
        return $this->repository->update($data, $identify);
    }

    public function destroy(string $identify)
    {
        return $this->repository->destroy($identify);
    }
}
