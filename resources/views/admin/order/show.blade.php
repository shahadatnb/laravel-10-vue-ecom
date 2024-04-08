@extends('admin.layouts.layout')
@section('title','Order Detail')
@section('content')
<div class="row">
  <div class="col-lg-9">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h2>Invoice</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <h4 class="title">Form Address</h4>
            {{config('settings.siteAddress')}} <br>
            Phone: {{config('settings.sitePhone')}}
          </div>
          <div class="col-4">
            <h4 class="title">To Address</h4> 
            {{ $order->name }} <br>
            {{ $order->address }} @if ($order->address2 != ''), {{ $order->address2 }} @endif<br>
            {{ $order->city }}, @if($order->state>0){{ $order->ostate->name }}@endif-{{ $order->postcode }}<br>
            {{ $order->phone }} <br>
            {{ $order->shipping? $order->shipping->title:'' }}
          </div>
          <div class="col-4">
            <table class="table">
              <tbody>
                <tr> <td>Order No:</td> <td>#{{ $order->id }}</td> </tr>
                <tr> <td>Date:</td> <td>{{ CustomHelper::prettyDate($order->created_at) }}</td> </tr>
              </tbody>
            </table>
              <br>
          </div>
        </div>
        
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>SL</th>
              <th>Image</th>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Amount</th>
            </tr>
          </thead>
          @php
              $sl = 1;
          @endphp
          <tbody>
            @foreach ($order->items as $item)
            <tr>
              <td>{{ $sl++ }}</td>
              <td><img width="50" class="img-thumb" src="{{ asset( 'storage/'.$item->product->photo) }}" alt="#"></td>
              <td>{{ $item->product->title }} {{ $item->variant? $item->variant->size? ' - '.$item->variant->size->name:'':''}} {{ $item->variant? $item->variant->color? ' - '.$item->variant->color->name:'':''}}</td>
              <td>{{ $item->price }}</td>
              <td>{{ $item->qty_ordered }}</td>
              <td>{{ $item->total }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-right">Sub Total</td>
              <td>{{$order->sub_total}}</td>
            </tr>
            <tr>
              <td colspan="5" class="text-right">Shipping Amount</td>
              <td>{{$order->shipping_amount}}</td>
            </tr>
            <tr>
              <td colspan="5" class="text-right">Total</td>
              <td>{{$order->amount}}</td>
            </tr>
            <tr>
              <td colspan="6">In Words: {{CustomHelper::numberTowords($order->amount)}}</td>
            </tr>
        </tfoot>
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
          <button class="btn btn-primary btn-sm" type="button" onclick="window.print();"><i class="nav-icon fas fa-print"></i> Print</button>
        </div>
      </div>
      <div class="card-body">
        @if($order->is_returned == 1)
        <p>Refund Date: {{ prettyDate($order->returned_date) }}</p>
        {!! $order->returned_note !!}
        @endif
        {!! Form::model($order,['route'=>['order.statusUpdate',$order->id],'method'=>'POST']) !!}
          {{ Form::select('status_id',CustomHelper::order_status(),null,['class'=>'form-control select2','placeholder'=>'Order Status']) }} 
          {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

@endsection