@extends('layouts.portal')
@section('title', config('app.name', 'Session') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.session.sessionComponent')
@endsection