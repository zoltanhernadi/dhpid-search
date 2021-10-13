@extends ('layouts.layout')
@section('title')
    <title>{{__("Clinical trial inspections")}}</title>
@endsection
@section('meta')
    <meta property="dcterms.title" content='{{__("Clinical trial inspections")}}'>
    <meta name="description" content='{{__("Find the latest results from the Government's Clinical trial inspections.")}}'>
    @yield('ctameta')
@endsection
