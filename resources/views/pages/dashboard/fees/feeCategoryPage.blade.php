@extends('layouts.portal')
@section('title', config('app.name', 'Session') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.feeManagement.feeCategory.feeCategoryCreateComponent')
@endsection