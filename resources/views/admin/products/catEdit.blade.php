@extends('admin.layouts.layout')
@section('title','Product Category')
@section('content')
  <section class="content">
    <!-- Main content -->   
      
      <!-- Default card -->
      <div class="card">
        <div class="card-header with-border">
          <h3 class="card-title">Edit</h3>
          <div class="card-tools">
            <a href="{{route('product.productsCat')}}" class="btn btn-primary btn-sm"> <i class="fas fa-arrow-left"></i> Back</a>
          </div>
        </div>
          @include('admin.layouts._message')          
        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <img width="200" src="{{ asset('storage/'.$product->photo) }}" alt="" class="img-thumbnail">
            </div>
            <div class="col-md-7">
              {!! Form::model($product,['route'=>['product.cat.edit',$product->id], 'files' => true ]) !!}
              <div class="form-group">
                  {{ Form::label('slug','Category slug') }}
                  {{ Form::text('slug',null,['class'=>'form-control','placeholder'=>'Category slug']) }}
                </div>
              <div class="form-group">
                  {{ Form::label('title','Category title') }}
                  {{ Form::text('title',null,['class'=>'form-control','placeholder'=>'Category title']) }}
                </div>
                <div class="form-group">
                  {{ Form::label('photo','Photo') }}
                  {{ Form::file('photo',null,array('class'=>'form-control')) }}
                </div>
                <div class="form-group">
                  {{ Form::submit('Submit', ['class'=>'btn btn-primary btn-block']) }} 
                </div> 
              {!! Form::close() !!}
              </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
 @endsection