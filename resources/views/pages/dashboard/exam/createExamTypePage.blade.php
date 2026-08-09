@extends('layouts.portal')
@section('title', config('app.name', 'Exam Type') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.exam.createExamComponent')
@endsection