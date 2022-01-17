<div class="row">

    <div class="col-sm-12">
        <div id="template-div">
            <div id="template-change-form">
                <div class="form-group">
                    <label>Card Template</label>
                    <select class="form-control" id="template_id_new">
                        <option value="{{ $ecard_template_id->id }}">{{ $ecard_template_id->template_name }}
                        </option>
                        @foreach ($ecard_templates as $ecard_template)
                            <option value="{{ $ecard_template->id }}">{{ $ecard_template->template_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger small">{{ $errors->first('template_id_new') }}</span>
                </div>

            </div>
            <div id="button-group-div">
                <button id="copy-modal" type="button" class="btn btn-info btn-lg" data-toggle="modal"
                    data-target="#myModal">Copy Template</button>
                <button id="template-save" style="margin-bottom:20px;" type="button" class="btn btn-success">Update
                    Template</button>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">

                <h4 id="template_name_div">{{ $ecard_template_id->template_name }}</h4>

                <div id="dynamic-id" class="form-group">
                    <input type="hidden" id="ecard_id" value="{{ $ecard->id }}" />
                    <input type="hidden" id="template_id" name="template_id" value="{{ $ecard_template_id->id }}" />
                </div>
            </div>
        </div>

        <div style="color:green; font-size: 20px;" id="autoSave-success">

        </div>
        <div style="color:red; font-size: 20px;" id="autoSave-error">

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#desktopview1" data-toggle="tab"
                                aria-expanded="true">Desktop
                                Template</a>
                        </li>
                        <li class=""><a href=" #mobileview1" data-toggle="tab"
                                aria-expanded="false">Mobile
                                Template</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="desktopview1">
                            <div class="form-group">
                                <button class="btn btn-primary" type="button" id="copy-dtom-btn">Copy Desktop Template
                                    Content to Mobile</button>
                            </div>

                            <div style="background:#fff;" id="card-template-preview">
                                <div id="left-col">
                                    <div style="padding:72.25% 0 0 0;position:relative;">
                                        <iframe
                                            src="https://player.vimeo.com/video/{{ $ecard->video }}?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                                            allowfullscreen
                                            style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe>
                                    </div><script src="https://player.vimeo.com/api/player.js"></script>
                                </div>
                                <div id="right-col">
                                    <div id="tinymce-heading">
                                        {!! $ecard_template_id->template_title !!}
                                    </div>
                                    <div id="tinymce-body">
                                        {!! $ecard_template_id->template_content !!}
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="tab-pane" id="mobileview1">

                            <div style="background:#fff; padding:30px;" id="mb-card-template-preview">
                                <div style="padding:72.25% 0 0 0;position:relative;">
                                    <iframe
                                        src="https://player.vimeo.com/video/{{ $ecard->video }}?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0"
                                        frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
                                        style="position:absolute;top:0%;left:0%;width:100%;height:100%;"></iframe>
                                </div><script src="https://player.vimeo.com/api/player.js"></script>
                                <div id="mb-tinymce-heading">
                                    {!! $ecard_template_id->mb_template_title !!}
                                </div>
                                <div id="mb-tinymce-body">
                                    {!! $ecard_template_id->mb_template_content !!}
                                </div>
                            </div>

                        </div>
                        <button id="save-template" style="display: block;
                        width: 100px;
                        margin: 20px auto;" type="button" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).off('change', '#template_id_new').on('change', '#template_id_new', function() {
                var id = $(this).val();

                $.ajax({
                    url: '/ecard-template/get_template_info/' + id,
                    type: 'GET',
                    success: function(data) {
                        if (data.status == "success") {
                            var template_name = data.template_name;
                            var template_title = data.template_title;
                            var template_content = data.template_content;
                            var mb_template_title = data.mb_template_title;
                            var mb_template_content = data.mb_template_content;

                            $("#tinymce-heading").html(template_title);
                            $("#tinymce-body").html(template_content);
                            $("#mb-tinymce-heading").html(mb_template_title);
                            $("#mb-tinymce-body").html(mb_template_content);
                            $("#template_id").val(id);
                            $("#template_name_div").text(template_name);
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
                    url: '/ecard-template/update_assigned',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $('#template_id').val(),
                        ecard_id: $('#ecard_id').val(),
                        template_title: $('#tinymce-heading').html(),
                        template_content: $('#tinymce-body').html(),
                        mb_template_title: $('#mb-tinymce-heading').html(),
                        mb_template_content: $('#mb-tinymce-body').html()
                    },
                    type: 'POST',
                    success: function(response) {
                        $('#autoSave-success').text("Your template was updated successfully.");
                        setInterval(function() {
                            $('#autoSave-success').text('');
                        }, 3000);
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

            $('#save-template').click(function() {

                $.ajax({
                    url: '/ecard-template/update_assigned',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: $('#template_id').val(),
                        ecard_id: $('#ecard_id').val(),
                        template_title: $('#tinymce-heading').html(),
                        template_content: $('#tinymce-body').html(),
                        mb_template_title: $('#mb-tinymce-heading').html(),
                        mb_template_content: $('#mb-tinymce-body').html()
                    },
                    type: 'POST',
                    success: function(response) {
                        $('#autoSave-success').text("Your template was updated successfully.");
                        setInterval(function() {
                            $('#autoSave-success').text('');
                        }, 3000);
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
