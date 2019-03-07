@extends('layouts.app')

@section('title', 'Designation List')

@section('content')

    <designation :desgs="{{ $designations }}"></designation>

@endsection