@extends('main')

@section('content')
<div class="container">
    <div class="pages-table-wrapper">
        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>Title</td>
                    <td>Short</td>
                    <td>Category</td>
                    <td>Created</td>
                    <td>Updated</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->short}}</td>
                        <td>{{$item->category_name}}</td>
                        <td>{{$item->created}}</td>
                        <td>{{$item->updated}}</td>
                        <td>
                            <a href="{{route('post', ['id' => $item->id])}}"><i class="fas fa-eye"></i></a>
                            <a href="{{route('update', ['id' => $item->id])}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('rempost', ['id' => $item->id])}}"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{route('newpost')}}"><div class="minimo-button">New</div></a>
</div>
@endsection