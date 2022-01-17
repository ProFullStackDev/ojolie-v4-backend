@extends('layouts.master')
@section('page-header')
Contact Message Detail
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Contact Message Detail</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('contact-messages.index') }}" class="btn btn-primry btn-xs">Back to contact list</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <div class="row">
            <div class="col-sm-6">
                <p>Name : {{$contact_message->name}}</p>
            </div>
            <div class="col-sm-6">
                <p>Sent at : {{$contact_message->created_at}}</p>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-sm-12">
                <p>Message</p>
                <p>{{$contact_message->message}}</p>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-sm-12">
                <p>Mail reply to</p>
                <p><a href="mailto:{{$contact_message->email}}">{{$contact_message->email}}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
