@extends('layouts.error')

@section('num1', '4')
@section('num2', '9')
@section('error', 'Conflict')
@section('content')
<div class="msg">{{ $exception->getMessage() }}</div>
@endsection

