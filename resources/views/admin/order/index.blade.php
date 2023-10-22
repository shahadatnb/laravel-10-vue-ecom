@extends('admin.layouts.layout')
@section('title','Order List')
@section('css')
<link href="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/datatables.min.css" rel="stylesheet"/>
<!-- Tempus Dominus Styles -->
{{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/css/tempusdominus-bootstrap-4.css" crossorigin="anonymous" /> --}}
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

@endsection
@section('content')
@php
    $status1 = ['invoice'=>'Print Invoice'];
    $status2 = CustomHelper::order_status();
    $status3 = ['pDelete'=>'Permanent Delete'];
    $status = $status1+$status2+$status3;
@endphp
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-md-12 mb-2">
          @foreach ($status2 as $key=>$item)
          <a class="btn btn-sm btn-outline-info" href="{{route('order.index',['status'=>$key])}}">{{$item}} <span class="badge badge-primary">{{$allOrder->where('status_id',$key)->count()}}</span></a>
          @endforeach
          <a class="btn btn-sm btn-outline-info" href="{{route('order.index',['is_return'=>1])}}">Return Request <span class="badge badge-primary">{{$allOrder->where('is_returned',1)->where('status_id','!=',9)->count()}}</span></a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12">
          {!! Form::model($data,['route' => 'order.index','method'=>'get','class'=>'d-print-none']) !!}
          <div class="row">
            <div class="col">
              {!! Form::text('startDate',null,['class'=>'form-control form-control-sm datetimepicker','placeholder'=>__('Start Date'), 'data-toggle'=>"datetimepicker", 'data-target'=>'#startDate','id'=>'startDate']) !!}
            </div>
            <div class="col">
              {!! Form::text('endDate',null,['class'=>'form-control form-control-sm datetimepicker','placeholder'=>__('End Date'), 'data-toggle'=>"datetimepicker", 'data-target'=>'#endDate','id'=>'endDate']) !!}
            </div>
            {{-- <div class="col">
              {{ Form::select('status',$status2,null,['class'=>'form-control form-control-sm select2','placeholder'=>'Order Status']) }} 
            </div> --}}
            <div class="col">
              {{ Form::select('assigned_user',$users,null,['class'=>'form-control form-control-sm select2','placeholder'=>'Assigned user']) }} 
            </div>
            <div class="col">
              {{ Form::select('shipping_method',$shipping_methods,null,['class'=>'form-control form-control-sm select2','placeholder'=>'Shipping Area']) }} 
            </div>
            <div class="col-1">
              {!! Form::number('paginate',null,['class'=>'form-control form-control-sm','placeholder'=>__('paginate')]) !!}
            </div>
            <div class="col-1">
              {!! Form::number('id',null,['class'=>'form-control form-control-sm','placeholder'=>__('Invoice')]) !!}
            </div>
            <div class="col">
              {{ Form::submit(__('Filter'),array('class'=>'btn btn-success btn-sm')) }}
              <a href="{{route('order.index')}}" class="btn btn-primary btn-sm">Reset</a>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
        {{-- <div class="col-md-3">
          {!! Form::model($data,['route' => 'order.index','method'=>'get','class'=>'d-print-none']) !!}
          <div class="input-group">
            {{ Form::select('status',$status2,null,['class'=>'form-control select2','placeholder'=>'Order Status']) }} 
            {{ Form::submit(__('Find'),array('class'=>'btn btn-success input-group-addon')) }}
          </div>
          {!! Form::close() !!}
        </div> --}}
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">      
      {{-- <form id="order_list" method="POST" action="{{route('invoice')}}" target="_blank"> --}}
        {!! Form::open(['route' => 'invoice','method'=>'get']) !!}
        <div class="row mb-2">
          <div class="col">
            {{ Form::select('status',$status,null,['class'=>'form-control form-control-sm select2','placeholder'=>'Order Status']) }} 
          </div>
          @if(Auth::user()->hasAnyRole(['Manager','Admin','SuperAdmin']))
          <div class="col">
            {{ Form::select('assigned_user',$users,null,['class'=>'form-control form-control-sm select2','placeholder'=>'Users']) }} 
          </div>
          @endif
        <div class="col"><button type="submit" class="btn btn-sm btn-primary">Submit</button></div>
        <div class="col"> <a href="{{route('order.create')}}" class="btn btn-sm btn-primary">Create Order</a> </div>
        </div>
      
      <div class="table-responsive">
        <table id="orders" class="table table-sm">
          <thead>
              <tr>
                <th class="not-exported"><input class="checkbox" id="selectAll" name="selectAll" type="checkbox"> <label for="selectAll">All</label></th>
                <th>Invoice</th>
                <th class="not-exported">Date</th>
                <th>Name</th>
                <th>Address</th>
                <th class="not-exported">Shipping</th>
                <th>Phone</th>
                <th>Amount</th>
                <th class="not-exported">Status</th>
                <th>Note</th>
                <th class="not-exported">Action</th>
                <th class="not-exported">Assign</th>
                <th class="not-exported">Updated</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $order)
              <tr>
                <td class="not-exported"><input class="order_list" name="order[]" type="checkbox" value="{{$order->id}}"></td>
                <td>{{ $order->id }}</td>
                <td>{{ CustomHelper::prettyDate($order->created_at) }}</td>
                <td>{{ $order->name }}</td>
                <td>
                  {{-- {!! $order->address !!},  {{ $order->city }}, @if($order->state>0){{ $order->ostate->name }}@endif-{{ $order->postcode }}<br> --}}
                  {!! $order->address !!}
                  {{-- {{ $order->email }} --}}
                </td>
                <td>{{ $order->shipping? $order->shipping->title:$order->shipping_method}}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->amount }}</td>
                <td>{{ $order->status? $order->status->name : '' }}</td>
                <td>{{ $order->note }}</td>
                <td class="not-exported">
                  <div class="btn-group">
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-info btn-sm">Show</a>
                    <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm">Edit</a>
                  </div>                  
                </td>
                <td>{{ $order->assignTo?$order->assignTo->name:'' }}</td>
                <td>{{ $order->updatedBy?$order->updatedBy->name:'' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="text-center">{{ $orders->appends($_GET)->links() }}</div>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/datatables.min.js"></script>
{{-- <script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script> --}}
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<!-- Tempus Dominus JavaScript -->
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0/js/tempusdominus-bootstrap-4.min.js" crossorigin="anonymous"></script> --}}
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>

<script>
    $(function () {
      
      $("#orders").DataTable({
        dom: '<"row"<"col"B><"col text-right"f>>tip',
            buttons: [
              'copy',
              {
                extend: 'excelHtml5',
                text: '<i title="Excel" class="far fa-file-excel"></i>',
                        //messageTop: header,
                exportOptions: {
                  columns: ':visible:Not(.not-exported)',
                  rows: ':visible'
                },
                title:'',                
              },
              {
                extend: 'pdfHtml5',	//pdf
                text: '<i title="PDF" class="far fa-file-pdf"></i>',
                charset: "utf-8",
                //messageTop: header,
                exportOptions: {
                  columns: ':visible:Not(.not-exported)',
                  rows: ':visible'
                },
              },
              {
                extend: 'print',
                text: '<i title="Print" class="fas fa-print"></i>',
                //messageTop: header,
                exportOptions: {
                  columns: ':visible:Not(.not-exported)',
                  rows: ':visible'
                },
                messageBottom: null
              },
              {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
              },
          ],
          "paging":   false,
      });

      $('.datetimepicker').datetimepicker({
            //format: 'DD/MM/YYYY'
            format: 'YYYY-MM-DD'
        });

      

      $(':checkbox[name=selectAll]').click (function () {
        //$(':checkbox[name=student_list]').prop('checked', this.checked);
        $('.order_list').prop('checked', this.checked);
      });
      
      $('#invoice').click (function () {
        var order_list = $('#order_list').serialize();
      });
      
      $('#pramoteStudentModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        })

        $('#pramoteStudentModal').on('click', '.pramote_close', function (e) {
          $('#pramoteStudentModal').modal('hide');
          location.reload(true);
        });

    });
  </script>
@endsection