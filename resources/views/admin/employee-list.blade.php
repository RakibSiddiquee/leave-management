@extends('layouts.app')

@section('title', 'Employee List')

@section('content')

    <employee :desgs="{{ $designations }}" :depts="{{ $departments }}" :empls="{{ $employees }}"></employee>

@endsection