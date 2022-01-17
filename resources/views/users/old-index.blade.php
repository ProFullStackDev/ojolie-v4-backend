@extends('layouts.master')
@section('page-header')
Users List
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap pricing-list" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active/Status</th>
                    <th class="no-sort">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <p>{{$user->id}}</p>
                    </td>
                    <td>
                        <p>{{$user->getFullName()}}</p>
                    </td>
                    <td>
                        <p>{{$user->email}}</p>
                    </td>
                    <td>
                        <p>{{optional($user->activereference)->name}}</p>
                    </td>
                    <td>
                        <a href="/users/{{$user->id}}/edit" title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
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
                "order": [[ 0, "desc" ]],
                "lengthMenu": [25, 50, 100, 200],
            }
        );
    });
</script>
@endpush
