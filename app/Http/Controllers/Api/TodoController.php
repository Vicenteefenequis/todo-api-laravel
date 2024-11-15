<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodo;
use App\Services\Todo\CreateTodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request) {

    }

    public function store(StoreTodo $request, CreateTodoService $createTodoService) {
        $output = $createTodoService->execute($request->toDTO());
        return response()->json($output, 201);
    }
}
