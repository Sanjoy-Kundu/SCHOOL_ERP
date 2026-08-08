@extends('layouts.portal')
@section('title', config('app.name', 'Subject Assignment Overview') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.report.subject-lists.subjectListsComponent')
@endsection