@extends('layouts.portal')
@section('title', config('app.name', 'Exam Shedule') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.exam.examSchedulesComponent')
@endsection