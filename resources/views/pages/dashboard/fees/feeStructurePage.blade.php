@extends('layouts.portal')
@section('title', config('app.name', 'Fees Structure') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.feeManagement.feeStructure.createFeeStructureComponent')
@endsection