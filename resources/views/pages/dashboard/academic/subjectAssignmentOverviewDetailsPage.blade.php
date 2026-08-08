@extends('layouts.portal')
@section('title', config('app.name', 'Subject Assignment Overview Details') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.subject-assignments.subjectAssignmentDetailsComponent')
@endsection