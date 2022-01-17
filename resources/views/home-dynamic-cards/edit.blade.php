@extends('layouts.master')
@section('page-header')
    Home Page Dynamic Cards
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Home Page Dynamic Card Edit</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('home-dynamic-cards.index') }}" class="btn btn-danger btn-xs"><i
                        class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::model($dynamic_card, ['method' => 'PATCH', 'action' => ['HomeDynamicCardsController@update', $dynamic_card->id], 'id' => 'create-form', 'files' => true]) !!}

            @csrf

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Card Section Name</label>
                        {{ Form::text('name', null, ['class' => 'form-control', 'value' => '$dynamic_card->name']) }}
                        <span class="text-danger small">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Card ID</label>
                        {{ Form::text('card_link', null, ['class' => 'form-control', 'value' => '$dynamic_card->card_link']) }}
                        <span class="text-danger small">{{ $errors->first('card_link') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Card Categories</label>
                        <select name="category_id" class="form-control">
                            <option value="{{ $dyanmic_card_category->id }}">{{ $dyanmic_card_category->name }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger small">{{ $errors->first('category_id') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Card Image</label>
                        {{ Form::file('card_img', ['id' => 'card_img', 'value' => '$dynamic_card->card_img']) }}
                        <span class="text-danger small">{{ $errors->first('card_img') }}</span>
                        <img src="/img/dynamic-data/{{ $dynamic_card->card_img }}" alt="Card Image" class="thumbnail"
                            width="100" id="image_small_display">
                    </div>
                    <div class="form-group">
                        <label>Card Text Block Background Color</label>
                        {{ Form::color('bg_color', null, ['class' => 'form-control', 'value' => '$dynamic_card->bg_color']) }}
                        <span class="text-danger small">{{ $errors->first('bg_color') }}</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Description Heading</label>
                        {{ Form::text('card_title', null, ['class' => 'form-control', 'value' => '$dynamic_card->card_title']) }}
                        <span class="text-danger small">{{ $errors->first('card_title') }}</span>
                    </div>
                    <div class="form-group">
                        <label>Description Content</label>
                        {{ Form::textarea('card_content', null, ['class' => 'form-control', 'value' => '$dynamic_card->card_content']) }}
                        <span class="text-danger small">{{ $errors->first('card_content') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {{ Form::submit('Update', ['class' => 'btn btn-success']) }}
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            function showCardImg(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_small_display').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#card_img").change(function() {
                showCardImg(this);
            });

        });
    </script>
@endpush
