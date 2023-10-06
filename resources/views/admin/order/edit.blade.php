@extends('admin.layouts.layout')
@section('title','Order Create/Edit')
@section('content')
@if (request()->routeIs('*.create'))
{!! Form::open(['route'=>['order.store'],'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::model($order,['route'=>['order.update',$order->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
{!! Form::hidden('order_id', $order->id,['id'=>'order_id']) !!}
@endif
<div class="row">
  <div class="col-lg-9">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        @if (request()->routeIs('*.edit'))
        <h2>Invoice# {{ $order->id }}</h2>
        @endif
      </div>
      <div class="card-body">
        @include('admin.layouts._message')
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="form-group mb-3">
              {{-- {!! Form::hidden('sub_total', null,['id'=>'sub_total']) !!} --}}
              {{-- {!! Form::hidden('shipping_amount', null,['id'=>'shipping_amount']) !!} --}}
              {{ Form::label('name','নাম') }}
							{{ Form::text('name',null,['class'=>'form-control', 'required'=>'required', 'placeholder'=>'নাম']) }}
						</div>
						<div class="form-group mb-3">
              {{ Form::label('address','ঠিকানা') }}
							{{ Form::textarea('address',null,['class'=>'form-control', 'required'=>'required','rows'=>'2', 'placeholder'=>'ঠিকানা']) }}
						</div>
						<div class="form-group mb-3">
              {{ Form::label('phone','মোবাইল') }}
							{{ Form::text('phone',null,['class'=>'form-control', 'required'=>'required', 'placeholder'=>'মোবাইল']) }}
						</div>
						<div class="form-group mb-3">
              {{ Form::label('status_id','Status') }}
							{{ Form::select('status_id',CustomHelper::order_status(),null,['class'=>'form-control', 'required'=>'required', 'placeholder'=>'Status']) }}
						</div>
          </div>
          <div class="col-sm-12 col-md-6">						
						
            {{-- <div class="form-group mb-3">
              {{ Form::label('shipping_method','Shipping') }}
							{{ Form::select('shipping_method',$shipping_methods,null,['class'=>'form-control', 'required'=>'required', 'placeholder'=>'Shipping']) }}
						</div> --}}
            <div class=" mb-3 form-group">
              {!! Form::label('country', 'Country') !!}
              {!! Form::select('country',$countries,config('settings.defaultCountry','BD'),['class'=>'form-control select2','required'=>true,'placeholder'=> __('Country')]) !!}
            </div>
            <div class=" mb-3 form-group">
              {!! Form::label('state', 'State') !!}
              {!! Form::select('state',$states,null,['class'=>'form-control select2','required'=>true,'placeholder'=> __('State')]) !!}
            </div>
            <div class="row">
              <div class="form-group mb-3 col-md-6">
                {{ Form::label('discount_amount','Discount Amount') }}
                {{ Form::number('discount_amount',null,['class'=>'form-control', 'placeholder'=>'Discount Amount']) }}
              </div>
              <div class="form-group mb-3 col-md-6">
                {{ Form::label('shipping_amount','Shipping Amount') }}
                {{ Form::number('shipping_amount',null,['class'=>'form-control', 'required'=>'required', 'min'=>'0', 'placeholder'=>'Shipping Amount']) }}
              </div>
						</div>
            <div class="row">
              <div class="form-group mb-3 col-md-6">
                {{ Form::label('sub_total','Sub Total') }}
                {{ Form::number('sub_total',null,['class'=>'form-control','readonly'=>'readonly','placeholder'=>'Sub Total']) }}
              </div>
              <div class="form-group mb-3 col-md-6">
                {{ Form::label('amount','Total') }}
                {{ Form::number('amount',null,['class'=>'form-control','readonly'=>'readonly', 'placeholder'=>'Total Amount']) }}
              </div>
            </div>
          </div>
        </div>
        @if (request()->routeIs('*.edit'))
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div class="input-group">
            {{ Form::select('product',$products,null,['class'=>'form-control select2', 'id'=>'product_id','placeholder'=>'Product']) }}
						{{ Form::number('qty',1,['class'=>'form-control', 'id'=>'qty', 'placeholder'=>'Qty']) }}
            <button id="product_add" class="btn btn-success input-group-addon" type="button">Add</button>
          </div>
        </div>
      </div>
      @endif
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>SL</th>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Amount</th>
              <th>#</th>
            </tr>
          </thead>
          @php
              $sl = 1;
          @endphp
          <tbody id="itemList">
            @if (request()->routeIs('*.edit'))
            @foreach ($order->items as $item)
            <tr data-id="{{ $item->id }}">
              <td>{{ $sl++ }}</td>
              <td>{{ $item->product->title }}</td>
              <td>{{ $item->price }}</td>
              <td><input class="form-control quantity update-cart" min="1" value="{{ $item->qty_ordered }}" type="number"></td>
              <td class="total">{{ $item->total }}</td>
              <td><a href="{{route('order.itemRemove',$item->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
            @endforeach
            @endif
          </tbody>
          @if (request()->routeIs('*.edit'))
          <tfoot>
            <tr>
              <td colspan="4" class="text-right">Sub Total</td>
              <td>{{$order->sub_total}}</td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Shipping Amount</td>
              <td id="shipping_amount_d">{{$order->shipping_amount}}</td>
            </tr>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Discount</td>
              <td>{{$order->discount_amount}}</td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Total</td>
              <td>{{$order->amount}}</td>
            </tr>
        </tfoot>
        @endif
        </table>
      </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
  </div>
  <div class="col-sm-12 col-lg-3 d-print-none">
    <div class="card">
      <div class="card-header">Action
        <div class="card-tools">
          {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
        </div>
      </div>
      <div class="card-body">       
        <div class="form-group">
          {{ Form::label('note','Note') }}
          {{ Form::textarea('note',null,['class'=>'form-control','placeholder'=>'Note']) }}
        </div>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection
@section('js')
<script>

    function calcAmount() {
      let sub_total = $("#sub_total").val();
      let shipping_amount = $("#shipping_amount").val();
      console.log(sub_total);
      let discount_amount = $("#discount_amount").val();
      let amount;
      amount = sub_total*1 + shipping_amount*1 - discount_amount*1;
      $("#shipping_amount_d").html(shipping_amount);
      $("#amount").val(amount);
    }

    $( "body" ).on( "load", function() {
      calcAmount();
    } );

    $( "body" ).on( "keyup", "#discount_amount, #shipping_amount", function() {
      calcAmount();
    } );

    $("#product_add").click(function(){
      let product_id = $("#product_id").find(':selected').val();
      let qty = $("#qty").val();
      let order_id = $("#order_id").val();

      $.ajax({
            url: '{{ route('order.itemAdd') }}',
            method: "post",
            data: {
                _token: '{{ csrf_token() }}', 
                product_id: product_id,
                order_id: order_id,
                qty: qty
            },
            success: function (response) {
              //console.log(response);
              location.reload(true);              
            }
        });

      calcAmount();
    });

    $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        ele.parents("tr").find(".total").val();
        $.ajax({
            url: '{{ route('order.qty.update') }}',
            method: "post",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
              //console.log(response);
              ele.parents("tr").find(".total").html(response.item_total);
              $("#sub_total").val(response.subtotal);
              calcAmount();
            }
        });
    });


    $("#country").change(function() {
			var country_code = $(this).val();
			var sitelink = $('meta[name=sitelink]').prop('content');
			$.get("{{route('getStates')}}?country_code="+country_code, function( data ) {
				$('#state').empty();
				$('#state').append('<option value="">Select State</option>');
				$.each(data, function(key, value) {
					$('#state').append('<option value="'+key+'">'+value+'</option>');
				});
				$('#state').append(data);
			});
		});

		$("#state").change(function() {
			var location_id = $(this).val();			
			//$('#userinfo').empty();
			//$('#userinfo').html('<i class="fa fa-refresh  fa-spin" aria-hidden="true"></i>');
			$.get("{{url('/')}}/shipingAmount/?location_id="+location_id+"&type=admin", function( data ) {
				$('#shipping_amount').val(data);
				calcAmount();
			});
		}); 

/*
    $("#shipping_method").change(function() {
			var location_id = $(this).val();
			var sub_total = $('#sub_total').val();
			var sitelink = $('meta[name=sitelink]').prop('content');
			
			//$('#userinfo').empty();
			//$('#userinfo').html('<i class="fa fa-refresh  fa-spin" aria-hidden="true"></i>');
			$.get( sitelink+"/shipingAmount/?location_id="+location_id, function( data ) {
				//console.log(sitelink);
				let amount = parseInt(sub_total)+parseInt(data);
				//$('#userinfo').empty();
				$('#shipping_amount').val(data);
				let discount_amount = $("#discount_amount").val();
        amount = sub_total*1 + data*1 - discount_amount*1;
        $("#amount").val(amount);
			});
		});
*/
</script>
@endsection