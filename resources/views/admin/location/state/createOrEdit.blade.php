@extends('admin.layouts.layout')
@section('title',"Location State")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Location State</h3>
        <div class="card-tools">
        
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        @if (request()->routeIs('locationState.edit'))
            {!! Form::model($locationState,['route'=>['locationState.update',$locationState], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
        @else
            {!! Form::open(array('route'=>'locationState.store','enctype'=>'multipart/form-data')) !!}
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    {{ Form::label('country_id','Country') }}
                    {{ Form::select('country_id',$countries,null,['class'=>'form-control select2','required'=>true,'placeholder'=> __('Country')]) }}
                </div>
            </div>
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