@extends('layouts.app')

@section('styles')
    <link href="{{asset('css/contacts.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        window.sources = @json($sources);
    </script>
@endsection

@section('content')
    <contacts></contacts>
@endsection
