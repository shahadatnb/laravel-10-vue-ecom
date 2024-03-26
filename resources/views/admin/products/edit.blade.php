@extends('admin.layouts.layout')
@section('title','Product')
@section('css')
  <link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <style>
    img{max-width: 100%}
    #image_row label {position: absolute;}
  </style>
@endsection
@section('content')
  <section class="content">
    <!-- Main content -->    
      {!! Form::model($product,['route'=>['product.products.update',$product->id],'method'=>'PUT', 'files' => true ]) !!}
      <!-- Default card -->
      <div class="row">
      <div class="col-lg-9 col-sm-12">
      <div class="card">
        <div class="card-header with-border">
          @include('admin.layouts._message')
          <div class="row">
            <div class="col-md-9">
              {{ Form::label('title','Title') }}
              {{ Form::text('title',null,['class'=>'form-control']) }} 
              @if($errors->has('title'))
                  <span class="help-block">{{ $errors->first('title') }}</span>
              @endif             
            </div>
            <div class="col-md-3">
              {{ Form::label('weight','Weight (kg)') }} 
              {{ Form::number('weight',null,['class'=>'form-control','step'=>'any']) }} 
              @if($errors->has('weight'))
                  <span class="help-block">{{ $errors->first('weight') }}</span>
              @endif           
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              {{ Form::label('quantity','Quantity') }}
              {{ Form::number('quantity',null,['class'=>'form-control']) }} 
              @if($errors->has('quantity'))
                  <span class="help-block">{{ $errors->first('quantity') }}</span>
              @endif 
            </div>
            <div class="col-md-2">
              {{ Form::label('price','MRP Price') }}
              {{ Form::number('price',null,['class'=>'form-control','required'=>true]) }} 
              @if($errors->has('price'))
                  <span class="help-block">{{ $errors->first('price') }}</span>
              @endif 
            </div>
            <div class="col-md-2">
              {{ Form::label('reduced_price','Discount Price') }}
              {{ Form::number('reduced_price',null,['class'=>'form-control']) }} 
              @if($errors->has('reduced_price'))
                  <span class="help-block">{{ $errors->first('reduced_price') }}</span>
              @endif 
            </div>
            <div class="col-md-2">
              {{ Form::label('discount_percentage','Discount %') }}
              {{ Form::number('discount_percentage',null,['class'=>'form-control', 'min'=>'0', 'max'=>'100']) }} 
              @if($errors->has('discount_percentage'))
                  <span class="help-block">{{ $errors->first('discount_percentage') }}</span>
              @endif 
            </div>
            <div class="col-md-4">
              {{ Form::label('product_type','Product Type') }}
              {{ Form::select('product_type',['simple'=>'Simple','variant'=>'Variant'],null,['class'=>'form-control','required'=>true,'placeholder'=>'Product Type']) }}
            </div>
            <div class="col-md-12">
              {{ Form::label('categories','Product Category') }}
              {{ Form::select('categories[]',$cats,null,['class'=>'form-control select2','multiple'=>'multiple']) }} 
              @if($errors->has('categories'))
                  <span class="help-block">{{ $errors->first('categories') }}</span>
              @endif 
            </div>
            <div class="col-md-6">
              <div class="form-group">
              {{ Form::label('colors','Colors') }}
              {{ Form::select('colors[]',$colors,null,['class'=>'form-control select2','multiple'=>true]) }}
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              {{ Form::label('sizes','Sizes') }}
              {{ Form::select('sizes[]',$sizes,null,['class'=>'form-control select2','multiple'=>true]) }}
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              {{ Form::label('short_description','Short Description') }}
              {{ Form::textarea('short_description',null,['class'=>'form-control','rows'=>'3']) }}
              @if($errors->has('short_description'))
                  <span class="help-block">{{ $errors->first('short_description') }}</span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              {{ Form::label('description','Description') }}
              {{ Form::textarea('description',null,['class'=>'form-control textarea']) }}
              @if($errors->has('description'))
                  <span class="help-block">{{ $errors->first('description') }}</span>
              @endif
            </div>
          </div>
          @if($product->product_type == 'variant')
          <div class="row">
            <div class="col-md-12">
              {{ Form::label('variants','Variants') }}
              <table class="table table-bordered table-striped table-sm" id="variants">
                <thead>
                  <tr>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>S Price</th>
                    <th class="not-exported">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($stocks as $variant)
                  <tr>
                    <td>{{ $variant->color?$variant->color->name:'' }} - {{ $variant->size?$variant->size->name:'' }}</td>
                    <td>{{ $variant->price }}</td>
                    <td>{{ $variant->reduced_price }}</td>
                    <td>
                      <a href="{{ route('product.variant.edit',$variant->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                      <a href="{{ route('product.variant.destroy',$variant->id) }}" class="btn btn-danger btn-xs delete-variant" data-id="{{ $variant->id }}"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
        </div>
        
        <!-- /.card-body -->
      </div>
      <!-- /.card -->        
      </div>
      <div class="col-lg-3 col-sm-12">
        <div class="card card-primary card-outline">
          <div class="card-body">
            {{ Form::submit('Update', ['class'=>'btn btn-success btn-block']) }}
              {{ Form::label('photo','Photo') }}
              {{ Form::file('photo',array('class'=>'form-control','maxlenth'=>'255')) }}
              @if($errors->has('photo'))
                  <span class="help-block">{{ $errors->first('photo') }}</span>
              @endif 
            <img src="{{ asset('storage/'.$product->photo) }}" alt="" class="img-thumbnail">
          </div>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="form-group">
              {{ Form::label('status','Status') }}
              {{ Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control']) }}
            </div>
            <div class="form-group">
              {!! Form::checkbox('featured', 1, null, ['class' => 'form-check-input form-control', 'id' => 'featured']) !!}
              {!! Form::label('featured', 'Featured', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-group">
              {!! Form::checkbox('free_shipping', 1, null, ['class' => 'form-check-input form-control', 'id' => 'free_shipping']) !!}
              {!! Form::label('free_shipping', 'Free Shipping', ['class' => 'form-check-label']) !!}
            </div>
          </div>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-body">
            <label>Photo Gallery</label>
            <ul class="list-group" id="image_row">              
            @foreach ($product->galleries as $item)
            <li id="image_row_{{$item->id}}" class="list-group-item d-flex justify-content-between align-items-center">
              <img src="{{ asset('storage/'.$item->image) }}" width="50" class="img-thumbnail">
              <span type="button" data-id="{{$item->id}}" class="badge badge-danger badge-pill"><i class="fas fa-trash"></i></span>
            </li>
            @endforeach
          </ul>
            {{ Form::file('galleryImage',array('class'=>'form-control','id'=>'galleryImage')) }}
          </div>
        </div>
      </div>
      </div>
        {!! Form::close() !!}
    </section>
 @endsection
    @section('js')
    <script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
      <script>
          $('.textarea').summernote();

          $('#discount_percentage').keyup(function(){
              let discount_percentage = $(this).val();
              if(discount_percentage > 0){
                let price = $('#price').val();
                let discount = (price*discount_percentage)/100;
                let reduced_price = price-discount;
                $('#reduced_price').val(reduced_price);
              }
          });

          $('#price').keyup(function(){
              let price = $(this).val();
              let discount_percentage = $('#discount_percentage').val();
              if(discount_percentage > 0){
                let discount = (price*discount_percentage)/100;
                let reduced_price = price-discount;
                $('#reduced_price').val(reduced_price);                
              }
          });

          $("#image_row").on('click', 'img', function () {
            let src = $(this).attr('src');
            navigator.clipboard.writeText(src);
            $(this).parent().append('<p>Copied.</p>').show().fadeTo(2000, 1, function(){
                $(this).parent().find('p').hide().fadeTo(1000, 0);
                $(this).parent().find('p').remove();
            });
          });

          $('#galleryImage').change(function(){          
          $(this).addClass('d-none');
            let uploadedFile = document.getElementById('galleryImage').files[0];
            var form_data = new FormData();
            form_data.append("image", uploadedFile);
            form_data.append("product_id", {{ $product->id }});
            form_data.append("_token", "{{ csrf_token() }}");            
            $.ajax({
                url: "{{ route('product.gallery.store') }}",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  let image_row = `<li id="image_row_${data.data.id}" class="list-group-item d-flex justify-content-between align-items-center">
                      <img src="{{ asset('storage/')}}/${ data.data.image }" width="50" class="img-thumbnail">
                      <span type="button" data-id="${data.data.id}" class="badge badge-danger badge-pill"><i class="fas fa-trash"></i></span>
                    </li>`;
                    $('#image_row').append(image_row);
                }
            });
            $(this).removeClass('d-none');
          });

          $("#image_row").on("click", "span", function() {
            if (confirm("Are you sure delete?") == true) {
              let id = $(this).data("id");
              $.ajax({
                  url: "{{ route('product.gallery.delete') }}",
                  method: "POST",
                  data: {
                      id: id,
                      _token: "{{ csrf_token() }}"
                  },
                  success: function (data) {
                    $("#image_row #image_row_"+id).remove();
                  }
              });
            }
          });

      </script>
    @endsection