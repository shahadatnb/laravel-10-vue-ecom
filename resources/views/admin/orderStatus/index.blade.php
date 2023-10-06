@extends('admin.layouts.layout')
@section('title','Order Status')
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      @include('admin.layouts._message')
        {!! Form::open(['route' => 'product.orderStatus.index','class'=>'d-print-none']) !!}
        <div class="input-group">
          {{ Form::text('name',null,['class'=>'form-control','placeholder'=>'Order Status']) }} 
          {{ Form::number('sl',null,['class'=>'form-control','placeholder'=>'SL']) }} 
          {{ Form::submit(__('Save'),array('class'=>'btn btn-success input-group-addon')) }}
        </div>
        {!! Form::close() !!}
    </div>
  </div>
  <div class="card">
    <div class="card-body">      
      <div class="table-responsive">
        <table id="orders" class="table table-sm">
          <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>SL</th>
                <th>Status</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($statuses as $item)
              <tr>                
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->sl }}</td>
                <td>{{ $item->status }}</td>
                <td class="not-exported">
                  <div class="btn-group">
                    <a href="{{route('product.orderStatus.edit',$item->id)}}" class="btn btn-primary btn-sm">Edit</a>
                  </div>                  
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
    </form>
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