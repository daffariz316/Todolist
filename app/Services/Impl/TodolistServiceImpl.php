<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService
{
    public function editTodo(string $todoId, string $newTodo, ?string $newDeadline = null, ?string $newCatatan = null): void
    {
        $todo = Todo::find($todoId);
        if ($todo != null) {
            $todo->todo = $newTodo;
            $todo->deadline = $newDeadline;
            $todo->catatan = $newCatatan;
            $todo->save();
        }
    }
    public function saveTodo(string $id, string $todo,  ?string $deadline = null, ?string $catatan = null) : void
    {
        $todo = new Todo([
            "id" => $id,
            "todo" => $todo,
            "deadline" => $deadline,
            "catatan" => $catatan
        ]);
        $todo->save();
    }

    public function getTodolist(): array
    {
        return Todo::query()->get()->toArray();
    }

    public function getTodoById(string $id)
    {
        return Todo::find($id);
    }

    public function removeTodo(string $todoId)
    {
        $todo = Todo::query()->find($todoId);
        if($todo != null){
            $todo->delete();
        }
    }
}
