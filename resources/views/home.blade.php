@extends('adminlte::page')

@section('title', 'ホーム画面')

@section('content_header')
    <h5>ようこそ{{ Auth::user()->name }}さん、こちらはホーム画面です。</h5>        
@stop

@section('content')
    <div class="bluelight">
        <a href="{{ url('items') }}">Product List</a>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bluelight.css') }}">
@stop


@section('js')
    <script> console.log('Hi!'); </script>
@stop