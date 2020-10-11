@extends('main')

@section('content')

@if(sizeof($pages) > 0)
<div class="first-post">
    <div class="container-wide">
        <div class="first-post-image-wrapper"><img src="{{asset("public/images/".$pages[0]->image)}}" alt="" class="firstPost-image"></div>
    </div>
    <div class="container">
        <article class="article-short">
            <a href="{{$pages[0]->category}}">
                <h3>
                    {{$pages[0]->category_name}}
                </h3>
            </a>
            <a href="{{route('post', ['id' => $pages[0]->id])}}">
                <h2>
                    {{$pages[0]->title}}
                </h2>
            </a>
            <p>
                {{$pages[0]->short}}<br/><br/>
                {{$pages[0]->created}}
            </p>
            <a href="{{route('post', ['id' => $pages[0]->id])}}" class="more">Leave a comment</a>
        </article>
    </div>
</div>
<div class="container">
    <div class="post-tiles">
        <?php
            $other = array_slice($pages->getArrayCopy(), 1);
            $itemsPerRow = 2;
        ?>
        @for($i = 0; $i < sizeof($other); $i += $itemsPerRow)
            <div class="row">
                @for($j = $i; $j < $i + $itemsPerRow; $j++)
                    @if ($j < sizeof($other))
                        <article class="article-short">
                            <img src="{{asset("public/images/".$other[$j]->image)}}" alt="">
                            <a href="#">
                                <h3>
                                    {{$other[$j]->category_name}}
                                </h3>
                            </a>
                            <a href="{{route('post', ['id' => $other[$j]->id])}}">
                                <h2>
                                    {{$other[$j]->title}}
                                </h2>
                            </a>
                            <p>
                                {{$other[$j]->short}}
                            </p>
                        </article>
                    @endif
                @endfor
            </div>
        @endfor
    </div>
</div>
<div class="load-more-button">
    <a href="#">Load More</a>
</div>
@endif

<div class="subscribe">
    <h2>
        Sign up for our newsletter!
    </h2>
    <div class="email-field">
        <input type="text" placeholder="Enter a valid email address">
        <a href="#"><i class="fas fa-check"></i></a>
    </div>
</div>
@endsection