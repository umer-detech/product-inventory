<?php

namespace App\Http\Controllers\API;

use App\Enums\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreTranslationRequest;
use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    public function __construct(private TranslationService $service)
    {
        $this->middleware('auth:api');
    }

    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $translations = $this->service->search($request->only(['locale', 'key', 'tag', 'per_page']));
        return response()->json($translations);
    }

    /**
     * store
     *
     * @param  \App\Http\Requests\StoreTranslationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTranslationRequest $request)
    {
        try {

            $translation = $this->service->store($request->validated());
            return response()->json($translation->load('tags'), 201);

        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error('Error saving: ' . $e->getMessage());
            // Return a JSON response with the error
            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                404
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Translation $translation)
    {
        try {
            return response()->json($translation->load('tags'));
        } catch (\Exception $e) {
            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreTranslationRequest $request, Translation $translation)
    {
        try {
            $updated = $this->service->update($translation, $request->validated());

            return response()->json($updated->load('tags'));
        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error('Error updating: ' . $e->getMessage());
            // Return a JSON response with the error
            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                404
            );
        }
    }

    /**
     * export
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function export()
    {
        return response()->json($this->service->export());
    }
}