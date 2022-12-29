<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /* public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    } */

    /** @test */

    public function can_create_new_articles()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New article')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'));


        $this->assertDatabaseHas('articles', [
            'title' => 'New article',
            'content' => 'Article content'

        ]);
    }
    /** @test */

    public function title_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'required']);
    }

    /** @test */
    public function title_must_be_4_characters_min()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min']);
    }

    /** @test */
    public function content_is_required()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New article')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required']);
    }

    /** @test */
    public function real_time_validation_works_for_title()
    {
        Livewire::test('article-form')
            ->set('article.title', '')
            ->assertHasErrors(['article.title' => 'required'])
            ->set('article.title', 'New')
            ->assertHasErrors(['article.title' => 'min'])
            ->set('article.title', 'New article')
            ->assertHasNoErrors('article.title');
    }
    /** @test */
    public function real_time_validation_works_for_content()
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->assertHasErrors(['article.content' => 'required'])

            ->set('article.content', 'Article content')
            ->assertHasNoErrors('article.title');
    }
}
