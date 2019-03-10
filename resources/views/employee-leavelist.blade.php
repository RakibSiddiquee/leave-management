@extends('layouts.app')

@section('title', 'Leave List')

@section('content')

    <employee-leave :lvs="{{ $leaves }}" :leave-types="{{ $leaveTypes }}"></employee-leave>

@endsection