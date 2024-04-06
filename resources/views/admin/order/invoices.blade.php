@extends('admin.layouts.layout')
@section('title','Order List')
@section('content')
@foreach ($orders as $key=>$order)
    <!-- Default box -->
    <div class="card invoice mb-5">
      <div class="card-header pb-0">
        <h2 class="card-title text-uppercase text-primary" mb-0 style="font-size:24px; font-weight: bold;">Invoice</h2>
        <div class="card-tools">
          <img width="120" src="{{ asset('upload/site_file/'.config('settings.siteLogo')) }}" alt="">
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <h4 class="title mb-0">Company Information</h4>
            {{config('settings.siteAddress')}} <br>
            {{-- Phone: {{config('settings.sitePhone')}} --}}
          </div>
          <div class="col-4">
            <h4 class="title mb-0">Customer Information</h4> 
            {{ $order->name }} <br>
            {{ $order->address }} @if ($order->address2 != ''), {{ $order->address2 }} @endif<br>
            {{-- {{ $order->city }}, @if($order->state>0){{ $order->ostate->name }}@endif-{{ $order->postcode }}<br> --}}
            {{ $order->phone }}            
          </div>
          <div class="col-4 text-right">
            Invoice Date: <b>{{ CustomHelper::prettyDate($order->created_at) }}</b> <br>
            Invoice No: <b>#{{ $order->id }}</b><br>
            {{-- Order No: <b>#{{ $order->id }}</b><br>
            Order Date: <b>{{ prettyDate($order->created_at) }}</b> --}}
            {{-- <table class="table table-sm">
              <tbody>
                <tr> <td class="text-right">Invoice Date:</td> <td></td> </tr>
                <tr> <td class="text-right">Invoice No:</td> <td>#{{ $order->id }}</td> </tr>
                <tr> <td class="text-right">Order No:</td> <td>#{{ $order->id }}</td> </tr>
                <tr> <td class="text-right">Order Date:</td> <td>{{ prettyDate($order->created_at) }}</td> </tr>
              </tbody>
            </table>
              <br> --}}
          </div>
        </div>
        
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>SL</th>
              <th>Image</th>
              <th>Item</th>
              <th>Quantity</th>
              <th>Price</th>
              <th class="text-right">Amount</th>
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
              <td>{{ $item->product->title }}</td>
              <td>{{ $item->qty_ordered }}</td>
              <td>{{ $item->price }}</td>
              <td class="text-right">{{ $item->total }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-right">Sub Total</td>
              <td class="text-right">{{$order->sub_total}}</td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Shipping Amount ({{ $order->shipping? $order->shipping->title:'' }})</td>
              <td class="text-right">{{$order->shipping_amount}}</td>
            </tr>
            @if ($order->discount_amount>0)
              <tr>
                <td colspan="4" class="text-right">Amount</td>
                <td class="text-right">{{$order->sub_total + $order->shipping_amount}}</td>
              </tr>
              <tr>
                <td colspan="4" class="text-right">Discount</td>
                <td class="text-right">{{$order->discount_amount}}</td>
              </tr>                
            @endif
            <tr>
              <td colspan="3" class="text-left">In Words: {{CustomHelper::numberTowords($order->amount)}}</td>
              <td class="text-right">Total</td>
              <td class="text-right">{{$order->amount}}</td>
            </tr>
        </tfoot>
        </table>
      </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @if( ++$key%3 == 0 )
        <div class="break"></div>
    @endif
@endforeach
    <style>
      @media print {
        .break {page-break-after: always;}
      }
    </style>
@endsection
@section('js')
<script>
  window.print();
  </script>
@endsection