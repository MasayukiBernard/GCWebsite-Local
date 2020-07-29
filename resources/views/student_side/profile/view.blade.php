@extends('layouts.app2')

@section('title')
    Profile
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="notification_bar" class="row justify-content-center m-0 mb-2 text-light">
                @isset($success)
                    <div id="success_notif" class="col-md-12 bg-success rounded py-2 font-weight-bold h4 m-0">
                        <div class="row">
                            <div class="col-11">
                                {{$success}}
                            </div>
                            <div class="col-1 text-right">
                                <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                            </div>
                        </div>
                    </div>
                @endisset
                @isset($warning)
                    <div id="warning_notif" class="col-md-12 bg-warning text-danger rounded py-2 font-weight-bold h4 m-0">
                        <div class="row">
                            <div class="col-11">
                                {{$warning}}
                            </div>
                            <div class="col-1 text-right">
                                <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                            </div>
                        </div>
                    </div>
                @endisset
                @isset($failed)
                    <div id="failed_notif" class="col-md-12 bg-danger rounded py-2 font-weight-bold h4 m-0">
                        <div class="row">
                            <div class="col-11">
                                {{$failed}}
                            </div>
                            <div class="col-1 text-right">
                                <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
            <div class="font-weight-bold">*** All of below data will be reflected on your CSA Application to Partner Universities! *** (Password will not be reflected).</div>
            <div class="card">
                <div class="card-header">
                    <table class="table table-borderless table-sm 2 w-auto mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="border border-dark rounded d-flex align-items-center" style="height: 150px; width=150vw;">
                                        <img src="/photos/ys=0&opt=profile-picture" width="150vw" class="p-2">
                                    </div>
                                </td>
                                <td class="w-auto">
                                    <strong class="h1 mb-0">{{$user->name}}</strong>
                                    <div>
                                        <div class="d-inline">{{$user->email}}</div>
                                        <div class="d-inline p-1 rounded text-light {{$user->email_verified_at == null ? "bg-danger" : "bg-success"}}">
                                            {{$user->email_verified_at == null ? "Not Yet Verified" : "Verified"}}
                                        </div>
                                        @if ($user->email_verified_at == null)
                                            <div class="d-inline  ml-2 p-2 border-left border-dark">
                                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Send Email Verification Link</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-4">{{$user->student->nim}}</div>
                                    <div>
                                        @if(!($profile_finalized))
                                            <a class="btn btn-primary" href="{{route('student.profile-edit-page')}}" role="button">Edit Profile</a>
                                        @else
                                            @if ($request_edit_permission)
                                                <a class="btn btn-primary" href="{{route('student.profile-request-edit-page')}}" role="button">Request Edit</a>
                                            @else
                                                <span class="text-warning rounded badge-primary p-1">Awaiting Profile Edit Request Approval</span>
                                            @endif
                                        @endif
                                        @if ($email_verified)
                                            @if(!($profile_finalized))
                                                <button class="btn btn-warning text-danger font-weight-bold" type="button" data-toggle="modal" data-target="#finalization_modal">
                                                    Finalize Profile
                                                </button>
                                                <form id="finalization_form" method="POST" action="{{route('student.profile-finalize')}}">
                                                    @csrf
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th scope="row">Password</th>
                            <td>
                                XXXXXXXXXXX <a href="{{route('student.change-pass-page')}}">Change Password?</a>
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
                        <tr>
                            <th scope="row">Enrolled Major</th>
                            <td>{{$user->student->major->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Place of Birth</th>
                            <td>{{$user->student->place_birth}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Date of Birth</th>
                            <td>{{$user->student->date_birth}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nationality</th>
                            <td>{{$user->student->nationality}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address</th>
                            <td>{{$user->student->address}}</td>
                        </tr>
                        <tr class="text-center">
                            <th scope="row">ID Card Picture</th>
                            <th scope="row">Flazz Card Picture</th>
                        </tr>
                        <tr class="text-center">
                            <td><img src="/photos/ys=0&opt=id-card" width="200px" alt="No Image Data Yet"></td>
                            <td><img src="/photos/ys=0&opt=flazz-card" width="200px" alt="No Image Data Yet"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finalization_modal" tabindex="-1" role="dialog" aria-labelledby="finalization_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Profile Finalization</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Do you want to finalize your profile information?<br>
            <b>Please keep in mind, after finalizing your profile, you will not be able to edit your profile without issuing a request!</b>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('finalization_form').submit();">Confirm</button>
        </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }
    </script>
@endpush