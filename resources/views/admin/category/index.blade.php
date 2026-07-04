@extends('admin.layouts.layout')
@section('title','Product Category')
@section('stylesheet')
  <style>
    form.delete {
  display: inline;
}
</style>
  @endsection
@section('content')
  <section class="content">
      <!-- Default card -->
      <div class="card">
        {{-- <div class="card-header with-border">
          
        </div> --}}
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              @include('admin.layouts._message')
            {!! Form::open(['route'=>'product.category.store','method'=>'POST', 'files' => true ]) !!}
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
            <div class="col-md-6">
              <table class="table">
            <tr>
              <th>ID</th>
              <th>Photo</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Action</th>
            </tr>
            @foreach ($cats as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td><img src="{{ asset('storage/'.$product->photo) }}" width="50" alt=""></td>
              <td>{{ $product->title }}</td>              
              <td>{{ $product->slug }}</td>              
              <td>
              <div class="btn-group">
                <a class="btn btn-success btn-xs" href="{{ route('product.category.edit',$product->id) }}"><i class="fa fa-edit"></i>  Edit</a>
                
                  @if($product->status==0)
                    <a class="btn btn-primary btn-xs" href="{{ route('product.category.hide',$product->id) }}">Show</a>
                  @else
                    <a class="btn btn-danger btn-xs" href="{{ route('product.category.hide',$product->id) }}">Hide</a>
                  @endif
                
                  <form class="delete" action="{{ route('product.category.destroy',$product->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-xs" href='{{ $product->id }}' onclick="return confirm('Are You Sure To Delete This Item?')"><i class="fa fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </table>
            </div>
          </div>
          
          
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
 @endsection
    @section('js')
      <script>
        $('.select2').select2();
      </script>
    @endsection