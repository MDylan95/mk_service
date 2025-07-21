@extends('back.dashboard')

@section('content')

<form action="{{ route('articles.update', $article->id) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- form fields -->
</form>
@endsection