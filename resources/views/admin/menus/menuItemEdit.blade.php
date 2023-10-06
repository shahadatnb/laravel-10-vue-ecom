@extends('admin.layouts.layout')
@section('title',"Menu")
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit</h3>
        <div class="card-tools">
            
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        {!! Form::model($menu,['route'=>['menuItem.update',$menu->id],'method'=>'POST','class'=>'form']) !!}
        @include('admin.menus.partial.fields') 
        
        {!! Form::close() !!}
        
    </div>
</div>
<!-- /.card -->
@endsection