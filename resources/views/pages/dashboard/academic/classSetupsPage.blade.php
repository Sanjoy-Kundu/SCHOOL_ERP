@extends('layouts.portal')
@section('title', config('app.name', 'Class Setup') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.class-setups.createClassSetupComponent')
@endsection