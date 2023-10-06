@extends('admin.layouts.layout')
@section('title',"Add/Edit User")
@section('content')
@include('admin.layouts._message')
@if($mode=='edit')
  {!! Form::model($user,['route'=>['userUpdate',$user->id]]) !!}
@else
  {!! Form::open(['route'=>['userStore'],'method'=>'POST']) !!}
@endif
  <div class="form-group row">
    {!! Form::label('name', 'Name',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
    </div>
  </div>
  <div class="form-group row">
      {!! Form::label('email', 'Email',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
      {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
    </div>
  </div>                    
  <div class="form-group row">
      {!! Form::label('mobile', 'Nobile No',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
      {!! Form::text('mobile',null,['class'=>'form-control','placeholder'=>'Nobile No']) !!}
    </div>
  </div>                    
  <div class="form-group row">
      {!! Form::label('address', 'Address',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
      {!! Form::textarea('address',null,['class'=>'form-control','placeholder'=>'Address','rows'=>'2']) !!}
    </div>
  </div>
  <div class="form-group row">
    {!! Form::label('password', 'Password',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
    </div>
  </div>
  <div class="form-group row">
      {!! Form::label('password_confirmation', 'Password confirm',['class'=>'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
      {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirm Password']) !!}
    </div>
  </div>
  <div class="form-group row">
    <div class="offset-sm-2 col-sm-10">
      {{ Form::submit('Save', ['class'=>'btn btn-success']) }}
    </div>
  </div>
{!! Form::close() !!}
{{-- @if($mode=='edit')
{!! Form::open(['route'=>'chengePasswordFource','method'=>'post','class'=>'form-inline']) !!}
  <input type="hidden" name="id" value="{{ $user->id }}">
  {{ Form::text('password',null,['class'=>'form-control']) }}
  <button class="btn btn-primary" type="submit">Set Pass</button>
{!! Form::close() !!}
@endif --}}
@if($mode=='edit')
  <a href="{{route('fourceLogin',$user->id)}}" class="btn btn-danger">Fource Login</a>
@endif
@endsection