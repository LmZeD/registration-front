@extends('layouts.master')

@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script>window.Laravel = {csrf_token: '{{csrf_token()}}'}</script>
@endsection

@section('content')
    <div id="app">
        <header-block></header-block>
        <router-view></router-view>
    </div>
    <footer>
        &copy; Made by Linas Maziukas
    </footer>
@endsection

@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection
