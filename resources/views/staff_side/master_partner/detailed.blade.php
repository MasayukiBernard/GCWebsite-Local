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
                        <a class="btn btn-primary text-light" role="button" href={{route('staff.partner-edit-page', ['partner' => $referred_partner])}}>Edit</a>
                        <a class="btn btn-danger text-light" role="button" onclick="document.getElementById('delete-form').submit();">Delete</a>

                        <form id="delete-form" method="POST" action={{route('staff.partner-delete')}}>
                            @csrf
                            <input type="hidden" name="partner-id" value="{{$referred_partner->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection