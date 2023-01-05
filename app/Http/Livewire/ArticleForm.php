<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleForm extends Component
{

    public Article $article;

    protected function rules()
    {
        return [
            'article.title' => ['required', 'min:4'],

            'article.slug' => [
                'required',
                'alpha_dash',
                Rule::unique('articles', 'slug')->ignore($this->article)
            ],
            'article.content' => ['required'],
        ];
    }



    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedArticleTitle($title)
    {

        $this->article->slug = Str::slug($title);
    }


    public function save()
    {

        $this->validate();

        Auth::user()->articles()->save($this->article);

        /*  $this->article->user_id = auth()->id(); */
        /*  $this->article->save(); */

        session()->flash('status', __('Article saved.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
