@extends ('layouts.layout')
@section('title')
    <title>{{__("Cells, tissues and organs (CTO) inspections")}}</title>
@endsection
@section('meta')
    <meta property="dcterms.title" content='{{__("Cells, tissues and organs (CTO) inspections")}}'>
    <meta name="description" content='{{__("Find the latest results from the Government's Cells, tissues and organs (CTO) inspections.")}}'>
    @yield('ctometa')
@endsection
