@extends('layouts.portal')
@section('title', config('app.name', 'Subject Assignment Overview') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.subject-assignments.subjectAssignmentOverviewComponent')
@endsection