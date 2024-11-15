<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodo;
use App\Services\DTO\Todo\TodoInputDto;
use App\Services\Todo\CreateTodoService;
use App\Services\Todo\DeleteTodoService;
use App\Services\Todo\ListTodoService;
use App\Services\Todo\ListTodosService;
use Illuminate\Http\JsonResponse;

class TodoController extends Controller
{
    public function index(ListTodosService $listTodosServices): JsonResponse
    {
        $output = $listTodosServices->execute();
        return response()->json($output);
    }

    public function show(string $id, ListTodoService $listTodoService)
    {
        $output = $listTodoService->execute(new TodoInputDto(id: $id));
        return response()->json($output);
    }

    public function store(StoreTodo $request, CreateTodoService $createTodoService): JsonResponse
    {
        $output = $createTodoService->execute($request->toDTO());
        return response()->json($output, 201);
    }

    public function destroy(string $id, DeleteTodoService $deleteTodoService)
    {
        $output = $deleteTodoService->execute(new TodoInputDto(id: $id));
        return response()->json($output);
    }
}