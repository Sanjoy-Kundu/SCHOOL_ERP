@extends('layouts.portal')
@section('title', config('app.name', 'Subject Paper') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.subjects-papers.createSubjectPapersComponent')
@endsection