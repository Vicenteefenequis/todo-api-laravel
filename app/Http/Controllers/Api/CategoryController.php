<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PHPUnit\Exception;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = $user->categories()->get();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }


    public function store(CategoryRequest $request)
    {
        try {
            $user = Auth::user();

            $category = $user->categories()->create([
                'name' => $request->name,
                'color' => $request->color
            ]);

            return response()->json($category, 201);
        } catch (Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage()
            ]);
        }
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'color' => $request->color
        ]);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response(null, 204);
    }
}
