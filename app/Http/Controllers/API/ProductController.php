<?php

namespace App\Http\Controllers\API;

use App\Enums\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('auth:api');
        $this->productService = $productService;
    }

    /**
     * index
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            ['message' => __("messages.get_all_products"), 'data' => $this->productService->getAllProducts()],
            HttpResponse::SUCCESS->value
        );
    }

    /**
     * store
     *
     * @param  \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $productData = $request->validated();
            $productData['image'] = $request->file('image') ? $request->file('image')->store('products', 'public') : null;
            // Create the Product
            $isSaved = $this->productService->createProduct($productData);

            if ($isSaved) {
                return response()->json(
                    ['message' => __("messages.data_save"), 'data' => []],
                    201
                );
            }

            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                404
            );
        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error('Error saving product: ' . $e->getMessage());
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        try {
            // return single product details
            return response()->json(
                ['message' => __('messages.product_details'), 'data' => $this->productService->getProduct($id)],
                200
            );
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreProductRequest $request, $id)
    {
        try {
            $productData = $request->validated();
            // Update the product
            $isUpdated = $this->productService->updateProduct($id, $productData);

            if ($isUpdated) {
                return response()->json(
                    ['message' => __('messages.data_save'), 'data' => []],
                    HttpResponse::CREATED->value
                );
            }

            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                HttpResponse::NOT_FOUND->value
            );
        } catch (\Exception $e) {
            // Log the error if something goes wrong
            Log::error('Error updating product: ' . $e->getMessage());
            // Return a JSON response with the error
            return response()->json(
                ['message' => __('messages.data_error'), 'data' => []],
                HttpResponse::NOT_FOUND->value
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            // Delete product
            $this->productService->deleteProduct($id);
            return response()->json(
                ['message' => __('messages.product_delete'), 'data' => []],
                HttpResponse::SUCCESS->value
            );
        } catch (\Exception $e) {
            return response()->json(
                ['message' => $e->getMessage(), 'data' => []],
                HttpResponse::NOT_FOUND->value
            );
        }
    }
}