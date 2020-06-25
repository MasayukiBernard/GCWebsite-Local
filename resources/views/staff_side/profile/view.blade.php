@extends('layouts.app2')

@section('title')
    Profile
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <table class="table table-borderless table-sm 2 w-auto mb-0">
                        <tbody>
                            <tr>
                                <td class="border-right">
                                    <strong class="h1">{{$user->name}}</strong><br>
                                    {{$user->email}}
                                </td>
                                <td class="align-middle">
                                    <a class="btn btn-primary" href="{{route('staff.profile-edit-page')}}" role="button">Edit Profile</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th scope="row">Role</th>
                            <td class="col-10">Staff</td>
                        </tr>
                        <tr>
                            <th scope="row">Position</th>
                            <td>{{$user->staff->position}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Password</th>
                            <td>
                                XXXXXXXXXXX <a href="{{route('staff.change-pass-page')}}">Change Password?</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Gender</th>
                            <td>{{$user->gender === 'M' ? 'Male' : 'Female'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Mobile Phone Number</th>
                            <td>0{{$user->mobile}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Telephone Number</th>
                            <td>0{{$user->telp_num}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection