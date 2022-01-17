@extends('layouts.master')
@section('page-header')
Home Page Dynamic Video
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('dynamic-video.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="dynamic-table" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Video ID</th>
                    <th>Date</th>
                    <th class="no-sort">Edit</th>
                    <th class="no-sort">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dynamic_videos as $dynamic_video)
                <tr>
                    <td>
                        <p>{{$dynamic_video->id}}</p>
                    </td>
                    <td>
                        <p>{{$dynamic_video->video}}</p>
                    </td>
                    <td>
                        <p>{{$dynamic_video->created_at}}</p>
                    </td>
                    <td>
                        <a href="/dynamic-video/{{$dynamic_video->id}}/edit" title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'get', 'url' => ['/dynamic-video/delete', $dynamic_video->id]]) !!}
                        @csrf

                        <input onclick="return confirm('Are you sure want to delete this video ID?')" class="btn btn-danger" type="submit" value="Delete" />

                        {{ Form::close() }}
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>
@endsection
