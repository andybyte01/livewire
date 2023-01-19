<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleForm extends Component
{

    use WithFileUploads;
    public Article $article;

    public $image;


    protected function rules()
    {
        return [

            'image' => [
                Rule::requiredIf(!$this->article->image),
                Rule::when($this->image, [
                    'image',
                    'max:2048'
                ])



            ],
            'article.title' => ['required', 'min:4'],

            'article.slug' => [
                'required',
                'alpha_dash',
                Rule::unique('articles', 'slug')->ignore($this->article)
            ],
            'article.content' => ['required'],
        ];
    }


    protected function uploadImage()
    {
        if ($oldImage = $this->article->image) {
            Storage::disk('public')->delete($oldImage);
        }

        return $this->image->store('/', 'public');
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

        if ($this->image) {

            $this->article->image = $this->uploadImage();
        }

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
