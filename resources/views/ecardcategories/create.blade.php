@extends('layouts.master')
@section('page-header')
Ecard Categories Create
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('ecardcategories.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Cancel</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{Form::open(['route'=>'ecardcategories.store','files'=>true])}}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Name</label>
                    {{Form::text('name',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('name')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Page Title</label>
                    {{Form::text('page_title',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('page_title')}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Slug</label>
                    {{Form::text('slug',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('slug')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Meta Keyword</label>
                    {{Form::text('meta_keyword',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('meta_keyword')}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Header Description</label>
                    {{Form::textarea('header_descripion',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('header_descripion')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Page Description</label>
                    {{Form::textarea('page_description',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('page_description')}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Parent Category</label>
                    {{Form::select('parent_id',$ecard_categories,null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('parent_id')}}</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Header Color</label>
                    {{Form::color('header_color',null,['class'=>'form-control'])}}
                    <span class="text-danger small">{{$errors->first('header_color')}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Header Image</label>
                    {{Form::file('header_image',['id'=>'header_image'])}}
                    <span class="text-danger small">{{$errors->first('header_image')}}</span>
                </div>
                <img src="#" alt="Header Image" class="img-responsive thumbnail" id="header_image_display" />
            </div>
            <div class="col-sm-6">
                {{Form::submit('Save',['class'=>'btn btn-success'])}}
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        function showImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#header_image_display').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#header_image").change(function() {
            showImage(this);
        });

        function slugify(text) {
            return text
                .toString() // Cast to string
                .toLowerCase() // Convert the string to lowercase letters
                .normalize('NFD') // The normalize() method returns the Unicode Normalization Form of a given string.
                .trim() // Remove whitespace from both sides of a string
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

    });
</script>
@endpush
