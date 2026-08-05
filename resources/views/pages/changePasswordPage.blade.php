@extends('layouts.portal')
@section('title', config('app.name', 'Change Password') . ' || Portal Dashboard')
@section('portal_content')
    @include('components.dashboard.changePasswordComponent')
@endsection