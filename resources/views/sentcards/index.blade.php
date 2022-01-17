@extends('layouts.master')
@section('page-header')
Sent Cards
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="#" data-toggle="control-sidebar" class="btn bg-navy btn-xs"><i class="fa fa-search"></i></a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="display responsive nowrap sentcardslist" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Card</th>
                    <th>Delivery</th>
                    <th>Message</th>
                    <th class="no-sort">Detail</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.box-body -->
</div>
@endsection

@include('sentcards.search')

@push('js')
<script type="text/javascript">
$(document).ready(function(){

          var searchParams = new URLSearchParams(window.location.search);
          var url = '{{route("sentcards.index")}}';

          var dt = $('.sentcardslist').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 25,
            "lengthMenu": [ 25, 50, 100, 200 ],
            "searching" : false,
            "stateSave": true,
            "responsive" : true,
            "ajax":{
                     "url": "{{route('sentcards.datasource')}}",
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
                { "data": "card"},
                { "data": "delivery"},
                { "data": "message"},
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
