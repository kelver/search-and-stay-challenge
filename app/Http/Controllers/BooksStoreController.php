<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\BookStoreRequest;
    use App\Http\Resources\BookStoreResource;
    use App\Services\BookStoreService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Symfony\Component\HttpFoundation\Response;

    class BooksStoreController extends Controller
    {
        private BookStoreService $service;

        public function __construct(BookStoreService $storeService)
        {
            $this->service = $storeService;
        }

        public function index(string $identifyStore): AnonymousResourceCollection
        {
            return BookStoreResource::collection($this->service->index($identifyStore));
        }

        public function store(BookStoreRequest $request, string $identifyStore): JsonResponse
        {
            $this->service->store($request->all(), $identifyStore);
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        public function show(string $identifyStore, string $identify): BookStoreResource
        {
            return new BookStoreResource($this->service->show($identify, $identifyStore));
        }

        public function update(BookStoreRequest $request, string $identifyStore, string $identify): JsonResponse
        {
            $this->service->update($request->all(), $identify, $identifyStore);
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        public function destroy(string $identifyStore, string $identify): JsonResponse
        {
            $this->service->destroy($identify, $identifyStore);
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
    }
