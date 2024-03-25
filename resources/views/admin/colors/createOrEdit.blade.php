@extends('admin.layouts.layout')
@section('title',"Color")
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}"/>
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Color</h3>
        <div class="card-tools">
        
        </div>
    </div>
    <div class="card-body">
        @include('admin.layouts._message')
        @if (request()->routeIs('color.edit'))
            {!! Form::model($color,['route'=>['color.update',$color], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
        @else
            {!! Form::open(array('route'=>'color.store','enctype'=>'multipart/form-data')) !!}
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    {{ Form::label('name','Name') }}
                    {{ Form::text('name',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    {{ Form::label('code','Color') }}                    
                    {{-- {{ Form::text('code',null,array('class'=>'form-control my-colorpicker1','required'=>true)) }} --}}
                    <div class="input-group my-colorpicker2">
                        {{-- <input type="text" class="form-control"> --}}
                        {{ Form::text('code',null,array('class'=>'form-control','required'=>true)) }}
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-square"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="form-group">
                    {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                </div>
            </div>
        </div>       
        
        {!! Form::close() !!}
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

<script>
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
</script>
@endsection