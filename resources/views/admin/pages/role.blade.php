@extends('admin.layouts.layout')
@section('title',"Ruse Role")
@section('css')
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">User Role</h3>
    <div class="card-tools">
    <a href="{{route('userCreate')}}" class="btn btn-sm btn-success">New User</a>
    </div>
  </div>
    <div class="card-body">
      <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User</th>
                <th>Action</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
              <tr>
                {!! Form::model($user,['route'=>'admin-assign','method'=>'post']) !!}
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                <td>{{ Form::select('roles[]',$roles,null,['class'=>'select2-multi form-control','multiple'=>'multiple']) }}</td>
                <td><button class="btn btn-primary" type="submit">Assign Role</button></td>
                {!! Form::close() !!}
                <td>
                  <a href="{{route('userEdit',$user->id)}}" class="btn btn-sm btn-success">Edit</a>
                  <a href="{{route('userDelete',$user->id)}}" onclick="return confirm('Are You Sure To Delete This Item?')" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
      </div>
        <div class="text-center">{{ $users->links() }}</div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      
    </div>
    <!-- /.box-footer-->
  </div>
<!--   Card  -->
 @endsection
    @section('js')
      
    @endsection