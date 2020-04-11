<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use LabelSeeder;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(LabelSeeder::class);
    }
}
