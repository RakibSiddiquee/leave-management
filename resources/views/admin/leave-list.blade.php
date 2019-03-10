@extends('layouts.app')

@section('title', 'Leave List')

@section('content')

    <leave-list :lvs="{{ $leaves }}" :leave-types="{{ $leaveTypes }}"></leave-list>

@endsection