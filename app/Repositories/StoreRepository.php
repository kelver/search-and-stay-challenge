<?php

namespace App\Repositories;

use App\Models\Store;
use Symfony\Component\HttpFoundation\Response;

class StoreRepository
{
    private Store $model;

    public function __construct(Store $store)
    {
        $this->model = $store;
    }

    public function all()
    {
        return $this->model->where('user_id', auth()->id())->get();
    }

    public function findStore(string $identify)
    {
        $store = $this->model->where([
            'user_id' => auth()->id(),
            'uuid' => $identify
        ])->first();

        if(!$store) {
            abort(Response::HTTP_NOT_FOUND, 'Store not found');
        }

        return $store;
    }

    public function store(array $data)
    {
        $data['user_id'] = auth()->id();
        return $this->model->create($data);
    }

    public function show(string $identify)
    {
        return $this->findStore($identify)->first();
    }

    public function update(array $data, string $identify)
    {
        $store = $this->findStore($identify);
        $store->update($data);
        return $store;
    }

    public function destroy(string $identify)
    {
        return $this->findStore($identify)->delete();
    }
}
