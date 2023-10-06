@extends('admin.layouts.layout')
@section('title','Order Status Edit')
@section('content')
    <div class="card">
      <div class="card-body">
        @include('admin.layouts._message')
      {!! Form::model($orderStatus,['route'=>['product.orderStatus.update',$orderStatus->id],'method'=>'PUT']) !!}
      <div class="input-group">
        {{ Form::text('name',null,['class'=>'form-control','placeholder'=>'Order Status']) }} 
        {{ Form::number('sl',null,['class'=>'form-control','placeholder'=>'SL']) }} 
        {{ Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control','placeholder'=>'Status']) }} 
        {{ Form::submit(__('Save'),array('class'=>'btn btn-success input-group-addon')) }}
      </div>
      {!! Form::close() !!}
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
@endsection
@section('js')
@endsection