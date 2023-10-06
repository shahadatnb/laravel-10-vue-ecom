@extends('admin.layouts.layout')
@section('title',"Export")
@section('css')
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Export</h3>
        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        {!! Form::open(['route'=>'InsuranceExport','method'=>'POST','class'=>'']) !!}
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label('startDate', 'Start Date') !!} 
                <div class="input-group" id="testDate" data-target-input="nearest">                
                    {!! Form::text('startDate',$startDate,['class'=>'form-control datetimepicker-input','placeholder'=>'Start Date', 'required'=>'required',
                    'data-target'=>'#testDate',
                    'data-inputmask-alias'=>'datetime','data-inputmask-inputformat'=>'dd/mm/yyyy','data-mask'=>'data-mask']) !!}
                    <div class="input-group-append" data-target="#testDate" data-toggle="datetimepicker">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                </div>                
            </div>

            <div class="col-sm-3">
                {!! Form::label('endDate', 'Start Date') !!}
                <div class="input-group" id="testDate2" data-target-input="nearest">
                    {!! Form::text('endDate',$endDate,['class'=>'form-control datetimepicker-input','placeholder'=>'End Date', 'required'=>'required',
                    'data-target'=>'#testDate2',
                    'data-inputmask-alias'=>'datetime','data-inputmask-inputformat'=>'dd/mm/yyyy','data-mask'=>'data-mask']) !!}
                    <div class="input-group-append" data-target="#testDate2" data-toggle="datetimepicker">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                </div>                
            </div>
            <div class="col-sm-3">
                {{ Form::label('submit','&nbsp;') }} 
                <div class="no-print">
                {{ Form::submit('Export Insurance list', ['class'=>'btn btn-success']) }}
                </div>
            </div>
        </div>
        {!! Form::close() !!}        
        
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        Footer
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<script src="{{ asset('assets/admin/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
    <script>
        $(document).ready(function(){

            //$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //$('[data-mask]').inputmask();
            $('#testDate').datetimepicker({
                format: 'DD/MM/YYYY'
            })
            $('#testDate2').datetimepicker({
                format: 'DD/MM/YYYY'
            })
        });
    </script>
@endsection