@extends('layouts.portal')
@section('title', config('app.name', 'Class Section') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.academic.shifts-groups.createShiftsGroupsComponent')
@endsection