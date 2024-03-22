<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_task_store(): void
    {
        $response = $this->post('/tasks', ['name' => 'Test task name']);

        $response->assertStatus(302);
        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_task_mark_as_complete(): void
    {
        $task = Task::factory()->create();

        $uri = route('tasks.update', $task);
        $response = $this->patch($uri, ['isComplete' => true]);

        $response->assertStatus(302);
        $this->assertModelExists($task);
        $task = Task::find($task->id);
        $this->assertTrue($task->isComplete);
    }

    public function test_task_destroy(): void
    {
        $task = Task::factory()->create();

        $uri = route('tasks.destroy', $task);
        $response = $this->delete($uri);

        $response->assertStatus(302);
        $this->assertModelMissing($task);
    }
}
