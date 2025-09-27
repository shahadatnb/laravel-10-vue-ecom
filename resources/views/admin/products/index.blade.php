@extends('admin.layouts.layout')
@section('title','Product List')
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
        <div class="card-header with-border">
          <div class="row">
            <div class="col-md-10">
              {!! Form::model($data, ['route' => 'product.products.index', 'method' => 'GET','class'=>'row']) !!}
              <div class="form-group col-md-5">
                {{ Form::text('title',null,['class'=>'form-control','placeholder'=>'Product title']) }}
              </div>
              <div class="form-group col-md-5">
                {{ Form::select('cat_id',$categories,null,['class'=>'form-control select2','placeholder'=>'Select Category']) }}
              </div>
              <div class="form-group col-md-2">
                {{ Form::submit('Search', ['class'=>'btn btn-primary btn-block']) }}
              </div>
              {!! Form::close() !!}
            </div>
            <div class="col-md-2">
              <a href="{{ route('product.products.create')}}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> New Product</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          @include('admin.layouts._message')
          <div class="table-responsive">
          <table class="table">
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Product</th>
              <th>Price</th>
              <th>Reduced Price</th>
              <th>Quantity</th>
              <th>Category</th>
              <th>Action</th>
            </tr>
            @foreach ($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td><img width="70" src="{{ asset('storage/'.$product->photo) }}" alt="" class="img-thumbnail"></td>
              <td>{{ $product->title }}</td>
              <td>{{ $product->price }}</td>
              <td>{{ $product->reduced_price }}</td>
              <td>{{ $product->quantity }}</td>
              <td>
                @php $passed = false; @endphp
                @foreach ($product->categories as $item)
                    {{($passed ? ', ' : '') . $item->title}}
                    @php $passed = true; @endphp
                @endforeach
              </td>
              <td>
                <div class="btn-group">
                <a class="btn btn-info btn-xs" href="{{ route('product.products.show',$product->id) }}"><i class="fa fa-eye"></i></a>
                <a class="btn btn-success btn-xs" href="{{ route('product.products.edit',$product->id) }}"><i class="fa fa-edit"></i>  Edit</a>
                
                  @if($product->status==0)
                    <a class="btn btn-primary btn-xs" href="{{ route('product.productHide',$product->id) }}">Show</a>
                  @else
                    <a class="btn btn-danger btn-xs" href="{{ route('product.productHide',$product->id) }}">Hide</a>
                  @endif
                
                <form class="delete" action="{{ route('product.products.destroy',$product->id) }}" method="post">
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
        <!-- /.card-body -->
        <div class="card-footer">
          {{ $products->appends($_GET)->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
 @endsection
    @section('js')
      <script>
        
      </script>
    @endsection