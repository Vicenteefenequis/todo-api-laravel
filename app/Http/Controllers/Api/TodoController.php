<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodo;
use App\Services\Todo\CreateTodoService;
use App\Services\Todo\ListTodosServices;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index(ListTodosServices $listTodosServices): JsonResponse
    {
        $output = $listTodosServices->execute();
        return response()->json($output);
    }

    public function store(StoreTodo $request, CreateTodoService $createTodoService): JsonResponse
    {
        $output = $createTodoService->execute($request->toDTO());
        return response()->json($output, 201);
    }
}
