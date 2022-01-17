@extends('layouts.master')
@section('page-header')
    Cards Template
@endsection
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Cards Template List</h3>
            <div class="box-tools pull-right">
                <a href="{{ route('ecard-template.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i>
                    Add New</a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="dynamic-table" class="template-table display responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Template Name</th>
                        <th>Default Template</th>
                        <th>Created At</th>
                        <th class="no-sort">Edit</th>
                        <th class="no-sort">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($card_templates as $card_template)
                        <tr>
                            <td>
                                <p>{{ $card_template->id }}</p>
                            </td>
                            <td>
                                <p>{{ $card_template->template_name }}</p>
                            </td>
                            <td>
                                @if($card_template->default == 1)
                                <p>YES</p>
                                @elseif ($card_template->default != 1)
                                <p>NO</p>
                                @endif
                            </td>
                            <td>
                                <p>{{ $card_template->created_at }}</p>
                            </td>
                            <td>
                                <a href="/ecard-template/{{ $card_template->id }}/edit" title='Edit'
                                    class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
                            </td>
                            <td>
                                @if($card_template->default == 1)
                                <button type="button" disabled class="btn btn-danger">Delete</button>
                                @elseif ($card_template->default != 1)
                                {!! Form::open(['method' => 'get', 'url' => ['/ecard-template/delete', $card_template->id]]) !!}
                                @csrf

                                <input onclick="return confirm('Are you sure want to delete this template?')"
                                    class="btn btn-danger" type="submit" value="Delete" />

                                {{ Form::close() }}
                                @endif

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
        $(".template-table").DataTable(
            {
                "pageLength": 25,
                "lengthMenu": [25, 50, 100, 200],
            }
        );
    });
</script>
@endpush
