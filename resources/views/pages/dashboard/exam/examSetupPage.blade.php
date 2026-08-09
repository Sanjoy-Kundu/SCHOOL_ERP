@extends('layouts.portal')
@section('title', config('app.name', 'Exam Setup') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.exam.examSetupComponent')
@endsection