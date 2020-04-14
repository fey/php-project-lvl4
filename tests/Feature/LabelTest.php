<?php

namespace Tests\Feature;

use App\Label;
use LabelSeeder;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(LabelSeeder::class);
    }

    public function testIndex()
    {
        $label = Label::inRandomOrder()->first();
        $indexUrl = route('labels.index');
        $response = $this->get($indexUrl);
        $response
            ->assertOk()
            ->assertSee($label->name);
    }

    public function testCreate()
    {
        $label = Label::inRandomOrder()->first();
        $createUrl = route('labels.create', $label);

        $this->actingAs($this->user);

        $response = $this->get($createUrl);
        $response->assertOk();
    }

    public function testCreateByGuest()
    {
        $label = Label::inRandomOrder()->first();
        $createUrl = route('labels.create', $label);

        $response = $this->get($createUrl);
        $response->assertRedirect();
        $this->assertGuest();
    }

    public function testStore()
    {
        $indexUrl = route('labels.index');
        $storeUrl = route('labels.store');
        $name = $this->faker->word;

        $this
            ->actingAs($this->user)
            ->from($indexUrl);

        $response = $this->post($storeUrl, ['name' => $name]);
        $response->assertRedirect($indexUrl);

        $this->assertDatabaseHas('labels', ['name' => $name]);
    }

    public function testStoreByGuest()
    {
        $storeUrl = route('labels.store');
        $loginUrl = route('login');
        $name = $this->faker->word;

        $response = $this->post($storeUrl, ['name' => $name]);
        $response->assertRedirect($loginUrl);

        $this->assertGuest();
        $this->assertDatabaseMissing('labels', ['name' => $name]);
    }

    public function testUpdate()
    {
        $label = Label::inRandomOrder()->first();
        $indexUrl = route('labels.index');
        $storeUrl = route('labels.update', $label);
        $name = $this->faker->word;

        $this
            ->actingAs($this->user)
            ->from($indexUrl);

        $response = $this->patch($storeUrl, ['name' => $name]);
        $response->assertRedirect($indexUrl);

        $this->assertDatabaseHas('labels', ['name' => $name]);
    }

    public function testUpdateByGuest()
    {
        $label = Label::inRandomOrder()->first();
        $updateUrl = route('labels.update', $label);
        $loginUrl = route('login');
        $name = $this->faker->word;

        $response = $this->patch($updateUrl, ['name' => $name]);
        $response->assertRedirect($loginUrl);

        $this->assertGuest();
        $this->assertDatabaseMissing('labels', ['name' => $name]);
    }

    public function testEdit()
    {
        $label = Label::inRandomOrder()->first();
        $editUrl = route('labels.edit', $label);

        $this->actingAs($this->user);

        $response = $this->get($editUrl);
        $response
            ->assertOk()
            ->assertSee($label->name);
    }

    public function testEditByGuest()
    {
        $label = Label::inRandomOrder()->first();
        $editUrl = route('labels.edit', $label);
        $loginUrl = route('login');

        $response = $this->get($editUrl);

        $this->assertGuest();
        $response->assertRedirect($loginUrl);
    }

    public function testDelete()
    {
        $label = Label::inRandomOrder()->first();
        $deleteUrl = route('labels.destroy', $label);

        $indexUrl = route('labels.index');
        $this->actingAs($this->user)->from($indexUrl);

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($indexUrl);

        $this->assertDeleted($label);
    }

    public function testDeleteByGuest()
    {
        $label = Label::inRandomOrder()->first();
        $deleteUrl = route('labels.destroy', $label);

        $loginUrl = route('login');

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($loginUrl);

        $this->assertDatabaseHas('labels', $label->only('id', 'name'));
    }
}
