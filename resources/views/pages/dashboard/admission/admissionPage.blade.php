@extends('layouts.portal')
@section('title', config('app.name', 'Admission') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.admission.admissionComponent')
    {{-- @include('components.dashboard.admission.academicStepComponent')
    @include('components.dashboard.admission.studentStepComponent')
    @include('components.dashboard.admission.parentStepComponent')
    @include('components.dashboard.admission.paymentStepComponent') --}}
@endsection