@extends('layouts.master')
@section('page-header')
    E Cards Update
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
            <div style="color:green; font-size: 20px;" id="autoSave1">

            </div>
            <div class="box-tools pull-right">
                <a href="{{ route('ecards.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>
                    Cancel</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


            <div id="myModal" class="modal fade" role="dialog">
                <div id="copy-modal-box" class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" style="float: right;" class="btn btn-default"
                                data-dismiss="modal">x</button>
                            <h4 class="modal-title">Add New Template</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::model($formdata, ['method' => 'PUT', 'route' => ['ecards.copy_template', $ecard->id], 'id' => 'card-form']) !!}
                            @include('ecards.copy_template')
                            {{ Form::close() }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="float: right;" class="btn btn-default"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <div id="autoSave">

            </div>
            {!! Form::model($formdata, ['method' => 'PATCH', 'files' => true, 'route' => ['ecards.update', $ecard->id], 'id' => 'card-form']) !!}

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a id="info-btn" href="#info" data-toggle="tab" aria-expanded="true">Card
                            Information</a>
                    </li>
                    <li class=""><a id="cat-btn" href=" #category" data-toggle="tab"
                            aria-expanded="false">Categories</a></li>
                    <li class=""><a id="template-form-open" href=" #template" data-toggle="tab"
                            aria-expanded="false">Assign Template</a></li>
                    <li class="pull-right">
                        {{ Form::submit('Update Card', ['class' => 'btn btn-success', 'id' => 'card-update-btn']) }}</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="info">
                        @include('ecards.info_form_update')
                    </div>
                    <div class="tab-pane" id="category">
                        @include('ecards.category_form_update')
                    </div>
                    <div class="tab-pane" id="template">
                        @include('ecards.assign_template')
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            // $('#upload').on('click', function() {

            //     var id = $('#id').val();
            //     var caption = $('#caption').val();
            //     var filename = $('#filename').val();
            //     var detail = $('#detail').val();
            //     var greetings = $('#greetings').serialize();
            //     var active = $('#active').val();
            //     var private = $('#private').val();
            //     var video = $('#video').val();
            //     var image_small = $('#image_small').prop('files')[0];
            //     var image_large = $('#image_large').prop('files')[0];
            //     var token = "{{ csrf_token() }}";
            //     var template_id = $('#template_id').val();
            //     var template_title = $('#tinymce-heading').html();
            //     var template_content = $('#tinymce-body').html();
            //     var mb_template_title = $('#mb-tinymce-heading').html();
            //     var mb_template_content = $('#mb-tinymce-body').html();
            //     var ecard_categories = $('.categories:checked').serialize();
            //     var form_data = new FormData();
            //     form_data.append('id', id);
            //     form_data.append('caption', caption);
            //     form_data.append('filename', filename);
            //     form_data.append('detail', detail);
            //     form_data.append('greetings', greetings);
            //     form_data.append('active', active);
            //     form_data.append('private', private);
            //     form_data.append('video', video);
            //     form_data.append('image_small', image_small);
            //     form_data.append('image_large', image_large);
            //     form_data.append('ecard_categories', ecard_categories);
            //     form_data.append('template_id', template_id);
            //     form_data.append('template_title', template_title);
            //     form_data.append('template_content', template_content);
            //     form_data.append('mb_template_title', mb_template_title);
            //     form_data.append('mb_template_content', mb_template_content);
            //     form_data.append('mb_template_title', mb_template_title);

            //     alert(form_data);
            //     $.ajax({
            //         url: 'upload.php',
            //         dataType: 'text',
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         data: form_data,
            //         type: 'post',
            //         success: function(php_script_response) {
            //             alert(
            //             php_script_response);
            //         }
            //     });
            // });

            $("#template-form-open").click(function() {
                $('#card-update-btn').css("display", "none");
            });
            $("#cat-btn").click(function() {
                $('#card-update-btn').css("display", "block");
            });
            $("#info-btn").click(function() {
                $('#card-update-btn').css("display", "block");
            });
        });
    </script>
@endpush
