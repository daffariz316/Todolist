<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{

    private TodolistService $todolistService;

    protected function setUp():void
    {
        parent::setUp();

        DB::delete("delete from todos");

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "Daffarizqy");

        $todolist = $this->todolistService->getTodolist();
        foreach ($todolist as $value){
            self::assertEquals("1", $value['id']);
            self::assertEquals("Daffarizqy", $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Daffarizqy"
            ],
            [
                "id" => "2",
                "todo" => "Prastowiyono"
            ]
        ];

        $this->todolistService->saveTodo("1", "Daffarizqy");
        $this->todolistService->saveTodo("2", "Prastowiyono");

        Assert::assertArraySubset($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo("1", "Daffarizqy");
        $this->todolistService->saveTodo("2", "Prastowiyono");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
    public function editTodo(string $todoId, string $newTodo): void
    {
        $todo = $this->findTodoById($todoId);

        if (!$todo) {
            throw new \InvalidArgumentException("Todo not found");
        }

        $todo['todo'] = $newTodo;
        $this->saveTodoData($todo);
    }

    public function updateTodo(string $todoId, string $newTodo): void
    {
        $this->editTodo($todoId, $newTodo);
    }


}
