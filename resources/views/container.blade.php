@extends('main')

@section('content')
<div class="container">
    <div class="container">
        <div class="page-container-wrapper">
            <div class="breadCrumbs">
                <a href="{{route('homepage')}}">Home</a>
                @foreach ($breadCrumbs as $item)
                    > <a href="{{ route('page', ['id' => $item->id]) }}">{{ $item->title }}</a>
                @endforeach
            </div>
            <h1>
                {{ $page->title }}
            </h1>
            <div class="children-dirs">
                @foreach ($childs as $item)
                    <div class="chd-item"><span class="arrow"><div>┃</div>┖━━►&nbsp;</span> <a href="{{ route('page', ['id' => $item->id]) }}">{{ $item->title }}</a><br/></div>
                @endforeach
            </div>
            
        </div>
        <div class="post-tiles">
            <?php
                $itemsPerRow = 2;
            ?>
            @for($i = 0; $i < sizeof($articles); $i += $itemsPerRow)
                <div class="row">
                    @for($j = $i; $j < $i + $itemsPerRow; $j++)
                        @if ($j < sizeof($articles))
                            <article class="article-short">
                                <img src="{{asset("public/images/".$articles[$j]->image)}}" alt="">
                                <a href="{{route('page', ['id' => $articles[$j]->id])}}">
                                    <h2>
                                        {{$articles[$j]->title}}
                                    </h2>
                                </a>
                                <p>
                                    {{$articles[$j]->short}}
                                    <span>
                                        <br/><br/>{{$articles[$j]->updated}}
                                    </span>
                                </p>
                            </article>
                        @endif
                    @endfor
                </div>
            @endfor
        </div>
    </div>
</div>

        {{-- <?php
            $other = array_slice($pages->toArray(), 1);
            $itemsPerRow = 2;
        ?>
        @for($i = 0; $i < sizeof($other); $i += $itemsPerRow)
            <div class="row">
                @for($j = $i; $j < $i + $itemsPerRow; $j++)
                    @if ($j < sizeof($other))
                        <article class="article-short">
                            <img src="{{asset("public/images/".$other[$j]->image)}}" alt="">
                            <a href="{{route('page', ['id' => $other[$j]->id])}}">
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
        @endfor --}}
@endsection