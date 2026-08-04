@extends('layouts.portal')
@section('title', config('app.name', 'School ERP') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.mainComponent')
@endsection