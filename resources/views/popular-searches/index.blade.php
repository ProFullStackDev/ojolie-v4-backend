@extends('layouts.master')
@section('page-header')
Popular Search List
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif        
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap contact-list" width="100%">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th >Keyword</th>
                    <th width="10%">Is New</th>
                    <th width="10%">Sequence</th>
                    <th width="10%">Count</th>
                    <th width="10%">Status</th>
                    <th width="10%">Created at</th>
                    <th width="10%" class="no-sort">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($popular_searches as $popular_search)
                <tr>
                    <td>{{$popular_search->id}}</td>
                    <td>{{$popular_search->keyword}}</td>
                    <td>{!! $popular_search->is_new==1 ? '<span class="text-active">Yes</span>':'<span class="text-inactive">No</span>' !!}</td>
                    <td>{{$popular_search->seq}}</td>
                    <td>{{$popular_search->count}}</td>
                    <td>{!! $popular_search->status==1 ? '<span class="text-active">Active</span>':'<span class="text-inactive">Inactive</span>' !!}</td>
                    <td>{{ \Carbon\Carbon::parse($popular_search->created_at)->format('d-m-Y H:i')}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('popular-searches.edit', ['popular_search' => $popular_search->id]) }}" ><span class="fa fa-edit"></span></a>
                        {!! Form::open(['method'=>'POST','class'=>'inline','url' => ['/popular-searches', $popular_search->id]]) !!}
                        <input type="hidden" name="_method" value="delete">
                        @csrf   

                        <button title="Delete Search Keyword"  onclick="return confirm('Are you sure want to delete this message?')" class="btn btn-danger " type="submit" value="">
                            <span class="fa fa-trash"></span>
                        </button>

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
                 "lengthChange": false
                  "order": [[ 0, "desc" ]]
            }
        );
    });
</script>
@endpush
