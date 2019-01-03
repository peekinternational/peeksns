@extends('admin.layouts.app')

@if($rPath == 'edit')
    @section('title', 'Update News')
@else
    @section('title', 'Add News')
@endif
@section('content')
<?php 
$featuredImage = '';
if($cpage['featuredImage'] != ''){
    $featuredImage = url('featured-photos/'.$cpage['featuredImage']);
}
?>
    <div class="layout-content">
        <div class="layout-content-body">
            <div class="title-bar">
                <h1 class="title-bar-title">
                    <span class="d-ib"> {{ $rPath == 'edit' ? 'Update News' : 'Add News' }}</span>
                    <a href="{{ url('admin/cms/pages') }}" class="btn btn-default pull-right">Back</a>
                </h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('admin.includes.alerts')
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" class="form-horizontal page-form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="pageId" value="{{ $pageId }}">
                              
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">News Title</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="title"  value="{{ $cpage['title'] }}">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-md-2 text-right">News Resource</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="news_resource"  value="{{ $cpage['news_resource'] }}" placeholder="Movie Source Example: (youtube.com, vimeo.com, site.com/video.mp4)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">News Category</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="news_category"  value="{{ $cpage['news_category'] }}" placeholder="Movie Source Example: (youtube.com, vimeo.com, site.com/video.mp4)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">News Detail    </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="newsData" id="page_editor">{{ $cpage['newsData'] }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">Featured Image</label>
                                    <div class="col-md-8">
                                        <div class="input-group input-group-file">
                                            <input class="form-control p-image" readonly="" type="text">
                                            <span class="input-group-btn">
                                                <label class="btn btn-primary file-upload-btn">
                                                    <input name="featuredImage" class="file-upload-input" type="file" onchange="getFileName(this)">
                                                    <span class="icon icon-image icon-lg"></span>
                                                </label>
                                            </span>
                                        </div>
                                        <p class="help-block">Format supported (png,jpeg,jpg,gif)</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">&nbsp;</label>
                                    <div class="col-md-8">
                                        <span style="background-color: #f8f8f8;padding: 10px;text-align: center;display: block;">
                                            <img src="{{ $featuredImage }}" alt="" style="max-width: 200px;">
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 text-right">&nbsp;</label>
                                    <div class="col-md-8">
                                        <button class="btn btn-block btn-primary do-save" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('page-footer')
<script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    CKEDITOR.replace('page_editor',{
        height: '400px',
        toolbar: [
            { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
            { name: 'styles', items: [ 'Styles', 'Format' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'insert', items: [ 'Image', 'EmbedSemantic', 'Table' ] },
        ],
    });
})
function getFileName(obj){
    var vValue = $(obj).val();
    vValue = vValue.replace("C:\\fakepath\\",'');
    $('.p-image').val(vValue);
}
function changeTxt(text){
    $('.page-form .slug').val(getSlug(text));
}
function getSlug(text){
    return text
        .toLowerCase()
        .replace(/& /g,'')
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'');
}
$('form.page-form').submit(function(e){
    $('.page-form .do-save').prop('disabled',true);
    $('.page-form .do-save').addClass('spinner spinner-inverse');
})
</script>
@endsection