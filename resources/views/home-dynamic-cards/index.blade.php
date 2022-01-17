@extends('layouts.master')
@section('page-header')
Home Page Dynamic Cards
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Home Page Dynamic Cards List</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('home-dynamic-cards.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Card Image</th>
                    <th>Card Section Name</th>
                    <th>Card ID</th>
                    <th>Text Block Bg Color</th>
                    <th>Created At</th>
                    <th class="no-sort">Edit</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dynamic_cards as $dynamic_card)
                <tr>
                    <td>
                        <p>{{$dynamic_card->id}}</p>
                    </td>
                    <td>
                        <img style="width:80px;" src="/img/dynamic-data/{{$dynamic_card->card_img}}"/>
                    </td>
                    <td>
                        <p>{{$dynamic_card->name}}</p>
                    </td>
                    <td>
                        <p>{{$dynamic_card->card_link}}</p>
                    </td>
                    <td>
                        <div style="width:20px; height:20px; border-radius:50%; background: {{$dynamic_card->bg_color}};">

                        </div>
                        <p>{{$dynamic_card->bg_color}}</p>
                    </td>
                    <td>
                        <p>{{$dynamic_card->created_at}}</p>
                    </td>
                    <td>
                    <a href="/home-dynamic-cards/{{$dynamic_card->id}}/edit" title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/home-dynamic-cards/delete', $dynamic_card->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to delete this card?')" class="btn btn-danger" type="submit" value="Delete" />

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
