@extends('layouts.app2')

@section('title')
    Profile
@endsection

@section('content')
    This is staff's manage account page.<br>
    <a href="{{ route('staff.change-pass-view')}}">Change Password?</a>
@endsection