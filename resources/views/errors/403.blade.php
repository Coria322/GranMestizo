@extends('layouts.error')

@section('num1', '4')
@section('num2', '3')
@section('error', 'Forbidden')
@section('content')
@if(session('error'))
    <div class="msg">{{ session('error') }}</div>
@endif

@if(session('Error'))
    <div class="msg">{{ session('error') }}</div>
@endif

@endsection


