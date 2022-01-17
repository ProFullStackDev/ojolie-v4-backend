@extends('layouts.master')
@section('page-header')
Pages
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">
            <a href="{{ route('pages.create') }}" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="pages" class="display responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Keywords</th>
                    <th class="no-sort">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->name}}</td>
                    <td>{{$page->title}}</td>
                    <td>{{$page->description}}</td>
                    <td>{{$page->keywords}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('pages.edit',$page->id)}}" title="Edit" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
                            <a href="{{route('pages.destroy',$page->id)}}" title="Delete" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></a>
                        </div>
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
$(document).ready(function(){
    $("#pages").DataTable();
});  
</script>
@endpush