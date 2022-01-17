@extends('layouts.master')
@section('page-header')
Settings
@endsection
@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="box-tools pull-right">

        </div>
    </div>

    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="@if(request('type')=='email') {{'active'}} @endif"><a href="{{route('settings.index',['type'=>'email'])}}">Email</a></li>
                <li class="@if(request('type')=='contact') {{'active'}} @endif"><a href="{{route('settings.index',['type'=>'contact'])}}">Contact Us</a></li>
                <li class="@if(request('type')=='prices') {{'active'}} @endif"><a href="{{route('settings.index',['type'=>'prices'])}}">Prices</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane @if(request('type')=='email') {{'active'}} @endif" id="email">
                    @if(request('type')=='email')
                        @include('settings.email')
                    @endif
                </div>
                <div class="tab-pane @if(request('type')=='contact') {{'active'}} @endif" id="contact">
                    @if(request('type')=='contact')
                        @include('settings.contact')
                    @endif
                </div>
                <div class="tab-pane @if(request('type')=='prices') {{'active'}} @endif" id="prices">
                    @if(request('type')=='prices')
                        @include('settings.prices')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection