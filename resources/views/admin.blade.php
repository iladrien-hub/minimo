@extends('main')

@section('content')
<div class="modal inactive">
    <div class="modal-window">
        <div class="modal-head">
            <div class="name">Creation of a category</div>
            <i class="modal-close fas fa-times"></i>
        </div>
        <div class="modal-content">
            <div class="category-creation">
                <div style="color: red; padding-bottom: 10px;" class="category-creation-error inactive">
                    <i style="color: red;" class="fas fa-exclamation-circle"></i> Such an id already exists
                </div>
                <form class="category-creation-form">
                    @csrf
                    <input type="hidden" name="allowUpdate" value="0">
                    <input type="hidden" name="parent" value="{{$dir}}">
                    <div class="minimo-text-input">
                        <input required type="text" name="id">
                        <span>id</span>
                    </div>
                    <div class="minimo-text-input">
                        <input required type="text" name="title">
                        <span>Title</span>
                    </div>
                    <select name="sortOrder" class="minimo-select" required>
                        <option value="" disabled selected>Select sort order</option>
                        <option value="title">Title</option>
                        <option value="created">Created</option>
                        <option value="updated">Updated</option>
                    </select>
                    <div>
                        <button type="submit" class="minimo-button">
                            Ok 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(".modal-close").click(function(){
            var window = $(this).parent().parent().parent();
            window.addClass('inactive');
            window.find("input[type='text']").val("");
            window.find(".category-creation-error").addClass("inactive");
        })
        $(".category-creation-form").submit(function(event){
            event.preventDefault();
            var parent = $(this).parent();
            parent.find(".category-creation-error").addClass("inactive");
            $(this).find("input[name='id']").prop('disabled', false);
            $.ajax({
                url: "{{ route('add-category') }}",
                type: "POST",
                data: new FormData($(this)[0]),
                success: function (data) {
                    if (data["result"] == false) {
                        parent.find(".category-creation-error").removeClass("inactive");
                    } else {
                        location.reload();
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

    </script>
</div>




<div class="container">
    <div>
        <div class="breadCrumbs">
            <a href="{{route('admin', ['id' => 'root'])}}">root</a>
            @foreach ($breadCrumbs as $crumb)
            > <a href="{{route('admin', ['id' => $crumb->id])}}">{{ $crumb->title }}</a> 
            @endforeach
        </div>
    </div>
    <div class="pages-table-wrapper">
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td></td>
                    <td>Title</td>
                    <td>Short</td>
                    <td>Created</td>
                    <td>Updated</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td><i class="fas fa-folder"></i></td>
                    <td><a href="{{route('admin', ['id' => $parent->id])}}" style="text-decoration: underline; font-weight: 500;">..</a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($pages as $item)
                    @if (!$item->isContainer)
                        @continue
                    @endif
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><i class="fas fa-folder"></i></td>
                        <td><a href="{{route('admin', ['id' => $item->id])}}" style="text-decoration: underline;">{{$item->title}}</a></td>
                        <td>{{$item->short}}</td>
                        <td>{{$item->created}}</td>
                        <td>{{$item->updated}}</td>
                        <td>
                            <a href="{{route('page', ['id' => $item->id])}}"><i class="fas fa-eye"></i></a>
                            <a style="cursor: pointer;" class="update-dir" routeId="{{$item->id}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('rempost', ['id' => $item->id])}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                @foreach ($pages as $item)
                    @if ($item->isContainer)
                        @continue
                    @endif
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><i class="fas fa-file"></i></td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->short}}</td>
                        <td>{{$item->created}}</td>
                        <td>{{$item->updated}}</td>
                        <td>
                            <a href="{{route('page', ['id' => $item->id])}}"><i class="fas fa-eye"></i></a>
                            <a href="{{route('update', ['id' => $item->id])}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('rempost', ['id' => $item->id])}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="display: flex; justify-content: space-between;">
        @if (sizeof($breadCrumbs) == 0)
            <a href="{{route('newpost',['id' => 'route'])}}"><div class="minimo-button">Add post</div></a>
        @else
            <a href="{{route('newpost',['id' => end($breadCrumbs)->id])}}"><div class="minimo-button">Add post</div></a>
        @endif
        <div class="minimo-button modal-activate">Add directory</div>
    </div>
    <script>
        $(".modal-activate").click(function(){
            $(".modal").removeClass("inactive");
            $(".modal").find("input[name='allowUpdate']").val(0);
            $(".modal").find("input[name='id']").val($(this).attr(''));
            $(".modal").find("input[name='id']").prop('disabled', false);
        });
        $(".update-dir").click(function(){
            $(".modal").removeClass("inactive");
            $(".modal").find("input[name='allowUpdate']").val(1);
            $(".modal").find("input[name='id']").val($(this).attr('routeId'));
            $(".modal").find("input[name='id']").prop('disabled', true);
        });
    </script>
</div>
@endsection