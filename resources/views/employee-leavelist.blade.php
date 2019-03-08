@extends('layouts.app')

@section('title', 'Employee List')

@section('content')

    <employee-leave :lvs="{{ $leaves }}" :leave-types="{{ $leaveTypes }}"></employee-leave>

@endsection