@extends('layouts.app2')

@section('title')
    Change Password
@endsection

@section('content')
    This is change password page!<br>
    Password cannot contain any white-space character or symbol.<br>
    Password must have a length of at least 8 characters.<br>
    Password can contain special characters.<br><br>
    <form method="POST" action="{{ route('change-pass')}}">
        @csrf
        <label>New Password</label><br>
        <input type="password" class="@error('new-pass') is-invalid @enderror" name="new-pass"><br>
        @error('new-pass')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label>Confirm New Password</label><br>
        <input type="password" class="@error('confirm-new-pass') is-invalid @enderror"name="confirm-new-pass"><br>
        @error('confirm-new-pass')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="submit" value="Change Password">
    </form>
@endsection