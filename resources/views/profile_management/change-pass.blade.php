@extends('layouts.app2')

@section('title')
    Change Password
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h3">
                    Change Profile Password
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <form method="POST" action="{{ route('change-pass')}}">
                                @csrf
                                <label>New Password</label><br>
                                <input type="password" class="form-control @error('new-pass') is-invalid @enderror" name="new-pass"><br>
                                @error('new-pass')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label>Confirm New Password</label><br>
                                <input type="password" class="form-control @error('confirm-new-pass') is-invalid @enderror"name="confirm-new-pass"><br>
                                @error('confirm-new-pass')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input class="btn btn-primary" type="submit" value="Change Password">
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h5><b>Password making rules:</b></h5>
                            <ul>
                                <li>Password cannot contain any white-space character or symbol.<br></li>
                                <li>Password must have a length of at least 8 characters.<br></li>
                                <li>Password can contain special characters.<br><br></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection