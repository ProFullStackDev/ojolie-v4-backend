@extends('layouts.master')
@section('page-header')
E Cards Sort
<span id="spinner">

</span>
@endsection
@section('content')
<div class="box box-default ecard-sorting-page">
    <div class="box-header with-border">
        {{Form::open(['route'=>'ecards.sort','class'=>'form-inline','method'=>'get'])}}
            <div class="form-group">
                {{Form::select('ecard_category_id',$ecard_categories,request('ecard_category_id'),['class'=>'form-control'])}}
            </div>
            {{Form::submit('Go',['class'=>'btn btn-default'])}}
        {{Form::close()}}

        <div class="box-tools pull-right">

        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">


        @if(!request('ecard_category_id'))
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fa-2x"> Please select a category.</i>
            </div>
        @else

        {{Form::open(['route'=>'ecards.sort_store_multiple'])}}
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAdd" id="add-btn">Add New</button>
        @csrf
        <!-- Modal -->
        <div class="modal fade" id="myModalAdd" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Ecards</h4>
                {{Form::submit('Add',['class'=>'btn btn-default', 'id' => 'add-btn'])}}
                </div>
                <div class="modal-body">

                <input type="hidden" value="{{$ecard_category}}" name="ecard_category_id" />

                <div class="form-group">
                <div class="radio-inline">
                    <label style="font-weight: normal;">
                        {{ Form::radio('groups[' . $ecard_category . ']', 1, true, ['class' => 'groups_' . $ecard_category]) }}
                        Group 1
                    </label>
                </div>
                <div class="radio-inline">
                    <label style="font-weight: normal;">
                        {{ Form::radio('groups[' . $ecard_category . ']', 2, false, ['class' => 'groups_' . $ecard_category]) }}
                        Group 2
                    </label>
                </div>
                </div><br>
                <ul class="row sortable" style="list-style-type: none; padding:10px;">
                @foreach($ungroup_ecards as $ungroup_ecard)
                    <li class="col-sm-3" id="etc">
                        {{$ungroup_ecard->id}}

                        {{Form::checkbox('ecard_ids[]',$ungroup_ecard->id,false,['class'=>'sort_ids id_groups_'.$ungroup_ecard->id])}}

                        <img src="{{asset('storage/img/ecards/'.$ungroup_ecard->filename.'.jpg')}}" class="img-responsive thumbnail"/>
                    </li>
                @endforeach
                </ul>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

            </div>
        </div>

        {{Form::close()}}

            @if(!$group_one_ecards && !group_two_ecards)
            <div class="alert alert-warning text-center">
                <i class="fa fa-info-warning fa-2x"> No cards found!</i>
            </div>
            @else
            {{Form::open(['route'=>'ecards.sort_delete_multiple'])}}
            <input onclick="return confirm('Are you sure want to delete this sorting?')" class="btn btn-danger" type="submit" value="Delete Selected" />

            <h4>Group 1</h4>
            <hr>
            <ul class="row sortable" id="group1" style="list-style-type: none; padding:10px;">
                @foreach($group_one_ecards as $group_one_ecard)
                    <li class="col-sm-2" id="etc_{{$group_one_ecard->id}}">
                        {{$group_one_ecard->ecard->id}}
                        {{Form::checkbox('ids[]',$group_one_ecard->id,false,['class'=>'sort_ids'])}}

                        <button type="button" data-toggle="modal" data-target="#myModal{{$group_one_ecard->id}}" id="delete-btn">x</button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal{{$group_one_ecard->id}}" role="dialog">
                            <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                <p>Are you sure want to delete this?</p>
                                <p><a id="delete-a" href="/ecards/sort_delete/{{$group_one_ecard->id}}"><button type="button" class="btn btn-danger">Delete</button></a></p>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                            </div>
                        </div>

                        <img src="{{asset('storage/img/ecards/'.$group_one_ecard->ecard->filename.'.jpg')}}" class="img-responsive thumbnail"/>
                    </li>
                @endforeach
            </ul>

            <h4>Group 2</h4>
            <hr>
            <ul class="row sortable" id="group2" style="list-style-type: none; padding:10px;">
                @foreach($group_two_ecards as $group_two_ecard)
                    <li class="col-sm-2" id="etc_{{$group_two_ecard->id}}">
                        {{$group_two_ecard->ecard->id}}
                        {{Form::checkbox('ids[]',$group_two_ecard->id,false,['class'=>'sort_ids'])}}
                        <button type="button" data-toggle="modal" data-target="#myModal{{$group_two_ecard->id}}" id="delete-btn">x</button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal{{$group_two_ecard->id}}" role="dialog">
                            <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                <p>Are you sure want to delete this?</p>
                                <p><a id="delete-a" href="/ecards/sort_delete/{{$group_two_ecard->id}}"><button type="button" class="btn btn-danger">Delete</button></a></p>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                            </div>
                        </div>

                        <img src="{{asset('storage/img/ecards/'.$group_two_ecard->ecard->filename.'.jpg')}}" class="img-responsive thumbnail"/>
                    </li>
                @endforeach
            </ul>
            {{Form::close()}}
            @endif
        @endif
    </div><!-- /.box-body -->
</div>
@endsection

@push('js')
<script type="text/javascript">
$(document).ready(function(){
    $("#group1,#group2").sortable({
        connectWith: ".sortable",
        update: function (event, ui) {
            $("#spinner").html('<i class="fa fa-spinner fa-spin"></i>');
            var group1 = $("#group1").sortable('serialize');
            var group2 = $("#group2").sortable('serialize');

            $.ajax({
                data: {_token:"{{csrf_token()}}",group1:group1,group2:group2},
                type: 'POST',
                url: "{{route('ecards.sort.store')}}",
                success:function(response){
                    $("#spinner").html('');
                }
            });
        }
    });

});
</script>
@endpush
