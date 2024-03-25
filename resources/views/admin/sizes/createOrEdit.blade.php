@extends('admin.layouts.layout')
@section('title',"Size")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Size</h3>
        <div class="card-tools">
        
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        @if (request()->routeIs('size.edit'))
            {!! Form::model($size,['route'=>['size.update',$size], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
        @else
            {!! Form::open(array('route'=>'size.store','enctype'=>'multipart/form-data')) !!}
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    {{ Form::label('name','Name') }}
                    {{ Form::text('name',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="form-group">
                    {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                </div>
            </div>
        </div>       
        
        {!! Form::close() !!}
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection