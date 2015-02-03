@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="/application/assets/js/tagsinput/jquery.tagsinput.css" />
@stop

@section('content')

<?php $settings = Setting::first(); ?>

<div class="container main_home_container">

    <div class="col-md-8 col-lg-8">

        <form method="POST" action="{{ URL::to('media') }}" id="media-form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
            
            <h2><i class="icon-cloud-upload"></i> {{ Lang::get('lang.upload') }}</h2>

            <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />

            <!-- Select between an image or a video -->
            <div class="btn-group vid-pic" data-toggle="buttons">
              <label class="btn btn-radio active">
                <input type="radio" name="pic" id="pic" checked> <i class="fa fa-picture-o"></i>  {{ Lang::get('lang.image') }}
              </label>
              <label class="btn btn-radio vid-radio-btn">
                <input type="radio" name="vid" id="vid"> <i class="icon-film"></i> {{ Lang::get('lang.video') }}
              </label>
            </div>

            <p><input name="title" class="form-control" type="text" id="title" placeholder="{{ Lang::get('lang.title') }}"></p>

            <select name="category_id" id="category_id" class="form-control">
            <option value="1">{{ Lang::get('lang.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
           
            <div style="clear:both"></div>
            <div id="img_upload" style="padding-left:100px; background:#f1f1f1; padding:15px; margin-top:15px; margin-bottom:15px;">
                <i class="fa fa-picture-o" style="font-size:50px; color:#aaa; float:left"></i>
                <p style="margin-left:65px; margin-bottom:6px;"><input type="file" multiple="true" id="pic_url" name="pic_url" style="" /></p>
                <h4 style="margin-left:65px; padding-top:0px;">{{ Lang::get('lang.or_enter_url') }}</h4>
                <p><input type="text" class="form-control" id="img_url" name="img_url" style="" placeholder="{{ Lang::get('lang.image_url') }}" /></p> 
            </div>

            <div id="vid_upload" style="display:none; padding-left:100px; background:#f1f1f1; padding:15px; margin-top:15px; margin-bottom:15px;">
                <label for="vid_url">
                    <i class="icon-film" style="font-size:50px; color:#aaa; float:left"></i> 
                    <p style="margin-left:65px; margin-bottom:6px; font-weight:normal; margin-top:2px;">{{ Lang::get('lang.add_a_video') }}</p>
                    <h4 style="margin-left:65px; padding-top:0px; margin-top:8px;">{{ Lang::get('lang.add_video_types_below') }}:</h4>
                </label>
                <p><input type="text" name="vid_url" class="form-control" id="vid_url" placeholder="{{ Lang::get('lang.add_url_here') }}" /></p>
            </div>
            
            @if($settings->media_description)
                <p><textarea name="description" class="form-control" id="description" placeholder="{{ Lang::get('lang.description') }}"></textarea></p>   
            @endif

            <p><input name="link_url" class="form-control" type="text" id="link_url" placeholder="{{ Lang::get('lang.source_optional') }}" /></p>
            
            <p><input name="tags" class="form-control" id="tags" placeholder="{{ Lang::get('lang.tags_optional') }}" /></p>      
            
            <p>
                <label for="nsfw">{{ Lang::get('lang.nsfw') }}</label>

                @if(isset($item->nsfw))<?php $nsfw = $item->nsfw ?>@else<?php $nsfw = 0 ?>@endif
                    {{ Form::checkbox('nsfw', '', $nsfw, array('class' => 'onoffswitch-checkbox', 'id' => 'nsfw')) }}                      
                    
            </p>

            <input class="btn btn-color submit-media" type="submit" value="{{ Lang::get('lang.submit') }}">



        </form>

        @if ($errors->any())
        	<ul style="margin:0px; padding:0px;">
        		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
        	</ul>
        @endif

    </div>

    @include('includes.sidebar')

</div>

<script type="text/javascript" src="/application/assets/js/tagsinput/jquery.tagsinput.js"></script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#tags').tagsInput();

        $('#img_url').keyup(function (){
            console.log($(this).val());
            if($(this).val() != ''){
                $('#pic_url').attr('disabled', 'true');
            } else {
                $('#pic_url').removeAttr('disabled');
            }
        });

        $('.vid-pic input').change(function(){
            if($(this).attr('id') == 'pic'){
                $('#img_upload').show();
                $('.drop_container').show();
                $('#import-fb').show();
                $('.img-drop').show();
                $('#vid_upload').hide();
            } else{
                console.log('hit');
                $('#vid_upload').show();
                $('#img_upload').hide();
                $('#import-fb').hide();
                $('.img-drop').hide();
                $('.drop_container').hide();
            }
        });


        $('.submit-media').click(function(){
            $('#media-form').submit();
        });
    });

</script>

@stop


