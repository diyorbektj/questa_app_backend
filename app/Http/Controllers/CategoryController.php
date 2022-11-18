<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->success(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return JsonResponse
     */
    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = Category::query()->create($request->validated());
        return response()->success($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::query()->firstOrFail($id)->update($request->validated());
        return response()->success($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(int $id, Category $category): JsonResponse
    {
        $category->query()->find($id)->delete();
        return response()->success([], "Category deleted!");
    }
}
