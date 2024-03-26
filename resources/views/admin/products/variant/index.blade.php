@extends('admin.layouts.layout')
@section('title','Product Stock')
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
          {{ Form::model($data,['route'=>'product.stock.index','method'=>'GET','class'=>'form row']) }}
          <div class="form-group col-md-3">
            {{ Form::text('searchTerm',null,['class'=>'form-control','placeholder'=>'Product title']) }}
          </div>
          <div class="form-group col-md-3">
            {{ Form::submit('Search', ['class'=>'btn btn-primary btn-block']) }}
          </div>
          {{ Form::close() }}
        </div>
        <div class="card-body">
          @include('admin.layouts._message')
          <div class="table-responsive">
          <table class="table table-bordered table-sm" id="products">
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>C/S</th>
              <th>Price</th>
              <th>R Price</th>
              <th>Quantity</th>
              <th>Add Qty</th>
            </tr>
            @foreach ($productStocks as $stock)
            <tr>
              <td>{{ $stock->product->id }}</td>
              <td>{{ $stock->product->title }}</td>
              <td>{{ $stock->color? $stock->color->name : '' }} - {{ $stock->size? $stock->size->name : '' }}</td>
              <td>{{ $stock->price }}</td>
              <td>{{ $stock->reduced_price }}</td>
              <td class="item_qty">{{ $stock->quantity }}</td>
              {{-- <td>
                @php $passed = false; @endphp
                @foreach ($product->categories as $item)
                    {{($passed ? ', ' : '') . $item->title}}
                    @php $passed = true; @endphp
                @endforeach
              </td> --}}
              <td>
                <input data-id="{{ $stock->id }}" type="number" name="quantity" class="form-control form-control-sm stockAdd">
              </td>
            </tr>
            @endforeach
          </table>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          {{ $productStocks->links() }}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </section>
 @endsection
@section('js')
  <script>
    $(document).ready(function(){
      $('#products').on('blur keyup','.stockAdd',function(e){
        if (e.type === 'blur' || e.keyCode === 13) {
          let id = $(this).data('id');
          let quantity = $(this).val();
          let inputItem = $(this);

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            type: 'POST',
            data: {id:id,quantity:quantity},
            url: "{{ route('product.stock.update') }}",
            datadataType: 'json',
            success: function (data) {
              if (data.success) {
                console.log(data);
                inputItem.addClass("is-valid");
                inputItem.removeClass("is-invalid");
                inputItem.closest('tr').find('.item_qty').html(data.quantity);
                //console.log(inputItem.closest('tr').next().find('.input_quantity'));
                inputItem.closest('tr').next().find('.stockAdd').select();
              }else{
                inputItem.addClass("is-invalid");
                inputItem.removeClass("is-valid");
                alert(data.message);
              }
            },
            error: function (data) {
                //console.log('Error:', data);
                inputItem.addClass("is-invalid");
                inputItem.removeClass("is-valid");
            }
          });
        }
      });
    });
  </script>
@endsection