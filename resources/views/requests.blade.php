@extends('layouts.app')

@section('content')
    <Request :requests-data="{{$requests->toJson()}}" role="{{$role}}" category="{{$category}}"></Request>
@stop