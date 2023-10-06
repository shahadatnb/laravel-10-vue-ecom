@extends('admin.layouts.layout')
@section('title')
@if($mode=='edit') Edit @else Create New @endif {{ $posttype['postType'] }}
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('assets/admin/plugins/summernote/summernote-bs4.css') }}"> --}}
@endsection
@section('content')
@if ($mode=='edit')
  {!! Form::model($post,['route'=>['posts.update',$post->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
@else
  {!! Form::open(array('route'=>'posts.store','data-parsley-validate'=>'','enctype'=>'multipart/form-data')) !!}
@endif

<div class="row">
  <div class="col-sm-12 col-lg-9">
    <div class="card">
      <div class="card-header">
        <a href="{{ route('posts.index').'?type='.$posttype['postType'] }}" class="btn btn-primary btn-sm">All {{ Str::plural($posttype['postType']) }}</a>
        @if($mode=='edit')<a href="{{ route('posts.create').'?type='.$posttype['postType'] }}" class="btn btn-primary btn-sm">Create New {{ $posttype['postType'] }}</a>@endif	
      </div>
      <div class="card-body">
        @include('admin.layouts._message')
        {{ Form::hidden('post_type', $posttype['postType'] ) }}
        {{ Form::label('title','Title') }}
        {{ Form::text('title',null,array('class'=>'form-control','required'=>'','maxlenth'=>'255')) }}
        @if ($mode=='edit')
        <div class="input-group">
          <span>{{$posttype['postType']}}/</span>          
          {{ Form::text('slug',$post->slug,['class'=>'form-control form-control-sm']) }}
        </div>
        @endif
        {{ Form::label('body','Post Body') }}
        {{ Form::textarea('body',null,array('class'=>'form-control textarea')) }}
        @if(array_key_exists('postMeta',$posttype))
              @foreach ($posttype['postMeta'] as $key=>$meta)
              <div class="form-group row">
                {{ Form::label("postMeta[{$meta['name']}]",$meta['title'],array('class'=>'col-sm-3 col-form-label')) }}
                <div class="col-sm-9">
                @if($mode=='edit')
                  @if(array_key_exists($key,$post->postMeta->toArray()))
                    {{ Form::text("postMeta[{$meta['name']}]",$post->postMeta[$key]->meta_value,array('class'=>'form-control','required'=>$meta['required'] ,'maxlenth'=>'255')) }}
                  @else
                    {{ Form::text("postMeta[{$meta['name']}]",null,array('class'=>'form-control','required'=>$meta['required'],'maxlenth'=>'255')) }}
                  @endif
                @else
                  {{ Form::text("postMeta[{$meta['name']}]",null,array('class'=>'form-control','required'=>$meta['required'],'maxlenth'=>'255')) }}
                @endif
                </div>
              </div>
              @endforeach
          @endif
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-lg-3">
    <div class="card">
      <div class="card-header">Save</div>
      <div class="card-body">{{ Form::submit('Publish',array('class'=>'btn btn-success')) }}</div>
    </div>
    @if ($posttype['taxonomy']==true)
    <div class="card">
      <div class="card-header">Category</div>
      <div class="card-body">
        @foreach ($taxonomy as $item)
          <div class="checkbox">
            <label for="{{$item->id}}" class="form-check-label">
              @if ($mode=='edit')
                {{ Form::checkbox('categories[]', $item->id, in_array($item->id, $post->taxonomy->pluck('id')->toArray()),['id'=>$item->id]) }}
              @else
                <input type="checkbox" name="categories[]" id="{{$item->id}}" value="{{$item->id}}"> 
              @endif
            {{$item->title}}
            </label>
          </div>
          @endforeach
      </div>
    </div>        
    @endif
    <div class="card">
      <div class="card-header">{{ Form::label('image','Thumnail') }}</div>
      <div class="card-body">
        @if ($mode=='edit')
         @if (Str::endsWith(strtolower($post->image), ['.jpg', '.jpeg','.png']))
          <img src="{{ asset('storage/'.$post->image) }}" alt="" class="img-thumbnail">
         @else
            <a target="_blank" href="{{ asset('storage/'.$post->image) }}">Download</a>
         @endif         
        @endif
        <div class="custom-file">
          {{ Form::file('image',null,array('class'=>'form-control custom-file-input')) }}
          <label class="custom-file-label" for="image">Choose file</label>
        </div>
{{-- 
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="filepath">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;"> --}}
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}

@endsection
@section('js')
{{-- <script src="{{ asset('assets/admin/plugins/summernote/summernote-bs4.min.js') }}"> </script> --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"> </script>
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function(){          
        $('.textarea').summernote();
/*
          // Define function to open filemanager window
          var lfm = function(options, cb) {
            var route_prefix = (options && options.prefix) ? options.prefix : '{{ config('app.url') }}/laravel-filemanager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = cb;
          };

          // Define LFM summernote button
          var LFMButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
              contents: '<i class="note-icon-picture"></i> ',
              tooltip: 'Insert image with filemanager',
              click: function() {

                lfm({type: 'image', prefix: '{{ config('app.url') }}/laravel-filemanager'}, function(lfmItems, path) {
                  lfmItems.forEach(function (lfmItem) {
                    context.invoke('insertImage', lfmItem.url);
                  });
                });

              }
            });
            return button.render();
          };

          // Initialize summernote with LFM button in the popover button group
          // Please note that you can add this button to any other button group you'd like
          $('.textarea').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                      ['style', ['style']],
                      ['font', ['bold', 'underline', 'clear']],
                      ['color', ['color']],
                      ['para', ['ul', 'ol', 'paragraph']],
                      ['table', ['table']],
                      ['insert', ['link', 'video']], //picture
                      ['view', ['fullscreen', 'codeview', 'help']],
                      ['popovers', ['lfm']],
                    ],
            buttons: {
              lfm: LFMButton
            }
          });
*/
          bsCustomFileInput.init();

          //$('#lfm').filemanager('image', {prefix: '{{ config('app.url') }}/laravel-filemanager'});
        });
    </script>
@endsection

{{-- 
  
  @php
    $userroles = $user->roles->pluck('id')->toArray();
@endphp

@foreach ($roles as $role)
    <div>
        <input class="checkbox" type="checkbox" name="roles[]" id="check-box-{{$role->id}}" value="{{ $role->id }}" {{ in_array($role->id, $userroles) ? "checked" : "" }} />
        <label for="check-box-{{$role->id}}">{{$role->display_name}}</label>
    </div>
@endforeach 
  
  --}}