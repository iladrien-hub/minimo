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
                @foreach ($subDirectories as $item)
                    @if($item->isContainer)
                        <div class="chd-item"><span class="arrow"><div>┃</div>┖━━►&nbsp;</span> <a href="{{ route('page', ['id' => $item->id]) }}">{{ $item->title }}</a><br/></div>
                    @endif
                @endforeach
            </div>

        </div>
        <div class="post-tiles">
            <?php
                $itemsPerRow = 2;
                $itemCounter = 0;
            ?>
            @while($itemCounter < sizeof($articles))
                <div class="row">
                    <?php
                        $j = 0;
                    ?>
                    @while($j < $itemsPerRow && $itemCounter < sizeof($articles))
                        @if(!$articles[$itemCounter]->isContainer)
                            <article class="article-short">
                                <img src="{{asset("public/images/".$articles[$itemCounter]->image)}}" alt="">
                                <a href="{{route('page', ['id' => $articles[$itemCounter]->id])}}">
                                    <h2>
                                        {{$articles[$itemCounter]->title}}
                                    </h2>
                                </a>
                                <p>
                                    {{$articles[$itemCounter]->short}}
                                    <span>
                                    <br/><br/>{{$articles[$itemCounter]->updated}}
                                </span>
                                </p>
                            </article>
                            <?php $j++; ?>
                        @endif
                        <?php $itemCounter++; ?>
                    @endwhile
                </div>
            @endwhile
        </div>
    </div>
</div>


@endsection
