@extends('layouts.app')

@section('title', 'Leave Report')

@section('content')

    <leave-report :emps="{{ $employees }}"></leave-report>

@endsection