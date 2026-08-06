@extends('layouts.portal')
@section('title', config('app.name', 'Subject Assignment') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.subject-assignments.createSubjectAssignmentsComponent')
@endsection