@extends('main')

@section('content')
<div class="container">
    <style>
        .pages-select-list {
            width: 100%;
            height: 80px;
            border-bottom: 1px solid #a0aec0;
            overflow: auto;
            margin-bottom: 25px;
        }
        .pages-list-item {
            padding: 10px;
            cursor: pointer;
        }
        .selected {
            background-color: #58CEFC;
            color: #1a202c;
        }
    </style>


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
                    <td>Sort order</td>
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
                        <td></td>
                        <td>{{$item->sortOrder}}</td>
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
                        <td>
                            @if ($item->isAlias)
                                <i class="fas fa-reply"></i>
                            @else
                                <i class="fas fa-file"></i>
                            @endif
                        </td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->short}}</td>
                        <td></td>
                        <td>{{$item->created}}</td>
                        <td>{{$item->updated}}</td>
                        <td>
                            <a href="{{route('page', ['id' => $item->id])}}"><i class="fas fa-eye"></i></a>
                            @if ($item->isAlias)
                                <a style="cursor: pointer;" class="update-alias" aliasId="{{ $item->aliasId }}"><i class="fas fa-edit"></i></a>
                                <a href="{{route('rempost', ['id' => $item->aliasId])}}"><i class="fas fa-trash-alt"></i></a>
                            @else
                                <a href="{{route('update', ['id' => $item->id])}}"><i class="fas fa-edit"></i></a>
                                <a href="{{route('rempost', ['id' => $item->id])}}"><i class="fas fa-trash-alt"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="display: flex; justify-content: center;">
        <style> .minimo-button { margin: 0 5px; } </style>
        @if (sizeof($breadCrumbs) == 0)
            <a href="{{route('newpost',['id' => 'route'])}}"><div class="minimo-button"><i class="fas fa-plus"></i> Post</div></a>
        @else
            <a href="{{route('newpost',['id' => end($breadCrumbs)->id])}}"><div class="minimo-button"><i class="fas fa-plus"></i> Post</div></a>
        @endif
        <div class="minimo-button create-directory-button"><i class="fas fa-plus"></i> Directory</div>
        <div class="minimo-button create-alias-button"><i class="fas fa-plus"></i> Alias</div>
    </div>
    <script src="{{ asset( 'public/scripts/modalWindow.js' ) }}"></script>
    <script>
        const DirectoryModalWindow = new ModalWindow();
        DirectoryModalWindow.setRoute("{{ route('add-category') }}")
            .append('{{ csrf_field() }}')
            .append('<input type="hidden" name="allowUpdate" value="0">')
            .append('<input type="hidden" name="parent" value="{{$dir}}">')
            .appendField(new MinimoTextInput({ title: 'Id', name: 'id' }))
            .appendField(new MinimoTextInput({ title: 'Title', name: 'title' }))
            .appendField((new MinimoSelect({ title: 'Select sort order', name: 'sortOrder' }))
                .option('title', 'Title')
                .option('created', 'Created')
                .option('updated', 'Updated'))
            .addSubmit();
        $(".update-dir").click(function () {
            console.log($(this).attr('routeId'))
            DirectoryModalWindow.setTitle('Directory update').show()
            DirectoryModalWindow.modal.find('input[name="allowUpdate"]').val('1')
            DirectoryModalWindow.modal.find('input[name="id"]').val($(this).attr('routeId')).prop( "disabled", true )
        })
        $(".create-directory-button").click(function () {
            DirectoryModalWindow.setTitle('Create directory').show()
            DirectoryModalWindow.modal.find('input[name="allowUpdate"]').val('0')
        })

        const AddAliasModalWindow = new ModalWindow();
        const pageSelect = new MinimoPageSelect( { name: 'searchField' })
        AddAliasModalWindow.setRoute("{{ route('add-alias')  }}")
            .setTitle('Create alias')
            .append('{{ csrf_field() }}')
            .append('<input type="hidden" required name="aliasTo" value="">')
            .append('<input type="hidden" name="parent" value="{{$dir}}">')
            .appendField(pageSelect
                .set_csrf('{{ csrf_token() }}')
                .set_route(" {{ route('get-pages-like') }} "))
            .appendField((new MinimoTextInput({ title: 'New title', name: 'newTitle' })).required(false))
            .appendField((new MinimoTextArea({ title: 'New description', name: 'newShort' })))
            .addSubmit()
        $(".create-alias-button").click(function () {
            AddAliasModalWindow.show()
        })

        const UpdateAliasModalWindow = new ModalWindow();
        UpdateAliasModalWindow.setRoute("{{ route('update-alias')  }}")
            .setTitle("Update alias")
            .append('{{ csrf_field() }}')
            .append('<input type="hidden" required name="aliasId" value="">')
            .appendField((new MinimoTextInput({ title: 'New title', name: 'newTitle' })).required(false))
            .appendField((new MinimoTextArea({ title: 'New description', name: 'newShort' })))
            .addSubmit()
        $(".update-alias").click(function () {
            UpdateAliasModalWindow.modal.find("input[name='aliasId']").val($(this).attr("aliasId"))
            UpdateAliasModalWindow.show()
        })
    </script>

</div>
@endsection
