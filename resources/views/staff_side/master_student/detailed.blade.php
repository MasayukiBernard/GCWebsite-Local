@extends('layouts.app2')

@section('title')
    Student Details
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">{{$referred_user->name}}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <img src="/photos/users_id={{$referred_user->id}}&opt=picture_path&mt={{$filemtimes['pp']}}" width="200px" alt="{{$referred_user->name}} - Profile Picture" class="img-thumbnail">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Profile Status</th>
                                    <td class="font-weight-bold {{$referred_user->student->is_finalized ? 'text-success' : 'text-danger'}}">{{$referred_user->student->is_finalized ? "FINALIZED" : "NOT YET FINALIZED"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Binusian Year</th>
                                    <td>{{$referred_user->student->binusian_year}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIM</th>
                                    <td>{{$referred_user->student->nim}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                {{$referred_user->email}}
                                            </div>
                                            <div class="ml-5 font-weight-bold {{$referred_user->email_verified_at == null ? 'text-danger' : 'text-success'}}">
                                                Verified At: {{$referred_user->email_verified_at == null ? 'Not Yet Verified' : $referred_user->email_verified_at}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Major</th>
                                    <td>{{$referred_user->student->major->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Place of Birth</th>
                                    <td>{{$referred_user->student->place_birth}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date of Birth</th>
                                    <td>{{$referred_user->student->date_birth}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nationality</th>
                                    <td>{{$referred_user->student->nationality}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th colspan="2" scope="row">Address</th>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="2">{{$referred_user->student->address}}</td>
                                </tr>
                                <tr>
                                    <th scope="row"s>e-KTP Card</td>
                                    <td class="text-center">
                                        <img src="/photos/users_id={{$referred_user->id}}&opt=id_card_picture_path&mt={{$filemtimes['ic']}}" width="200px" alt="{{$referred_user->name}} - National ID" class="img-thumbnail">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Flazz Card</td>
                                    <td class="text-center">
                                        <img src="/photos/users_id={{$referred_user->id}}&opt=flazz_card_picture_path&mt={{$filemtimes['fc']}}" width="200px" alt="{{$referred_user->name}} - Flazz Card" class="img-thumbnail">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap's Popup Window -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirm the deletion of '{{$referred_user->name}} - {{$referred_user->student->nim}}' data!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit();">Confirm</button>
            </div>
        </div>
        </div>
    </div>

    <form id="delete-form" method="POST" action={{route('staff.student.delete')}}>
        @csrf
    </form>
@endsection