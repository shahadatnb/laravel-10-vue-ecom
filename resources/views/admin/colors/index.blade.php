@extends('admin.layouts.layout')
@section('title',"Color")
@section('content')
<style>
    form.delete {
  display: inline;
}
.color-box {
    display: block;
    color: #fff;
    padding: 5px 10px;
}
</style>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Color</h3>
        <div class="card-tools">
            <a href="{{route('color.create')}}" class="btn btn-success">New</a>
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($colors as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td><span class="color-box" style="background-color:{{$data->code}};"> {{ $data->code }} </span></td>
                    <td>
                        <a href="{{ route('color.edit', $data) }}" class="btn btn-warning btn-xs">Edit</a>
                        <form class="delete" action="{{ route('color.destroy',$data) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection