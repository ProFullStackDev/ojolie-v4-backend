@extends('layouts.master')
@section('page-header')
Newsletter Subscription List
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>

    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap mailing-list" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subscriber Email</th>
                    <th>Sent at</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mailing_lists as $mailing_list)
                <tr>
                    <td>
                        <p>{{$mailing_list->id}}</p>
                    </td>
                    <td>
                        <p><a href="mailto:{{$mailing_list->email}}">{{$mailing_list->email}}</a></p>
                    </td>
                    <td>
                        <p>{{$mailing_list->created_at}}</p>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/newsletter-subscription/delete', $mailing_list->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to delete this email?')" class="btn btn-danger" type="submit" value="Delete" />

                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div><!-- /.box-body -->
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $("#dynamic-table").DataTable(
            {
                "pageLength": 25,
                "lengthMenu": [25, 50, 100, 200],
            }
        );
    });
</script>
@endpush
