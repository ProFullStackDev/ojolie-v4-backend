@extends('layouts.master')
@section('page-header')
Premium Subscription Type List
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('premium-subscription-type.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap pricing-list" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">Subscription Type</th>
                    <th>Created At</th>
                    <th class="no-sort">Edit</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pricing_lists as $pricing_list)
                <tr>
                    <td>
                        <p>{{$pricing_list->subscription_type}}</p>
                    </td>
                    <td>
                        <p>{{$pricing_list->created_at}}</p>
                    </td>
                    <td>
                        <a href="/premium-subscription-type/{{$pricing_list->id}}/edit" title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/premium-subscription-type/delete', $pricing_list->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to delete this subscription type?')" class="btn btn-danger" type="submit" value="Delete" />

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
