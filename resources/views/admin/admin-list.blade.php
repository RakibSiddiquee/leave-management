@extends('layouts.app')

@section('title', 'Admin List')

@section('content')

    <admin :admns="{{ $admins }}"></admin>

@endsection