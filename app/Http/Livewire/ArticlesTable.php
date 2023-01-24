<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ArticlesTable extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.articles-table', [
            'articles' => \App\Models\Article::where('title', 'like', "%{$this->search}%")->latest()->get()

        ]);
    }
}
