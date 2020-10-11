@extends('main')

@section('content')
<div class="container-wide">
    <div class="first-post-image-wrapper"><img src="{{asset("public/images/".$post->image)}}" alt="" class="firstPost-image"></div>
</div>
<div class="container">
    <article class="article-short">
        <a href="#">
            <h3>
                {{$post->category_name}}
            </h3>
        </a>
        <h2>
            {{$post->title}}
        </h2>
        <div class="post-content">
            {!! $post->content !!}
        </div>
    </article>
</div>
@endsection