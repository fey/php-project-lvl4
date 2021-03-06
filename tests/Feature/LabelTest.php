<?php

namespace Tests\Feature;

use App\Label;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
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
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('labels', ['name' => $name]);
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
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('labels', ['name' => $name]);
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

    public function testDelete()
    {
        $label = Label::inRandomOrder()->first();
        $deleteUrl = route('labels.destroy', $label);

        $indexUrl = route('labels.index');
        $this->actingAs($this->user)->from($indexUrl);

        $response = $this->delete($deleteUrl);
        $response->assertRedirect($indexUrl);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDeleted($label);
    }
}
