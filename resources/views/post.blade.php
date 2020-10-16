@extends('main')

@section('content')
<div class="container-wide">
    <div class="first-post-image-wrapper"><img src="{{asset("public/images/".$post->image)}}" alt="" class="firstPost-image"></div>
</div>
<div class="container">
    <article class="article-short">
        <h3>
            <div class="breadCrumbs">
                <a href="{{route('homepage')}}">Home</a>
                @foreach ($breadCrumbs as $crumb)
                > <a href="{{route('page', ['id' => $crumb->id])}}">{{ $crumb->title }}</a> 
                @endforeach
            </div>
        </h3>
        <h2>
            {{$post->title}}
        </h2>
        <div class="post-content">
            {!! $post->content !!}
        </div>
    </article>
</div>
@endsection