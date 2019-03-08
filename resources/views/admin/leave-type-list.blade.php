@extends('layouts.app')

@section('title', 'Leave Type List')

@section('content')

    <leave-type :leave-types="{{ $leaveTypes }}"></leave-type>

@endsection