<?php

namespace App\Services;

interface TodolistService
{

    public function saveTodo(string $id, string $todo,?string $deadline = null, ?string $catatan = null): void;

    public function getTodolist(): array;

    public function removeTodo(string $todoId);

    public function editTodo(string $todoId, string $newTodo, ?string $newDeadline = null, ?string $newCatatan = null);
}
