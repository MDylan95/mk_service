@extends('back.dashboard')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-primary">Tous Les Articles</h2>

    <div class="mb-3 text-center">

        <a href="{{ route('back.articles.create') }}" class="btn btn-success fw-bold">
            ➕ Ajouter un article
        </a>
        <!-- <div class="text-muted fst-italic small">Total : {{ $articles->total() }} articles</div>  -->
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 20%;">Nom de l'Article</th>
                    <th>Description</th>
                    <th style="width: 10%;">Image</th>
                    <th style="width: 12%;">Prix (FCFA)</th>
                    <th style="width: 18%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                <tr>
                    <td class="text-center fw-semibold">{{ $article->code_article }}</td>
                    <td class="fw-semibold">{{ $article->titre }}</td>
                    <td>{{ Str::limit($article->description, 60) }}</td>
                    <td class="text-center">
                        @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}"
                            alt="Image de {{ $article->titre }}"
                            class="rounded shadow-sm"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                        <span class="text-muted fst-italic small">Aucune image</span>
                        @endif
                    </td>
                    <td class="text-center fw-semibold text-success">
                        {{ number_format($article->prix, 0, ',', ' ') }} F CFA
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('back.articles.show', $article->id) }}" class="btn btn-sm btn-info shadow-sm" title="Voir">
                                👁
                            </a>
                            <a href="{{ route('back.articles.edit', $article->id) }}" class="btn btn-sm btn-warning shadow-sm" title="Modifier">
                                ✏
                            </a>

                            <form action="{{ route('back.articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger shadow-sm"
                                    title="Supprimer"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection