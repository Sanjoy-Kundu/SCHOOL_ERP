@extends('layouts.portal')
@section('title', config('app.name', 'School Informaiton') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.settings.schoolInformation.createSchoolInformationComponent')
@endsection