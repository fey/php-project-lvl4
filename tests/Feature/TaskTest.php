<?php

namespace Tests\Feature;

use App\Task;
use App\TaskStatus;
use App\User;
use TaskStatusSeeder;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TaskStatusSeeder::class);

        $taskStatuses = TaskStatus::all();

        $tasks = factory(Task::class, 5)->make();

        $tasks->each(function (Task $task) use ($taskStatuses) {
            $task->status_id = $taskStatuses->random()->id;
            $task->created_by_id = $this->user->id;
            $task->save();
        });
    }

    public function testIndex()
    {
        $task = Task::inRandomOrder()->first();
        $indexUrl = route('tasks.index');
        $response = $this->get($indexUrl);
        $response
            ->assertOk()
            ->assertSee($task->name);
    }

    public function testShow()
    {
        $task = Task::inRandomOrder()->first();
        $showUrl = route('tasks.show', $task);
        $response = $this->get($showUrl);
        $response
            ->assertOk()
            ->assertSee($task->name);
    }

    public function testCreate()
    {
        $task = Task::inRandomOrder()->first();
        $createUrl = route('tasks.create', $task);

        $this->actingAs($this->user);

        $response = $this->get($createUrl);
        $response->assertOk();
    }

    public function testCreateByGuest()
    {
        $task = Task::inRandomOrder()->first();
        $createUrl = route('tasks.create', $task);

        $response = $this->get($createUrl);
        $response->assertRedirect();
        $this->assertGuest();
    }

    public function testStore()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $storeUrl = route('tasks.store');

        $this
            ->actingAs($this->user)
            ->from(route('tasks.index'));

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentences(5, true),
            'status_id' => $taskStatus->id,
        ];
        $response = $this->post($storeUrl, $data);
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', array_merge($data, ['created_by_id' => $this->user->id]));
    }

    public function testStoreByGuest()
    {
        $storeUrl = route('tasks.store');
        $loginUrl = route('login');
        $name = $this->faker->word;

        $response = $this->post($storeUrl, ['name' => $name]);
        $response->assertRedirect($loginUrl);

        $this->assertGuest();
        $this->assertDatabaseMissing('task_statuses', ['name' => $name]);
    }

    public function testUpdate()
    {
        $task = Task::inRandomOrder()->first();
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $updateUrl = route('tasks.update', $task);

        $this
            ->actingAs($this->user)
            ->from(route('tasks.index'));

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentences(5, true),
            'status_id' => $taskStatus->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->patch($updateUrl, $data);
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', array_merge([
            'id' => $task->id,
            'created_by_id' => $this->user->id,
        ], $data));
    }

    public function testUpdateByGuest()
    {
        $task = Task::inRandomOrder()->first();
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $updateUrl = route('tasks.update', $task);

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentences(5, true),
            'status_id' => $taskStatus->id,
            'assigned_to_id' => $this->user->id
        ];
        $response = $this->patch($updateUrl, $data);
        $response->assertRedirect();

        $this->assertGuest();
        $this->assertDatabaseMissing('tasks', array_merge($data, [
            'id' => $task->created_by_id,
            'status_id' => $taskStatus->id,
            'created_by_id' => $this->user->id
        ]));
    }

    public function testEdit()
    {
        $task = Task::inRandomOrder()->first();
        $editUrl = route('tasks.edit', $task);

        $this->actingAs($this->user);

        $response = $this->get($editUrl);
        $response
            ->assertOk()
            ->assertSee($task->name);
    }

    public function testEditByGuest()
    {
        $task = Task::inRandomOrder()->first();
        $editUrl = route('tasks.edit', $task);
        $loginUrl = route('login');

        $response = $this->get($editUrl);

        $this->assertGuest();
        $response->assertRedirect($loginUrl);
    }

    public function testDelete()
    {
        $task = Task::inRandomOrder()->first();
        $deleteUrl = route('tasks.destroy', $task);

        $indexUrl = route('tasks.index');
        $this->actingAs($this->user)->from($indexUrl);

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($indexUrl);

        $this->assertDeleted($task);
    }
    public function testDeleteByNotOwner()
    {
        $task = Task::inRandomOrder()->first();
        $deleteUrl = route('tasks.destroy', $task);
        $notOwner = factory(User::class)->create();

        $indexUrl = route('tasks.index');
        $this->actingAs($notOwner)->from($indexUrl);

        $response = $this->delete($deleteUrl);
        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', $task->only('id', 'name'));
    }

    public function testDeleteByGuest()
    {
        $task = Task::inRandomOrder()->first();
        $deleteUrl = route('tasks.destroy', $task);
        $loginUrl = route('login');

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($loginUrl);

        $this->assertDatabaseHas('tasks', $task->only('id', 'name'));
    }
}
