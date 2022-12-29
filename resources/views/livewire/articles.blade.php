<div>
    <h1>Listado de artículos</h1>
    <a href="{{ route('articles.create') }}">Crear</a>
    <input wire:model="search" type="search" placeholder="Buscar...">

    <ul>
        @foreach ($articles as $article)
            <li>
                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                <a href="{{ route('articles.edit', $article) }}">Editar</a>

            </li>
        @endforeach
    </ul>
</div>
