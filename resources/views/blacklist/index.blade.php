@extends('layouts.master')
@section('page-header')
Blacklist
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('blacklist.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th class="no-sort">Edit</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($black_lists as $black_list)
                <tr>
                    <td>
                        <p>{{$black_list->id}}</p>
                    </td>
                    <td>
                        <p>{{$black_list->email}}</p>
                    </td>
                    <td>
                        <p>{{$black_list->created_at}}</p>
                    </td>
                    <td>
                        <a href="/blacklist/{{$black_list->id}}/edit" title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/blacklist/delete', $black_list->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to remove this email from blacklist?')" class="btn btn-danger" type="submit" value="Delete" />

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
