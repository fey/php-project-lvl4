<?php

namespace Tests\Feature;

use App\TaskStatus;
use TaskStatusSeeder;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TaskStatusSeeder::class);
    }

    public function testIndex()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $indexUrl = route('task_statuses.index');
        $response = $this->get($indexUrl);
        $response
            ->assertOk()
            ->assertSee($taskStatus->name);
    }

    public function testCreate()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $createUrl = route('task_statuses.create', $taskStatus);

        $this->actingAs($this->user);

        $response = $this->get($createUrl);
        $response->assertOk();
    }

    public function testStore()
    {
        $indexUrl = route('task_statuses.index');
        $storeUrl = route('task_statuses.store');
        $name = $this->faker->word;

        $this
            ->actingAs($this->user)
            ->from($indexUrl);

        $response = $this->post($storeUrl, ['name' => $name]);
        $response->assertRedirect($indexUrl);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('task_statuses', ['name' => $name]);
    }

    public function testUpdate()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $indexUrl = route('task_statuses.index');
        $storeUrl = route('task_statuses.update', $taskStatus);
        $name = $this->faker->word;

        $this
            ->actingAs($this->user)
            ->from($indexUrl);

        $response = $this->patch($storeUrl, ['name' => $name]);
        $response->assertRedirect($indexUrl);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('task_statuses', ['name' => $name]);
    }

    public function testEdit()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $editUrl = route('task_statuses.edit', $taskStatus);

        $this->actingAs($this->user);

        $response = $this->get($editUrl);
        $response
            ->assertOk()
            ->assertSee($taskStatus->name);
    }

    public function testDelete()
    {
        $taskStatus = TaskStatus::inRandomOrder()->first();
        $deleteUrl = route('task_statuses.destroy', $taskStatus);

        $indexUrl = route('task_statuses.index');
        $this->actingAs($this->user)->from($indexUrl);

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($indexUrl);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDeleted($taskStatus);
    }
}
