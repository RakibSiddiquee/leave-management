@extends('layouts.app')

@section('title', 'Department List')

@section('content')

    <department :depts="{{ $departments }}"></department>

@endsection