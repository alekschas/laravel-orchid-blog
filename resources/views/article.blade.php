@extends('layouts.base')

@section('content')

@unless (empty($article))

<div class="article_card">
    <h3> @if (! Auth::guest() && isAdmin())
        [ID={{ $article->id }}]
        @endif

        {{ $article->title }}</h3>

    <div class="publication_date">{{ $article->published_at }}</div>

    {{-- @if (! Auth::guest() && isAdmin()) --}}
    {{-- <button class="tag">
        <a href="{{ route('articleEdit',['id'=>$article->id]) }}">
    {{ __('Редактировать') }}
    </a>
    </button> --}}
    {{-- @endif --}}

    <p>{!! $article->content_html !!}</p>
</div>
<br />

@include('includes/comments_list')

<hr>

@include('includes/comments_form')

@endunless

@push('scripts')
<script type="text/javascript">
</script>
@endpush

@endsection
