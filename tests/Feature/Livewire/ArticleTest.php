<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*   public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    } */

    /** @test */

    function articles_component_renders_properly()
    {
        $this->get('/')->assertSeeLivewire('articles');
    }
}
