<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete("delete from todos");
    }

    public function testTodolist()
    {
        $this->seed(TodoSeeder::class);

        $this->withSession([
            "user" => "Daffarizqy"
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Daffarizqy")
            ->assertSeeText("2")
            ->assertSeeText("Prastowiyono");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Daffarizqy"
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Daffarizqy"
        ])->post("/todolist", [
            "todo" => "Prastowiyono"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "Daffarizqy",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Daffarizqy"
                ],
                [
                    "id" => "2",
                    "todo" => "Prastowiyono"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }


}
