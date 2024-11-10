<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Services\Category\{
    CreateCategoryService,
    ListCategoryService,
    ListCategoriesService,
    DeleteCategoryService,
    UpdateCategoryService
};
use App\Services\DTO\Category\CategoryInputDto;
use App\Services\DTO\Category\Update\CategoryUpdateInputDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{

    public function __construct(
        private readonly CreateCategoryService $createCategory,
        private readonly ListCategoriesService $listCategories,
        private readonly ListCategoryService $listCategory,
        private readonly UpdateCategoryService $updateCategory,
        private readonly DeleteCategoryService $deleteCategory
    ) {}

    public function index(): JsonResponse
    {
        $output = $this->listCategories->execute();
        return response()->json($output);
    }

    public function show($id)
    {
        $output = $this->listCategory->execute(new CategoryInputDto(id: $id));
        return response()->json($output);
    }


    public function store(CategoryRequest $request)
    {
        $output = $this->createCategory->execute($request->toDTO());

        return response()->json($output);
    }

    public function update(CategoryUpdateRequest $request, string $id)
    {
        $output = $this->updateCategory->execute(new CategoryUpdateInputDto(
            id: $id,
            name: $request->name,
            color: $request->color
        ));
        return response()->json($output);
    }

    public function destroy($id)
    {
        $output = $this->deleteCategory->execute(new CategoryInputDto(id: $id));

        return response()->json($output);
    }
}
