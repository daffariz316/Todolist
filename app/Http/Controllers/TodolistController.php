<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        $deadline = null; // Atur nilainya sesuai kebutuhan
        $catatan = null; // Atur nilainya sesuai kebutuhan
        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $todolist,
            "deadline" => $deadline,
            "catatan" => $catatan
        ]);
    }



    public function openAddTodo()
    {
        return response()
            ->view("todolist.addtodo");
    }

    public function addTodo(Request $request)
{
    $todo = $request->input("todo");
    $deadline = $request->input("deadline");
    $catatan = $request->input("catatan");

    if (empty($todo)) {
        $todolist = $this->todolistService->getTodolist();
        return response()->view("todolist.todolist", [
            "todolist" => $todolist,
            "deadline" => $deadline,
            "catatan" => $catatan,
            "error" => "Todo is required"
        ]);
    }

    // Validate and format the deadline
    $formattedDeadline = null;
    if (!empty($deadline)) {
        $formattedDeadline = date("Y-m-d H:i:s", strtotime($deadline));
    }

    // Save the todo item
    $this->todolistService->saveTodo(uniqid(), $todo, $formattedDeadline,$catatan);

    return redirect()->action([TodolistController::class, 'todoList']);
}


    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }


    public function editTodo(Request $request, string $todoId)
    {
        $todo = $this->todolistService->getTodo($todoId);

        if (!$todo) {
            return response()->view("todolist.todolist", [
                "title" => "Todolist",
                "todolist" => $this->todolistService->getTodolist(),
                "error" => "Todo not found"
            ]);
        }

        return response()->view("todolist.editTodo", [
            "title" => "Edit Todo",
            "todo" => $todo,
            "deadline" => $todo->deadline, // Tambahkan deadline ke dalam array
            "catatan" => $todo->catatan, // Tambahkan catatan ke dalam array
        ]);
    }



}
