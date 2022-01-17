@extends('layouts.master')
@section('page-header')
    Card Template Create
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Card Template Create</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('ecard-template.index') }}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>
                    Cancel</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['url' => '/ecard-template/add', 'id' => 'create-form']) !!}

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Template Name *</label>
                        {{ Form::text('template_name', null, ['class' => 'form-control', 'id' => 'template_name']) }}
                        <span class="text-danger small">{{ $errors->first('template_name') }}</span>
                    </div>

                    <div class="form-group">
                        <label>Select Cards</label>
                        <select id="ecard_id" class="js-example-basic-single form-control" name="ecard_id">
                            <option value="">Choose card to assign this template</option>
                            @foreach ($ecards as $ecard)
                                <option value="{{ $ecard->id }}">{{ $ecard->caption }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Set Default Template</label>
                        <select id="default" class="form-control" name="default">
                            <option value="0">NO</option>
                            <option value="11">YES</option>
                        </select>
                        <span class="text-danger small">{{ $errors->first('default') }}</span>
                    </div>

                </div>

            </div>

            <button id="template-save" style="margin-bottom:20px;margin-left:0px;" type="button" class="btn btn-success">Save</button>

            <div style="color:green; font-size: 20px;" id="autoSave">

            </div>
            <div style="color:red; font-size: 20px;" id="autoSave-error">

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#desktopview" data-toggle="tab" aria-expanded="true">Desktop
                                    Template</a>
                            </li>
                            <li class=""><a href=" #mobileview" data-toggle="tab" aria-expanded="false">Mobile
                                Template</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="desktopview">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="button" id="copy-dtom-btn">Copy Desktop Template Content to Mobile</button>
                                </div>

                                <div style="background:#fff;" id="card-template-preview">
                                    <div id="left-col">
                                        <div id="video-div" style="padding:72.25% 0 0 0;position:relative;">
                                            <iframe
                                            src="https://player.vimeo.com/video/82463776?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                            style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                                    </div>
                                    <div id="right-col">
                                        <div id="tinymce-heading">
                                            <h3 style="text-align:center;" id="title-font"><span style="font-size:40px;font-family:AlexBrush-Regular;">YOUR GREETING GOES HERE</span></h2>
                                        </div>
                                        <div id="tinymce-body">
                                            <p style="text-align:center;" id="content-font">
                                                <span style="font-family:AlexBrush-Regular;font-size:22px;">
                                                Personalize this card with your own message. You can write as much as you
                                                like
                                                and the message area will expand to fit your text.
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="mobileview">

                                <div style="background:#fff; padding:30px;" id="mb-card-template-preview">
                                    <div id="mb-video-div" style="padding:72.25% 0 0 0;position:relative;">
                                        <iframe
                                            src="https://player.vimeo.com/video/82463776?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                            style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                                    <div id="mb-tinymce-heading">
                                        <h3 style="text-align:center;" id="mb-title-font"><span style="font-size:40px;font-family:AlexBrush-Regular;">YOUR GREETING GOES HERE</span></h3>
                                    </div>
                                    <div id="mb-tinymce-body">
                                        <p style="text-align:center;" id="mb-content-font">
                                            <span style="font-size:22px;font-family:AlexBrush-Regular;">
                                            Personalize this card with your own message. You can write as much as you like
                                            and
                                            the message area will expand to fit your text.
                                            </span>
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>
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

            $(document).off('change', '#ecard_id').on('change', '#ecard_id', function() {
            var id = $(this).val();

            $.ajax({
                  url: '/ecard-template/get_card_info/' + id,
                  type: 'GET',
                  success: function(data) {
                    if(data.status=="success"){

                        var video_id = data.video;
                        var videoLink = '<iframe src="https://player.vimeo.com/video/'+video_id+'?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe>';
                        $("#video-div").html(videoLink);
                        $("#mb-video-div").html(videoLink);
                    }
                  }
                });

            });

            $('#copy-dtom-btn').click(function() {
                var tHeading = $('#tinymce-heading').html();
                var tBody = $('#tinymce-body').html();
                $("#mb-tinymce-heading").html(tHeading);
                $("#mb-tinymce-body").html(tBody);
            });

            $('#template-save').click(function() {

                    $.ajax({
                    url: '/ecard-template/add',
                    data: {
                        _token: "{{ csrf_token() }}",
                        template_name: $('#template_name').val(),
                        ecard_id: $('#ecard_id').val(),
                        default: $('#default').val(),
                        template_title: $('#tinymce-heading').html(),
                        template_content: $('#tinymce-body').html(),
                        mb_template_title: $('#mb-tinymce-heading').html(),
                        mb_template_content: $('#mb-tinymce-body').html()
                    },
                    type: 'POST',
                    success: function(response) {
                        $('#autoSave').text("Your template was created successfully.");
                        setInterval(function() {
                            $('#autoSave').text('');
                            location.href = "/ecard-template";
                        }, 2000);
                        console.log(response) // Your response
                    },
                    error: function(error) {
                        const myJSON = JSON.stringify(error);
                        let obj = JSON.parse(myJSON);
                        let objw = JSON.parse(obj.responseText);
                        const message = JSON.stringify(objw.errors);

                        $('#autoSave-error').text(message);
                        setInterval(function() {
                            $('#autoSave-error').text('');
                        }, 5000);
                        console.log(error) // No successful request
                    }
                });


            });
        });

        var templateHeaderConfig = {
            selector: '#tinymce-heading',
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'autolink',
            ],
            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull'
            ],
            valid_elements: 'h3[style],strong,em,span[style],a[href]',
            valid_styles: {
                '*': 'font-size,font-family,font-style,color,text-decoration,text-align'
            },
            fontsize_formats: "36px 38px 40px 42px 44px 46px 48px",
            font_formats: "AlexBrush-Regular;Amiri-Regular;Corben-Regular;Dancing Script;MarketingScript;petitformalscript-regular-webfont;Philosopher-Regular;PlayfairDisplaySC-Regular;Quicksand-Regular;JosefinSlab-Regular;Niconne-Regular;Parisienne-Regular;PinyonScript-Regular;PoiretOne-Regular;Raleway-Regular;Rochester-Regular;Sacramento-Regular;Satisfy-Regular;OpenSans-Regular;",
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
        };

        var templateBodyConfig = {
            selector: '#tinymce-body',
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'autolink',
            ],
            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ],
            valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li',
            valid_styles: {
                '*': 'font-size,font-family,font-style,color,text-decoration,text-align'
            },
            fontsize_formats: "16px 18px 20px 22px 24px 26px 28px",
            font_formats: "AlexBrush-Regular;Amiri-Regular;Corben-Regular;Dancing Script;MarketingScript;petitformalscript-regular-webfont;Philosopher-Regular;PlayfairDisplaySC-Regular;Quicksand-Regular;JosefinSlab-Regular;Niconne-Regular;Parisienne-Regular;PinyonScript-Regular;PoiretOne-Regular;Raleway-Regular;Rochester-Regular;Sacramento-Regular;Satisfy-Regular;OpenSans-Regular;",
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
        };

        var mbtemplateHeaderConfig = {
            selector: '#mb-tinymce-heading',
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'autolink',
            ],
            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull'
            ],
            valid_elements: 'h3[style],strong,em,span[style],a[href]',
            valid_styles: {
                '*': 'font-size,font-family,font-style,color,text-decoration,text-align'
            },
            fontsize_formats: "36px 38px 40px 42px 44px 46px 48px",
            font_formats: "AlexBrush-Regular;Amiri-Regular;Corben-Regular;Dancing Script;MarketingScript;petitformalscript-regular-webfont;Philosopher-Regular;PlayfairDisplaySC-Regular;Quicksand-Regular;JosefinSlab-Regular;Niconne-Regular;Parisienne-Regular;PinyonScript-Regular;PoiretOne-Regular;Raleway-Regular;Rochester-Regular;Sacramento-Regular;Satisfy-Regular;OpenSans-Regular;",
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
        };

        var mbtemplateBodyConfig = {
            selector: '#mb-tinymce-body',
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'autolink',
            ],
            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ],
            valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li',
            valid_styles: {
                '*': 'font-size,font-family,font-style,color,text-decoration,text-align'
            },
            fontsize_formats: "16px 18px 20px 22px 24px 26px 28px",
            font_formats: "AlexBrush-Regular;Amiri-Regular;Corben-Regular;Dancing Script;MarketingScript;petitformalscript-regular-webfont;Philosopher-Regular;PlayfairDisplaySC-Regular;Quicksand-Regular;JosefinSlab-Regular;Niconne-Regular;Parisienne-Regular;PinyonScript-Regular;PoiretOne-Regular;Raleway-Regular;Rochester-Regular;Sacramento-Regular;Satisfy-Regular;OpenSans-Regular;",
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
        };

        tinymce.init(templateHeaderConfig);
        tinymce.init(templateBodyConfig);
        tinymce.init(mbtemplateHeaderConfig);
        tinymce.init(mbtemplateBodyConfig);
    </script>
@endpush
