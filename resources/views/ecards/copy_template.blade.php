<div class="row">

    <div class="col-sm-12">

        <div class="row">
            <div class="col-sm-6">

                <div class="form-group">
                    <label>Template Name *</label>
                    {{ Form::text('template_name', null, ['class' => 'form-control', 'id' => 'template_name1']) }}
                    <span class="text-danger small">{{ $errors->first('template_name') }}</span>
                </div>

                <div class="form-group">
                    <input type="hidden" id="ecard_id1" name="ecard_id1" value="{{ $ecard->id }}" />
                </div>

                <div class="form-group">
                    <label>Set Default Template</label>
                    <select id="default1" class="form-control" name="default">
                        <option value="0">NO</option>
                        <option value="11">YES</option>
                    </select>
                    <span class="text-danger small">{{ $errors->first('default') }}</span>
                </div>

            </div>

        </div>

        <div style="color:red; font-size: 20px;" id="autoSave-error1">

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
                        <li class="pull-right"><button id="template-save1" style="float: right;" type="button" class="btn btn-success">Save Template</button></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="desktopview">
                            <div class="form-group">
                                <button class="btn btn-primary" type="button" id="copy-dtom-btn1">Copy Desktop Template
                                    Content to Mobile</button>
                            </div>

                            <div style="background:#fff;" id="card-template-preview">
                                <div id="left-col">
                                    <div style="padding:72.25% 0 0 0;position:relative;">
                                        <iframe
                                        src="https://player.vimeo.com/video/{{$ecard->video}}?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                        style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                                </div>
                                <div id="right-col">
                                    <div id="tinymce-heading1">
                                        {!! $ecard_template_id->template_title !!}
                                    </div>
                                    <div id="tinymce-body1">
                                        {!! $ecard_template_id->template_content !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="mobileview">

                            <div style="background:#fff; padding:30px;" id="mb-card-template-preview">
                                <div style="padding:72.25% 0 0 0;position:relative;">
                                    <iframe
                                    src="https://player.vimeo.com/video/{{$ecard->video}}?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                    frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                    style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                                <div id="mb-tinymce-heading1">
                                    {!! $ecard_template_id->mb_template_title !!}
                                </div>
                                <div id="mb-tinymce-body1">
                                    {!! $ecard_template_id->mb_template_content !!}
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('js')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#copy-dtom-btn1').click(function() {
                var tHeading1 = $('#tinymce-heading1').html();
                var tBody1 = $('#tinymce-body1').html();
                $("#mb-tinymce-heading1").html(tHeading1);
                $("#mb-tinymce-body1").html(tBody1);
            });

            $('#template-save1').click(function() {

                $.ajax({
                    url: '/ecards/copy_template',
                    data: {
                        _token: "{{ csrf_token() }}",
                        template_name: $('#template_name1').val(),
                        ecard_id: $('#ecard_id1').val(),
                        default: $('#default1').val(),
                        template_title: $('#tinymce-heading1').html(),
                        template_content: $('#tinymce-body1').html(),
                        mb_template_title: $('#mb-tinymce-heading1').html(),
                        mb_template_content: $('#mb-tinymce-body1').html()
                    },
                    type: 'POST',
                    success: function(response1) {
                        $('#autoSave1').text("copy template was created successfully.");
                        $('#myModal').modal('toggle');
                        $('#template_name1').val('');

                        setInterval(function() {
                            $('#autoSave1').text('');
                        }, 5000);
                        console.log(response1) // Your response
                    },
                    error: function(error1) {
                        const myJSON1 = JSON.stringify(error1);
                        let obj1 = JSON.parse(myJSON1);
                        let objw1 = JSON.parse(obj1.responseText);
                        const message1 = JSON.stringify(objw1.errors);

                        $('#autoSave-error1').text(message1);

                        setInterval(function() {
                            $('#autoSave-error1').text('');
                        }, 5000);
                        console.log(error1) // No successful request
                    }
                });

            });
        });

        var templateHeaderConfig1 = {
            selector: '#tinymce-heading1',
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

        var templateBodyConfig1 = {
            selector: '#tinymce-body1',
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

        var mbtemplateHeaderConfig1 = {
            selector: '#mb-tinymce-heading1',
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

        var mbtemplateBodyConfig1 = {
            selector: '#mb-tinymce-body1',
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

        tinymce.init(templateHeaderConfig1);
        tinymce.init(templateBodyConfig1);
        tinymce.init(mbtemplateHeaderConfig1);
        tinymce.init(mbtemplateBodyConfig1);
    </script>
@endpush
