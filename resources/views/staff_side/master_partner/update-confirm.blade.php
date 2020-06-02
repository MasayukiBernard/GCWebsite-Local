@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    Partner Update
@endsection

@section('entity-distinct-content')
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Old Data</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">University Name</th>
                                    <td>{{$referred_partner->name}}</td>
                                </tr>
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
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">New data</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">University Name</th>
                                    <td>{{$inputted_partner['uni-name']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Related Major Name</th>
                                    <td>{{$inputted_partner['major']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Location</th>
                                    <td>{{$inputted_partner['location']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Minimum GPA</th>
                                    <td>{{$inputted_partner['min-gpa']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">English Proficiency Requirement</th>
                                    <td>{{$inputted_partner['eng-proficiency']}}</td>
                                </tr>
                                <tr class="text-center">
                                    <th scope="row" colspan="2">Short Detail</th>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="2">{{$inputted_partner['details']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('form-action')
    {{route('staff.partner-update')}}
@endsection

@section('return-route')
    {{route('staff.partner-edit-page', ['partner' => $referred_partner])}}
@endsection