@extends('layouts.master')
@section('page-header')
Users
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
            <a href="#" data-toggle="control-sidebar" class="btn bg-navy btn-xs"><i class="fa fa-search"></i></a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="users" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active/Status</th>
                    <th class="no-sort">Options</th>
                </tr>
            </thead>
        </table>
    </div><!-- /.box-body -->
</div>
@endsection

@include('users.search')

@push('js')
<script type="text/javascript">
$(document).ready(function(){

          var searchParams = new URLSearchParams(window.location.search);
          var url = '{{route("users.index")}}';

          var dt = $('#users').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "lengthMenu": [ 25, 50, 75, 100, 200 ],
            "searching" : false,
            "stateSave": true,
            "responsive" : true,
            "ajax":{
                     "url": "{{route('users.datasource')}}",
                     "dataType": "json",
                     "type": "POST",
                     "data":function(d)
                     {
                        d._token = "{{csrf_token()}}";
                        for (var p of searchParams) {
                          d[p[0]] = p[1];
                        }
                     }
                   },
            "columns": [
                { "data": "id"},
                { "data": "name"},
                { "data": "email"},
                { "data": "active"},
                { "data": "options"}
            ],
            "order": [[ 0, "desc" ]],
            "columnDefs": [
              {"targets"  : 'no-sort',"orderable": false},
              {"targets"  : [4],"responsivePriority": -1},
            ]
        });

        $("#search").click(function(){
            var form = $("form[name='search_form']");
            for(var input of form[0])
            {
                searchParams.set(input['name'],input['value']);
            }

            window.history.replaceState(null, null, url+"?"+searchParams.toString());
            dt.draw();
            $("#close-sidebar").click();
        });
});
</script>
@endpush
