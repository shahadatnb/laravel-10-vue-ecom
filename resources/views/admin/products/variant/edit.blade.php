@extends('admin.layouts.layout')
@section('title','Product Variant Edit')
@section('content')
  <section class="content">
    <!-- Main content -->   
      
      <!-- Default card -->
      <div class="card">
        <div class="card-header with-border">
          <h3 class="card-title">Edit</h3>
          <div class="card-tools">
            <a href="{{route('product.products.edit',$productStock->product_id)}}" class="btn btn-primary btn-sm"> <i class="fas fa-arrow-left"></i> Back</a>
          </div>
        </div>
          @include('admin.layouts._message')          
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              {!! Form::model($productStock,['route'=>['product.variant.update',$productStock], 'files' => true ]) !!}
              <div class="form-group">
                  {{ Form::label('price','Price') }}
                  {{ Form::number('price',null,['class'=>'form-control','placeholder'=>'Price']) }}
              </div>
              <div class="form-group">
                  {{ Form::label('reduced_price','Reduced Price') }}
                  {{ Form::number('reduced_price',null,['class'=>'form-control','placeholder'=>'Reduced Price']) }}
              </div>
              <div class="form-group">
                  {{ Form::label('quantity','Quantity') }}
                  {{ Form::number('quantity',null,['class'=>'form-control','placeholder'=>'Quantity']) }}
              </div>
                <div class="form-group">
                  {{ Form::submit('Submit', ['class'=>'btn btn-primary btn-block']) }} 
                </div> 
              {!! Form::close() !!}
            </div>
            <div class="col-md-5">
              <div class="card card-primary card-outline">
                <div class="card-body">
                  <label>Photo Gallery</label>
                  <ul class="list-group" id="image_row">              
                  @foreach ($productStock->galleries as $item)
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
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
 @endsection
 @section('js')
      <script>

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
            form_data.append("product_id", {{ $productStock->product_id }});
            form_data.append("color_id", {{ $productStock->color_id }});
            form_data.append("_token", "{{ csrf_token() }}");            
            $.ajax({
                url: "{{ route('product.variant.gallery.store') }}",
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
                  url: "{{ route('product.variant.gallery.delete') }}",
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