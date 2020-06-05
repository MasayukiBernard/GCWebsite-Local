@extends('layouts.app2')

@section('title')
    Partner Details
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">{{$referred_partner->name}}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Related Major Name</th>
                                    <td>{{$referred_partner->major->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Location</th>
                                    <td>{{$referred_partner->location}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Minimum GPA</th>
                                    <td>{{$referred_partner->min_gpa}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">English Proficiency Requirement</th>
                                    <td>{{$referred_partner->eng_requirement}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th scope="row" colspan="2">Short Detail</th>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="2">{{$referred_partner->short_detail}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-primary text-light" role="button" href={{route('staff.partner.edit-page', ['partner' => $referred_partner])}}>Edit</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            Delete
                        </button>
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
                Confirm the deletion of '{{$referred_partner->name}}' data!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit();">Confirm</button>
            </div>
        </div>
        </div>
    </div>
    <form id="delete-form" method="POST" action={{route('staff.partner.delete')}}>
        @csrf
    </form>
@endsection