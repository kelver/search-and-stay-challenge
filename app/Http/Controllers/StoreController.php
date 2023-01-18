<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    private StoreService $service;

    public function __construct(StoreService $storeService)
    {
        $this->service = $storeService;
    }

    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection($this->service->index());
    }

    public function store(StoreRequest $request)
    {
        $this->service->store($request->all());
        return response()->json([], Response::HTTP_CREATED);
    }

    public function show(string $identify)
    {
        return new StoreResource($this->service->show($identify));
    }

    public function update(StoreRequest $request, string $identify)
    {
        $this->service->update($request->all(), $identify);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function delete(string $identify): JsonResponse
    {
        $this->service->destroy($identify);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
