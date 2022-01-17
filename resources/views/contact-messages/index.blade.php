@extends('layouts.master')
@section('page-header')
Contact Messages List
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap contact-list" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sender Name</th>
                    <th>Sender Email</th>
                    <th>Message</th>
                    <th>Sent at</th>
                    <th class="no-sort">View Message</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contact_messages as $contact_message)
                <tr>
                    <td>
                        <p>{{$contact_message->id}}</p>
                    </td>
                    <td>
                        <p>{{$contact_message->name}}</p>
                    </td>
                    <td>
                        <p><a href="mailto:{{$contact_message->email}}">{{$contact_message->email}}</a></p>
                    </td>
                    <td>
                        <p>{{ substr($contact_message->message, 0,  20) }}</p>
                    </td>
                    <td>
                        <p>{{$contact_message->created_at}}</p>
                    </td>
                    <td>
                        <a href="/contact-messages/{{$contact_message->id}}/detail" title='View' class='btn btn-default btn-xs'>View Message</a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/contact-messages/delete', $contact_message->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to delete this message?')" class="btn btn-danger" type="submit" value="Delete" />

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
        $(".contact-list").DataTable(
            {
                "pageLength": 25,
                "lengthMenu": [25, 50, 100, 200],
            }
        );
    });
</script>
@endpush
