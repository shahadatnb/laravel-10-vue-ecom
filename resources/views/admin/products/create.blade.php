@extends('admin.layouts.layout')
@section('title','Product')
@section('content') 
<section class="content"> 
      {!! Form::open(['route'=>'product.products.store','method'=>'POST']) !!}
      <!-- Default card -->
      <div class="card">
        <div class="card-header with-border">
          @include('admin.layouts._message')
          <div class="row">
            <div class="col-md-8">
              {{ Form::label('title','Title') }}
              {{ Form::text('title',null,['class'=>'form-control']) }} 
              @if($errors->has('title'))
                  <span class="help-block">{{ $errors->first('title') }}</span>
              @endif             
            </div>
            <div class="col-md-4">
              <br>
              {{ Form::submit('Next Step', ['class'=>'btn btn-primary btn-block']) }}             
            </div>
          </div>
        </div>
        <div class="card-body">          
          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      {!! Form::close() !!}

    </section>
 @endsection