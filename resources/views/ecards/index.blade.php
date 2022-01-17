@extends('layouts.master')
@section('page-header')
E Cards
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('ecards.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
            <a href="#" data-toggle="control-sidebar" class="btn bg-navy btn-xs"><i class="fa fa-search"></i></a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="cards" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Filename</th>
                    <th>Caption</th>
                    <th>Active</th>
                    <th>Private</th>
                    <th class="no-sort">Options</th>
                </tr>
            </thead>
        </table>
    </div><!-- /.box-body -->
</div>
@endsection

@include('ecards.search')

@push('js')
<script type="text/javascript">
    $(document).ready(function() {

        var searchParams = new URLSearchParams(window.location.search);
        var url = '{{route("ecards.index")}}';

        var dt = $('#cards').DataTable({
            "processing": true,
            "pageLength": 25,
            "lengthMenu": [ 25, 50, 100, 200 ],
            "serverSide": true,
            "searching": false,
            "stateSave": true,
            "responsive": true,
            "ajax": {
                "url": "{{route('ecards.datasource')}}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d._token = "{{csrf_token()}}";
                    for (var p of searchParams) {
                        d[p[0]] = p[1];
                    }
                }
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "thumbnail"
                },
                {
                    "data": "filename"
                },
                {
                    "data": "caption"
                },
                {
                    "data": "active"
                },
                {
                    "data": "private"
                },
                {
                    "data": "options"
                }
            ],
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                },
                {
                    "targets": [6],
                    "responsivePriority": -1
                },
            ]
        });

        $("#search").click(function() {
            var form = $("form[name='search_form']");
            for (var input of form[0]) {
                searchParams.set(input['name'], input['value']);
            }

            window.history.replaceState(null, null, url + "?" + searchParams.toString());
            dt.draw();
            $("#close-sidebar").click();
        });

    });

</script>
@endpush
