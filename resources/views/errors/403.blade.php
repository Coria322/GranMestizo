@extends('layouts.error')

@section('num1', '4')
@section('num2', '3')
@section('error', 'Forbidden')
@section('content')
<div class="msg">{{ $exception->getMessage() }}</div>
@endsection


