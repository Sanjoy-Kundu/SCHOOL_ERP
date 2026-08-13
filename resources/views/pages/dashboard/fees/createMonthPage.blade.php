@extends('layouts.portal')
@section('title', config('app.name', 'Month') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.feeManagement.MonthMaster.createMonthsComponent')
@endsection